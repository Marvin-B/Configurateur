<?php
// ======================================= CONFIGURATEUR 3D =======================================
// ATTENTION : wc_get_cart_url() ne fonctionne pas sur la page panier, il faut utiliser $_SERVER['REQUEST_URI'] pour récupérer l'url de la page panier
// ATTENTION : wc_before_cart() ne fonctionne pas si le panier est VIDE
$actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
if($actual_link == "https://dev-echo.fr/configurateur/panier/"){
    // echo '<span style="position:absolute;z-index:9999;width:100%;top:25%;left:0;height:50vh;"><h1 style="text-align:center;">Hello World</h1></span>';
    //configurator();
    add_action('wp_head', 'configurator'); // On charge la fonction APRES que Wordpress a chargé tous les scripts nécessaires
}
// --- Fonction permettant d'afficher la description dans le panier : ---
/*add_filter( 'woocommerce_cart_item_name', 'cart_description', 20, 3);
function cart_description( $name, $cart_item, $cart_item_key ) {
  // Get the corresponding WC_Product
  $product_item = $cart_item['data'];
  if(!empty($product_item)) {
    // WC 3+ compatibility
    $description = $product_item->get_description();
    $result = __( 'Description: ', 'woocommerce' ) . $description;
    return $name . '<br>' . $description; // Remplacer $description par $result si on veut préciser que c'est la description
  } else{
    return $name;
  }
}*/
// --- Fonction permettant d'ajouter le produit configurateur au panier : ---
function configurator(){
    $product_id = 420 ; // ID du produit configurateur : nous servira à l'ajouter au panier
    $quantity = 1 ; //Quantité à ajouter au panier
    
    // On récupère les données du cookie
      if (isset($_COOKIE['configurateur-prix'])){
        $data = $_COOKIE['configurateur-prix'];
      }
      else{
      $data = 'vide';
      }
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
    $_SESSION['description-produit'] = $description;
  
    //echo '<script>console.log("' . $data . '")</script>';
    echo '<div style="position:fixed;max-width:20%;border:3px solid red;padding:2rem;top: 20vh;left:2rem;z-index:9999;background-color:black;font-family:monospace;color:white;font-weight:bold;height:40vh;overflow-y:scroll">';
    print_r(wp_get_current_user()->user_login);
    echo '<br>';
    print_r(wc_get_product('420')->name);
    echo '<br>';
   /*var_dump($data3);
    echo '<br>'; */
    print_r($_SESSION['description-produit']);
    echo '<br>';
    var_dump($data2);
    echo '<br> Prix : <br>';
    var_dump($prix);
    echo '<br> Description : <br>';
    var_dump($description);
    echo '</div>';
  
  
    //echo'<span style="position:absolute;z-index:9999;width:100%;top:25%;left:0;height:50vh;"><h1 style="text-align:center;color:red;">';
    switch ($prix){
      case '0':
        break;
      default:
        $product_id = 420; // ID du produit à ajouter au panier
        $product = wc_get_product( $product_id );
        if ( class_exists( 'WC_Cart' )) {
          $cart = WC()->cart;
          
          // Ajout du produit au panier
  
          $custom_description = 'Description personnalisée du produit'; // Description personnalisée du produit
    
          // Modification de la description et du prix (en session  l'idée étant de ne pas modifier le produit dans la base de données)
  
          WC()->session->set('product_'.$product_id.'_price', 20);
          WC()->session->set('product_'.$product_id.'_description', 'changement description');
          $ouvertureBalise = '<div style="position:fixed;z-index:9999;border:5px solid red;bottom:25%;width:34vw;height:25vh;left:65%;background:black;padding:1rem;font-weight:bold;color:white;font-family:monospace; overflow-y:scroll">';
          $fermetureBalise = '</div>';
          $content = 'Le cookie existe';
          echo $ouvertureBalise.$content.$fermetureBalise;
    
          // Ajout de l'objet produit au panier
          $cart_item_key = $cart->add_to_cart( $product_id, $quantity);
          echo $ouvertureBalise.$product->description.$fermetureBalise;
          // Suppression du cookie
          // echo '<script>document.cookie= "configurateur-prix=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";</script>';
          
    
        } else {
          echo 'Erreur : le produit n\'existe pas. Veuillez contacter l\'administrateur du site.';
        }
        break;
    }
    //echo '</h1></span>';
  
}
add_filter( 'woocommerce_cart_item_name', 'custom_cart_item_name', 10, 3 );
function custom_cart_item_name( $product_name, $cart_item, $cart_item_key ) {
  $description = $_SESSION['description produit'];
  $product_name .= '<br>';
    $product_name .= ' - ' . $description;
    return $product_name;
}
?>