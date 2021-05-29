<?php include("includes/header.php") ?>
<?php include("includes/nav.php") ?>
<div class="content row articlecontainer">
	<div class='row col-12 align-items-center' style="max-height:100px; background-color:white;">
		<?php display_message(); ?>
		<?php kod_walidacyjny(); ?>
	</div>
	<div class="row col-12 align-items-start justify-content-around">
		<div class="signup-form col-xs-12 col-sm-12 col-md-10 col-lg-4 col-xl-4 framebackground">
			<div class="text-center">
				<h3><b> Wprowadź kod</b></h3>
				<hr>
			</div>
			<form id="register-form" method="post" role="form" autocomplete="off">
				<div class="form-group">
					<input type="text" name="code" id="code" tabindex="1" class="form-control" placeholder="Wpisz kod" value="" autocomplete="off" required />
				</div>
				<div class="form-group">
					<input type="submit" name="code-submit" id="recover-submit" tabindex="2" class="form-control btn btn-register" value="ZATWIERDŹ KOD" /></div>
				<input type="hidden" class="hide" name="token" id="token" value="">
		</div>
		</form>
	</div>
</div>
<?php include("includes/footer.php") ?>