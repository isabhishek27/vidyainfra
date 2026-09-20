<?php

$routes->group(
    '', ['namespace' => '\Modules\Portfolio\Controllers'], function ($routes) {
        $routes->get('portfolio', 'Portfolio::index');
        
    }
);