<?php if (is_admin()) { 
if(isset($_GET['action']) and $_GET['action']=='del')
   {
	   	if(isset($_GET['bid']) and $_GET['bid']!= NULL)
		{
			global $wpdb;
    		$bslider = $wpdb->prefix.'bslider';
			$bslider_img = $wpdb->prefix.'bslider_imgs';

			$ids = esc_sql($_GET['bid']);
			$wpdb->delete( $bslider, array( 'id' => $ids ) );
			$wpdb->delete( $bslider_img, array( 'sliderid' => $ids ) );
			$redirect = 'admin.php?page=b-slider&action=del_success';
			$redirect_url = admin_url($redirect);
			print("<script>window.location='".$redirect_url."'</script>");
			}
			else
			{
				$redirect = 'admin.php?page=b-slider&action=del_error';
				$redirect_url = admin_url($redirect);
				print("<script>window.location='".$redirect_url."'</script>");
				}
	   }
?>
<div class="wrap">
<h1>B-sliders</h1>
<?php if(isset($_GET['action']) and $_GET['action']=='del_success') { echo '<div class="notice notice-success is-dismissible"><p>slider successfully deleted!</p></div>'; } elseif(isset($_GET['action']) and $_GET['action']=='del_error') { echo '<div class="notice notice-warning is-dismissible"><p>Unable to delete slider!</p></div>'; } ?>
<table class="widefat">
<thead>
    <tr>
        <th>Date</th>
        <th>Name</th>       
        <th>Shortcode</th>
        <th>Images</th>
        <th>Actions</th>
    </tr>
</thead>
<tfoot>
    <tr>
        <th>Date</th>
        <th>Name</th>       
        <th>Shortcode</th>
        <th>Images</th>
        <th>Actions</th>
    </tr>
</tfoot>
<tbody>
<?php 
global $wpdb;
$bs_rows = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix.bslider);
if($bs_rows):
$alt = true; 
foreach($bs_rows as $brow) :
$query_imgs = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix.bslider_imgs." WHERE sliderid = '".$brow->id."'");
$alt = !$alt;
$path = 'admin.php?page=b-slider&action=del&bid='.$brow->id;
$edit_path = 'admin.php?page=edit_bslider&bid='.$brow->id;

$url = admin_url($path);
$edit_url = admin_url($edit_path);
?>
   <tr <?php echo $alt ? '' : ' class="alternate"'; ?>>
     <td><?php echo date('d M Y', strtotime($brow->dat)); ?></td>
     <td><?php echo $brow->slidername; ?></td>
     <td>[bslider bid = <?php echo $brow->id; ?>]</td>
	 <td><?php echo count($query_imgs); ?></td>
     <td><a href="<?php echo $edit_url; ?>">Edit</a> | <a href="<?php echo $url; ?>" onclick="return confirm('Are you sure you want to delete this slider?');">Delete</a></td>
   </tr>
<?php endforeach; endif; ?>   
</tbody>
</table>
    </div>
   <?php } ?>