<?php
$routes->group(
    '', ['namespace' => '\Modules\Workshops\Controllers'], function ($routes) {
        $routes->get('workshops', 'Workshops::index');
        
        //$routes->get('workshops/details/(:any)', 'Workshops::details/$1');
        
        $routes->get('photo-workshop/(:any)', 'Workshops::details/$1');

        $routes->post('workshops/detailpost', 'Workshops::detailpost');
        //$routes->post('workshops/(:any)', 'Workshops::details/$1');
        $routes->get('workshops/billing-info', 'Workshops::checkout');
        $routes->post('workshops/billing-info', 'Workshops::checkout');        
        $routes->get('workshops/payment', 'Workshops::payment');
        $routes->post('workshops/payment', 'Workshops::payment');

        $routes->get('workshops/payment/success/(:any)', 'Workshops::success');
        $routes->post('workshops/payment/success/(:any)', 'Workshops::success');
        $routes->get('workshops/payment/cancle/(:any)', 'Workshops::cancle');

        $routes->get('workshops/payment/printinv/(:any)', 'Workshops::printinvoice');

        $routes->post('workshops/payment/verify-coupon', 'Workshops::verifycoupon');

        $routes->post('workshops/post-notifyme', 'Workshops::notify');
          
    }
);