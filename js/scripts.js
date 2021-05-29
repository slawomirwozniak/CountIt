function toggleFunction()
{
  $('.switchlg').toggleClass('row align-self-end col-xl-12 d-xl-block d-sm-none d-lg-none d-md-none d-block-none d-none d-xs-none d-sm-none d-none headercontent');
  document.querySelector('#button').addEventListener('click', classToggle);
}
function toggleFunction()
{
  $('.switchmd').toggleClass('row align-self-end col-lg-12 d-xl-none d-lg-block d-sm-none d-md-none d-block-none d-none d-xs-none d-sm-none d-none headercontent');
  document.querySelector('#button').addEventListener('click', classToggle);
}
function toggleFunction()
{
  $('.switchsm').toggleClass('row align-self-end col-xs-12 col-sm-12 col-md-12 d-sm-block  d-xs-block d-md-block d-block d-lg-none d-none headercontent');
  document.querySelector('#button').addEventListener('click', classToggle);
}
/*MOVE DIV*/
$(document).ready( function () {
    $('.tabela').dataTable({
        ordering:  true,
        responsive: true,
        "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "Wszystkie"]]
} );
} );
$(document).ready(function () {
    $('.tabela2').dataTable({
        "paging":   false,
        "bInfo": false,
        "bFilter": false,
        responsive: true
    });
});
/*koniec obsługi paginacji*/

$(function () {


    $("#register_email").on('change', function () {


        var email = $(this).val();



        $.post("ajax_functions.php", { email: email }, function (data) {



            $(".db-feedback").html(data);

        });



    });
});


//-------------------- ŁADOWANIE KATEGORII DO PROJEKTU PRZY DODAWANIU PROJEKTU----------------------


$(document).ready(function(){
    $('#projekt').on('change', function(){
        var id_projektu = $(this).val();
        if(id_projektu){
            $.ajax({
                type:'POST',
                url:'functions/ajax_functions.php',
                data:'id_projektu='+id_projektu,
                success:function(html){
                    $('#kategoria').html(html);
                     
                }
            }); 
        }else{
            $('#kategoria').html('<option value="">Wybierz projekt</option>');
            
        }
    });
    
    $('#kategoria').on('change', function(){
        var kategoriaID = $(this).val();
        if(kategoriaID){
            $.ajax({
                type:'POST',
                url:'ajax_functions.php',
                data:'id_kw='+id_kw,
                success:function(html){
                    
                }
            }); 
        }else{
            
        }
    });
});

