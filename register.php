<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);


include("includes/header.php") ?>


<?php include("includes/nav.php") ?>
<div class="content row articlecontainer">
<div class='row col-12 align-items-center' style="max-height:100px; background-color:white;">
    </div>
<div class="row col-12 align-items-start justify-content-around">
<div class="signup-form framebackground col-xs-12 col-sm-12 col-md-10 col-lg-4 col-xl-4 ">

      <!--przerwa-->
      <form id="register-form" method="post" role="form">
        <h1>
          <center>Załóż darmowe konto</center>
        </h1>
        <div class="form-group text-left">
          <input type="text" name="imie" id="imie" tabindex="1" class="form-control" placeholder="Imię" value="" required>

        </div>
        <div class="form-group text-left">
          <input type="email" name="email" id="email" tabindex="1" class="form-control" placeholder="Adres email" value="" required>
        </div>
        <div class="form-group text-left">
          <input type="password" name="haslo" id="haslo" tabindex="2" class="form-control" placeholder="Hasło" required>
        </div>
        <div class="form-group text-left">
          <input type="password" name="potwierdz_haslo" id="potwierdz_haslo" tabindex="2" class="form-control" placeholder="Potwierdź hasło" required>
        </div>
        <div class="form-group text-left">
          <label for="remember"><input type="checkbox" tabindex="3" class="" name="regulamin" id="regulamin" required>Akceptuje <a href="regulations.php">regulamin</a></label>
        </div>
        <div class="form-group">
          <input type="submit" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-register" value="Załóż konto">

        </div>

        <div class="form-group signin">
          Masz już konto? <a href="login.php" style="color:#007bff;">Kliknij ten link aby przejść do strony logowania</a>
        </div>
        <?php validate_user_registration();
        ?>
      </form>
    </div>
    </div>
</div>
<?php include("includes/footer.php") ?>

