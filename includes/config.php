<?php
/**
 * Database Configuration & Site Constants
 * Dean RGIA - MNNIT Allahabad
 */

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database credentials
define('DB_HOST', 'localhost');
define('DB_NAME', 'deanrgia_db');
define('DB_USER', 'root');
define('DB_PASS', ''); // Default XAMPP password is empty

// Site configuration — Updated from official MNNIT Resource Generation document
define('SITE_NAME', 'RGIA');
define('SITE_FULL_NAME', 'Resource Generation and International Affairs');
define('SITE_INSTITUTION', 'Motilal Nehru National Institute of Technology Allahabad, Prayagraj');
define('SITE_TAGLINE', 'Fostering Global Partnerships & Resource Mobilization');
define('SITE_EMAIL', 'deanrgia@mnnit.ac.in');
define('SITE_PHONE', '+91-532-2271012');
define('SITE_PHONE2', '+91-532-2271055');
define('SITE_ADDRESS', 'Motilal Nehru National Institute of Technology Allahabad, Prayagraj - 211004, Uttar Pradesh, India');
define('SITE_DOMAIN', 'deanrgia.mnnit.ac.in');

// Base URL - auto-detect
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$scriptDir = dirname($_SERVER['SCRIPT_NAME']);
// Determine the base path for the project
$basePath = '/deanrgia_php';
define('BASE_URL', $protocol . '://' . $host . $basePath);

// Database connection (PDO)
function getDB() {
    static $pdo = null;
    if ($pdo === null) {
        try {
            $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
            $pdo = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } catch (PDOException $e) {
            die('Database connection failed: ' . $e->getMessage());
        }
    }
    return $pdo;
}

// Navigation links — MoU removed from public navigation (admin-only)
function getNavLinks() {
    return [
        ['name' => 'Home', 'href' => BASE_URL . '/'],
        ['name' => 'Resource Generation', 'href' => BASE_URL . '/resource-generation.php'],
        ['name' => 'Publications', 'href' => BASE_URL . '/publications.php'],
        ['name' => 'Team', 'href' => BASE_URL . '/team.php'],
        ['name' => 'Dean RGIA', 'href' => BASE_URL . '/dean-rgia.php'],
        ['name' => 'Souvenir', 'href' => BASE_URL . '/souvenir.php'],
        ['name' => 'Contact', 'href' => BASE_URL . '/contact.php'],
    ];
}
