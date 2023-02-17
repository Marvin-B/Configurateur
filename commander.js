var Commander = pc.createScript('commander');

// Ce script permet de rediriger vers la page "panier" lorsqu'on clique sur le bouton pour commander.

// Pour rappel : les données sont récupérées via un cookie, généré dans le script "bouton-material".

Commander.prototype.initialize = function() {
    var self = this;
    this.materialIndex = 0;

    this.entity.button.on('click', function(event){

        sessionStorage.setItem('ajout-produit-config','oui');

        // Envoyer ajout-produit-config à la page panier en post avec ajax, sans jquery

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'https://dev-echo.fr/configurateur/panier', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send('ajout-produit-config=oui');

        // problème : requête bloquée par le navigateur, alors que le site est en https

        // Pour contourner le problème, on peut utiliser un iframe

        var iframe = document.createElement('iframe');
        iframe.style.display = 'none';
        iframe.src = 'https://dev-echo.fr/configurateur/panier';
        document.body.appendChild(iframe);

        var form = document.createElement('form');
        form.style.display = 'none';
        form.method = 'POST';
        form.action = 'https://dev-echo.fr/configurateur/panier';
        form.target = iframe.name;
        document.body.appendChild(form);

        var input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'ajout-produit-config';
        input.value = 'oui';
        form.appendChild(input);

        form.submit();

        document.body.removeChild(form);
        document.body.removeChild(iframe);

        self.app.fire('ajout-produit-config');




    
        self.procederALaCommande();
    });
};

Commander.prototype.procederALaCommande = function(){
    var panier = 'https://dev-echo.fr/configurateur/panier';
    window.parent.location.href = panier;
};

