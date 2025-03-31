<?php
// Start session
session_start();

// Define routes
$routes = [
    '/' => 'index.php',
    '/user' => 'user/time_tracking.php', // Redirect user main page to time tracking
    '/user/time-tracking' => 'user/time_tracking.php',
    '/user/time-sheets' => 'user/time_sheets.php',
    '/user/leave-management' => 'user/leave_management.php',
    '/admin' => 'admin/time_tracking.php', // Redirect admin main page to time tracking
    '/admin/time-tracking' => 'admin/time_tracking.php',
    '/admin/time-sheets' => 'admin/time_sheets.php',
    '/admin/leave-management' => 'admin/leave_management.php',
    '/about' => 'about.php', // New route
];

// Get the current path
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Route the request
if (array_key_exists($requestUri, $routes)) {
    require $routes[$requestUri];
} else {
    http_response_code(404);
    echo "<h1>404 - Page Not Found</h1>";
    echo "<p>The page you are looking for does not exist.</p>";
}