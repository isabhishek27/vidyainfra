<?php

$routes->group(
    '', ['namespace' => '\Modules\Pages\Controllers'], function ($routes) {
        $routes->get('about', 'Pages::about');
        $routes->get('about-us', 'Pages::about');
        $routes->get('contact', 'Pages::contact_us');
        $routes->get('contact-us', 'Pages::contact_us');
        $routes->post('contact/submit', 'Pages::submit_contact');
        $routes->post('post-contact-us', 'Pages::submit_contact');
        $routes->get('certificates', 'Pages::certificates');
        $routes->get('sitemap\.xml', 'Pages::sitemap');
        $routes->get('robots\.txt', 'Pages::robots');
        $routes->get('thanks', 'Pages::thank_you');
    }
);
