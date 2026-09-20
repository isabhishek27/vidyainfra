<?php

$routes->group(
    '', ['namespace' => '\Modules\Blog\Controllers'], function ($routes) {
        $routes->get('blog', 'Blog::index');        
        $routes->get('blog/article/(:any)', 'Blog::article_details/$1');
        $routes->get('blog/(:any)', 'Blog::articles/$1');
        
    }
);