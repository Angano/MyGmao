$(document).ready(function(){
    // Recherche client
    $('body').on('click', '#materiel-client', function () {

        var data = new XMLHttpRequest();
        data.responseType = 'json';
        data.onload = function (){

            //creation élément

            var newDiv = document.createElement('ul');
            newDiv.setAttribute('style', 'margin-top:-1rem; padding-left:0px; border: solid 2px gainsboro;width: 100%;position: absolute;z-index: 100;background-color: white;');
            newDiv.setAttribute('id', 'clients');

            this.response.forEach(element => {
                //clients = clients+'<li class="nav nav-link " data-nom="'+element+'" id="'+element.id+'">Sociète:'+element.societe+' Nom: '+element.nom+' Prenom: '+element.prenom+' '+'</li>';
                var newLi = document.createElement("li");
                newLi.setAttribute('class', 'nav nav-link');
                newLi.setAttribute('id', element.id);
                newLi.append('Sociète:' + element.societe + ' Nom: ' + element.nom + ' Prenom: ' + element.prenom);
                newLi.setAttribute('data-nom', element.nom);
                newLi.setAttribute('data-prenom', element.prenom);
                newLi.setAttribute('data-societe', element.societe);
                newLi.setAttribute('data-adresse', element.adresse);
                newLi.setAttribute('data-codepostal', element.codepostal);
                newLi.setAttribute('data-ville', element.ville);
                newLi.setAttribute('data-telephone', element.telephone);
                newLi.setAttribute('data-email', element.email);

                newDiv.appendChild(newLi);
            });

            $('#resultat-client').html(newDiv);
            $('#resultat-client>ul>li').on('click',function(e){
                $('#materiel_client').val(e.target.id)
                $('#materiel-client').val($(e.target).data('societe'));
                $('#nom-client').val($(e.target).data('nom'));
                $('#prenom-client').val($(e.target).data('prenom'));
                $('#adresse-client').val($(e.target).data('adresse'));
                $('#codepostal-client').val($(e.target).data('codepostal'));
                $('#ville-client').val($(e.target).data('ville'));
                $('#resultat-client').html('');
            });
        };
        data.open("get", window.location.origin+'/api/getClient', true);
        data.send();
    });

// Recherche Matériel
    $('body').on('click','#materiel-materiels', function(){
        
    // on recupère la liste du matériel
    var xmlh = new XMLHttpRequest();
    xmlh.responseType = 'json';
    xmlh.onload = function(){
        
        var newUl = document.createElement("ul");
        newUl.id = "ul-materiel"
        this.response.forEach(element => {
          
            var newLi = document.createElement("li");
            newLi.setAttribute('data-id-materiel-client',element.id);
            newLi.setAttribute('data-marque-materiel-client',element.marque);
            newLi.setAttribute('data-modele-materiel-client',element.modele);
            newLi.setAttribute('data-categorie-materiel-client',element.categorie);
            newLi.append('Marque:'+element.marque+' Modèle: '+element.modele+' Catégorie: '+element.categorie)
            newUl.appendChild(newLi);
        });
        $('#resultat-materiels').html(newUl);
        $('#resultat-materiels').css('z-index','+15');

         $('#ul-materiel>li').on('click',function(e){
            $('#resultat-materiels').html('');
            $('#marque-materiel-search').val($(e.target).data('marque-materiel-client'));
            $('#modele-materiel').val($(e.target).data('modele-materiel-client'));
            $('#categorie-materiel').val($(e.target).data('categorie-materiel-client'));
            $('#materiel-materiels').val($(e.target).data('marque-materiel-client'));
            $('#materiel_materieltype').val($(e.target).data('id-materiel-client'));
            
           
            
        })
    }
    xmlh.open('get',window.location.origin+'/api/getMaterielsType', true);
    xmlh.send();
    });

 // on efface les champs de résultat
 $('body').on('click',function(){

    $('#clients').css('z-index','-15').html('');
    $('#resultat-materiels').css('z-index','-15').html('');
 })   
    
});


