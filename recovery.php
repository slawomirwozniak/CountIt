<?php include("includes/header.php") ?>
<?php include("includes/nav.php") ?>
<div class="content row articlecontainer">
<div class='row col-12 align-items-center' style="max-height:100px; background-color:white;">
    </div>
    <div class='row col-12 align-items-start justify-content-around articlecontainer'>
        <div class="col-xl-4 col-lg-4 col-md-1"></div>
    <div class="signup-form col-xs-12 col-sm-12 col-md-10 col-lg-4 col-xl-4 framebackground justify-content-center">
            <div class="alert-placeholder">
                <div class="text-center">
                    <h2><b>Odzyskiwanie hasła</b></h2>
                </div>
                <form id="register-form" method="post" role="form" autocomplete="off">
                    <div class="form-group">
                        <label for="email">Adres e-mail</label>
                        <input type="email" name="email" id="email" tabindex="1" class="form-control" placeholder="Email Address" value="" autocomplete="off" />
                    </div>
                    <div class="form-group">
                        <div class="row justify-content-center">
                            <!--PRZYCISK CANCEL -->
                            <div class="col-4 col-sm-4 col-md-4 col-lg-4">
                                <input type="submit" name="cancel_submit" id="cencel-submit" tabindex="2" class="form-control btn btn-danger" value="Cofnij" />
                            </div>
                            <!--KONIEC PRZYCISKU CANCEL -->
                            <!--PRZYCISK RESET-->
                            <div class="col-4 col-sm-4 col-md-4 col-lg-4">
                                <input type="submit" name="recover-submit" id="recover-submit" tabindex="2" class="form-control btn btn-success" value="Wyślij" />
                            </div>
                            <!--KONIEC PRZYCISKU RESET-->
                        </div><br>
                        <?php display_message(); ?>
                        <?php recover_password(); ?>
                    </div>
                    <input type="hidden" class="hide" name="token" id="token" value="<?php echo token_generator(); ?>">
                </form>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-1"></div>

    </div>
</div>
<!--KONTENER Z ODZYSKIWANIEM HASŁA KOŃCZY SIĘ TUTAJ-->
<?php include("includes/footer.php") ?>