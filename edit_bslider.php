<?php if (is_admin()) { ?>
<?php 
require_once( ABSPATH . 'wp-admin/includes/image.php' );
require_once( ABSPATH . 'wp-admin/includes/file.php' );
require_once( ABSPATH . 'wp-admin/includes/media.php' );

global $wpdb;

$bslider = $wpdb->prefix.'bslider';
$bslider_img = $wpdb->prefix.'bslider_imgs';


if(isset($_GET['bid']) and $_GET['bid']!="") { 
$sliderquery = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix.bslider." WHERE id = '".esc_sql($_GET['bid'])."'"); 


if(isset($_GET['action']) and $_GET['action']=='delimg')
{
	if(isset($_GET['imgid']) and $_GET['imgid']!='')
	{
			$bslider_img = $wpdb->prefix.'bslider_imgs';
			$imgsids = esc_sql($_GET['imgid']);
			$wpdb->delete( $bslider_img, array( 'id' => $imgsids ) );
			$redirect = 'admin.php?page=edit_bslider&bid='.$_GET['bid'].'&action=del_success';
			$redirect_url = admin_url($redirect);
			print("<script>window.location='".$redirect_url."'</script>");
		}
	}
?>
<div class="wrap">
<h2>Update <u><?php echo $sliderquery->slidername; ?></u> slider</h2>
<?php
 if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	$wpdb->update($bslider,
	array('slidername' => $_POST['slidername'],'bullets' => $_POST['bullets'],'captions' => $_POST['captions'],'status' => $_POST['status']),
	array( 'id' => $_POST['sid'] ),
	array('%s','%s','%s','%s'),
	array( '%d' )
);
	$redirect = 'admin.php?page=edit_bslider&bid='.$_GET['bid'].'&action=update_success';
	$redirect_url = admin_url($redirect);
	print("<script>window.location='".$redirect_url."'</script>");
    /*$files = $_FILES["slidersimg"];
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
         </div>';*/
				 //echo wp_get_attachment_url( $attachment_id ); 
                // The image was uploaded successfully!
                //echo "File added successfully with ID: " . $attachment_id . "<br>";
               // echo wp_get_attachment_image($attachment_id, array(800, 600)) . "<br>"; //Display the uploaded image with a size you wish. In this case it is 800x600
            //}
        //}
   // }
} 
?>

<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data">
<input type="hidden" name="sid" value="<?php echo $sliderquery->id; ?>">
   <?php if(isset($_GET['action']) and $_GET['action']=='del_success') { echo '<div class="notice notice-success is-dismissible"><p>Image successfully deleted!</p></div>'; } elseif(isset($_GET['action']) and $_GET['action']=='update_success') { echo '<div class="notice notice-success is-dismissible"><p>Slider Successfully updated!</p></div>'; } ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Slider Name</th>
        <td><input type="text" name="slidername" value="<?php echo $sliderquery->slidername; ?>" /></td>
        </tr>
         <tr valign="top">
        <th scope="row">Slider Name</th>
        <td><input type='file' id='slidersimg' name='slidersimg[]' multiple></td>
        </tr>
        <tr valign="top">
        <th scope="row">Show Bullets</th>
        <td><select name="bullets">
        		<option value="1" <?php if($sliderquery->bullets == 1) { echo "selected";  } ?>>Yes</option>
                <option value="0" <?php if($sliderquery->bullets == 0) { echo "selected";  } ?>>No</option>
            </select></td>
        </tr>
        <tr valign="top">
        <th scope="row">Show Captions</th>
        <td><select name="captions">
        		<option value="1" <?php if($sliderquery->captions == '1') { echo "selected";  } ?>>Yes</option>
                <option value="0" <?php if($sliderquery->captions == '0') { echo "selected";  } ?>>No</option>
            </select></td>
        </tr>
        <tr valign="top">
        <th scope="row">Slider status</th>
        <td><select name="status">
        		<option value="1" <?php if($sliderquery->status == 1) { echo "selected";  } ?>>Active</option>
                <option value="0" <?php if($sliderquery->status == 0) { echo "selected";  } ?>>Pending</option>
            </select></td>
        </tr>
        
    </table>
    
    <table class="widefat">
<thead>
    <tr>
        <th>Image</th>
        <th>Title</th>       
        <th>Alt</th>
        <th>Actions</th>
    </tr>
</thead>
<tfoot>
    <tr>
        <th>Image</th>
        <th>Title</th>       
        <th>Alt</th>
        <th>Actions</th>
    </tr>
</tfoot>
<tbody>
<?php 
$alt = true; 
$query_imgs = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix.bslider_imgs." WHERE sliderid = '".$sliderquery->id."'");
foreach($query_imgs as $row) :
$alt = !$alt;
$path = 'admin.php?page=edit_bslider&bid='.$sliderquery->id.'&action=delimg&imgid='.$row->id;
$url = admin_url($path);

?>

	<tr <?php echo $alt ? '' : ' class="alternate"'; ?>>
    	<td><img src="<?php echo $row->imgs; ?>" height="60px" width="150px"></td>
        <td><input type="text" placeholder="title" name="title[]" value="<?php echo $row->title_txt; ?>"><br>
        <textarea name="sub_title_txt[]" placeholder="sub title"><?php echo $row->sub_title_txt; ?></textarea>
        <td><input type="text" name="alt_txt[]" value="<?php echo $row->alt_txt; ?>"></td>
        <td><a href="<?php echo $url; ?>" onclick="return confirm('Are you sure you want to delete this image?');">Delete</a></td>
    </tr>
<?php endforeach; ?>    
</tbody>
</table>
    <?php submit_button(); ?>

</form>



     
</div>



<?php } } ?>