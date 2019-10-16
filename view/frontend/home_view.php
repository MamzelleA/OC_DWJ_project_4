<?php
$this->title = 'Jean Forteroche';
$this->subtitle = 'Suivez ici la création de son nouveau roman';
?>

<!-- CONTAINER -->
<!-- ROW -->
<div class="row m-0">
	<div class="col-sm-12 px-0 m-0">
		<?php
		if (!empty($_COOKIE['readDate'])) {
			$readDate = date('d/m/Y', $_COOKIE['readDate']);
			$readNext = $_COOKIE['numLastChap']+1;
			$countChap = intVal($countCh[0]);
		?>
			<div class="alert alert-primary alert-dismissible fade show text-center mb-0 cookie-inform" role="alert">
				<?php
				if(isset($_COOKIE['author'])) {echo '<h2 class="mb-3">Bonjour <b>' .$_COOKIE['author']. '</b> !</h2>';}
				else {echo '<h2 class="mb-3">Bonjour <b>Bel(le) inconnu(e)</b> !</h2>';}
				if($readNext > $countChap) {
				?>
					<p>Voici le dernier chapitre que vous avez lu le <?= $readDate ?> : </p>
					<h4>CHAPITRE <?= '<b>' .$_COOKIE['numLastChap'].'</b> | '.$_COOKIE['titleLastChap'] ?></h4>
					<p>L'auteur n'a pas encore écrit le chapitre <?= $readNext ?>.</p>
				<?php
				} else {
				?>
					<a href="index.php?action=chapter&num=<?= $readNext ?>" title ="lire le chapitre suivant">
						<p class="mb-0">Voici le dernier chapitre que vous avez lu le <?php echo $readDate; ?> : </p>
						<h4>CHAPITRE <?= '<b>' .$_COOKIE['numLastChap'].'</b> | '.$_COOKIE['titleLastChap'] ?></h4>
					</a>
				<?php } ?>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true"><i class="far fa-times-circle"></i></span></button>
			</div>
		<?php
		}
		?>
	</div>
	<div class="col-sm-12 mt-0 px-0">
		<div id="carousel" class="carousel slide pb-0" data-ride="carousel">
			<ol class="carousel-indicators">
				<li data-target="#carousel" data-slide-to="0" class="active"></li>
				<li data-target="#carousel" data-slide-to="1"></li>
				<li data-target="#carousel" data-slide-to="2"></li>
			</ol>
			<div class="carousel-inner">
				<div class="carousel-item active">
					<img class="d-block w-100" src="public/images/body2.jpg" alt="...">
					<div class="carousel-caption d-block">
						<a href="index.php?action=chapter&num=<?= $lastCh[0]['num_chap'] ?>" title ="lire le chapitre">
							<h2>CHAPITRE <?= '<b>' .$lastCh[0]['num_chap'].'</b> | ' .$lastCh[0]['title_chap']; ?></h2>
							<p><?= 'écrit le '.$lastCh[0]['create_date_fr']; ?></p>
						</a>
					</div>
				</div>
				<div class="carousel-item">
					<img class="d-block w-100" src="public/images/body3.jpg" alt="...">
					<div class="carousel-caption d-block">
						<a href="index.php?action=chapter&num=<?= $lastCh[1]['num_chap'] ?>" title ="lire le chapitre">
							<h2>CHAPITRE <?= '<b>' .$lastCh[1]['num_chap'].'</b> | ' .$lastCh[1]['title_chap']; ?></h2>
							<p><?= 'écrit le '.$lastCh[1]['create_date_fr']; ?></p>
						</a>
					</div>
				</div>
				<div class="carousel-item">
					<img class="d-block w-100" src="public/images/body4.jpg" alt="...">
					<div class="carousel-caption d-block">
						<a href="index.php?action=chapter&num=<?= $lastCh[2]['num_chap'] ?>" title ="lire le chapitre">
							<h2>CHAPITRE <?= '<b>' .$lastCh[2]['num_chap'].'</b> | ' .$lastCh[2]['title_chap']; ?></h2>
							<p><?= 'écrit le '.$lastCh[2]['create_date_fr']; ?></p>
						</a>
					</div>
				</div>
			</div>
			<a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
		</div>
	</div>
