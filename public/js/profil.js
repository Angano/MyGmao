$(document).ready(function () {

    $('#technicien_metier').on('keyup', function () {
        var data = $(this).val();
        if (($(this).val()).length > 0) {
            var xmlh = new XMLHttpRequest();
            xmlh.open('get', window.location.origin+'/api/getMetierByData/?data=' + $(this).val(), true);

            var tab = [];
            xmlh.responseType = 'JSON';
            xmlh.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
            xmlh.onload = function () {
                var item = '';
                var tab2 = JSON.parse(this.response);

                tab2.forEach(element => {
                    item = item + '<li class="retour_metier">' + element + '</li>';
                    tab.push(element.metier);
                });
                $('#resultat_metier').html('').css('z-index', '15').css('list-style', 'none').html(item);

                $('#resultat_metier').on('click', ".retour_metier", function () {
                    $('#technicien_metier').val(($(this).text()));
                    $('#resultat_metier').html('').css('z-index', '-15');
                })
            }

            xmlh.send();

        } else {
            $('#resultat_metier').html('').css('z-index', '-15');
        }
    });


    $('#list_metier').on('click', function () {
        var xmlh = new XMLHttpRequest();
        var tab = [];
        xmlh.responseType = 'json';
        xmlh.onload = function () {
            var item = '';
            (this.response).forEach(element => {
                item = item + '<li class="retour_metier">' + element + '</li>';
                tab.push(element.metier);
            });


            $('#resultat_metier').html('').css('z-index', '15').css('list-style', 'none').html(item);

            $('#resultat_metier').on('click', ".retour_metier", function () {
                $('#technicien_metier').val(($(this).text()));
                $('#resultat_metier').html('').css('z-index', '-15');
            })
        }
        xmlh.open('get', window.location.origin+'/api/getMetierByData/?data=' + $(this).val(), true);
        xmlh.send();

    })


    ////
    $('body').on('click', ".container-fluid", function () {
        $('#resultat_metier').html('').css('z-index', '-15');
    })

})