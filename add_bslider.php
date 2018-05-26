<?php if (is_admin()) { ?>

<div class="wrap">
<h2>Add New slider</h2>

<?php

 if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	  
	global $wpdb;
    $bslider = $wpdb->prefix.'bslider';
	$bslider_img = $wpdb->prefix.'bslider_imgs';
	
	$data = array(
		'slidername' => $_POST['slidername'],
		'bullets' => $_POST['bullets'],
		'captions' => $_POST['captions'],
		'dat' => date('Y-m-d H:i:s'),
		'status' => $_POST['status']
	 );
	$format = array('%s','%s','%s');
	$success=$wpdb->insert( $bslider, $data, $format );
	$bslid = $wpdb->insert_id;
		
		
    require_once( ABSPATH . 'wp-admin/includes/image.php' );
    require_once( ABSPATH . 'wp-admin/includes/file.php' );
    require_once( ABSPATH . 'wp-admin/includes/media.php' );

    $files = $_FILES["slidersimg"];
    foreach ($files['name'] as $key => $value) {
        if ($files['name'][$key]) {
            $file = array(
                'name' => $files['name'][$key],
                'type' => $files['type'][$key],
                'tmp_name' => $files['tmp_name'][$key],
                'error' => $files['error'][$key],
                'size' => $files['size'][$key]
            );
            $_FILES = array("upload_file" => $file);
            $attachment_id = media_handle_upload("upload_file", 0);

            if (is_wp_error($attachment_id)) {
                // There was an error uploading the image.
                $msg = '<div class="notice notice-warning is-dismissible">
          <p>Unable to uplaod files!</p>
         </div>';
            } else {
				
				$data2 = array(
					'sliderid' => $bslid,
					'imgs' => wp_get_attachment_url( $attachment_id ),
					'attachid' => $attachment_id,
					'alt_txt' => $_POST['slidername'],
					'txt_align' => date('Y-m-d H:i:s'),
					'title_txt' => '',
					'sub_title_txt' => '',
					'status' => date('Y-m-d H:i:s'),
					'dat' => $_POST['status'],
				 );
				$formats = array('%s','%s','%s');
				$success=$wpdb->insert( $bslider_img, $data2, $formats );
				$msg = '<div class="notice notice-success is-dismissible">
          <p>Slider added successfully!</p>
         </div>';
				 //echo wp_get_attachment_url( $attachment_id ); 
                // The image was uploaded successfully!
                //echo "File added successfully with ID: " . $attachment_id . "<br>";
               // echo wp_get_attachment_image($attachment_id, array(800, 600)) . "<br>"; //Display the uploaded image with a size you wish. In this case it is 800x600
            }
        }
    }
} 


        ?>

<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data">
   <?php echo $msg; ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Slider Name</th>
        <td><input type="text" name="slidername" value="" /></td>
        </tr>
         <tr valign="top">
        <th scope="row">Slider Name</th>
        <td><input type='file' id='slidersimg' name='slidersimg[]' multiple></td>
        </tr>
        <tr valign="top">
        <th scope="row">Show Bullets</th>
        <td><select name="bullets">
        		<option value="1">Yes</option>
                <option value="0">No</option>
            </select></td>
        </tr>
        <tr valign="top">
        <th scope="row">Show Captions</th>
        <td><select name="captions">
        		<option value="1">Yes</option>
                <option value="0">No</option>
            </select></td>
        </tr>
        <tr valign="top">
        <th scope="row">Slider status</th>
        <td><select name="status">
        		<option value="1">Active</option>
                <option value="0">Pending</option>
            </select></td>
        </tr>
        
    </table>
    
    <?php submit_button(); ?>

</form>
     
</div>

<?php } ?>