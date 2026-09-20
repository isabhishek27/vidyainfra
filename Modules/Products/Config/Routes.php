<?php

$routes->group(
    '', ['namespace' => '\Modules\Products\Controllers'], function ($routes) {
        $routes->get('inventory', 'Products::index');
    }
);
