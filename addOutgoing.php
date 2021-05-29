<?php

ini_set('display_errors', 1);

error_reporting(E_ALL);

include('includes/header.php') ?>

<?php

if (logged_in()) {
} else {

    redirect('index.php');
}

?>

<?php include('includes/nav.php') ?>
<div class="content row articlecontainer">
<div class='row col-12 align-items-center' style="max-height:100px; background-color:white;">
        <div class='col-lg-6 d-lg-block d-sm-none d-none d-md-none d-xs-none d-sm-none text-left'>
        </div>

        <div class='col-xs-12 col-sm-12 col-md-12 d-block d-sm-block  d-xs-block d-md-block d-lg-none text-center'>
        </div>

        <div class='col-lg-6 d-lg-block d-sm-none d-md-none d-none d-xs-none d-sm-none text-right'>
        <?php showBackButtonAddOutgoing(); ?>
        </div>
        <div class='col-12 col-xs-12 col-sm-12 col-md-12 d-sm-block  d-block d-xs-block d-md-block d-lg-none text-center'>
        <?php showBackButtonAddOutgoing(); ?>
        </div>

    </div>
<div class="row col-12 align-items-start justify-content-around">
<div class='col-10 col-sm-6 col-md-6 col-lg-4  text-center framebackground'>

<h1>Dodaj wydatek</h1>

<form method='post'>
    <input type='text' name='nazwaWydatku' id='nazwaWydatku' tabindex='1' class='form-control' placeholder='Wpisz wydatek' required><br>

    <input type='text' name='kwotaWydatku' id='kwotaWydatku' tabindex='1' class='form-control' placeholder='Wpisz kwotę' required><br>

    <select class='form-control' id='projekt' name='projekt'>

        <option selected='' disabled=''>Wybierz projekt</option><?php loadProjects();
                                                                ?>
    </select><br>

    <select class='form-control' id='kategoria' name='kategoria'>
        <option selected='' disabled=''>Wybierz kategorię</option><br>
    </select><br>

    <textarea class='form-control' rows='5' id='komentarz' name='komentarz' placeholder='Wpisz komentarz (opcjonalnie)'></textarea><br>

    <input type='submit' name='login-submit' id='login-submit' tabindex='4' class='form-control btn btn-success' value='Dodaj wydatek'>
    <?php validate_outgoing();
    ?>

    <br><br>
    <?php echo display_message();
    ?>

    </div>
</div>
</div>
<?php include('includes/footer.php') ?>
