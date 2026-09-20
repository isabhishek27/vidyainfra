<?php

$routes->group(
    '', ['namespace' => '\Modules\Testimonials\Controllers'], function ($routes) {
        $routes->get('testimonials', 'Testimonials::index');
        $routes->post('post-testimonials', 'Testimonials::post_testimonials');
        
    }
);