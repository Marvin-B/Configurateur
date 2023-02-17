<?php
// ======================================= CONFIGURATEUR 3D =======================================
//Appel ajax

function scriptconfig() {
	if( is_page('panier')  ){
		wp_enqueue_script( 'configadd', get_stylesheet_directory_uri() . '/js/configuratorv2.js', array(), '', true );
		wp_localize_script( 'configadd', 'ajaxurl', admin_url( 'admin-ajax.php' ) );
	}
}



//add_action( 'wp_ajax_configurateurv2', 'change_item_price' );
//add_action( 'wp_ajax_nopriv_configurateurv2', 'change_item_price' );


add_action( 'wp_ajax_configurateurv2', 'configurateurv2' );
add_action( 'wp_ajax_nopriv_configurateurv2', 'configurateurv2' );



add_action( 'wp_enqueue_scripts', 'scriptconfig' );




$lien_courant = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

if($lien_courant == "https://dev-echo.fr/configurateur/panier/"){
    //add_action('wp_head', 'configurateurv2'); // On charge la fonction APRES que Wordpress a chargé tous les scripts nécessaires
}



add_filter( 'woocommerce_cart_item_price', 'change_item_price', 10, 2 );

function change_item_price( $price, $cart_item ) {
    $prix=$_POST['prix'];
    $new_price = $prix;
    return $new_price;
}


// --- Fonction permettant d'ajouter le produit configurateur au panier : ---

function configurateurv2(){

    // On récupère l'id du produit configurateur
    $product_id = '420';

    // On récupère la description du produit configurateur
    $description = 'ceci est la description';

    // On récupère les données en Ajax
    $datas = $_POST['datas'];
    $ajoutProduitConfig = $_POST['ajoutProduitConfig'];
    $prix = $_POST['prix'];
    echo $datas;
    echo $ajoutProduitConfig;

    echo '<script>console.log("'.$ajoutProduitConfig.'<">/script>';

    $quantities = WC()->cart->get_cart_item_quantities();
    echo $quantities[$product_id];

    if ( $quantities[$product_id] >= 1 && $ajoutProduitConfig !== 'oui') {
    } else{
        // On ajoute le produit configurateur au panier
        WC()->cart->add_to_cart( $product_id, 1, 0, array(), array('description' => $description));
    }

    // probleme : la vérification ne marche pas et le produit est ajouté à chaque fois
    
    $debug_window = '

    <style>
    #debug-window{
        position: fixed;
        z-index: 9999;
        width: 30vw;
        top: 25%;
        left: 69%;
        border:5px solid red;
        height: 50vh;
        background-color: #000;
        color:#fff;
        font-family:monospace;
        padding:1rem;
        overflow-y:scroll;
    }
    </style>
    <div id="debug-window">';

    $debug_window .= '<div style="text-align:center;font-size:2rem;text-decoration:underline;margin-bottom:24px">Debuggage</div>';
    $debug_window .= '<ul>';
    $debug_window .= '<li>'.get_stylesheet_directory_uri().'</li>';
    $debug_window .= '<li>'.$datas.' aa</li>';

    // Début Fonction

    // Fin Fonction

    $debug_window .= '</ul>';
    $debug_window .= '</div>';

    echo $debug_window;



}



// --- Fonction permettant d'afficher la description du produit configurateur dans le panier : ---
add_filter( 'woocommerce_get_item_data', 'customizing_cart_item_data', 10, 2 );
function customizing_cart_item_data( $cart_data, $cart_item ) {

    // On récupère l'id du produit configurateur
    $product_id = '420';

    // On initialise la description du produit configurateur
    $description = ''; 

    // Si le produit est le numéro 420
    if( $cart_item['product_id'] == $product_id ){
        // On récupère le produit
        $product = wc_get_product( $cart_item['product_id'] );
        // On récupère la description du produit
        $description = 'test de la voiture';
    }

    // Si la description n'est pas vide, on l'ajoute au panier
    if( ! empty( $description ) ){
        $cart_data[] = array(
            'key'      => __( '', 'woocommerce' ),
            'value'    => $description,
            'display'  => $description,
        );
    }

    // On retourne les données
    return $cart_data;
}


// --- Fonction permettant de changer le prix du produit configurateur dans le panier : ---


?>




