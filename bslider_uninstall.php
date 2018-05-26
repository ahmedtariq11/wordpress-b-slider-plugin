<?php
global $wpdb;
     $table_name = $wpdb->prefix . 'bslider';
	 $table_name2 = $wpdb->prefix . 'bslider_imgs';
     $sql = "DROP TABLE IF EXISTS $table_name";
     $wpdb->query($sql);
	 
	 $sql2 = "DROP TABLE IF EXISTS $table_name2";
     $wpdb->query($sql2);
     delete_option("my_plugin_db_version");
?>