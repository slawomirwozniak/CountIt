<?php

ini_set('short_open_tag', 1);

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
<div class="col-12 col-xs-10 col-sm-8 col-md-8 col-lg-6  col-xl-4 text-left text-justify justify-content-md-center framebackground">

<?php projectModification();
?>

<h1 class="text-center">Modyfikuj projekt</h1>

<form method='post'>
    <input type='textarea' name='nazwa' id='nazwa' tabindex='1' class='form-control' placeholder="<?php echo $_GET['nazwa'] ?> " required <br><br>
    <input type='textarea' name='budzet' id='budzet' tabindex='1' class='form-control' placeholder="<?php echo $_GET['budzet'] ?>" required <br><br>
    <input type='submit' name='login-submit' id='login-submit' tabindex='4' class='form-control btn btn-success' value='Zapisz'><br><br>

    <?php validateProjectModification();
    ?>
    <?php echo display_message();
    ?>
</form>

<form method='post'>
    <input type='submit' name='zakoncz' id='zakoncz' class=" form-control btn btn-danger" value='Zakończ projekt'>

</form>
</div>
    </div>
</div>
<?php include('includes/footer.php') ?>

