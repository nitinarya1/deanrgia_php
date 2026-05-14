<?php
/**
 * Reusable Admin CRUD Page
 * Include this file after setting $crudConfig
 * Supports file upload fields (type => 'file')
 */
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/auth_check.php';

$db = getDB();
$table = $crudConfig['table'];

// Upload directory
$uploadDir = __DIR__ . '/../../public/uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

/**
 * Auto-compress image to target size (in KB) using GD
 * Resizes and reduces quality iteratively
 */
function compressImage($filePath, $ext, $targetKB = 100) {
    if (!function_exists('imagecreatefromjpeg')) return; // GD not available
    
    $targetBytes = $targetKB * 1024;
    
    // Already under target?
    if (filesize($filePath) <= $targetBytes) return;
    
    // Load image based on type
    switch ($ext) {
        case 'jpg': case 'jpeg':
            $img = @imagecreatefromjpeg($filePath);
            break;
        case 'png':
            $img = @imagecreatefrompng($filePath);
            break;
        case 'webp':
            $img = @imagecreatefromwebp($filePath);
            break;
        default:
            return;
    }
    if (!$img) return;
    
    $origW = imagesx($img);
    $origH = imagesy($img);
    
    // Step 1: Resize if larger than 1920px wide
    $maxW = 1920;
    if ($origW > $maxW) {
        $ratio = $maxW / $origW;
        $newW = $maxW;
        $newH = (int)($origH * $ratio);
        $resized = imagecreatetruecolor($newW, $newH);
        // Preserve transparency for PNG
        if ($ext === 'png') {
            imagealphablending($resized, false);
            imagesavealpha($resized, true);
        }
        imagecopyresampled($resized, $img, 0, 0, 0, 0, $newW, $newH, $origW, $origH);
        imagedestroy($img);
        $img = $resized;
    }
    
    // Step 2: Iteratively reduce quality for JPEG (or convert PNG to JPEG)
    // Always save as JPEG for slideshow (best compression)
    $quality = 85;
    $minQuality = 30;
    
    while ($quality >= $minQuality) {
        ob_start();
        imagejpeg($img, null, $quality);
        $data = ob_get_clean();
        
        if (strlen($data) <= $targetBytes) {
            // Save compressed file (as JPEG)
            file_put_contents($filePath, $data);
            imagedestroy($img);
            return;
        }
        $quality -= 5;
    }
    
    // Step 3: If still too large, resize further
    $currentW = imagesx($img);
    $currentH = imagesy($img);
    $scales = [0.75, 0.6, 0.5, 0.4, 0.3];
    
    foreach ($scales as $scale) {
        $newW = (int)($currentW * $scale);
        $newH = (int)($currentH * $scale);
        if ($newW < 400) break; // Don't go too small
        
        $scaled = imagecreatetruecolor($newW, $newH);
        imagecopyresampled($scaled, $img, 0, 0, 0, 0, $newW, $newH, $currentW, $currentH);
        
        ob_start();
        imagejpeg($scaled, null, 60);
        $data = ob_get_clean();
        imagedestroy($scaled);
        
        if (strlen($data) <= $targetBytes) {
            file_put_contents($filePath, $data);
            imagedestroy($img);
            return;
        }
    }
    
    // Last resort: just save at minimum quality
    imagejpeg($img, $filePath, $minQuality);
    imagedestroy($img);
}

// Handle delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $db->prepare("DELETE FROM $table WHERE id = ?")->execute([$id]);
    header('Location: ' . $_SERVER['PHP_SELF'] . '?deleted=1');
    exit;
}

// Handle add/edit
$editItem = null;
if (isset($_GET['edit'])) {
    $stmt = $db->prepare("SELECT * FROM $table WHERE id = ?");
    $stmt->execute([intval($_GET['edit'])]);
    $editItem = $stmt->fetch();
}

