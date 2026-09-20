<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class VidyaInfraSeeder extends Seeder
{
    public function run()
    {
        $db = $this->db;
        $now = date('Y-m-d H:i:s');

        // Skip if already seeded
        if ($db->table('site_settings')->countAllResults() > 0) {
            echo "VidyaInfra already seeded. Skipping.\n";
            return;
        }

        $settings = [
            ['website_name', 'Vidya Infra Construction', 'general'],
            ['company_name', 'Vidya Infra Construction', 'general'],
            ['logo', 'logo/logo.png', 'branding'],
            ['logo_alt', 'logo/logo2.png', 'branding'],
            ['favicon', 'favicon/favicon.ico', 'branding'],
            ['phone', '+91 8595189698', 'contact'],
            ['email', 'vidyainfra0203@gmail.com', 'contact'],
            ['address', "3rd Floor, B-164, Pandav Nagar,\nNew Delhi – 110092", 'contact'],
            ['google_map_url', '', 'contact'],
            ['whatsapp', '918595189698', 'contact'],
            ['facebook_url', 'https://www.facebook.com/people/Vidya-Infra/', 'social'],
            ['instagram_url', 'https://www.instagram.com/vidya_infra/', 'social'],
            ['linkedin_url', 'https://www.linkedin.com/in/sneha-y-54a87214b?utm_source=share_via&utm_content=profile&utm_medium=member_ios', 'social'],
            ['youtube_url', '', 'social'],
            ['footer_description', 'Architectural design & construction firm delivering premium projects across India since 2008.', 'footer'],
            ['copyright_text', 'Vidya Infra Construction. All rights reserved.', 'footer'],
            ['seo_title', 'Vidya Infra Construction — Building Landmarks, Delivering Trust', 'seo'],
            ['seo_description', 'Vidya Infra Construction — architectural design & construction firm delivering premium residential, commercial and infrastructure projects across India.', 'seo'],
            ['seo_keywords', 'Vidya Infra, construction, architectural design, Delhi, MEP, civil works', 'seo'],
            ['og_image', 'logo/logo.png', 'seo'],
            ['hero_eyebrow', 'Established Excellence · Since 2008', 'home'],
            ['phone_icon', 'settings/phoneIcon.svg', 'branding'],
            ['email_icon', 'settings/emailIcon.svg', 'branding'],
        ];

        foreach ($settings as $s) {
            $db->table('site_settings')->insert([
                'setting_key' => $s[0],
                'setting_value' => $s[1],
                'setting_group' => $s[2],
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // Update admin user site info
        $db->table('tbl_users')->where('id', 1)->update([
            'comp_name' => 'Vidya Infra Construction',
            'user_email' => 'vidyainfra0203@gmail.com',
            'phone1' => '+91 8595189698',
            'phone2' => '',
            'address' => "3rd Floor, B-164, Pandav Nagar,\nNew Delhi – 110092",
            'fb_link' => 'https://www.facebook.com/people/Vidya-Infra/',
            'instagram_link' => 'https://www.instagram.com/vidya_infra/',
            'linkedin_link' => 'https://www.linkedin.com/in/sneha-y-54a87214b?utm_source=share_via&utm_content=profile&utm_medium=member_ios',
            'user_password' => md5('Admin@123'),
            'firstname' => 'Admin',
            'user_name' => 'admin',
        ]);

        // Pages
        $pages = [
            [
                'title' => 'Home',
                'slug' => 'home',
                'subtitle' => 'Building Landmarks, Delivering Trust.',
                'seo_title' => 'Vidya Infra Construction — Building Landmarks, Delivering Trust',
                'seo_description' => 'Vidya Infra Construction — architectural design & construction firm delivering premium residential, commercial and infrastructure projects across India.',
                'status' => 1,
                'sort_order' => 1,
            ],
            [
                'title' => 'About',
                'slug' => 'about',
                'subtitle' => 'Crafting spaces. Building trust.',
                'breadcrumb' => 'About',
                'hero_image' => 'pages/about-2.jpg',
                'seo_title' => 'About — Vidya Infra Construction',
                'seo_description' => 'Learn about Vidya Infra Construction — our story, values, leadership and commitment to architectural excellence.',
                'status' => 1,
                'sort_order' => 2,
            ],
            [
                'title' => 'Services',
                'slug' => 'services',
                'subtitle' => 'End-to-end services, one accountable team',
                'breadcrumb' => 'Services',
                'hero_image' => 'services/s2.jpg',
                'seo_title' => 'Services — Vidya Infra Construction',
                'seo_description' => 'Architectural design, construction, structural engineering, interior fit-out and more — full-service offerings from Vidya Infra Construction.',
                'status' => 1,
                'sort_order' => 3,
            ],
            [
                'title' => 'Projects',
                'slug' => 'projects',
                'subtitle' => 'Projects that define skylines',
                'breadcrumb' => 'Projects',
                'hero_image' => 'hero/slide3.jpg',
                'seo_title' => 'Projects — Vidya Infra Construction',
                'seo_description' => 'Explore the portfolio of Vidya Infra Construction — residential, commercial and infrastructure projects delivered across India.',
                'status' => 1,
                'sort_order' => 4,
            ],
            [
                'title' => 'Contact',
                'slug' => 'contact',
                'subtitle' => "Let's build together",
                'breadcrumb' => 'Contact',
                'hero_image' => 'hero/slide2.jpg',
                'seo_title' => 'Contact — Vidya Infra Construction',
                'seo_description' => 'Get in touch with Vidya Infra Construction. Send us your project brief and our team will respond within 24 hours.',
                'status' => 1,
                'sort_order' => 5,
            ],
            [
                'title' => 'Certificates',
                'slug' => 'certificates',
                'subtitle' => 'Our Certifications',
                'breadcrumb' => 'Certificates',
                'seo_title' => 'Certificates — Vidya Infra Construction',
                'seo_description' => 'Certifications and credentials of Vidya Infra Construction.',
                'status' => 1,
                'sort_order' => 6,
            ],
        ];

        foreach ($pages as $p) {
            $p['created_at'] = $now;
            $p['updated_at'] = $now;
            $db->table('pages')->insert($p);
        }

        $homeId = $db->table('pages')->where('slug', 'home')->get()->getRow()->id;
        $aboutId = $db->table('pages')->where('slug', 'about')->get()->getRow()->id;
        $contactId = $db->table('pages')->where('slug', 'contact')->get()->getRow()->id;
        $servicesPageId = $db->table('pages')->where('slug', 'services')->get()->getRow()->id;

        // Page sections - Home
        $sections = [
            [
                'page_id' => $homeId,
                'section_key' => 'hero',
                'eyebrow' => 'Established Excellence · Since 2008',
                'title' => 'Building <span>Landmarks</span>,<br/>Delivering Trust.',
                'content' => 'An architectural and construction company crafting residential, commercial and infrastructure projects that stand the test of time — engineered with precision, delivered with integrity.',
                'extra_json' => json_encode([
                    'slides' => [
                        'hero/slide1.jpg', 'hero/slide2.jpg', 'hero/slide3.jpg',
                        'hero/slide4.jpg', 'hero/slide5.jpg', 'hero/slide6.jpg',
                    ],
                ]),
                'status' => 1,
                'sort_order' => 1,
            ],
            [
                'page_id' => $homeId,
                'section_key' => 'about_preview',
                'eyebrow' => 'About Vidya Infra',
                'title' => 'Where architectural vision meets construction discipline.',
                'content' => "Vidya Infra Construction is a full-service infrastructure and design solutions provider dedicated to shaping functional, high-quality spaces. We bring a unified approach to the built environment, seamlessly integrating structural integrity, modern aesthetics, and mechanical precision.\n\nFrom full-scale architectural design and custom interior execution to critical MEP (Mechanical, Electrical, and Plumbing) installations and long-term civil maintenance, we manage every phase of a project's lifecycle. Our focus remains on delivering durable, cost-effective, and precisely engineered solutions tailored to commercial, industrial, and residential needs.",
                'image' => 'pages/about-1.jpg',
                'button_text' => 'More About Us',
                'button_link' => '/about',
                'status' => 1,
                'sort_order' => 2,
            ],
            [
                'page_id' => $homeId,
                'section_key' => 'cta',
                'title' => 'Have a project in mind?',
                'content' => "Let's discuss your vision. Our team will get back within 24 hours with a tailored proposal.",
                'button_text' => 'Start a Conversation →',
                'button_link' => '/contact',
                'status' => 1,
                'sort_order' => 3,
            ],
            // About page
            [
                'page_id' => $aboutId,
                'section_key' => 'who_we_are',
                'eyebrow' => 'Who We Are',
                'title' => 'A unified approach to the built environment.',
                'content' => 'Vidya Infra Construction is a full-service infrastructure and design solutions provider dedicated to shaping functional, high-quality spaces. We bring a unified approach to the built environment, seamlessly integrating structural integrity, modern aesthetics, and mechanical precision.',
                'content_2' => "From full-scale architectural design and custom interior execution to critical MEP (Mechanical, Electrical, and Plumbing) installations and long-term civil maintenance, we manage every phase of a project's lifecycle. Our focus remains on delivering durable, cost-effective, and precisely engineered solutions tailored to commercial, industrial, and residential needs.",
                'image' => 'pages/about-1.jpg',
                'status' => 1,
                'sort_order' => 1,
            ],
            [
                'page_id' => $aboutId,
                'section_key' => 'mission',
                'eyebrow' => 'What Guides Us',
                'title' => 'Mission & Vision',
                'extra_json' => json_encode([
                    'mission_tag' => 'Mission',
                    'mission_title' => 'Precision, quality, transparency.',
                    'mission_content' => 'To deliver reliable engineering, architectural design, and construction services through precision execution, high quality standards, and transparent project management. We aim to protect, enhance, and transform built environments while ensuring safety, durability, and complete client satisfaction at every stage.',
                    'vision_tag' => 'Vision',
                    'vision_title' => 'A trusted regional leader.',
                    'vision_content' => 'To be a trusted regional leader in comprehensive construction, maintenance, and design services — recognized for engineering excellence, innovative design execution, and sustainable infrastructure practices that stand the test of time.',
                ]),
                'status' => 1,
                'sort_order' => 2,
            ],
            [
                'page_id' => $aboutId,
                'section_key' => 'core_strengths',
                'eyebrow' => 'Why Vidya Infra',
                'title' => 'Core strengths',
                'extra_json' => json_encode([
                    ['tag' => '01', 'title' => 'Comprehensive Execution', 'content' => 'End-to-end management spanning architectural concepts to fine interior detailing.'],
                    ['tag' => '02', 'title' => 'Technical Expertise', 'content' => 'Advanced MEP design and integration to ensure optimal operational efficiency.'],
                    ['tag' => '03', 'title' => 'Structural Longevity', 'content' => 'Focused civil repair and proactive maintenance strategies that preserve asset value.'],
                    ['tag' => '04', 'title' => 'Client-Centric Delivery', 'content' => 'Direct coordination, transparent timelines, and strict adherence to project budgets.'],
                ]),
                'status' => 1,
                'sort_order' => 3,
            ],
            [
                'page_id' => $aboutId,
                'section_key' => 'cta',
                'title' => "Let's build something remarkable together.",
                'content' => "From first sketch to final handover — we're here for every step.",
                'button_text' => 'Talk to Our Team →',
                'button_link' => '/contact',
                'status' => 1,
                'sort_order' => 4,
            ],
            [
                'page_id' => $servicesPageId,
                'section_key' => 'intro',
                'eyebrow' => 'What we deliver',
                'title' => 'From concept to completion',
                'content' => 'Every service is delivered by an in-house team of architects, engineers and site professionals — no handoffs, no finger-pointing.',
                'status' => 1,
                'sort_order' => 1,
            ],
            [
                'page_id' => $contactId,
                'section_key' => 'intro',
                'eyebrow' => 'Get in touch',
                'title' => "We'd love to hear about your project.",
                'content' => 'Share your requirement using the form and our team will get back within 24 hours with a tailored proposal.',
                'status' => 1,
                'sort_order' => 1,
            ],
        ];

        foreach ($sections as $sec) {
            $sec['created_at'] = $now;
            $sec['updated_at'] = $now;
            $db->table('page_sections')->insert($sec);
        }

        // Services
        $services = [
            ['Repairing & Maintenance of Civil Work', 'repairing-maintenance-of-civil-work', 'services/s1.jpg', 1],
            ['Electrical- MEP', 'electrical-mep', 'services/s2.jpg', 2],
            ['Building Completion / Interior Works', 'building-completion-interior-works', 'services/s3.jpg', 3],
            ['Architectural Design Consultant', 'architectural-design-consultant', 'services/s4.jpg', 4],
            ['Physical Model', 'physical-model', 'services/s5.jpg', 5],
            ['3D Rendering & Walkthrough', '3d-rendering-walkthrough', 'services/s6.jpg', 6],
        ];

        $archId = null;
        foreach ($services as $s) {
            $db->table('services')->insert([
                'title' => $s[0],
                'slug' => $s[1],
                'featured_image' => $s[2],
                'short_description' => '',
                'seo_title' => $s[0] . ' — Vidya Infra Construction',
                'seo_description' => $s[0] . ' services by Vidya Infra Construction.',
                'status' => 1,
                'sort_order' => $s[3],
                'show_in_footer' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            if ($s[1] === 'architectural-design-consultant') {
                $archId = $db->insertID();
            }
        }

        $subServices = [
            ['Residential', 'residential'],
            ['Commercial', 'commercial'],
            ['Villa', 'villa'],
            ['Plot Development', 'plot-development'],
        ];
        $i = 1;
        foreach ($subServices as $sub) {
            $db->table('services')->insert([
                'parent_id' => $archId,
                'title' => $sub[0],
                'slug' => $sub[1],
                'status' => 1,
                'sort_order' => $i++,
                'show_in_footer' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // Project categories
        $cats = [
            ['Civil Works', 'civil-works', 'civil', 1],
            ['Architectural Design', 'architectural-design', 'arch', 2],
            ['Physical Model', 'physical-model', 'model', 3],
            ['3D Rendering & Walkthrough', '3d-rendering-walkthrough', 'render', 4],
        ];
        $catIds = [];
        foreach ($cats as $c) {
            $db->table('project_categories')->insert([
                'name' => $c[0],
                'slug' => $c[1],
                'filter_class' => $c[2],
                'status' => 1,
                'sort_order' => $c[3],
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            $catIds[$c[2]] = $db->insertID();
        }

        // Projects + images
        $projectsData = [
            [
                'title' => 'Ambedkar Hospital · NBCC',
                'slug' => 'ambedkar-hospital-nbcc',
                'cat' => 'civil',
                'client' => 'NBCC',
                'location' => 'Delhi',
                'images' => [
                    ['civil-1.jpg', '504-1120'],
                    ['civil-2.jpg', '504-1120'],
                    ['civil-3.jpg', '504-1120'],
                    ['civil-4.jpg', '504-1120'],
                    ['civil-5.jpg', '504-1120'],
                    ['civil-6.jpg', '504-1120'],
                ],
            ],
            [
                'title' => 'Architectural Design Services',
                'slug' => 'architectural-design-services',
                'cat' => 'arch',
                'client' => '',
                'location' => '',
                'images' => [
                    ['arch-1.jpg', '1600-681'],
                    ['arch-2.jpg', '1600-681'],
                    ['arch-4.jpg', '1200-667'],
                    ['arch-5.jpg', '995-1600'],
                    ['arch-6.jpg', '995-1600'],
                    ['arch-7.jpg', '1280-531'],
                    ['arch-8.jpg', '1600-664'],
                    ['arch-9.jpg', '1280-811'],
                    ['arch-10.jpg', '1600-1000'],
                    ['arch-11.jpg', '1280-720'],
                    ['arch-12.jpg', '1280-737'],
                ],
            ],
            [
                'title' => 'Physical Model',
                'slug' => 'physical-model-portfolio',
                'cat' => 'model',
                'client' => '',
                'location' => '',
                'images' => [
                    ['model-1.jpg', '1280-963'],
                    ['model-2.jpg', '1280-963'],
                    ['model-3.jpg', '1280-963'],
                    ['model-4.jpg', '1280-963'],
                    ['model-5.jpg', '1280-963'],
                    ['model-6.jpg', '1280-963'],
                    ['model-7.jpg', '1280-963'],
                    ['model-8.jpg', '1280-960'],
                    ['model-9.jpg', '1280-960'],
                    ['model-10.jpg', '1280-960'],
                    ['model-11.jpg', '1280-960'],
                    ['model-12.jpg', '960-1280'],
                    ['model-13.jpg', '1200-1600'],
                ],
            ],
            [
                'title' => '3D Rendering & Walkthrough',
                'slug' => '3d-rendering-walkthrough-portfolio',
                'cat' => 'render',
                'client' => '',
                'location' => '',
                'images' => [
                    ['render-1.jpg', '1280-578'],
                ],
            ],
            [
                'title' => 'Ozen Realtor, Nagpur',
                'slug' => 'ozen-realtor-nagpur',
                'cat' => 'render',
                'client' => 'Ozen Realtor',
                'location' => 'Nagpur',
                'images' => [
                    ['render-2.jpg', '1280-720'],
                ],
            ],
        ];

        $sort = 1;
        foreach ($projectsData as $proj) {
            $catId = $catIds[$proj['cat']];
            $featImg = 'project_gallery/' . $proj['images'][0][0];
            $db->table('projects')->insert([
                'category_id' => $catId,
                'title' => $proj['title'],
                'slug' => $proj['slug'],
                'short_description' => $proj['title'],
                'client' => $proj['client'],
                'location' => $proj['location'],
                'featured_image' => $featImg,
                'seo_title' => $proj['title'] . ' — Vidya Infra Construction',
                'seo_description' => $proj['title'],
                'status' => 1,
                'is_featured' => 1,
                'sort_order' => $sort++,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            $projectId = $db->insertID();
            $imgSort = 1;
            foreach ($proj['images'] as $img) {
                $path = 'project_gallery/' . $img[0];
                $db->table('project_images')->insert([
                    'project_id' => $projectId,
                    'image_path' => $path,
                    'caption' => $proj['title'],
                    'alt_text' => $proj['title'] . ' — Vidya Infra Construction',
                    'lg_size' => $img[1],
                    'is_primary' => $imgSort === 1 ? 1 : 0,
                    'sort_order' => $imgSort++,
                    'status' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
                $db->table('media')->insert([
                    'original_name' => $img[0],
                    'file_name' => $img[0],
                    'file_path' => $path,
                    'file_type' => 'image',
                    'mime_type' => 'image/jpeg',
                    'module' => 'projects',
                    'module_id' => $projectId,
                    'alt_text' => $proj['title'],
                    'title' => $proj['title'],
                    'created_at' => $now,
                ]);
            }
        }

        // Social links
        $socials = [
            ['facebook', 'https://www.facebook.com/people/Vidya-Infra/', 'Facebook — Vidya Infra', 'f', 1],
            ['linkedin', 'https://www.linkedin.com/in/sneha-y-54a87214b?utm_source=share_via&utm_content=profile&utm_medium=member_ios', 'LinkedIn — Sneha Y', 'in', 2],
            ['instagram', 'https://www.instagram.com/vidya_infra/', 'Instagram — @vidya_infra', 'ig', 3],
        ];
        foreach ($socials as $s) {
            $db->table('social_links')->insert([
                'platform' => $s[0],
                'url' => $s[1],
                'label' => $s[2],
                'icon' => $s[3],
                'status' => 1,
                'sort_order' => $s[4],
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // Menus
        $db->table('menus')->insert(['name' => 'Main Navigation', 'location' => 'header', 'status' => 1, 'created_at' => $now, 'updated_at' => $now]);
        $headerMenuId = $db->insertID();
        $db->table('menus')->insert(['name' => 'Footer Company', 'location' => 'footer_company', 'status' => 1, 'created_at' => $now, 'updated_at' => $now]);
        $footerMenuId = $db->insertID();

        $menuItems = [
            [$headerMenuId, 'Home', '/', 1],
            [$headerMenuId, 'About', '/about', 2],
            [$headerMenuId, 'Projects', '/projects', 3],
            [$headerMenuId, 'Services', '/services', 4],
            [$headerMenuId, 'Contact', '/contact', 5],
            [$footerMenuId, 'About', '/about', 1],
            [$footerMenuId, 'Projects', '/projects', 2],
            [$footerMenuId, 'Services', '/services', 3],
            [$footerMenuId, 'Contact', '/contact', 4],
        ];
        foreach ($menuItems as $m) {
            $db->table('menu_items')->insert([
                'menu_id' => $m[0],
                'title' => $m[1],
                'url' => $m[2],
                'status' => 1,
                'sort_order' => $m[3],
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // Roles & permissions
        $roles = [
            ['Super Admin', 'super-admin', 'Full access'],
            ['Admin', 'admin', 'Administrative access'],
            ['Editor', 'editor', 'Content editing access'],
        ];
        foreach ($roles as $r) {
            $db->table('admin_roles')->insert([
                'name' => $r[0],
                'slug' => $r[1],
                'description' => $r[2],
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        $perms = [
            ['Dashboard', 'dashboard', 'dashboard'],
            ['Settings', 'settings', 'settings'],
            ['Pages', 'pages', 'pages'],
            ['Services', 'services', 'services'],
            ['Projects', 'projects', 'projects'],
            ['Media', 'media', 'media'],
            ['Enquiries', 'enquiries', 'enquiries'],
            ['Users', 'users', 'users'],
            ['SEO', 'seo', 'seo'],
            ['Testimonials', 'testimonials', 'content'],
            ['Team', 'team', 'content'],
            ['Gallery', 'gallery', 'content'],
        ];
        foreach ($perms as $p) {
            $db->table('admin_permissions')->insert([
                'name' => $p[0],
                'slug' => $p[1],
                'module' => $p[2],
                'created_at' => $now,
            ]);
        }

        // Super admin gets all permissions
        $permIds = $db->table('admin_permissions')->get()->getResult();
        foreach ($permIds as $perm) {
            $db->table('admin_role_permissions')->insert([
                'role_id' => 1,
                'permission_id' => $perm->id,
            ]);
        }

        // Media for logos/hero
        $staticMedia = [
            ['logo.png', 'logo/logo.png', 'logo'],
            ['logo2.png', 'logo/logo2.png', 'logo'],
            ['about-1.jpg', 'pages/about-1.jpg', 'pages'],
            ['about-2.jpg', 'pages/about-2.jpg', 'pages'],
        ];
        foreach ($staticMedia as $m) {
            $db->table('media')->insert([
                'original_name' => $m[0],
                'file_name' => $m[0],
                'file_path' => $m[1],
                'file_type' => 'image',
                'module' => $m[2],
                'created_at' => $now,
            ]);
        }

        for ($i = 1; $i <= 6; $i++) {
            $db->table('media')->insert([
                'original_name' => "slide{$i}.jpg",
                'file_name' => "slide{$i}.jpg",
                'file_path' => "hero/slide{$i}.jpg",
                'file_type' => 'image',
                'module' => 'hero',
                'created_at' => $now,
            ]);
        }

        echo "VidyaInfra seeder completed.\n";
    }
}