</div>
<div class="row m-0">
	<div class="col-sm-12 px-0">
		<a class="btn btn-outline-primary btn-block" id="chapter-list" href="<?='index.php?action=chapters'?>" role="button">DECOUVRIR L'INTEGRALITE DES CHAPITRES</a>
	</div>
</div>

<div class="row m-3">
	<div class="col-sm-12 px-0">
		<h3 class="text-center home-h3">DERNIERS COMMENTAIRES</h3>
		<?php
		if(empty($lastCo)) {
			echo '<p class="text-center">Il n\'y a aucun commentaire publié actuellement. Soyez le premier !</p>';
		} else {
			foreach ($lastCo as $lcom):
				?>
				<blockquote class="blockquote px-3">
					<p class="mb-0 text-justify"><i class="fas fa-quote-left small-fa"></i> <?= $lcom['content_co'] ?> <i class="fas fa-quote-right small-fa"></i></p>
					<footer class="blockquote-footer text-left">par <?= $lcom['author'] ?><cite title="Source Title"> à propos du chapitre <?= $lcom['num_chap'] ?> | <?= $lcom['title_chap'] ?></cite></footer>
				</blockquote>
			<?php
			endforeach;
		}
		?>
	</div>
</div>
<div class="row m-0">
	<div class="col-md-12 px-0">
		<div class="card-group">
			<div class="card card-summary mb-0" id="author-card">
				<div class="card-title" id="author-link">
					<h3 class="text-center home-h3"><a class="card-link " data-toggle="collapse" role="button" href="#author-resume" aria-expanded="false" aria-controls="author-resume">L'AUTEUR</a></h3>
				</div>
				<div class="card-body collapse" id="author-resume">
					<p class="text-justify">Jean Forteroche est originaire du Berry. Après quelques années consacrées à l'enseignement universitaire, il a décidé de se consacrer entièrement à l'écriture et de découvrir le monde à travers de nombreux voyages. Féru de nouvelles technologies, il a décidé de publié au fur et à mesure de sa création son nouveau roman.</p>
					<a class="btn btn-outline-primary btn-sm btn-block btn-more" href="<?='index.php?action=about'?>" role="button">EN SAVOIR PLUS</a>
				</div>
				<div class="card-img">
					<img class="img-fluid" src="public/images/body7.jpg">
				</div>
			</div>
			<div class="card card-summary mb-0" id="novel-card">
				<div class="card-title" id="novel-link">
					<h3 class="text-center home-h3"><a class="card-link" data-toggle="collapse" role="button" href="#novel-resume" aria-expanded="false" aria-controls="novel-resume">LE ROMAN</a></h3>
				</div>
				<div class="card-body collapse" id="novel-resume">
					<p class="text-justify">Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Praesent augue tellus, commodo eu ex id, aliquam vulputate tortor. Proin rutrum imperdiet odio in mattis. Donec volutpat aliquam enim a scelerisque. Pellentesque semper auctor lorem, ac aliquam felis maximus vitae.</p>
					<a class="btn btn-outline-primary btn-sm btn-block btn-more" href="<?='index.php?action=about'?>" role="button">EN SAVOIR PLUS</a>
				</div>
				<div class="card-img">
					<img class="img-fluid" src="public/images/body8.jpg">
				</div>
			</div>
			<div class="card card-summary mb-0" id="chapters-card">
				<div class="card-title" id="chapter-link">
					<h3 class="text-center home-h3"><a class="card-link" data-toggle="collapse" role="button" href="#last-chapter" aria-expanded="false" aria-controls="last-chapter">SES ECRITS</a></h3>
				</div>
				<div class="card-body collapse" id="last-chapter">
					<div class="card-text">
						<p><i class="far fa-paper-plane small-fa"></i> Mission Sénégal</p>
						<p><i class="far fa-paper-plane small-fa"></i> Simplissime</p>
						<p><i class="far fa-paper-plane small-fa"></i> Par-delà les lignes</p>
						<a class="btn btn-outline-primary btn-sm btn-block btn-more" href="<?='index.php?action=about'?>" role="button">EN SAVOIR PLUS</a>
					</div>
				</div>
				<div class="card-img">
					<img class="img-fluid" src="public/images/body9.jpg">
				</div>
			</div>
		</div>
	</div>
</div>
</div><!-- //ROW -->