$successMsg = '';
$errorMsg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fields = $crudConfig['fields'];
    $id = $_POST['id'] ?? null;

    $fieldValues = [];
    foreach ($fields as $f) {
        $fieldType = $f['type'] ?? 'text';
        
        if ($fieldType === 'file') {
            // Handle file upload
            $fileKey = $f['name'];
            if (isset($_FILES[$fileKey]) && $_FILES[$fileKey]['error'] === UPLOAD_ERR_OK) {
                $tmpName = $_FILES[$fileKey]['tmp_name'];
                $origName = basename($_FILES[$fileKey]['name']);
                $ext = strtolower(pathinfo($origName, PATHINFO_EXTENSION));
                
                // Validate file type
                $allowedExts = $f['allowed'] ?? ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'pdf'];
                if (!in_array($ext, $allowedExts)) {
                    $errorMsg = 'Invalid file type for ' . $f['label'] . '. Allowed: ' . implode(', ', $allowedExts);
                    break;
                }
                
                // Validate file size (max 10MB)
                $maxSize = $f['max_size'] ?? 10 * 1024 * 1024;
                if ($_FILES[$fileKey]['size'] > $maxSize) {
                    $errorMsg = 'File too large for ' . $f['label'] . '. Maximum size: ' . round($maxSize / 1024 / 1024) . 'MB';
                    break;
                }
                
                // Generate unique filename
                $newName = $table . '_' . time() . '_' . mt_rand(1000, 9999) . '.' . $ext;
                $destPath = $uploadDir . $newName;
                
                if (move_uploaded_file($tmpName, $destPath)) {
                    // Auto-compress images if configured (e.g. slideshow)
                    $autoCompress = $f['auto_compress'] ?? false;
                    if ($autoCompress && in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
                        compressImage($destPath, $ext, 100); // Target: under 100KB
                    }
                    $fieldValues[$fileKey] = 'public/uploads/' . $newName;
                } else {
                    $errorMsg = 'Failed to upload file for ' . $f['label'];
                    break;
                }
            } else {
                // No new file uploaded — keep old value if editing, or empty if adding
                if ($id) {
                    // Keep existing value
                    $stmt = $db->prepare("SELECT $fileKey FROM $table WHERE id = ?");
                    $stmt->execute([$id]);
                    $row = $stmt->fetch();
                    $fieldValues[$fileKey] = $row[$fileKey] ?? '';
                } else {
                    $fieldValues[$fileKey] = '';
                }
            }
        } else {
            $fieldValues[$f['name']] = $_POST[$f['name']] ?? '';
        }
    }

    if (empty($errorMsg)) {
        if ($id) {
            // Update
            $sets = []; $vals = [];
            foreach ($fields as $f) {
                $sets[] = $f['name'] . ' = ?';
                $vals[] = $fieldValues[$f['name']];
            }
            $vals[] = $id;
            $db->prepare("UPDATE $table SET " . implode(', ', $sets) . " WHERE id = ?")->execute($vals);
            $successMsg = $crudConfig['singular'] . ' updated successfully!';
        } else {
            // Insert
            $cols = []; $placeholders = []; $vals = [];
            foreach ($fields as $f) {
                $cols[] = $f['name'];
                $placeholders[] = '?';
                $vals[] = $fieldValues[$f['name']];
            }
            $db->prepare("INSERT INTO $table (" . implode(',', $cols) . ") VALUES (" . implode(',', $placeholders) . ")")->execute($vals);
            $successMsg = $crudConfig['singular'] . ' added successfully!';
        }
        $editItem = null;
    }
}

if (isset($_GET['deleted'])) $successMsg = $crudConfig['singular'] . ' deleted successfully!';

$order = $crudConfig['order'] ?? 'id DESC';
$items = $db->query("SELECT * FROM $table ORDER BY $order")->fetchAll();

// Check if any field is a file field (we need enctype)
$hasFileField = false;
foreach ($crudConfig['fields'] as $f) {
    if (($f['type'] ?? 'text') === 'file') { $hasFileField = true; break; }
}

include __DIR__ . '/admin_header.php';
?>

<?php if ($successMsg): ?>
<div class="mb-6 p-4 rounded-xl bg-emerald-50 text-emerald-800 border border-emerald-200 text-sm font-medium"><?php echo $successMsg; ?></div>
<?php endif; ?>

<?php if ($errorMsg): ?>
<div class="mb-6 p-4 rounded-xl bg-red-50 text-red-800 border border-red-200 text-sm font-medium"><?php echo $errorMsg; ?></div>
<?php endif; ?>

