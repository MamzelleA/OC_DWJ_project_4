<?php
$this->title = 'Administration';
?>
<div class="row">
	<div class="col-sm-12">
		<h2 class="text-center">DERNIERS <b>CHAPITRES</b></h2>
	</div>
</div><!-- //ROW title-->
<div class="row">
	<div class="card-group col-md-12 mb-5">
	<?php
	foreach ($lastCh as $chap):
	?>
		<div class="card border-light mx-0">
			<div class="card-body">
				<h4 class="text-center">Chapitre <b><?= $chap['num_chap'] ?></b></h4>
				<h3 class="text-center"><b><?= $chap['title_chap'] ?></b></h3>
				<p class="card-text text-center"><small class="text-center"><i>Statut : <span class="status"><?= $chap['status_chap'] ?></span></i></small></p>
			</div>
			<div class="card-footer bg-primary text-center">
				<a href="<?='index.php?action=see&id=' . $chap['id']?>" class="btn btn-outline-primary btn-fa mr-3" title="lire"><i class="fas fa-book-reader" id="reader-white"></i></a>
				<a href="<?='index.php?action=modify&id=' .$chap['id']?>" class="btn btn-outline-primary btn-fa" title="modifier" ><i class="far fa-edit" id="edit-white"></i></a>
    	</div>
		</div>
	<?php
	endforeach;
	?>
	</div>
</div><!-- //ROW last ch-->
<div class="row">
	<div class="col-sm-12">
		<hr>
		<h2 class="text-center"><a href="index.php?action=commentsList#reported-comments">COMMENTAIRES <b>SIGNALES</b></a></h2>
		<?php
		if (count($reported) == 0)
		{
			print '<p class="content-com">Il n\'y a actuellement aucun commentaire signalé.</p>';

		} else {
			foreach ($reported as $rcom):
				?>
				<h4>écrit par <b><?= mb_strtoupper($rcom['author']) ?></b></h4>
				<p class="text-justify content-com"><?= nl2br($rcom['content_co']) ?></p>
				<p class="text-right"><i>Ajouté le <?= $rcom['add_date_fr'] ?></i><br>
					à propos du chapitre <?= $rcom['num_chap'] ?> | <?=$rcom['title_chap'] ?></p>
					<hr class="small-hr">
		<?php
			endforeach;
		}
		?>
	</div>
</div><!-- //ROW reported co-->
<div class="row">
	<div class="col mx-3">
		<h2 class="text-center"><a href="index.php?action=commentsList#published-comments">DERNIERS COMMENTAIRES <b>PUBLIES</b></a></h2>
		<?php
		foreach ($lastCo as $pcom):
		?>
			<div id="last-com">
				<h4>écrit par <b><?= mb_strtoupper($pcom['author']) ?></b></h4>
				<p class="content-com text-justify"><?= nl2br($pcom['content_co']) ?></p>
				<p class="text-right"><i>Ajouté le <?= $pcom['add_date_fr'] ?></i><br>
					à propos du chapitre <?= $pcom['num_chap'] ?> | <?=$pcom['title_chap'] ?></p>
				<hr class="small-hr">
			</div>
		<?php
		endforeach;
		?>
	</div>
</div><!-- //ROW published co -->
