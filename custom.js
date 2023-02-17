
jQuery(document).ready(function($) {

    $('#application-canvas').after(
        '<div id="aside-configurateur"><h1>Voiture sur-mesure</h1><div><h2>Bienvenue au sein de notre configurateur 3D exclusif</h2><h3>Créez et personnalisez votre voiture sur-mesure 100% Made In Deutsch en totale liberté</h3><p>Choisissez parmi une gamme de couleurs</p> <p><span id="jaune" class="button-config" style="background: yellow;"></span><span id="rouge" class="button-config" style="background: red;"></span><span id="noir" class="button-config" style="background: black;"></span></p></div></div>'
    );

    if ($("application-canvas")){
        $('body').css('background','#0B1419');
    }

});


console.log(this);