tinymce.init({
    selector: 'textarea',
    branding: false,
    width: '100%',
    height: '300',
    menubar: false,
    plugins: 'image media link autolink',
    toolbar: 'undo redo | styleselect | forecolor | bold italic | link image media | alignleft aligncenter alignright alignjustify | outdent indent',
    link_default_protocol: 'https',
    images_upload_url: 'upload.php',
    verify_html : false,
    images_file_types: 'jpg,jpeg,gif,png',
    
    
    // override default upload handler to simulate successful upload
    images_upload_handler: function (blobInfo, success, failure) {
        var xhr, formData;
        var image_size = blobInfo.blob().size / 1000;  // image size in kbytes
        var max_size   =  1000;// max size in kbytes
        if( image_size  > max_size ){        
            failure('Kuva on liian iso(' + image_size  + ') , Max: ' + max_size + ' kB');
            return;      
        }else {

        xhr = new XMLHttpRequest();
        xhr.withCredentials = false;
        xhr.open('POST', 'upload.php');
      
        xhr.onload = function() {
            var json;
        
            if (xhr.status != 200) {
                failure('HTTP Error: ' + xhr.status);
                return;
            }
        
            json = JSON.parse(xhr.responseText);
        
            if (!json || typeof json.location != 'string') {
                failure('Invalid JSON: ' + xhr.responseText);
                return;
            }
        
            success(json.location);
        };
      
        formData = new FormData();
        formData.append('file', blobInfo.blob(), blobInfo.filename());
      
        xhr.send(formData);
    }
    },
});