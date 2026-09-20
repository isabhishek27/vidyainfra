<?php

$routes->group(
    '', ['namespace' => '\Modules\Faqs\Controllers'], function ($routes) {
        $routes->get('faqs', 'Faqs::index');        
    }
);