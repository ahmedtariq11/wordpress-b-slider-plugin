<?php
global $wpdb, $wnm_db_version;
	$sql = array();
	
	$bslider = $wpdb->prefix.'bslider';
	$bslider_img = $wpdb->prefix.'bslider_imgs';
	
	if( $wpdb->get_var("show tables like '". $bslider . "'") !== $bslider ) { 
        $sql[] = "CREATE TABLE ". $bslider . " (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `slidername` varchar(255) NOT NULL,
		`bullets` int(11) NOT NULL,
		`captions` int(11) NOT NULL,
	    `dat` datetime NOT NULL,
	    `status` int(11) NOT NULL,
         PRIMARY KEY  (id)
        )";
    }
	

    if( $wpdb->get_var("show tables like '". $bslider_img . "'") !== $bslider_img ) { 
        $sql[] = "CREATE TABLE ". $bslider_img . "   (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `sliderid` int(11) NOT NULL,
	    `imgs` varchar(255) NOT NULL,
		`attachid` int(11) NOT NULL,
	    `alt_txt` varchar(255) NOT NULL,
	    `txt_align` varchar(255) NOT NULL,
	    `title_txt` varchar(255) NOT NULL,
	    `sub_title_txt` text NOT NULL,
	    `status` int(11) NOT NULL,
	    `dat` datetime NOT NULL,
        PRIMARY KEY  (id)
        )";
    }
	
	 if ( !empty($sql) ) {
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
        add_option("wnm_db_version", $wnm_db_version);
    }
?>