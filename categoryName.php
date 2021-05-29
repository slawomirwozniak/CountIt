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
<div class="content">
    <div class="row col-12 justify-content-center articlecontainer">
        <div class="col-1 col-md-1">
            <!--prawybok-->
        </div>
        <div class="col-xs-8 col-sm-8 col-md-10 col-lg-4 framebackground justify-content-center framebackground">
            <h1>Zmień nazwę projektu</h1>
            <form method='post'>
                <input type='text' name='nazwakategorii' id='nazwa' tabindex='1' class='form-control' placeholder='<?php echo $_GET['nazkat'] ?>' required><br>
                <input type='submit' name='login-submit' id='login-submit' tabindex='4' class='form-control btn btn-primary' value='Zapisz'>

                <?php validateCategoryName();
                ?>

                <br>
                <?php echo display_message();
                ?>

        </div>
        <div class="col-1 col-md-1">
            <!--prawybok-->
        </div>
    </div>
</div>
<?php include('includes/footer.php') ?>