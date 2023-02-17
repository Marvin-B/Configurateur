<?php

$prix = 0; // Initialisation de la variable prix

function scriptconfig() {
    if( is_page('panier')  ){
        wp_enqueue_script( 'configadd', get_stylesheet_directory_uri() . '/js/configuratorv3.js', array(), '', true );
        wp_enqueue_script( 'configadd', get_stylesheet_directory_uri() . '/js/clear-storage.js', array(), '', true );
        wp_localize_script( 'configadd', 'ajaxurl', admin_url( 'admin-ajax.php' ) );
    }
}
// Récupération du lien où on se situe
$lien_courant = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

// Condition : ne se déclenche que si on est sur la page panier
if($lien_courant == "https://dev-echo.fr/configurateur/panier/"){
    //add_action('wp_head', 'debuggage'); 
}

add_action( 'wp_ajax_appelajax', 'ajax_configurator' );
add_action( 'wp_ajax_nopriv_appelajax', 'ajax_configurator' );
add_action( 'wp_enqueue_scripts', 'scriptconfig' );

// Récupérer le prix en ajax

if ($_POST['ajout-produit-config']){
    echo 'Variable présente';
} else{
    echo 'Variable absente   ';
}

// Fonction de redirection vers la page panier
function redirection_panier(){
    echo '<script>location.href="https://dev-echo.fr/configurateur/panier/"</script>';
}

function ajax_configurator(){
    // Récupération des données du formulaire
    if (isset ($_POST['prix'])){
        $prix = $_POST['prix'];
    } else {
        $prix = 0;
    }
    if (isset ($_POST['description'])){
        $description = $_POST['description'];
    } else {
        $description = '';
    }

     $custom_price = $prix;
     $product_id = 420;

    echo 'prix (fonction): ' . $prix . ' €';
    echo '          ';
    echo 'description (fonction): ' . $description;

    // Ajout du produit configurateur dans le panier, avec le prix personnalisé et la description
    if ($_POST['ajout-produit-config']){
        WC()->cart->add_to_cart( $product_id, 1, 0, array(), array('description' => $description, 'custom_price' => $custom_price) );
        echo '<script>clearStorage()</script>';
        $prix = 0; // Réinitialisation de la variable prix afin de ne pas ajouter plusieurs fois le même produit configurateur
        $custom_price = 0; // Réinitialisation de la variable prix afin de ne pas ajouter plusieurs fois le même produit configurateur
    }
}

// Mise à jour du prix du produit configurateur dans le panier
add_action( 'woocommerce_before_calculate_totals', 'update_custom_price', 10, 1 );
function update_custom_price( $cart_object ) {
    foreach ( $cart_object->get_cart() as $cart_item ) {
        if( !empty( $cart_item['custom_price'] ) ) {
            $cart_item['data']->set_price( $cart_item['custom_price'] );
        }
    }
};

// Affichage de la description du produit configurateur dans le panier
add_filter( 'woocommerce_cart_item_name', 'custom_product_name', 10, 3 );
function custom_product_name( $name, $cart_item, $cart_item_key ) {
    if( !empty( $cart_item['description'] ) ) {
        $name .= '<br><small>' . $cart_item['description'] . '</small>';
    }
    return $name;
}

