<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

$method = getRequestMethod();
$db = getDB();

if ($method === 'GET') {
    $stmt = $db->query("SELECT * FROM contacts ORDER BY created_at DESC");
    apiResponse($stmt->fetchAll());
} elseif ($method === 'POST') {
    $data = getJsonBody();
    $name = trim($data['name'] ?? '');
    $email = trim($data['email'] ?? '');
    $subject = trim($data['subject'] ?? '');
    $message = trim($data['message'] ?? '');

    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        apiError('All fields are required', 400);
    }

    $stmt = $db->prepare("INSERT INTO contacts (name, email, subject, message) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $email, $subject, $message]);
    apiResponse(['success' => true, 'message' => 'Message sent successfully', 'id' => $db->lastInsertId()], 201);
} elseif ($method === 'DELETE') {
    requireAdminAuth();
    $id = $_GET['id'] ?? null;
    if (!$id) apiError('ID required', 400);
    $stmt = $db->prepare("DELETE FROM contacts WHERE id = ?");
    $stmt->execute([$id]);
    apiResponse(['success' => true, 'message' => 'Contact deleted']);
} else {
    apiError('Method not allowed', 405);
}
