<?php

ini_set( 'display_errors', 1 );

error_reporting( E_ALL );

include( 'includes/header.php' ) ?>

<?php

if ( logged_in() ) {

} else {

    redirect( 'index.php' );
}

?>

<?php include( 'includes/nav.php' ) ?>


<div class="content row articlecontainer">
<div class='row col-12  align-items-center justify-content-center d-block d-xs-none d-sm-none d-md-none d-lg-none d-xl-none' style="min-height:100px; background-color:white;">
<br>
            <h1 class="text-center">Panel Administracyjny</h1>
            <br>

    </div>
<div class='row col-12  align-items-center justify-content-center d-none d-xs-block d-sm-block d-md-block d-lg-block d-lg-block' style="height:100px; background-color:white;">
        <br>
            <h1 class="text-center">Panel Administracyjny</h1>
            <br>

    </div>

    <div class=" row col-12 align-items-center  justify-content-around">
    <div class='col-xs-12 col-sm-12 col-md-12 col-lg-3 framebackground'>
        <h1>Zmiana hasła</h1>

        <form id='changePassword' method='post' role='form'>
            <input type='password' name='currentPassword' id='currentPassword' tabindex='1' class='form-control'
                placeholder='Aktualne hasło' required><br>
            <input type='password' name='newPassword' id='newPassword' tabindex='2' class='form-control'
                placeholder='Nowe hasło' required><br>
                
            <input type='password' name='newPasswordConfirmation' id='newPasswordConfirmation' tabindex='3'
                class='form-control' placeholder='Potwierdź nowe hasło' required><br>
            <input type='submit' name='changePassword-submit' id='changePassword-submit' tabindex='3' class='form-control btn btn-success'
                value='Zapisz'>

            <?php   changePassword();
?><?php echo display_message();
?>
        </form>


    </div>


    <div class='col-xs-12 col-sm-12 col-md-12 col-lg-3 framebackground'  style="min-height:307px;">
    
        <h1>Zmiana adresu <br>e-mail</h1>

        <form id='changeEmail' method='post' role='form'>
           <p>  Aktualny adres email: <?php showEmail ()?> </p>
            <!-- <input type='text' name='currentEmail' id='currentEmail' tabindex='4' class='form-control'
                placeholder='<?php showEmail ()?>'><br> -->
            <input type='text' name='newEmail' id='newEmail' tabindex='5' class='form-control'
                placeholder='Nowy adres e-mail' required><br>
            <input type='submit' name='changeEmail-submit' id='changeEmail-submit' tabindex='6' class='form-control btn btn-success'
                value='Zapisz'>

                        <?php changeEmail(); ?>
    </div>
</form>
    <div class='col-xs-12 col-sm-12 col-md-12 col-lg-3 framebackground' style="min-height:307px;">

        <h1>Usunięcie konta</h1>

        <form id='changeEmail' method='post' role='form'>
            <div class='form-group text-left'>
                <label for='zgoda'><input type='checkbox' tabindex='7' class='' name='deleteaccount'
                        id='deleteaccount'> Chce
                    usunąć konto</label>
            </div>

            <input type='submit' name='deleteaccount-submit' id='deleteaccount-submit' tabindex='8' class='form-control btn btn-danger'
                value='Zatwierdź'>

                <?php deleteAccount (); ?> 
            </form>
    </div>
</div>
<div class='col-1 col-md-3 col-lg-3'>
    <!--przerwa-->
</div>
</div>

<?php include( 'includes/footer.php' ) ?>

<?php echo display_message();
?>