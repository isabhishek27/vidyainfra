<?php
$uri = current_url(true);
$seg1 = ($uri->getSegment(1) != NULL) ? $uri->getSegment(1) : '';
$seg2 = ($uri->getSegment(2) != NULL) ? $uri->getSegment(2) : '';
$seg3 = ($uri->getSegment(3) != NULL) ? $uri->getSegment(3) : '';

$isOpen = function (array $keys) use ($seg2) {
	return in_array($seg2, $keys, true);
};
?>
<div class="left-side-bar">
	<div class="brand-logo">
		<a href="<?php echo site_url('admin/dashboard'); ?>">
			<span style="color:#1276BD;"><?php echo config('MyApplication')->site_logo_text; ?></span>
		</a>
		<div class="close-sidebar" data-toggle="left-sidebar-close">
			<i class="ion-close-round"></i>
		</div>
	</div>
	<div class="menu-block customscroll">
		<div class="sidebar-menu">
			<ul id="accordion-menu">
				<li>
					<a href="<?php echo site_url('admin/dashboard'); ?>" class="dropdown-toggle no-arrow <?php echo ($seg2 == 'dashboard') ? 'active' : ''; ?>">
						<span class="micon bi bi-calendar4-week"></span><span class="mtext">Dashboard</span>
					</a>
				</li>

				<li class="dropdown <?php echo $isOpen(['sitesettings', 'pagesadmin', 'pagesections', 'menus', 'settings']) ? 'show' : ''; ?>">
					<a href="javascript:;" class="dropdown-toggle">
						<span class="micon bi bi-globe"></span><span class="mtext">Website</span>
					</a>
					<ul class="submenu" <?php echo $isOpen(['sitesettings', 'pagesadmin', 'pagesections', 'menus', 'settings']) ? 'style="display:block;"' : ''; ?>>
						<li><a class="<?php echo ($seg2 === 'sitesettings') ? 'active' : ''; ?>" href="<?php echo site_url('admin/sitesettings'); ?>">Site Settings</a></li>
						<li><a class="<?php echo ($seg2 === 'pagesadmin') ? 'active' : ''; ?>" href="<?php echo site_url('admin/pagesadmin'); ?>">Pages</a></li>
						<li><a class="<?php echo ($seg2 === 'settings') ? 'active' : ''; ?>" href="<?php echo site_url('admin/settings'); ?>">Admin Profile</a></li>
					</ul>
				</li>

				<li class="dropdown <?php echo $isOpen(['services']) ? 'show' : ''; ?>">
					<a href="javascript:;" class="dropdown-toggle">
						<span class="micon bi bi-tools"></span><span class="mtext">Services</span>
					</a>
					<ul class="submenu" <?php echo $isOpen(['services']) ? 'style="display:block;"' : ''; ?>>
						<li><a class="<?php echo ($seg2 === 'services') ? 'active' : ''; ?>" href="<?php echo site_url('admin/services'); ?>">All Services</a></li>
					</ul>
				</li>

				<li class="dropdown <?php echo $isOpen(['projects', 'projectcategories', 'projectimages']) ? 'show' : ''; ?>">
					<a href="javascript:;" class="dropdown-toggle">
						<span class="micon bi bi-building"></span><span class="mtext">Projects</span>
					</a>
					<ul class="submenu" <?php echo $isOpen(['projects', 'projectcategories', 'projectimages']) ? 'style="display:block;"' : ''; ?>>
						<li><a class="<?php echo ($seg2 === 'projects') ? 'active' : ''; ?>" href="<?php echo site_url('admin/projects'); ?>">All Projects</a></li>
						<li><a class="<?php echo ($seg2 === 'projectcategories') ? 'active' : ''; ?>" href="<?php echo site_url('admin/projectcategories'); ?>">Categories</a></li>
					</ul>
				</li>

				<li class="dropdown <?php echo $isOpen(['contact-enquiries', 'service-enquiries', 'enquiries']) ? 'show' : ''; ?>">
					<a href="javascript:;" class="dropdown-toggle">
						<span class="micon bi bi-envelope"></span><span class="mtext">Enquiries</span>
					</a>
					<ul class="submenu" <?php echo $isOpen(['contact-enquiries', 'service-enquiries', 'enquiries']) ? 'style="display:block;"' : ''; ?>>
						<li><a class="<?php echo ($seg2 === 'contact-enquiries') ? 'active' : ''; ?>" href="<?php echo site_url('admin/contact-enquiries'); ?>">Contact Enquiries</a></li>
						<li><a class="<?php echo ($seg2 === 'service-enquiries') ? 'active' : ''; ?>" href="<?php echo site_url('admin/service-enquiries'); ?>">Service Enquiries</a></li>
					</ul>
				</li>

				<li class="dropdown <?php echo ($seg2 == 'seo') ? 'show' : ''; ?>">
					<a href="javascript:;" class="dropdown-toggle">
						<span class="micon bi bi-search"></span><span class="mtext">SEO</span>
					</a>
					<ul class="submenu" <?php echo ($seg2 == 'seo') ? 'style="display:block;"' : ''; ?>>
						<li><a class="<?php echo ($seg2 === 'seo') ? 'active' : ''; ?>" href="<?php echo site_url('admin/seo'); ?>">Page SEO</a></li>
						<li><a href="<?php echo site_url('admin/sitesettings'); ?>">Global SEO</a></li>
					</ul>
				</li>

				<li class="dropdown <?php echo $isOpen(['adminusers', 'roles']) ? 'show' : ''; ?>">
					<a href="javascript:;" class="dropdown-toggle">
						<span class="micon bi bi-shield-lock"></span><span class="mtext">Administration</span>
					</a>
					<ul class="submenu" <?php echo $isOpen(['adminusers', 'roles']) ? 'style="display:block;"' : ''; ?>>
						<li><a href="<?php echo site_url('admin/settings'); ?>">Admin Users / Profile</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</div>
<div class="mobile-menu-overlay"></div>