<!-- Add/Edit Form -->
<div class="bg-white rounded-2xl border border-slate-200 p-6 mb-8 shadow-sm">
    <h3 class="text-lg font-bold text-slate-900 mb-4"><?php echo $editItem ? 'Edit' : 'Add New'; ?> <?php echo $crudConfig['singular']; ?></h3>
    <form method="POST" <?php echo $hasFileField ? 'enctype="multipart/form-data"' : ''; ?> class="space-y-4">
        <?php if ($editItem): ?>
            <input type="hidden" name="id" value="<?php echo $editItem['id']; ?>">
        <?php endif; ?>
        <div class="grid md:grid-cols-2 gap-4">
            <?php foreach ($crudConfig['fields'] as $field): ?>
            <?php $fieldType = $field['type'] ?? 'text'; ?>
            <div class="<?php echo $fieldType === 'textarea' ? 'md:col-span-2' : ''; ?>">
                <label class="block text-sm font-medium text-slate-700 mb-1"><?php echo $field['label']; ?></label>
                <?php if ($fieldType === 'textarea'): ?>
                    <textarea name="<?php echo $field['name']; ?>" rows="3" class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500/50"><?php echo sanitize($editItem[$field['name']] ?? ''); ?></textarea>
                <?php elseif ($fieldType === 'select'): ?>
                    <select name="<?php echo $field['name']; ?>" class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500/50">
                        <?php foreach ($field['options'] as $opt): ?>
                            <option value="<?php echo $opt; ?>" <?php echo ($editItem[$field['name']] ?? '') === $opt ? 'selected' : ''; ?>><?php echo $opt; ?></option>
                        <?php endforeach; ?>
                    </select>
                <?php elseif ($fieldType === 'file'): ?>
                    <div class="space-y-2">
                        <!-- Current file preview (when editing) -->
                        <?php 
                        $currentFile = $editItem[$field['name']] ?? '';
                        $isImage = false;
                        if ($currentFile) {
                            $ext = strtolower(pathinfo($currentFile, PATHINFO_EXTENSION));
                            $isImage = in_array($ext, ['jpg','jpeg','png','gif','webp','svg']);
                        }
                        ?>
                        <?php if ($currentFile): ?>
                        <div class="flex items-center gap-3 p-3 rounded-lg bg-slate-50 border border-slate-200">
                            <?php if ($isImage): ?>
                                <img src="<?php echo BASE_URL . '/' . sanitize($currentFile); ?>" alt="Current" class="w-16 h-16 object-cover rounded-lg border border-slate-200 shadow-sm">
                            <?php else: ?>
                                <div class="w-16 h-16 rounded-lg bg-teal-50 border border-teal-100 flex items-center justify-center">
                                    <svg class="w-8 h-8 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                                </div>
                            <?php endif; ?>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-slate-500 mb-0.5">Current file</p>
                                <p class="text-sm text-slate-700 font-medium truncate"><?php echo basename($currentFile); ?></p>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <!-- File upload input -->
                        <label class="relative flex flex-col items-center justify-center w-full py-5 px-4 rounded-xl border-2 border-dashed border-slate-300 bg-slate-50 cursor-pointer hover:bg-teal-50 hover:border-teal-400 transition-all duration-200 group">
                            <svg class="w-8 h-8 text-slate-400 group-hover:text-teal-500 mb-2 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="text-sm font-semibold text-slate-500 group-hover:text-teal-600 transition-colors">
                                <?php echo $currentFile ? 'Upload new file to replace' : 'Click to browse & upload'; ?>
                            </span>
                            <span class="text-xs text-slate-400 mt-1">
                                <?php 
                                $allowedExts = $field['allowed'] ?? ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'pdf'];
                                echo strtoupper(implode(', ', $allowedExts));
                                ?> — Max <?php echo round(($field['max_size'] ?? 10*1024*1024) / 1024 / 1024); ?>MB
                            </span>
                            <input 
                                type="file" 
                                name="<?php echo $field['name']; ?>" 
                                accept="<?php echo '.' . implode(',.', $allowedExts); ?>"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                onchange="previewUpload(this, '<?php echo $field['name']; ?>')"
                            >
                        </label>
                        
                        <!-- Upload preview -->
                        <div id="preview-<?php echo $field['name']; ?>" class="hidden items-center gap-3 p-3 rounded-lg bg-emerald-50 border border-emerald-200">
                            <img id="preview-img-<?php echo $field['name']; ?>" src="" alt="Preview" class="w-14 h-14 object-cover rounded-lg border border-emerald-200 shadow-sm">
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-emerald-600 font-semibold mb-0.5">New file selected</p>
                                <p id="preview-name-<?php echo $field['name']; ?>" class="text-sm text-emerald-800 font-medium truncate"></p>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <input type="<?php echo $fieldType; ?>" name="<?php echo $field['name']; ?>" value="<?php echo sanitize($editItem[$field['name']] ?? ($field['default'] ?? '')); ?>" class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500/50" <?php echo ($field['required'] ?? false) ? 'required' : ''; ?>>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="px-6 py-2.5 bg-teal-600 hover:bg-teal-700 text-white rounded-xl text-sm font-bold transition-colors"><?php echo $editItem ? 'Update' : 'Add'; ?> <?php echo $crudConfig['singular']; ?></button>
            <?php if ($editItem): ?>
                <a href="<?php echo $_SERVER['PHP_SELF']; ?>" class="px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-sm font-bold transition-colors">Cancel</a>
            <?php endif; ?>
        </div>
    </form>
