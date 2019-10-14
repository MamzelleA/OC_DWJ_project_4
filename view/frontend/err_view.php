<?php $this->title = 'Oups...'; ?>
<div class="row m-5 error_view">
	<div class="col-lg-1"><i class="fas fa-unlink"></i></div>
	<div class="col-lg-11 col-md-11 col-sm-11">
		<div class="text-justify">
			<h3 class="title">Oups ! il semble qu'il y ait une erreur</h3>
			<p><b>Message :</b> <?= $errMessage ?></p>
			<p><b>Code :</b> <?= $errCode ?></p>
			<p><b>Ligne :</b> <?= $errLine ?></p>
			<p><b>Fichier :</b> <?= $errFile ?></p>
			<form>
				<input type = "button" class="btn btn-outline-primary btn-sm" value = "RETOUR PAGE PRECEDENTE"  onclick = "history.back()">
			</form>
		</div>
	</div>
</div>
