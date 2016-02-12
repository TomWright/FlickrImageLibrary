<?php

$config = [];

$config['notFoundController'] = '\\App\\Controllers\\Error';

$config['notFoundAction'] = 'index';

$config['defaultAction'] = 'index';

$config['routeFiles'] = [
    APP_PATH . '/routes/main.php',
];

// We also want the ability to specify routes for specific sub-domains.
$subdomain = \Whirlpool\Request::subdomain();
if ($subdomain !== null) {
    $routesPath = APP_PATH . "/routes/{$subdomain}.php";
    if (file_exists($routesPath) && is_file($routesPath)) {
        $config['routeFiles'][] = $routesPath;
    }
}

return $config;