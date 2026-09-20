<?php
$routes->group('', ['namespace' => '\Modules\Projects\Controllers'], function ($routes) {
    $routes->get('projects', 'Projects::index');
    $routes->get('projects/(:segment)', 'Projects::detail/$1');
});
