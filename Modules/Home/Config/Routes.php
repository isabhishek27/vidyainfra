<?php

$routes->group(
    '', ['namespace' => '\Modules\Home\Controllers'], function ($routes) {
        $routes->get('/', 'Home::index');
        $routes->post('/', 'Home::index');
        $routes->get('test', 'Home::test');
    }
);