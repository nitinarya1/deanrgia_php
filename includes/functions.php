<?php
/**
 * Helper Functions
 * Dean RGIA - MNNIT Allahabad
 */

/**
 * Sanitize user input
 */
function sanitize($str) {
    return htmlspecialchars(trim($str), ENT_QUOTES, 'UTF-8');
}

/**
 * Ensure external URLs have https://
 */
function formatUrl($url) {
    if (empty($url) || $url === '#') return '#';
    if (strpos($url, 'http') === 0) return $url;
    return 'https://' . $url;
}

/**
 * Format date for display
 */
function formatDate($dateStr, $format = 'M d, Y') {
    if (empty($dateStr)) return '';
    $ts = strtotime($dateStr);
    if ($ts === false) return $dateStr;
    return date($format, $ts);
}

/**
 * Send JSON API response
 */
function apiResponse($data, $statusCode = 200) {
    http_response_code($statusCode);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

/**
 * Send JSON error response
 */
function apiError($message, $statusCode = 400) {
    apiResponse(['error' => true, 'message' => $message], $statusCode);
}

/**
 * Get current page filename for active nav detection
 */
function getCurrentPage() {
    return basename($_SERVER['SCRIPT_NAME']);
}

/**
 * Check if current page matches a nav link
 */
function isActivePage($href) {
    $currentPage = getCurrentPage();
    $linkPage = basename(parse_url($href, PHP_URL_PATH));
    
    // Special case for home page
    if ($currentPage === 'index.php' && ($linkPage === '' || $linkPage === 'index.php' || $linkPage === 'deanrgia_php')) {
        return true;
    }
    
    return $currentPage === $linkPage;
}

/**
 * Get image URL with base path handling
 */
function imageUrl($path) {
    if (empty($path)) return BASE_URL . '/public/placeholder-professor.svg';
    if (strpos($path, 'http') === 0) return $path;
    if (strpos($path, '/') === 0) return BASE_URL . $path;
    return BASE_URL . '/' . $path;
}

/**
 * Check admin auth for API endpoints
 */
function requireAdminAuth() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['admin_id'])) {
        apiError('Unauthorized', 401);
    }
}

/**
 * Get request method
 */
function getRequestMethod() {
    return $_SERVER['REQUEST_METHOD'];
}

/**
 * Get JSON body from POST/PUT request
 */
function getJsonBody() {
    $json = file_get_contents('php://input');
    return json_decode($json, true) ?? [];
}
