<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

$method = getRequestMethod();
$db = getDB();

if ($method === 'POST') {
    $data = getJsonBody();
    $action = $data['action'] ?? '';

    if ($action === 'login') {
        $username = trim($data['username'] ?? '');
        $password = $data['password'] ?? '';

        if (empty($username) || empty($password)) {
            apiError('Username and password are required', 400);
        }

        $stmt = $db->prepare("SELECT * FROM admins WHERE username = ?");
        $stmt->execute([$username]);
        $admin = $stmt->fetch();

        if (!$admin || !password_verify($password, $admin['password'])) {
            apiError('Invalid credentials', 401);
        }

        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_username'] = $admin['username'];

        apiResponse(['success' => true, 'username' => $admin['username']]);
    } elseif ($action === 'verify') {
        if (isset($_SESSION['admin_id'])) {
            apiResponse(['valid' => true, 'username' => $_SESSION['admin_username']]);
        } else {
            apiError('Not authenticated', 401);
        }
    } elseif ($action === 'logout') {
        session_destroy();
        apiResponse(['success' => true]);
    } else {
        apiError('Invalid action', 400);
    }
} else {
    apiError('Method not allowed', 405);
}
