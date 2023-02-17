<?php

//require_once( $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php' );

/**

 * Loading the parent theme css.

 */

function divi_child_load_parent_css() {

	wp_enqueue_style( 'divi-parent-style', get_template_directory_uri() . '/style.css', false, '' );

}

add_action( 'wp_enqueue_scripts', 'divi_child_load_parent_css' );

function get_image_alt_text($image_url) {

  if ( ! $image_url )

    return '';

  if ( '/' === $image_url[0] )

    $post_id = attachment_url_to_postid(home_url() . $image_url);

  else

    $post_id = attachment_url_to_postid($image_url);

  $alt_text = get_post_meta($post_id, '_wp_attachment_image_alt', true);

  if ( '' === $alt_text )

    $alt_text = get_the_title($post_id);

  return $alt_text;

}

function update_module_alt_text( $attrs, $unprocessed_attrs, $slug ) {

  if ( ( $slug === 'et_pb_image' || $slug === 'et_pb_fullwidth_image' ) && '' === $attrs['alt'] )

    $attrs['alt'] = get_image_alt_text($attrs['src']);

  elseif ( $slug === 'et_pb_blurb' && 'off' === $attrs['use_icon'] && '' === $attrs['alt'] )

    $attrs['alt'] = get_image_alt_text($attrs['image']);

  elseif ( $slug === 'et_pb_slide' && '' !== $attrs['image'] && '' === $attrs['image_alt'] )

    $attrs['image_alt'] = get_image_alt_text($attrs['image']);

  elseif ( $slug === 'et_pb_fullwidth_header' ) {

    if ( '' !== $attrs['logo_image_url'] && '' === $attrs['logo_alt_text'] )

      $attrs['logo_alt_text'] = get_image_alt_text($attrs['logo_image_url']);

    if ( '' !== $attrs['header_image_url'] && '' === $attrs['image_alt_text'] )

      $attrs['image_alt_text'] = get_image_alt_text($attrs['header_image_url']);

  }

  return $attrs;

}

/* Injection du filtre */

add_filter( 'et_pb_module_shortcode_attributes', 'update_module_alt_text', 20, 3 );

/*MASQUER LES INFOS DE MISES A JOUR SAUF POUR LES ADMIN*/

function wpm_hide_update_notice_to_all_but_admin_users(){

	// Si l'utilisateur n'a pas les droits pour mettre à jour WordPress

    if (!current_user_can('update_core')) {

		// On supprime les notifications de mises à jour

        remove_action( 'admin_notices', 'update_nag', 3 );

    }

}

add_action( 'admin_head', 'wpm_hide_update_notice_to_all_but_admin_users', 1 );

/********************************************

* Auto non-breakable space

********************************************/

if( !function_exists( 'twoobl_automatic_nbsp' ) ) {

function twoobl_automatic_nbsp($content) {

$chars = '?!:;';

$content = preg_replace('/ (['.$chars.'])/', '&nbsp;${1}', $content);

return $content;

}

}

add_filter( 'the_content', 'twoobl_automatic_nbsp' );

// PlayCanvas

// add_action( 'wp_enqueue_scripts', 'my_enqueue_assets' ); 

// add_action('wp_enqueue_scripts', 'add_scripts');

function add_scripts() {

  wp_register_script( 'playcanvas-stable', '/playcanvas/playcanvas-stable.min.js', $deps = array(), $ver = false, $in_footer = false);

  wp_register_script( 'playcanvas-settings', '/playcanvas/__settings__.js', $deps = array(), $ver = false, $in_footer = false);

  wp_register_script( 'playcanvas-modules', '/playcanvas/__modules__.js', $deps = array(), $ver = false, $in_footer = false);

  wp_register_script( 'playcanvas-scripts', '/playcanvas/__scripts__.js', $deps = array(), $ver = false, $in_footer = false);

  wp_register_script( 'custom', '/wp-content/themes/Groupe-echo-1/custom.js', $deps = array(), $ver = false, $in_footer = true);

  wp_enqueue_script( 'playcanvas-stable' );

  wp_enqueue_script( 'playcanvas-settings' );

  wp_enqueue_script( 'playcanvas-modules' );

  wp_enqueue_script( 'playcanvas-scripts' );

  wp_enqueue_script( 'custom' );

  wp_enqueue_script( 'configurator-cart' );

}

function my_enqueue_assets() { 

  wp_enqueue_style( 'playcanvas-style', '/playcanvas/styles.css' ); 

}

// add this filter in functions.php file

add_filter( 'woocommerce_get_item_data', 'wc_checkout_description_so_15127954', 10, 2 );

function wc_checkout_description_so_15127954( $other_data, $cart_item )

{

    $post_data = get_post( $cart_item['product_id'] );

    $other_data[] = array( 'name' =>  $post_data->post_excerpt );

    return $other_data;

}

// ======================================= CONFIGURATEUR 3D =======================================

// ======================================= CONFIGURATEUR 3D =======================================

//  Version 1.0.0 :

//  include 'configurateur.php'; 

//    Problème de cette façon de faire : on stocke des variables dans des cookies, 

//    ce qui a pour conséquence d'empêcher la commande s'ils ne sont pas acceptés ou si on est en navigation privée ...

//  Version 2.0.0 : 



include 'debuggage.php';

echo '<script>console.log("'.$_POST['ajout-produit-config'].'");</script>';

include 'appelajax.php';

/*if ($_POST['ajout-produit-config']) {
  echo '<script>console.log("est-ce-ok ? '.$_POST['ajout-produit-config'].'");</script>';
} else{
    echo '<script>console.log("est-ce-ok ? Non");</script>';
}

*/

