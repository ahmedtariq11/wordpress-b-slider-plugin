<div class="slideshow-container">
<?php 
global $wpdb;
$j=1;
$sliderquery = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix.bslider." WHERE id = '".$bid."'"); 

$slider_query = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix.bslider_imgs." WHERE sliderid = '".$bid."'"); 
foreach($slider_query as $row) :
?>

<div class="mySlides fade">
  <div class="numbertext"><?php echo $j++; ?> / <?php echo count($slider_query); ?></div>
  <img src="<?php echo $row->imgs; ?>" style="width:100%">
  <?php if($sliderquery->captions == '1'): ?>
	<div class="text">Caption Text</div>
  <?php endif; ?>  
</div>
<?php endforeach; ?>
<a class="prev" onclick="plusSlides(-1)">&#10094;</a>
<a class="next" onclick="plusSlides(1)">&#10095;</a>
</div>
<?php if($sliderquery->bullets == 1): ?>
<br>
<div style="text-align:center">
<?php $i = 1; foreach($slider_query as $row) : ?>
  <span class="dot" onclick="currentSlide(<?php echo $i++; ?>)"></span> 
<?php endforeach; ?>  
</div>
<?php endif; ?>
<?php 
wp_register_style ( 'b_slider', plugins_url ( 'assests/bslider.css', __FILE__ ));
wp_register_script ( 'b_slider', plugins_url ( 'assests/bslider.js', __FILE__ ) );
wp_enqueue_script('b_slider');
wp_enqueue_style('b_slider');
?>


