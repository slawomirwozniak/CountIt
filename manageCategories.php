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
    <div class='row col-12 align-items-center' style="max-height:100px; background-color:white;">
        <div class='col-lg-6 d-lg-block d-sm-none d-none d-md-none d-xs-none d-sm-none text-left'>
            <br>
            <h3><?php echo 'Projekt:' . ' ' . $_GET['nazwa'] ?></h3>
            <br>
        </div>

        <div class='col-xs-12 col-sm-12 col-md-12 d-block d-sm-block  d-xs-block d-md-block d-lg-none text-center'>
            <br>
            <h3><?php echo 'Projekt:' . ' ' . $_GET['nazwa'] ?></h3>
            <br>
        </div>

        <div class='col-lg-6 d-lg-block d-sm-none d-md-none d-none d-xs-none d-sm-none text-right'>
            <?php showBackButton(); ?>
        </div>
        <div class='col-12 col-xs-12 col-sm-12 col-md-12 d-sm-block  d-block d-xs-block d-md-block d-lg-none text-center'>
            <?php showBackButton(); ?>
        </div>

    </div>
    <div class="row col-12 justify-content-around articlecontainer" style="min-height:80px;"></div>
    <div class='row col-12 justify-content-around articlecontainer'>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 framebackground" style="min-height:250px";>
            <b>
                <h3>Kategorie wydatków</h3>
            </b>
            <?php showCategories();
            ?>

            <form method='post'>

                <//input type='submit' name='delete' id='delete' tabindex='4' class='btn btn-default' value='Usuń zaznaczone'>

            </form>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 framebackground" style="min-height:250px" ;>
            <div><b>
                    <h3>Dodaj nowe kategorie</h3>
                </b><br></div>

            <form method='post'>
                <input type='text' name='nazwakategorii' id='nazwakategorii' tabindex='1' class='form-control' placeholder='Nazwa kategorii' required><br>
                <input type='submit' name='login-submit' id='login-submit' tabindex='4' class='form-control btn btn-primary' value='Zapisz'>
                <?php validateCategory();
                ?><br><br>
                <?php echo display_message();
                ?>
            </form>
        </div>
        <div class="col-1 col-md-1 col-lg-3">
            <!--prawybok-->
        </div>

</div>
</div>
<?php include('includes/footer.php') ?>