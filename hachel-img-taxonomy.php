<?php
/**
 * Plugin Name: Hachel IMG Taxonomy
 * Plugin URI: https://github.com/laurenthergot/wp-hachel-img-taxonomy
 * Description: Add an image to taxonomies
 * Version: 1.0.0
 * Author: Laurent Hergot(Hachel)
 * Author URI: https://github.com/laurenthergot/
 * License: GPL
 * Text Domain: hachelimgtaxonomy
 */

require_once 'class-HachelImgtaxonomy.php';
$hachel_image_category = new HachelImgTaxonomy( 'category' );
$hachel_image_post_tag = new HachelImgTaxonomy( 'post_tag' );

function HachelImgtaxonomy_scripts()
{

	wp_enqueue_media();

	$screen = get_current_screen();

	if ( 'edit-tags' === $screen->base OR 'term' === $screen->base )
	{
		wp_enqueue_style( 'hachel-image-taxonomy-style', plugin_dir_url( __FILE__ ) . '/assets/hachel-image-taxonomy.css' );
		wp_enqueue_script( 'hachel-image-taxonomy-script', plugin_dir_url( __FILE__ ) . '/assets/hachel-image-taxonomy.js', array(), '1.0.0', true );
		wp_script_add_data( 'hachel-image-taxonomy-script', 'defer', 'defer' );
	}

}

add_action( 'admin_enqueue_scripts', 'HachelImgtaxonomy_scripts' );