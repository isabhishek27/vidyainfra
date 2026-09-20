<?php
//$routes->setAutoRoute(true);
$routes->group(
    'admin', ['namespace' => '\Modules\Admin\Controllers'], function ($routes) {
        
        $routes->get('/', 'Admin::login');

        $routes->get('login', 'Admin::login');
        $routes->post('login', 'Admin::login');        
        $routes->get('logout', 'Admin::logout');

        $routes->get('dashboard', 'Dashboard::index');

        #Editor image upload        
        $routes->get('cms/tmimageupload', 'Cms::tm_image_upload');
        $routes->post('cms/tmimageupload', 'Cms::tm_image_upload');

        #CMS Module
        $routes->get('cms', 'Cms::index');
        $routes->post('cms/page_details', 'Cms::page_details');
        $routes->get('cms/edit_page/(:num)', 'Cms::edit_page/$1');
        $routes->post('cms/edit_page/(:num)', 'Cms::edit_page/$1');

        $routes->get('cms/categories', 'Cms::categories');
        $routes->post('cms/categories', 'Cms::categories');
        $routes->get('cms/add_category', 'Cms::add_category');
        $routes->post('cms/add_category', 'Cms::add_category');

        $routes->get('cms/edit_category/(:num)', 'Cms::edit_category/$1');
        $routes->post('cms/edit_category/(:num)', 'Cms::edit_category/$1');
        $routes->get('cms/category_delete/(:num)', 'Cms::category_delete/$1');

        /** Portfolio */
        $routes->get('portfolio', 'Portfolio::index');
        $routes->post('portfolio', 'Portfolio::index');
        $routes->get('portfolio/add', 'Portfolio::add');
        $routes->post('portfolio/add', 'Portfolio::add');
        $routes->get('portfolio/edit/(:num)', 'Portfolio::edit/$1');
        $routes->post('portfolio/edit/(:num)', 'Portfolio::edit/$1');
        $routes->get('portfolio/delete/(:num)', 'Portfolio::delete/$1');

        /** Reveiws */
        $routes->get('reviews', 'Reviews::index');
        $routes->post('reviews', 'Reviews::index');
        $routes->get('reviews/add', 'Reviews::add');
        $routes->post('reviews/add', 'Reviews::add');
        $routes->get('reviews/edit/(:num)', 'Reviews::edit/$1');
        $routes->post('reviews/edit/(:num)', 'Reviews::edit/$1');
        $routes->get('reviews/delete/(:num)', 'Reviews::delete/$1');

        /** Photographar */
        $routes->get('photographar', 'Photographar::index');
        $routes->post('photographar', 'Photographar::index');
        $routes->get('photographar/add', 'Photographar::add');
        $routes->post('photographar/add', 'Photographar::add');
        $routes->get('photographar/edit/(:num)', 'Photographar::edit/$1');
        $routes->post('photographar/edit/(:num)', 'Photographar::edit/$1');
        $routes->get('photographar/delete/(:num)', 'Photographar::delete/$1');

        /** Photo Adventure */
        $routes->get('photoadventure', 'Photoadventure::index');
        $routes->post('photoadventure', 'Photoadventure::index');
        $routes->get('photoadventure/add', 'Photoadventure::add');
        $routes->post('photoadventure/add', 'Photoadventure::add');
        $routes->get('photoadventure/edit/(:num)', 'Photoadventure::edit/$1');
        $routes->post('photoadventure/edit/(:num)', 'Photoadventure::edit/$1');
        $routes->get('photoadventure/delete/(:num)', 'Photoadventure::delete/$1');

        /** Coupon */
        $routes->get('coupon', 'Coupon::index');
        $routes->post('coupon', 'Coupon::index');
        $routes->get('coupon/add', 'Coupon::add');
        $routes->post('coupon/add', 'Coupon::add');
        $routes->get('coupon/edit/(:num)', 'Coupon::edit/$1');
        $routes->post('coupon/edit/(:num)', 'Coupon::edit/$1');
        $routes->get('coupon/delete/(:num)', 'Coupon::delete/$1');

        /** Coupon */
        $routes->get('banners', 'Banners::index');
        $routes->post('banners', 'Banners::index');
        $routes->get('banners/add', 'Banners::add');
        $routes->post('banners/add', 'Banners::add');
        $routes->get('banners/edit/(:num)', 'Banners::edit/$1');
        $routes->post('banners/edit/(:num)', 'Banners::edit/$1');
        $routes->get('banners/delete/(:num)', 'Banners::delete/$1');

        /** Workshop */
        $routes->get('workshop', 'Workshop::index');
        $routes->post('workshop', 'Workshop::index');
        $routes->get('workshop/add', 'Workshop::add');
        $routes->post('workshop/add', 'Workshop::add');
        $routes->get('workshop/edit/(:num)', 'Workshop::edit/$1');
        $routes->post('workshop/edit/(:num)', 'Workshop::edit/$1');
        $routes->get('workshop/delete/(:num)', 'Workshop::delete/$1');

        /** Workshop Gallery */
        $routes->get('workshopgallery', 'Workshopgallery::index');
        $routes->post('workshopgallery', 'Workshopgallery::index');
        $routes->get('workshopgallery/add', 'Workshopgallery::add');
        $routes->post('workshopgallery/add', 'Workshopgallery::add');
        $routes->get('workshopgallery/edit/(:num)', 'Workshopgallery::edit/$1');
        $routes->post('workshopgallery/edit/(:num)', 'Workshopgallery::edit/$1');
        $routes->get('workshopgallery/delete/(:num)', 'Workshopgallery::delete/$1');

        /** Workshop Waiting List */
        $routes->get('workshop/waitinglist', 'Workshop::waitinglist');
        $routes->post('workshop/waitinglist', 'Workshop::waitinglist');        
        $routes->get('workshop/waitinglist_delete/(:num)', 'Workshop::waitinglist_delete/$1');

        /** Products / Inventory */
        $routes->get('product', 'Product::index');
        $routes->post('product', 'Product::index');
        $routes->get('product/add', 'Product::add');
        $routes->post('product/add', 'Product::add');
        $routes->get('product/edit/(:num)', 'Product::edit/$1');
        $routes->post('product/edit/(:num)', 'Product::edit/$1');
        $routes->get('product/delete/(:num)', 'Product::delete/$1');

        /** Product Gallery */
        $routes->get('productgallery', 'Productgallery::index');
        $routes->post('productgallery', 'Productgallery::index');
        $routes->get('productgallery/add', 'Productgallery::add');
        $routes->post('productgallery/add', 'Productgallery::add');
        $routes->get('productgallery/edit/(:num)', 'Productgallery::edit/$1');
        $routes->post('productgallery/edit/(:num)', 'Productgallery::edit/$1');
        $routes->get('productgallery/delete/(:num)', 'Productgallery::delete/$1');

        /** Faq */
        $routes->get('faq', 'Faq::index');
        $routes->post('faq', 'Faq::index');
        $routes->get('faq/add', 'Faq::add');
        $routes->post('faq/add', 'Faq::add');
        $routes->get('faq/edit/(:num)', 'Faq::edit/$1');
        $routes->post('faq/edit/(:num)', 'Faq::edit/$1');
        $routes->get('faq/delete/(:num)', 'Faq::delete/$1');

        /** Newsletter */

        $routes->get('newsletter', 'Newsletter::index');
        $routes->post('newsletter', 'Newsletter::index');
        $routes->get('newsletter/delete/(:num)', 'Newsletter::delete/$1');

        /** Settings */
        $routes->get('settings', 'Settings::index');
        $routes->post('settings', 'Settings::index');

         /** Orders */
        $routes->get('orders', 'Orders::index');
        $routes->post('orders', 'Orders::index');        
        $routes->post('orders/details', 'Orders::details');
        $routes->get('orders/order_delete/(:num)', 'Orders::order_delete/$1');
        $routes->get('orders/order_cancle/(:num)', 'Orders::order_cancle/$1');

        /** Enquiries */
        $routes->get('enquiries', 'Enquiries::index');
        $routes->post('enquiries', 'Enquiries::index');
        $routes->get('enquiries/interest', 'Enquiries::interest');
        $routes->post('enquiries/interest', 'Enquiries::interest');
        $routes->post('enquiries/enquiries_details', 'Enquiries::enquiries_details');
        $routes->get('enquiries/enquiries_delete/(:num)', 'Enquiries::enquiries_delete/$1');
       

        /** Request a quote */
        $routes->get('enquiries/requestquote', 'Enquiries::requestquote');
        $routes->post('enquiries/requestquote', 'Enquiries::requestquote');
        $routes->post('enquiries/requestquote_details', 'Enquiries::requestquote_details');
        $routes->get('enquiries/requestquote_delete/(:num)', 'Enquiries::requestquote_delete/$1');

        /** Blog Category */
        $routes->get('blog/category', 'Blog::category');
        $routes->post('blog/category', 'Blog::category');

        $routes->get('blog/category_add', 'Blog::category_add');
        $routes->post('blog/category_add', 'Blog::category_add');
        
        $routes->get('blog/category_edit/(:num)', 'Blog::category_edit/$1');
        $routes->post('blog/category_edit/(:num)', 'Blog::category_edit/$1');

        $routes->get('blog/category_delete/(:num)', 'Blog::category_delete/$1');

        /** Blog post */
        $routes->get('blog/post', 'Blog::post');
        $routes->post('blog/post', 'Blog::post');
        $routes->post('blog/post_details', 'Blog::post_details');

        $routes->get('blog/post_add', 'Blog::post_add');
        $routes->post('blog/post_add', 'Blog::post_add');
        
        $routes->get('blog/post_edit/(:num)', 'Blog::post_edit/$1');        
        $routes->post('blog/post_edit/(:num)', 'Blog::post_edit/$1');

        $routes->get('blog/post_delete/(:num)', 'Blog::post_delete/$1');


        /** SEO */
        $routes->get('seo', 'Seo::index');
        $routes->post('seo', 'Seo::index');
        $routes->get('seo/add', 'Seo::add');
        $routes->post('seo/add', 'Seo::add');
        $routes->get('seo/edit/(:num)', 'Seo::edit/$1');
        $routes->post('seo/edit/(:num)', 'Seo::edit/$1');
        $routes->get('seo/delete/(:num)', 'Seo::delete/$1');

        /** Vidya Infra — Site Settings */
        $routes->get('sitesettings', 'Sitesettings::index');
        $routes->post('sitesettings', 'Sitesettings::index');

        /** Vidya Infra — Services */
        $routes->get('services', 'Servicesctrl::index');
        $routes->post('services', 'Servicesctrl::index');
        $routes->get('services/create', 'Servicesctrl::create');
        $routes->post('services/create', 'Servicesctrl::create');
        $routes->get('services/edit/(:num)', 'Servicesctrl::edit/$1');
        $routes->post('services/edit/(:num)', 'Servicesctrl::edit/$1');
        $routes->get('services/delete/(:num)', 'Servicesctrl::delete/$1');

        /** Vidya Infra — Projects */
        $routes->get('projects', 'Projectsctrl::index');
        $routes->post('projects', 'Projectsctrl::index');
        $routes->get('projects/create', 'Projectsctrl::create');
        $routes->post('projects/create', 'Projectsctrl::create');
        $routes->get('projects/edit/(:num)', 'Projectsctrl::edit/$1');
        $routes->post('projects/edit/(:num)', 'Projectsctrl::edit/$1');
        $routes->get('projects/delete/(:num)', 'Projectsctrl::delete/$1');

        /** Contact / Service enquiries */
        $routes->get('contact-enquiries', 'Contactenquiries::index');
        $routes->get('contact-enquiries/view/(:num)', 'Contactenquiries::view/$1');
        $routes->post('contact-enquiries/view/(:num)', 'Contactenquiries::view/$1');
        $routes->get('contact-enquiries/delete/(:num)', 'Contactenquiries::delete/$1');

        $routes->get('service-enquiries', 'Serviceenquiries::index');
        $routes->get('service-enquiries/view/(:num)', 'Serviceenquiries::view/$1');
        $routes->post('service-enquiries/view/(:num)', 'Serviceenquiries::view/$1');
        $routes->get('service-enquiries/delete/(:num)', 'Serviceenquiries::delete/$1');

        /** Project categories */
        $routes->get('projectcategories', 'Projectcategories::index');
        $routes->post('projectcategories', 'Projectcategories::index');
        $routes->get('projectcategories/create', 'Projectcategories::create');
        $routes->post('projectcategories/create', 'Projectcategories::create');
        $routes->get('projectcategories/edit/(:num)', 'Projectcategories::edit/$1');
        $routes->post('projectcategories/edit/(:num)', 'Projectcategories::edit/$1');
        $routes->get('projectcategories/delete/(:num)', 'Projectcategories::delete/$1');

        /** Service categories */
        $routes->get('servicecategories', 'Servicecategories::index');
        $routes->post('servicecategories', 'Servicecategories::index');
        $routes->get('servicecategories/create', 'Servicecategories::create');
        $routes->post('servicecategories/create', 'Servicecategories::create');
        $routes->get('servicecategories/edit/(:num)', 'Servicecategories::edit/$1');
        $routes->post('servicecategories/edit/(:num)', 'Servicecategories::edit/$1');
        $routes->get('servicecategories/delete/(:num)', 'Servicecategories::delete/$1');

        /** Pages admin */
        $routes->get('pagesadmin', 'Pagesadmin::index');
        $routes->get('pagesadmin/edit/(:num)', 'Pagesadmin::edit/$1');
        $routes->post('pagesadmin/edit/(:num)', 'Pagesadmin::edit/$1');

        /** Media */
        $routes->get('media', 'Medialibrary::index');
        $routes->post('media', 'Medialibrary::index');
        $routes->get('media/delete/(:num)', 'Medialibrary::delete/$1');

        /** Content modules */
        $routes->get('testimonials', 'Testimonialsadmin::index');
        $routes->post('testimonials', 'Testimonialsadmin::index');
        $routes->get('testimonials/create', 'Testimonialsadmin::create');
        $routes->post('testimonials/create', 'Testimonialsadmin::create');
        $routes->get('testimonials/edit/(:num)', 'Testimonialsadmin::edit/$1');
        $routes->post('testimonials/edit/(:num)', 'Testimonialsadmin::edit/$1');
        $routes->get('testimonials/delete/(:num)', 'Testimonialsadmin::delete/$1');

        $routes->get('team', 'Teamadmin::index');
        $routes->post('team', 'Teamadmin::index');
        $routes->get('team/create', 'Teamadmin::create');
        $routes->post('team/create', 'Teamadmin::create');
        $routes->get('team/edit/(:num)', 'Teamadmin::edit/$1');
        $routes->post('team/edit/(:num)', 'Teamadmin::edit/$1');
        $routes->get('team/delete/(:num)', 'Teamadmin::delete/$1');

        $routes->get('gallery', 'Galleryadmin::index');
        $routes->post('gallery', 'Galleryadmin::index');
        $routes->get('gallery/create', 'Galleryadmin::create');
        $routes->post('gallery/create', 'Galleryadmin::create');
        $routes->get('gallery/delete/(:num)', 'Galleryadmin::delete/$1');
    }
);