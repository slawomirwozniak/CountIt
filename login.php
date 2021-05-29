<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
include("includes/header.php") ?>

<?php

if (logged_in()) {

    redirect("main.php");
}


?>


<?php include("includes/nav.php") ?>
<div class="content row articlecontainer">
<div class='row col-12 align-items-center' style="max-height:100px; background-color:white;">
    </div>
    <div class=" row col-12 align-items-start justify-content-around">
    <div class="signup-form col-xs-12 col-sm-12 col-md-10 col-lg-4 col-xl-4 ">
            <article class="text-left framebackground zoomopacity registrationcontainer">
                <h1 class="card-title mb-4 mt-1 text-center">Logowanie</h1>
                <form id="login-form" method="post" role="form" style="display: block;">
                    <!-- form-group -->
                    <div class="form-group">
                        <input type="text" name="email" id="email" tabindex="1" class="form-control" placeholder="Email" required>
                    </div>
                    <!-- form-group// -->
                    <!-- form-group -->
                    <div class="form-group">
                        <input type="password" name="haslo" id="haslo_logowanie" tabindex="2" class="form-control" placeholder="Hasło" required>
                        <a class="float-right"  style="color:#007bff;" href="recovery.php">Nie pamiętasz hasła?</a>
                    </div>
                    <!-- form-group// -->
                    <!-- form-group -->
                    <div class="form-group">
                        <!--checkbox//-->
                        <div class="checkbox">
                            <label for="remember">
                                <input type="checkbox" tabindex="3" class="" name="pamietaj" id="pamietaj">Pamiętaj mnie </label>
                            <?php validate_user_login(); ?><?php display_message(); ?>
                        </div>
                        <!-- checkbox .// -->
                    </div>
                    <!-- form-group// -->
                    
                    <div class="form-group">
                        <input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-register" value="Zaloguj">
                    </div>
                    <!-- form-group// -->
                </form>
            </article>
        </div>
    </div>
</div>
<?php include("includes/footer.php") ?>

