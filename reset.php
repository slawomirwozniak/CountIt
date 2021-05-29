<?php include("includes/header.php") ?>
<?php include("includes/nav.php") ?>
<div class="content row articlecontainer">
<div class='row col-12 align-items-center' style="max-height:100px; background-color:white;">	
<?php display_message(); ?>
<?php password_reset(); ?>
	</div>
    <div class="row col-12 align-items-start justify-content-around">
	<div class="signup-form col-xs-12 col-sm-12 col-md-10 col-lg-4 col-xl-4 framebackground">
					<div class="text-center">
								<h3>Reset hasła</h3>
						</div>
						<hr>
							<div class="col-lg-12">
								<form id="register-form" method="post" role="form" >
									<div class="form-group">
										<input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Hasło" required>
									</div>
									<div class="form-group">
										<input type="password" name="confirm_password" id="confirm-password" tabindex="2" class="form-control" placeholder="Potwierdź hasło" required>
									</div>
									<div class="form-group">
												<input type="submit" name="reset-password-submit" id="reset-password-submit" tabindex="4" class="form-control btn btn-register" value="Zresetuj hasło">
											</div>
										</div>
									<input type="hidden" class="hide" name="token" id="token" value="<?php echo token_generator(); ?>">
								</form>
								</div>
					</div>
				</div>
<?php include("includes/footer.php") ?>