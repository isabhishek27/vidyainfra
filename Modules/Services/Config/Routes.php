<?php
$routes->group('', ['namespace' => '\Modules\Services\Controllers'], function ($routes) {
    $routes->get('services', 'Services::index');
    $routes->post('services/enquire', 'Services::enquire');
    $routes->get('services/(:segment)', 'Services::detail/$1');
});