</div>

<!-- Items List -->
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-slate-200">
        <h3 class="text-lg font-bold text-slate-900">All <?php echo $crudConfig['plural']; ?> (<?php echo count($items); ?>)</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-bold text-slate-500 uppercase">#</th>
                    <?php foreach ($crudConfig['columns'] as $col): ?>
                        <th class="px-4 py-3 text-left text-xs font-bold text-slate-500 uppercase"><?php echo $col['label']; ?></th>
                    <?php endforeach; ?>
                    <th class="px-4 py-3 text-right text-xs font-bold text-slate-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php if (empty($items)): ?>
                    <tr><td colspan="<?php echo count($crudConfig['columns']) + 2; ?>" class="px-4 py-8 text-center text-slate-400">No <?php echo strtolower($crudConfig['plural']); ?> found.</td></tr>
                <?php else: ?>
                    <?php foreach ($items as $i => $item): ?>
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-4 py-3 text-slate-400 font-medium"><?php echo $i + 1; ?></td>
                        <?php foreach ($crudConfig['columns'] as $col): ?>
                            <?php 
                            $colType = $col['type'] ?? 'text';
                            $cellValue = $item[$col['key']] ?? '';
                            ?>
                            <td class="px-4 py-3 text-slate-700 max-w-xs truncate">
                                <?php if ($colType === 'image' && $cellValue): ?>
                                    <img src="<?php echo BASE_URL . '/' . sanitize($cellValue); ?>" alt="" class="w-10 h-10 object-cover rounded-lg border border-slate-200">
                                <?php else: ?>
                                    <?php echo sanitize(substr($cellValue, 0, 100)); ?>
                                <?php endif; ?>
                            </td>
                        <?php endforeach; ?>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="?edit=<?php echo $item['id']; ?>" class="px-3 py-1.5 bg-blue-50 text-blue-700 rounded-lg text-xs font-bold hover:bg-blue-100 transition-colors">Edit</a>
                                <a href="?delete=<?php echo $item['id']; ?>" onclick="return confirm('Are you sure you want to delete this?')" class="px-3 py-1.5 bg-red-50 text-red-700 rounded-lg text-xs font-bold hover:bg-red-100 transition-colors">Delete</a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- File upload preview script -->
<script>
function previewUpload(input, fieldName) {
    const previewDiv = document.getElementById('preview-' + fieldName);
    const previewImg = document.getElementById('preview-img-' + fieldName);
    const previewName = document.getElementById('preview-name-' + fieldName);
    
    if (input.files && input.files[0]) {
        const file = input.files[0];
        previewName.textContent = file.name + ' (' + (file.size / 1024).toFixed(1) + ' KB)';
        previewDiv.classList.remove('hidden');
        previewDiv.classList.add('flex');
        
        // Show image preview if it's an image
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewImg.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        } else {
            previewImg.classList.add('hidden');
        }
    } else {
        previewDiv.classList.add('hidden');
        previewDiv.classList.remove('flex');
    }
}
</script>

<?php include __DIR__ . '/admin_footer.php'; ?>
