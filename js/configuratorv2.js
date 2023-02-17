jQuery(document).ready(function($){

console.log('le script est chargé !');

var datas = sessionStorage.getItem('datas');

//var datas = datas.split('&');

var prix = sessionStorage.getItem('prix');
var ajoutProduitConfig = sessionStorage.getItem('ajout-produit-config');

var test = 'test';

//console.log(datas); // OK
//console.log('prix : ' + prix); // OK

  if (datas == null) {
    datas = 'Pas de données';
  };
  if (prix == null) {
    prix = 'Pas de prix';
  };
  if (ajoutProduitConfig == null) {
    ajoutProduitConfig = 'Pas de produit';
  };

  $.ajax({

    url:ajaxurl,
    type:'post',
    data: {
      //'datas':datas.substring(0, datas.length -1), // On enlève le 0 qui se génère à la fin de la chaîne de caractères
      'datas':datas,
      'ajoutProduitConfig':ajoutProduitConfig,
      'prix':prix,
      //'test':test,
      'action':'configurateurv2',
    },
    success: function(response){
      console.log('réponse : '+response);
      console.log (datas);
    },

    error: function(error){
      alert('error');
    }
  });

});