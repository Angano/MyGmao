$(document).ready(function () {
    $('#list_marque').on('click', function () {
        var xmlh = new XMLHttpRequest();
        var tab = [];
        xmlh.responseType = 'json';
        xmlh.onload = function () {
            var item = '';
            (this.response).forEach(element => {
                if (!tab.includes(element.marque)) {
                    item = item + '<li class="retour_marque py-1">' + element.marque + '</li>';
                    tab.push(element.marque);
                }

            });
            $('#resultat_marque').html('').css('z-index', '15').css('list-style', 'none').html(item);

            $('#resultat_marque').on('click', ".retour_marque", function () {
                $('#materieltype_marque').val(($(this).text()));
                $('#resultat_marque').html('').css('z-index', '-15');
            })
        }
        xmlh.open('get', window.location.origin+'/api/getMaterielsType', true);
        xmlh.send();

    })

    $('#list_categorie').on('click', function () {
        var xmlh = new XMLHttpRequest();
        var tab = [];
        xmlh.responseType = 'json';
        xmlh.onload = function () {
            var item = '';
            (this.response).forEach(element => {
                if (!tab.includes(element.categorie)) {
                    item = item + '<li class="retour_categorie py-1">' + element.categorie + '</li>';
                    tab.push(element.categorie);
                }

            });
            $('#resultat_categorie').html('').css('z-index', '15').css('list-style', 'none').html(item);

            $('#resultat_categorie').on('click', ".retour_categorie", function () {
                $('#materieltype_categorie').val(($(this).text()));
                $('#resultat_categorie').html('').css('z-index', '-15');
            })
        }
        xmlh.open('get', window.location.origin+'/api/getMaterielsType', true);
        xmlh.send();

    })


    //// on change

    $('#materieltype_marque').on('keyup', function () {
        var data = $(this).val();
        if (($(this).val()).length > 0) {
            var xmlh = new XMLHttpRequest();
            xmlh.open('get', window.location.origin+'/api/getMarqueByData/?data='+$(this).val(), true);
            
            var tab = [];
            xmlh.responseType = 'JSON';
            xmlh.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
            xmlh.onload = function () {
               var item = '';
                var tab2 = JSON.parse(this.response);
                
                tab2.forEach(element => {
                    if (!tab.includes(element)) {
                        item = item + '<li class="retour_marque">' + element + '</li>';
                        tab.push(element.marque);
                    }

                }); 
                $('#resultat_marque').html('').css('z-index', '15').css('list-style', 'none').html(item);

                $('#resultat_marque').on('click', ".retour_marque", function () {
                    $('#materieltype_marque').val(($(this).text()));
                    $('#resultat_marque').html('').css('z-index', '-15');
                })
               


               
            }
            
            xmlh.send();

            

        }else{
            $('#resultat_marque').html('').css('z-index', '-15');
        }
    });


    $('#materieltype_categorie').on('keyup', function () {
        var data = $(this).val();
        if (($(this).val()).length > 0) {
            var xmlh = new XMLHttpRequest();
            xmlh.open('get', window.location.origin+'/api/getCategorieByData/?data='+$(this).val(), true);
            
            var tab = [];
            xmlh.responseType = 'JSON';
            xmlh.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
            xmlh.onload = function () {
               var item = '';
                var tab2 = JSON.parse(this.response);
                
                tab2.forEach(element => {
                    if (!tab.includes(element)) {
                        item = item + '<li class="retour_categorie">' + element + '</li>';
                        tab.push(element.categorie);
                    }

                }); 
                $('#resultat_categorie').html('').css('z-index', '15').css('list-style', 'none').html(item);

                $('#resultat_categorie').on('click', ".retour_categorie", function () {
                    $('#materieltype_categorie').val(($(this).text()));
                    $('#resultat_categorie').html('').css('z-index', '-15');
                })
            }
            
            xmlh.send();

        }else{
            $('#resultat_categorie').html('').css('z-index', '-15');
        }
    });


    ////
    $('body').on('click', ".container-fluid", function () {
    $('#resultat_categorie').html('').css('z-index', '-15');
    $('#resultat_marque').html('').css('z-index', '-15')
})

    $('body').on('click', '#document',function(){
       $('#object').attr('data','/upload/'+$('#document').data('href'));
    })

    
   
})