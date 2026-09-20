<!DOCTYPE html>
<html>

<head>

<?php echo view('Modules\Admin\Views\inc\top_head'); ?>

</head>
	<body class="login-page">
		<div class="login-header box-shadow">
			<div
				class="container-fluid d-flex justify-content-between align-items-center"
			>
				<div class="brand-logo">
					<a href="<?php echo site_url('admin');?>">
						<span style="color:#1276BD;"><?php echo config('MyApplication')->site_logo_text;?></span>
					</a>
				</div>
				<div class="login-menu">
					<?php /*
					<ul>
						<li><a href="register.html">Register</a></li>
					</ul> */?>
				</div>
			</div>
		</div>
		<div
			class="login-wrap d-flex align-items-center flex-wrap justify-content-center"
		>
			<div class="container">
				<div class="row align-items-center">
					 
					<div class="col-md-6 offset-md-3 ">
						<div class="login-box bg-white box-shadow border-radius-10">
							<div class="login-title">
								<h2 class="text-center text-primary">Login To <?php echo config('MyApplication')->site_logo_text;?></h2>
							</div>

							<?php if (session()->getFlashdata('error') !== NULL) : ?>
								<div class="alert alert-danger" role="alert"><?php echo session()->getFlashdata('error'); ?></div>
							<?php endif; ?>	

							<?php echo validation_list_errors(); ?>

							
								<?php echo form_open('admin/login',['csrf_id'=>'my-id']);?>
								
								<div class="input-group custom">
									<input type="text" name="user_name" id="user_name" class="form-control form-control-lg" placeholder="Username" value="<?php echo $remember['user_name'];?>"/>
									
									<div class="input-group-append custom">
										<span class="input-group-text"
											><i class="icon-copy dw dw-user1"></i
										></span>
									</div>
								</div>
								<div class="input-group custom">
									<input type="password" name="user_password" id="user_password" class="form-control form-control-lg"	placeholder="**********" value="<?php echo $remember['user_password'];?>" />
									
									<div class="input-group-append custom">
										<span class="input-group-text"
											><i class="dw dw-padlock1"></i
										></span>
									</div>
								</div>
								<div class="row pb-30">
									<div class="col-6">
										<div class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input" name="remember" id="customCheck1" <?php echo ($remember['user_name'] && !empty($remember['user_name']))?'checked="checked"':'';?> />
											<label class="custom-control-label" for="customCheck1">Remember</label>
										</div>
									</div>
									<div class="col-6">
										<div class="forgot-password">
											<a href="forgot-password.html">Forgot Password</a>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12">
										<div class="input-group mb-0">
											
											
											<input class="btn btn-primary btn-lg btn-block" type="submit" value="Sign In">
										
											<!-- <a
												class="btn btn-primary btn-lg btn-block"
												href="index.html"
												>Sign In</a
											> -->
										</div>
										 
										 
									</div>
								</div>
							<?php echo form_close();?>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		
	 
	</div>
</div>
 
<!-- Bottom part -->
<?php echo view('Modules\Admin\Views\inc\bottom'); ?>

</body>

</html>