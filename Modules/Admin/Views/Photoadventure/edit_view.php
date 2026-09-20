<!DOCTYPE html>
<html>

<head><?php echo view('Modules\Admin\Views\inc\top_head'); ?>
<script src="<?php echo assets_image_url('admin/tinymce/js/tinymce/tinymce.min.js');?>" referrerpolicy="origin" crossorigin="anonymous"></script>

<script>
	/*
	tinymce.init({
	selector: 'textarea#cmscontainer',
	license_key: 'gpl',
	plugins: 'image',
	toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | image',
			images_upload_url: '<?php echo base_url("admin/cms/tmimageupload"); ?>'
	});*/
	
	tinymce.init({
		selector: 'textarea#cmscontainer',
		license_key: 'gpl',
		plugins: 'image code',
		toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | image',
		/* enable title field in the Image dialog*/
		image_title: true,
		/* enable automatic uploads of images represented by blob or data URIs*/
		automatic_uploads: true,
		/*
		URL of our upload handler (for more details check: https://www.tiny.cloud/docs/configure/file-image-upload/#images_upload_url)
		images_upload_url: 'postAcceptor.php',
		here we add custom filepicker only to Image dialog
		*/
		file_picker_types: 'image',
		/* and here's our custom image picker*/
		file_picker_callback: (cb, value, meta) => {
			const input = document.createElement('input');
			input.setAttribute('type', 'file');
			input.setAttribute('accept', 'image/*');
			input.addEventListener('change', (e) => {
				const file = e.target.files[0];
				const reader = new FileReader();
				reader.addEventListener('load', () => {
					/*
					Note: Now we need to register the blob in TinyMCEs image blob
					registry. In the next release this part hopefully won't be
					necessary, as we are looking to handle it internally.
					*/
					const id = 'blobid' + (new Date()).getTime();
					const blobCache =  tinymce.activeEditor.editorUpload.blobCache;
					const base64 = reader.result.split(',')[1];
					const blobInfo = blobCache.create(id, file, base64);
					blobCache.add(blobInfo);
					/* call the callback and populate the Title field with the file name */
					cb(blobInfo.blobUri(), { title: file.name });
				});
				reader.readAsDataURL(file);
			});
			
			input.click();
		},
		content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }'
	});
	</script>  
</head>

<body class="header-white sidebar-light">
	
    <?php echo view('Modules\Admin\Views\inc\header'); ?>

    <?php echo view('Modules\Admin\Views\inc\left'); ?>

	<div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">
                <div class="page-header">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="title">
                                <h4><?php echo $page_heading;?></h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo site_url('admin/dashboard');?>">Home</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo site_url('admin/photoadventure');?>">Photo Adventure</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        <?php echo $page_heading;?>
                                    </li>
                                </ol>
                            </nav>
                        </div>
                       
                    </div>
                </div>

                 <!-- Default Basic Forms Start -->
					<div class="pd-20 card-box mb-30">
						
						<?php echo form_open_multipart('admin/photoadventure/edit/'.$row->id);?>
                            <input type="hidden" name="id" value="<?php echo $row->id;?>">

							<div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Name</label>
								<div class="col-sm-12 col-md-10">
									<input class="form-control" type="text" placeholder="Name" name="name" value="<?php echo set_value('name',$row->name);?>"/>                                   
                                    <small class="text-danger"><?php echo isset($validation['name']) ? $validation['name'] : null;  ?></small>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Photo</label>
								<div class="col-sm-12 col-md-10">
									<input class="form-control" type="file" name="photo"/>
									<small class="text-danger"><?php echo isset($validation['photo']) ? $validation['photo'] : null;  ?></small>
									<?php
									$img_dir_path = FCPATH . 'uploads/photoadventure/'.$row->photo;
									if(is_file($img_dir_path)){
										$img_url_path = site_url('public/uploads/photoadventure/'.$row->photo);
										echo '<img src="'.$img_url_path.'" width="250" height="250" alt="">';
									}
								?>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Is Home</label>
								<div class="col-sm-12 col-md-10">
									<select class="form-control" name="is_home">
										<option value="">Select One</option>
										<option value="1" <?php echo ($is_home=1 || $row->is_home==1)?'selected':'';?>>Yes</option>
										<option value="0" <?php echo ($is_home=0 || $row->is_home==0)?'selected':'';?>>No</option>	
									</select>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Is Menu</label>
								<div class="col-sm-12 col-md-10">
									<select class="form-control" name="is_menu">
										<option value="">Select One</option>
										<option value="1" <?php echo ($is_menu=1 || $row->is_menu==1)?'selected':'';?>>Yes</option>
										<option value="0" <?php echo ($is_menu=0 || $row->is_menu==0)?'selected':'';?>>No</option>	
									</select>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Content</label>
								<div class="col-sm-12 col-md-10">
									<textarea class="form-control border-radius-0" rows="6" placeholder="About Photo Adventure" name="content" id="cmscontainer"><?php echo set_value('content',$row->content);?></textarea>
									<small class="text-danger"><?php echo isset($validation['content']) ? $validation['content'] : null;  ?></small>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Meta Title</label>
								<div class="col-sm-12 col-md-10">
									<input class="form-control" type="text" placeholder="Meta Title" name="meta_title" value="<?php echo set_value('meta_title',$row->meta_title);?>"/>
									<small class="text-danger"><?php echo isset($validation['meta_title']) ? $validation['meta_title'] : null;  ?></small>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Meta Description</label>
								<div class="col-sm-12 col-md-10">
									<textarea class="form-control" name="meta_desc" style="height: 100px;"><?php echo set_value('meta_desc',$row->meta_desc);?></textarea>
									<small class="text-danger"><?php echo isset($validation['meta_desc']) ? $validation['meta_desc'] : null;  ?></small>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Meta Keyword</label>
								<div class="col-sm-12 col-md-10">
									<textarea class="form-control" name="meta_keyword" style="height: 100px;"><?php echo set_value('meta_keyword',$row->meta_keyword);?></textarea>
									<small class="text-danger"><?php echo isset($validation['meta_keyword']) ? $validation['meta_keyword'] : null;  ?></small>
								</div>
							</div>
							
							<div class="modal-footer">
								<input type="submit" value="Save" class="btn btn-primary" />
								<a href="<?php echo site_url('admin/photoadventure');?>" class="btn btn-warning">Cancel</a>
							</div>
							<input type='hidden' name='page' value="<?php echo $curr_page;?>">
							<?php echo form_close();?>

						</div>
					<!-- Default Basic Forms End -->

                    

            </div>
        
			<?php echo view('Modules\Admin\Views\inc\footer'); ?>
        </div>
    </div>


	<?php echo view('Modules\Admin\Views\inc\bottom'); ?>

</body>

</html>