// surveille les changements de l'URL
window.addEventListener('popstate', function(event) {
    // vérifie si la variable est présente
    if (typeof event.state !== 'undefined' && typeof event.state['ajout-produit-config'] !== 'undefined') {
      // envoie une requête AJAX au serveur pour traiter la variable
      var xhr = new XMLHttpRequest();
      xhr.open('POST', 'appelajax.php', true);
      xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
          console.log(xhr.responseText);
        }
      };
      xhr.send('ajout-produit-config=' + encodeURIComponent(event.state['ajout-produit-config']));
    }
  });