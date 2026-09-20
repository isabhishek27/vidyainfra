<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateVidyaInfraTables extends Migration
{
    public function up()
    {
        // site_settings (key-value)
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'setting_key'=> ['type' => 'VARCHAR', 'constraint' => 100],
            'setting_value' => ['type' => 'TEXT', 'null' => true],
            'setting_group' => ['type' => 'VARCHAR', 'constraint' => 50, 'default' => 'general'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('setting_key');
        $this->forge->createTable('site_settings', true);

        // media
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'original_name' => ['type' => 'VARCHAR', 'constraint' => 255],
            'file_name'     => ['type' => 'VARCHAR', 'constraint' => 255],
            'file_path'     => ['type' => 'VARCHAR', 'constraint' => 500],
            'file_type'     => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'mime_type'     => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'file_size'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'width'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'height'        => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'alt_text'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'title'         => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'module'        => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'module_id'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey(['module', 'module_id']);
        $this->forge->createTable('media', true);

        // pages
        $this->forge->addField([
            'id'              => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'title'           => ['type' => 'VARCHAR', 'constraint' => 255],
            'slug'            => ['type' => 'VARCHAR', 'constraint' => 150],
            'subtitle'        => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'breadcrumb'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'hero_image'      => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'content'         => ['type' => 'LONGTEXT', 'null' => true],
            'seo_title'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'seo_description' => ['type' => 'TEXT', 'null' => true],
            'seo_keywords'    => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'og_image'        => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'canonical_url'   => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'robots'          => ['type' => 'VARCHAR', 'constraint' => 100, 'default' => 'index,follow'],
            'status'          => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'sort_order'      => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'created_at'      => ['type' => 'DATETIME', 'null' => true],
            'updated_at'      => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'      => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('slug');
        $this->forge->createTable('pages', true);

        // page_sections
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'page_id'      => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'section_key'  => ['type' => 'VARCHAR', 'constraint' => 100],
            'title'        => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'subtitle'     => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'eyebrow'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'content'      => ['type' => 'LONGTEXT', 'null' => true],
            'content_2'    => ['type' => 'LONGTEXT', 'null' => true],
            'image'        => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'button_text'  => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'button_link'  => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'extra_json'   => ['type' => 'TEXT', 'null' => true],
            'status'       => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'sort_order'   => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('section_key');
        $this->forge->addKey('page_id');
        $this->forge->createTable('page_sections', true);

        // service_categories
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'parent_id'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'name'        => ['type' => 'VARCHAR', 'constraint' => 200],
            'slug'        => ['type' => 'VARCHAR', 'constraint' => 200],
            'description' => ['type' => 'TEXT', 'null' => true],
            'status'      => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'sort_order'  => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('slug');
        $this->forge->createTable('service_categories', true);

        // services
        $this->forge->addField([
            'id'                => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'category_id'       => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'parent_id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'title'             => ['type' => 'VARCHAR', 'constraint' => 255],
            'slug'              => ['type' => 'VARCHAR', 'constraint' => 200],
            'short_description' => ['type' => 'TEXT', 'null' => true],
            'full_description'  => ['type' => 'LONGTEXT', 'null' => true],
            'featured_image'    => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'icon'              => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'seo_title'         => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'seo_description'   => ['type' => 'TEXT', 'null' => true],
            'status'            => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'sort_order'        => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'show_in_footer'    => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at'        => ['type' => 'DATETIME', 'null' => true],
            'updated_at'        => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'        => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('slug');
        $this->forge->addKey('category_id');
        $this->forge->addKey('parent_id');
        $this->forge->createTable('services', true);

        // project_categories
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'        => ['type' => 'VARCHAR', 'constraint' => 200],
            'slug'        => ['type' => 'VARCHAR', 'constraint' => 200],
            'filter_class'=> ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'description' => ['type' => 'TEXT', 'null' => true],
            'status'      => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'sort_order'  => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('slug');
        $this->forge->createTable('project_categories', true);

        // projects
        $this->forge->addField([
            'id'                => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'category_id'       => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'title'             => ['type' => 'VARCHAR', 'constraint' => 255],
            'slug'              => ['type' => 'VARCHAR', 'constraint' => 200],
            'short_description' => ['type' => 'TEXT', 'null' => true],
            'full_description'  => ['type' => 'LONGTEXT', 'null' => true],
            'location'          => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'client'            => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'project_type'      => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'completion_date'   => ['type' => 'DATE', 'null' => true],
            'featured_image'    => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'seo_title'         => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'seo_description'   => ['type' => 'TEXT', 'null' => true],
            'status'            => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'is_featured'       => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'sort_order'        => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'created_at'        => ['type' => 'DATETIME', 'null' => true],
            'updated_at'        => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'        => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('slug');
        $this->forge->addKey('category_id');
        $this->forge->createTable('projects', true);

        // project_images
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'project_id'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'media_id'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'image_path'   => ['type' => 'VARCHAR', 'constraint' => 500],
            'caption'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'alt_text'     => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'lg_size'      => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'is_primary'   => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'sort_order'   => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'status'       => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('project_id');
        $this->forge->createTable('project_images', true);

        // gallery
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'title'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'image_path' => ['type' => 'VARCHAR', 'constraint' => 500],
            'alt_text'   => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'status'     => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'sort_order' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('gallery', true);

        // testimonials
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'       => ['type' => 'VARCHAR', 'constraint' => 200],
            'designation'=> ['type' => 'VARCHAR', 'constraint' => 200, 'null' => true],
            'company'    => ['type' => 'VARCHAR', 'constraint' => 200, 'null' => true],
            'content'    => ['type' => 'TEXT'],
            'image'      => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'rating'     => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 5],
            'status'     => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'sort_order' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('testimonials', true);

        // team_members
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'       => ['type' => 'VARCHAR', 'constraint' => 200],
            'designation'=> ['type' => 'VARCHAR', 'constraint' => 200, 'null' => true],
            'bio'        => ['type' => 'TEXT', 'null' => true],
            'image'      => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'email'      => ['type' => 'VARCHAR', 'constraint' => 200, 'null' => true],
            'phone'      => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'status'     => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'sort_order' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('team_members', true);

        // contact_submissions
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'         => ['type' => 'VARCHAR', 'constraint' => 200],
            'phone'        => ['type' => 'VARCHAR', 'constraint' => 50],
            'email'        => ['type' => 'VARCHAR', 'constraint' => 200],
            'project_type' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'message'      => ['type' => 'TEXT', 'null' => true],
            'status'       => ['type' => 'VARCHAR', 'constraint' => 30, 'default' => 'new'],
            'admin_notes'  => ['type' => 'TEXT', 'null' => true],
            'ip_address'   => ['type' => 'VARCHAR', 'constraint' => 45, 'null' => true],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('status');
        $this->forge->createTable('contact_submissions', true);

        // service_enquiries
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'service_id'  => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'service_name'=> ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'name'        => ['type' => 'VARCHAR', 'constraint' => 200],
            'phone'       => ['type' => 'VARCHAR', 'constraint' => 50],
            'email'       => ['type' => 'VARCHAR', 'constraint' => 200],
            'message'     => ['type' => 'TEXT', 'null' => true],
            'status'      => ['type' => 'VARCHAR', 'constraint' => 30, 'default' => 'new'],
            'admin_notes' => ['type' => 'TEXT', 'null' => true],
            'ip_address'  => ['type' => 'VARCHAR', 'constraint' => 45, 'null' => true],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('service_id');
        $this->forge->createTable('service_enquiries', true);

        // social_links
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'platform'   => ['type' => 'VARCHAR', 'constraint' => 50],
            'url'        => ['type' => 'VARCHAR', 'constraint' => 500],
            'label'      => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'icon'       => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'status'     => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'sort_order' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('social_links', true);

        // menus
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'       => ['type' => 'VARCHAR', 'constraint' => 100],
            'location'   => ['type' => 'VARCHAR', 'constraint' => 50],
            'status'     => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('location');
        $this->forge->createTable('menus', true);

        // menu_items
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'menu_id'    => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'parent_id'  => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'title'      => ['type' => 'VARCHAR', 'constraint' => 150],
            'url'        => ['type' => 'VARCHAR', 'constraint' => 500],
            'target'     => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => '_self'],
            'status'     => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'sort_order' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('menu_id');
        $this->forge->createTable('menu_items', true);

        // admin_roles
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'        => ['type' => 'VARCHAR', 'constraint' => 100],
            'slug'        => ['type' => 'VARCHAR', 'constraint' => 100],
            'description' => ['type' => 'TEXT', 'null' => true],
            'status'      => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('slug');
        $this->forge->createTable('admin_roles', true);

        // admin_permissions
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'       => ['type' => 'VARCHAR', 'constraint' => 100],
            'slug'       => ['type' => 'VARCHAR', 'constraint' => 100],
            'module'     => ['type' => 'VARCHAR', 'constraint' => 100],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('slug');
        $this->forge->createTable('admin_permissions', true);

        // admin_role_permissions
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'role_id'       => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'permission_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['role_id', 'permission_id']);
        $this->forge->createTable('admin_role_permissions', true);

        // Extend tbl_users for role_id if column missing - handled in seeder via raw SQL
    }

    public function down()
    {
        $tables = [
            'admin_role_permissions', 'admin_permissions', 'admin_roles',
            'menu_items', 'menus', 'social_links', 'service_enquiries',
            'contact_submissions', 'team_members', 'testimonials', 'gallery',
            'project_images', 'projects', 'project_categories', 'services',
            'service_categories', 'page_sections', 'pages', 'media', 'site_settings',
        ];
        foreach ($tables as $table) {
            $this->forge->dropTable($table, true);
        }
    }
}
