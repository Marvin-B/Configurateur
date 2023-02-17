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


//add_action('woocommerce_before_checkout_form', 'hello_world', 1);


 // ATTENTION : wc_get_cart_url() ne fonctionne pas sur la page panier, il faut utiliser $_SERVER['REQUEST_URI'] pour récupérer l'url de la page panier
 // ATTENTION : wc_before_cart() ne fonctionne pas si le panier est VIDE

 $actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";


 if($actual_link == "https://dev-echo.fr/configurateur/panier/"){
  // echo '<span style="position:absolute;z-index:9999;width:100%;top:25%;left:0;height:50vh;"><h1 style="text-align:center;">Hello World</h1></span>';
  configurator();

  
 }




function configurator(){

  $product_id = 420 ; // ID du produit configurateur : nous servira à l'ajouter au panier
  $quantity = 1 ; //Quantité à ajouter au panier

  $data = $_COOKIE['configurateur-prix']; // On récupère les données du cookie
  $separator = '&'; // Séparateur des données
  $data2 = explode($separator, $data); // On convertie les données en tableau
  $prix=0; // Initialisation prix
  $description = ''; // Initialisation description


  // On parcours le tableau pour récupérer le prix et la description
  foreach ($data2 as $key => $value) {
    $data2[$key] = explode('=', $value);
  }
  foreach ($data2 as $key => $value) {
    if ($data2[$key][0] == 'prix') {
      $prix = $data2[$key][1];
    }
  }
  
  foreach ($data2 as $key => $value) {
    if ($data2[$key][0] != 'prix'){
      $description .= $data2[$key][0] . ' : ' . $data2[$key][1] . ', ';
    }
  }

  $description = substr($description, 0, -2); // On supprime la dernière virgule

  $data3 = $_COOKIE['configurateur-prix'];

  echo '<script>console.log("' . $data . '")</script>';
  echo '<div style="position:fixed;max-width:20%;border:3px solid black;padding:2rem;top: 20vh;left:2rem;z-index:9999;background-color:white">';
 /*var_dump($data3);
  echo '<br>'; */
  var_dump($data2);
  echo '<br> Prix : <br>';
  var_dump($prix);
  echo '<br> Description : <br>';
  var_dump($description);
  echo '</div>';


  echo'<span style="position:absolute;z-index:9999;width:100%;top:25%;left:0;height:50vh;"><h1 style="text-align:center;color:red;">';
  switch ($prix){
    case '0':
      echo 'Le prix est de 0';
      break;
    default:
      echo 'Le prix est différent de 0';


      
  // Ajout du produit au panier

  /*$product_id = '420'; // ID du produit à ajouter au panier
  $quantity = 1; // Quantité à ajouter au panier
  $custom_price = 20; // Prix personnalisé du produit
  $custom_description = 'Description personnalisée du produit'; // Description personnalisée du produit
  
  $cart = WC()->cart;
  
  // Récupération de l'objet WC_Product
  $product = wc_get_product( $product_id );
  
  // Modification de la description et du prix
  $product->set_description( $custom_description );
  $product->set_price( $custom_price );
  
  // Ajout de l'objet produit au panier
  $cart_item_key = $cart->add_to_cart( $product_id, $quantity);
  
  // Ajout des meta-données personnalisées à l'article
  $cart->cart_contents[$cart_item_key]['custom_description'] = $custom_description;
  $cart->cart_contents[$cart_item_key]['custom_price'] = $custom_price;
  
  //$cart->calculate_totals();*/


  $product_id = '420'; // ID du produit à ajouter au panier
  echo $product_id;
  
  



      break;
  }
  echo '</h1></span>';




}
