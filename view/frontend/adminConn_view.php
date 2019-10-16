<?php
$this->title = 'Connection';
?>
	<div class="row">
		<div class="col-sm-12 py-3 mb-5">
			<h2 class="text-center">ACCES A LA PARTIE <b>ADMINISTRATION</b></h2>
		</div>
		<div class="col-md-9 offset-md-3 py-1 mb-1">
			<p>Pour accèder à cette partie, vous devez être administrateur du site. Merci de vous authentifier.</p>
		</div>
		<?php
		if (isset($confirm)) {
		?>
			<div class="col-md-7 offset-md-3 alert alert-primary alert-dismissible fade show" role="alert">
				<?php echo $confirm;?>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
		<?php
		}
		?>
		</div>
	<div class="row">
		<div class="col-md-9 offset-md-3">
			<form id="form-connexion" method="post" action="">
				<div class="form-group">
					<div class="col-sm-6 mb-3">
						<label for="numChap">Identifiant :</label>
						<input class="form-control text-field" type="text" id="num-chap" name="login"/>
					</div>
					<div class="col-sm-6 mb-3">
						<label for="titleChap">Mot de passe :</label>
						<input class="form-control text-field" type="password" id="title" name="password"/>
					</div>
				</div>
				<div class="col-sm-6">
					<button name="connexion" type="submit" class="btn btn-outline-primary btn-sm my-3" id="btn-form-conn">CONNECTION</button>
				</div>
			</form>
		</div>
	</div><!-- //ROW -->
