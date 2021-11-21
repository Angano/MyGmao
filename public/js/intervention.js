$(document).ready(function () {

    $('body').on('click', '#list_technicien', function () {
       
        var data = new XMLHttpRequest();
        data.responseType = 'json';

        data.onload = function () {

            var techniciens ="<ul id='technicien' style='padding-left:0px; border: solid 2px gainsboro;width: 100%;position: absolute;z-index: 100;background-color: white;'>";
            this.response.forEach(element => {
                techniciens = techniciens+'<li class="nav nav-link " id="'+element.id+'">'+element.nom+' '+element.prenom+' '+element.metier+'</li>';
            });
            $('#reponse').html(techniciens+'</ul>')

            $('#technicien').on('click','li',function(e){
                console.log(e.target.id);

                // selection select
                $('#intervention_technicien').val(e.target.id)
                $('#search_technicien').val($(e.target).text());
               
             
            })
        };
        data.open("get", window.location.origin+'/api/getTechnicien', true);

        data.send();



    })


    $('body').on('keydown', '#search_technicien', function () {
       
        var data = new XMLHttpRequest();
        data.responseType = 'json';
        data.onload = function () {

            var techniciens ="<ul id='technicien' style='padding-left:0px; border: solid 2px gainsboro;width: 100%;position: absolute;z-index: 100;background-color: white;'>";
            this.response.forEach(element => {
                techniciens = techniciens+'<li class="nav nav-link " id="'+element.id+'">'+element.nom+' '+element.prenom+' '+element.metier+'</li>';
            });
            $('#reponse').html(techniciens+'</ul>')

            $('#technicien').on('click','li',function(e){
                console.log(e.target.id);

                // selection select
                $('#intervention_technicien').val(e.target.id)
                $('#search_technicien').val($(e.target).text());
               
             
            })
        };
        data.open("get", window.location.origin+'/api/getTechnicien', true);

        data.send();



    })



    // liste client


    $('body').on('click', '#list_societe', function () {

        var data = new XMLHttpRequest();
        data.responseType = 'json';
        data.onload = function () {

            //creation élément

            var newDiv = document.createElement('ul');
            newDiv.setAttribute('style','margin-top:-1rem; padding-left:0px; border: solid 2px gainsboro;width: 100%;position: absolute;z-index: 100;background-color: white;');
            newDiv.setAttribute('id','clients');
           
            this.response.forEach(element => {
                //clients = clients+'<li class="nav nav-link " data-nom="'+element+'" id="'+element.id+'">Sociète:'+element.societe+' Nom: '+element.nom+' Prenom: '+element.prenom+' '+'</li>';
                var newLi = document.createElement("li");
                newLi.setAttribute('class','nav nav-link');
                newLi.setAttribute('id',element.id);
                newLi.append('Sociète:'+element.societe+' Nom: '+element.nom+' Prenom: '+element.prenom);
                newLi.setAttribute('data-nom',element.nom);
                newLi.setAttribute('data-prenom',element.prenom);
                newLi.setAttribute('data-societe',element.societe);
                newLi.setAttribute('data-adresse',element.adresse);
                newLi.setAttribute('data-codepostal',element.codepostal);
                newLi.setAttribute('data-ville',element.ville);
                newLi.setAttribute('data-telephone',element.telephone);
                newLi.setAttribute('data-email',element.email);

                newDiv.appendChild(newLi);

            });
            $('#resultat_client').html(newDiv)

            $('#resultat_client').on('click','li',function(e){
                e.stopPropagation();
                // on efface les données matériel affichées
                $('.data_materiel').val('');


                // selection select
                $('#intervention_client').val(e.target.id)

                // on rempli les données clients
                $('#search_client').val($(e.target).data('societe'));
                $('#nom').val($(e.target).data('nom'));
                $('#prenom').val($(e.target).data('prenom'));
                $('#adresse').val($(e.target).data('adresse'));
                $('#codepostal').val($(e.target).data('codepostal'));
                $('#ville').val($(e.target).data('ville'));
                $('#telephone').val($(e.target).data('telephone'));
                $('#mail').val($(e.target).data('email'));

                
                $('#materiels').html('');
                $('#list_materiel').css('z-index','50');
                $('#resultat_client').html('');

                // on recupère la liste du matériel
                var xmlh = new XMLHttpRequest();
                xmlh.responseType = 'json';
                xmlh.onload = function(){
                    
                    var newUl = document.createElement("ul");
                    newUl.id = "ul-materiel"
                    this.response.forEach(element => {
                      
                        var newLi = document.createElement("li");
                        newLi.setAttribute('class','nav nav-link');
                        newLi.setAttribute('data-id-materiel-client',element.id);
                        newLi.setAttribute('data-marque-materiel-client',element.marque);
                        newLi.setAttribute('data-modele-materiel-client',element.modele);
                        newLi.setAttribute('data-matricule-materiel-client',element.matricule);
                        newLi.setAttribute('data-categorie-materiel-client',element.categorie);
                        newLi.append('Marque:'+element.marque+' Modèle: '+element.modele+' Matricule: '+element.matricule+' Catégorie: '+element.categorie)
                        newUl.appendChild(newLi);
                    });
                    $('#materiels').html(newUl);

                    $('#ul-materiel>li').on('click',function(e){
                       $('#marque_materiel-search').val($(e.target).data('marque-materiel-client'));
                       $('#modele_materiel').val($(e.target).data('modele-materiel-client'));
                       $('#matricule_materiel').val($(e.target).data('matricule-materiel-client'));
                       $('#categorie_materiel').val($(e.target).data('categorie-materiel-client'));
                       $('#intervention_materiel').val($(e.target).data('id-materiel-client'));
                        
                    })
                }
                xmlh.open('get',window.location.origin+'/api/getMaterielById/'+e.target.id, true);
                xmlh.send();
               
             
            })
        };
        data.open("get", window.location.origin+'/api/getClient', true);

        data.send();



    })

    // effacement des zones de recherches
    $('html').not('#search_client').on('click',function(){
        $('#resultat_client').html('');
        $('#reponse').html('');
        $('#list_materiel').css('z-index','-50')
   
       
    })

    // test si materiel entré
    $('body').on('click','#intervention_enregistrer',function(){

        if($('#intervention_materiel').val()==null){
            alert('saisir un materiel valide')
        }
    })
    $('body').on('click', '#document',function(){
        $('#object')
        .attr('data','/upload/'+$('#document').data('document'))
        .css('display','inherit')
        .css('width','100%')
        .css('height','65vh');
        $('#exampleModalLabel').text($('#document').text())
     })
     $('body').on('click', '#photo',function(){
        $('#object')
        .attr('data','/upload/'+$('#photo').data('photo'))
        .css('margin','auto')
        .css('width','auto')
        .css('height','auto')
        .css('display','block')
        ;
        $('#exampleModalLabel').text($('#photo').text())
     })

})