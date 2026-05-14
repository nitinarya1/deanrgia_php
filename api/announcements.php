<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

$method = getRequestMethod();
$db = getDB();

if ($method === 'GET') {
    $showAll = isset($_GET['all']);
    $where = $showAll ? '' : 'WHERE is_active = 1';
    $stmt = $db->query("SELECT * FROM announcements $where ORDER BY date DESC");
    apiResponse($stmt->fetchAll());
} elseif ($method === 'POST') {
    requireAdminAuth();
    $data = getJsonBody();
    $stmt = $db->prepare("INSERT INTO announcements (title, content, link, date, is_active, is_new) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $data['title'] ?? '', $data['content'] ?? '', $data['link'] ?? '',
        $data['date'] ?? date('Y-m-d'), $data['is_active'] ?? 1, $data['is_new'] ?? 1
    ]);
    apiResponse(['success' => true, 'id' => $db->lastInsertId()], 201);
} elseif ($method === 'PUT') {
    requireAdminAuth();
    $data = getJsonBody();
    $id = $data['id'] ?? $_GET['id'] ?? null;
    if (!$id) apiError('ID required');
    $stmt = $db->prepare("UPDATE announcements SET title=?, content=?, link=?, date=?, is_active=?, is_new=? WHERE id=?");
    $stmt->execute([$data['title'], $data['content'] ?? '', $data['link'] ?? '', $data['date'], $data['is_active'] ?? 1, $data['is_new'] ?? 0, $id]);
    apiResponse(['success' => true]);
} elseif ($method === 'DELETE') {
    requireAdminAuth();
    $id = $_GET['id'] ?? null;
    if (!$id) apiError('ID required');
    $db->prepare("DELETE FROM announcements WHERE id=?")->execute([$id]);
    apiResponse(['success' => true]);
} else {
    apiError('Method not allowed', 405);
}
