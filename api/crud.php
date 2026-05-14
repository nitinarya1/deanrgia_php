<?php
// Generic CRUD API for: deans, publications, mous, team, souvenirs, slideshow
// This file handles all based on query param ?table=
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

$method = getRequestMethod();
$db = getDB();
$table = $_GET['table'] ?? '';

$allowed = [
    'deans' => ['name','designation','department','tenure','image','bio','profile_link','email','display_order'],
    'publications' => ['title','author','description','image','link'],
    'mous' => ['institution','country','date','description','status'],
    'team' => ['name','role','department','image','profile_link'],
    'souvenirs' => ['title','year','description','pdf_link','category'],
    'slideshows' => ['image_url','caption','display_order','is_active'],
];

if (!isset($allowed[$table])) {
    apiError('Invalid table', 400);
}

$fields = $allowed[$table];

if ($method === 'GET') {
    $order = $table === 'deans' ? 'display_order ASC' : ($table === 'slideshows' ? 'display_order ASC' : 'created_at DESC');
    if ($table === 'slideshows' && !isset($_GET['all'])) {
        $stmt = $db->query("SELECT * FROM $table WHERE is_active = 1 ORDER BY $order");
    } else {
        $stmt = $db->query("SELECT * FROM $table ORDER BY $order");
    }
    apiResponse($stmt->fetchAll());
} elseif ($method === 'POST') {
    requireAdminAuth();
    $data = getJsonBody();
    $cols = []; $placeholders = []; $vals = [];
    foreach ($fields as $f) {
        $cols[] = $f;
        $placeholders[] = '?';
        $vals[] = $data[$f] ?? '';
    }
    $sql = "INSERT INTO $table (" . implode(',', $cols) . ") VALUES (" . implode(',', $placeholders) . ")";
    $db->prepare($sql)->execute($vals);
    apiResponse(['success' => true, 'id' => $db->lastInsertId()], 201);
} elseif ($method === 'PUT') {
    requireAdminAuth();
    $data = getJsonBody();
    $id = $data['id'] ?? $_GET['id'] ?? null;
    if (!$id) apiError('ID required');
    $sets = []; $vals = [];
    foreach ($fields as $f) {
        if (isset($data[$f])) {
            $sets[] = "$f = ?";
            $vals[] = $data[$f];
        }
    }
    if (empty($sets)) apiError('No fields to update');
    $vals[] = $id;
    $sql = "UPDATE $table SET " . implode(', ', $sets) . " WHERE id = ?";
    $db->prepare($sql)->execute($vals);
    apiResponse(['success' => true]);
} elseif ($method === 'DELETE') {
    requireAdminAuth();
    $id = $_GET['id'] ?? null;
    if (!$id) apiError('ID required');
    $db->prepare("DELETE FROM $table WHERE id = ?")->execute([$id]);
    apiResponse(['success' => true]);
} else {
    apiError('Method not allowed', 405);
}
