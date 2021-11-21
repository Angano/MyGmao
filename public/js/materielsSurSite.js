
var getData = function() {
    var table = $('#knp_search>').find('select').val();
    var url,label1,label2;
    if(table=='client'){
        url = '/api/getClienByNom/?client=';
        label1 = 'Societe: ';
        label2 = ' Nom: ';
    } 
    else if(table=='categorie'){
        url = '/api/getCategoriesByNom/?categorie='
        label1 = 'Categorie: ';
        label2 = null;
    }
    else if(table == 'materiel'){
        url = '/api/getMaterielByMarque/?materiel=';
        label1 = 'Marque: ';
        label2 = ' Modèle: ';
    }
    if (true) {
     
        var search_value = $('#knp_search>').find('input[type="search"]').val();
        if ((search_value.length) > 1) {
            var data = new XMLHttpRequest();
            data.responseType = 'json';
            data.onload = function () {

                //creation élément

                var newDiv = document.createElement('ul');
                newDiv.setAttribute('style', 'padding-left:0px; border: solid 2px gainsboro;width: 100%;position: absolute;z-index: 100;background-color: white;');
                newDiv.setAttribute('id', 'clients');

                this.response.forEach(element => {
                    //clients = clients+'<li class="nav nav-link " data-nom="'+element+'" id="'+element.id+'">Sociète:'+element.societe+' Nom: '+element.nom+' Prenom: '+element.prenom+' '+'</li>';
                    var newLi = document.createElement("li");
                    newLi.setAttribute('class', 'nav nav-link');
                    newLi.setAttribute('id', element.id);

                    var spanSociete = document.createElement('small')
                    spanSociete.innerText = label1;
                    spanSociete.style.color = "black";

                    var spanNom = document.createElement('small');
                    spanNom.innerText = label2;
                    spanNom.style.color = "black";

                    var span1 = document.createElement('span');
                    span1.append(element.societe);
                    span1.setAttribute('class', 'resultat_li')
                    span1.style.cursor = "pointer";

                    var span2 = document.createElement('span');
                    span2.setAttribute('class', 'resultat_li')
                    span2.style.cursor = "pointer";
                    span2.append(element.nom);

                    if(element.societe!==undefined){
                         newLi.append(spanSociete);
                    newLi.append(span1);
                    }
                   
                    newLi.append(spanNom);
                    newLi.append(span2);

                    newDiv.appendChild(newLi);
                });

                if ($(newDiv).children().length == 0) {
                    var noLi = document.createElement('li');
                    noLi.setAttribute('class', 'nav nav-link');
                    noLi.setAttribute('style', '');
                    noLi.innerText = 'Aucun résultat';
                    newDiv.append(noLi);
                    ($('#resultat-client')).html(newDiv);
                } else {
                    $('#resultat-client').html(newDiv);
                };

                $('#resultat-client>ul>li>.resultat_li').on('click', function (e) {

                    $('#knp_search>').find('input[type="search"]').val($(e.target).text())
                    $('#resultat-client').html('');
                });
            };
            data.open("get", window.location.origin+url+search_value, true);
            data.send();
        }
    }

}


$(document).ready(function () {
    $('#knp_search>').find('input[type="search"]').attr('autocomplete', 'off');


    // Recherche client
    $('body').on('keyup', $('#knp_search>').find('input[type="search"]'), function () {

        getData();



    });

    $('body').on('click', function () {
        $('#resultat-client').html('');
    })








});