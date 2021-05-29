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
    </div>
<div class="row col-12 align-items-start justify-content-around">
<div class="col-10 col-sm-6 col-md-6 col-lg-4  text-center justify-content-md-center framebackground">
        <h1>Dodaj projekt</h1>

<form method='post'>
    <input type='text' name='nazwa' id='nazwa' tabindex='1' class='form-control' placeholder='Nazwa projektu' required><br>
    <input type='text' name='budzet' id='budzet' tabindex='1' class='form-control' placeholder='Budżet remontu' required><br>
    <input type='submit' name='login-submit' id='login-submit' tabindex='4' class='form-control btn btn-success' value='Zapisz'>

    <?php validate_project();
    ?>

    <br><br>
    <?php echo display_message();
    ?>

        </div>
    </div>
</div>
<?php include('includes/footer.php') ?>

