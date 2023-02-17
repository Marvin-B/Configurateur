jQuery(document).ready(function($){

    console.log('Configurateur V3');




    var prix = sessionStorage.getItem('prix');

    var description = sessionStorage.getItem('datas');

    if (prix == null) {prix = 0;}



    // Récupérer le prix avec ajax uniquement si une variable de session ""

    $.ajax({

        url:ajaxurl,

        type:'post',

        data: {

            'prix':prix,
            'description':description,
            'action':'appelajax',

        },

        success: function(response){

            console.log(response);

            if (response.success) {

                // Récupérer le prix renvoyé par l'appel AJAX

              

            }

        },

        error: function(error){

            console.log(error);

        }

    })



    // Si on arrive sur la page panier, on efface les données de session

    /*if (window.location.href.indexOf("panier") > -1) {
            sessionStorage.removeItem('prix');
            sessionStorage.removeItem('datas');

        }
*/
});

