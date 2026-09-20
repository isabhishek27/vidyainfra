tinymce.init({
	selector: 'textarea#itinerary',
	statusbar: true, // Ensure statusbar is enabled if you want other statusbar elements
    branding: false, // This removes the "Powered by Tiny" branding
	license_key: 'gpl',
	plugins: 'image, code, table, link, advlist lists',
	toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | ' +
	'alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | ' +
	'forecolor backcolor removeformat | pagebreak | charmap emoticons | ' +
	'fullscreen preview save print | insertfile image media template link anchor codesample | ' +
	'ltr rtl | code',

	toolbar_sticky: true,
	autosave_ask_before_unload: true,
	importcss_append: true,
	image_caption: true,
	quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
	noneditable_noneditable_class: 'mceNonEditable',
	toolbar_mode: 'wrap', // ensures everything is visible by wrapping to multiple lines
	advlist_bullet_styles: 'default,circle,square',
	advlist_number_styles: 'default,lower-alpha,lower-roman,upper-alpha,upper-roman',
	

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