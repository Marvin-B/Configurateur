jQuery(document).ready(function($) {
    window.onbeforeunload = function() {
        return 'You have not yet saved your work.Do you want to continue? Doing so, may cause loss of your work';
    }


    var eventMethod = window.addEventListener ? "addEventListener" : "attachEvent";
    var eventer = window[eventMethod];
    var messageEvent = eventMethod === "attachEvent" ? "onmessage" : "message";
    eventer(messageEvent, function(e) {
        if (event.origin !== window.origin) {
            return;
        }

        if ((e.data.config !== undefined)) {
            var infoprod = e.data.config;

            var caisse = infoprod.caisse;
            var ttc = infoprod.ttc;
            var masse = infoprod.masse;
            var options = infoprod.options;
            var vehiculeconfig = infoprod.vehiculeConfig;

            var data = {
                action: 'load_comments',
                product_id: '51210',
                product_sku: '',
                quantity: '1',
                caisse: caisse,
                ttc: ttc,
                masse: masse,
                options: options,
                vehiculeconfig: vehiculeconfig
                // variation_id: variation_id,
            };

            $.ajax({
                url: ajaxurl,
                type: "POST",
                data: data
            }).done(function(response) {
                console.log(response);
                window.onbeforeunload = null;
                if (response == 'commandeok') {

                    window.location.href = 'https://dev-echo.fr/configurateur/panier'; //Redirection similaire à un clic sur un lien
                }
                if (response == 'commandeoken') {

                    window.location.href = 'https://dev-echo.fr/configurateur/cart'; //Redirection similaire à un clic sur un lien
                }

            });
        }

    });


    jQuery(document).ready(function($) {
        jQuery(".acf-field-repeater[data-name='vos_vehicules'] .acf-repeater .acf-row").each(function(i, element) {
            var row = $(element);
            //console.log(row);	
            var allListElements = $('.acf-field-select[data-name="vehicule_marque"] .acf-input select option:selected');
            var verifselect = row.find(allListElements).val();
            //console.log(verifselect);
            //var musearch= row.find('.acf-field-select[data-name="vehicule_modele"] .acf-input select').text();
            //	console.log(musearch);
            if (verifselect > 0) {
                var marque = verifselect;
                var idrow = row.attr("data-id");
                //var vehicule=$(this).val();

                var data = {
                    action: 'load_modele',
                    id_marque: marque,
                    ligne: idrow
                    // variation_id: variation_id,
                };

                $.ajax({
                    url: ajaxurl,
                    type: "POST",
                    data: data
                }).done(function(responsemarque) {
                    var responsemarque = responsemarque.substring(0, responsemarque.length - 1);

                    var response = JSON.parse(responsemarque);
                    var ligne = response.idrow;

                    // $('.acf-table .acf-row[data-id="'+ligne+'"] .acf-field-select[data-name="vehicule_modele"]').fadeIn();
                    // console.log(response.liste);
                    // on insert les champs modele en js
                    var modele = response.liste;

                    var valmod = $('.acf-table .acf-row[data-id="' + ligne + '"] .acf-field-select[data-name="vehicule_modele"] .acf-input select option:selected').val();


                    $('.acf-table .acf-row[data-id="' + ligne + '"] .acf-field-select[data-name="vehicule_modele"] .acf-input select  option').remove();
                    for (const property in modele) {
                        //  console.log(`${property}: ${modele[property]}`);
                        if (`${property}` == valmod) {
                            $('.acf-table .acf-row[data-id="' + ligne + '"] .acf-field-select[data-name="vehicule_modele"] .acf-input select').append('<option value="' + `${property}` + '" selected>' + `${modele[property]}` + '</option>');
                        } else {
                            $('.acf-table .acf-row[data-id="' + ligne + '"] .acf-field-select[data-name="vehicule_modele"] .acf-input select').append('<option value="' + `${property}` + '">' + `${modele[property]}` + '</option>');
                        }
                    }
                });
            }
        });

        /*gestion tva*/

        var typepers = $('input[name=billing_wooccm11]:checked').val();
        //$('input[name=billing_wooccm11]:checked').attr('value'); 
        var datatva = {
            action: 'load_changetav',
            typepers: typepers,
        };

        $.ajax({
            url: ajaxurl,
            type: "POST",
            data: datatva
        }).done(function(response) {

            console.log(response);

        });

        $('input[name=billing_wooccm11]').click(function() {
            var typepers = $('input[name=billing_wooccm11]:checked').val();

            var datatva = {
                action: 'load_changetav',
                typepers: typepers,
            };

            $.ajax({
                url: ajaxurl,
                type: "POST",
                data: datatva
            }).done(function(response) {

                console.log(response);

            });
        });
    });
});