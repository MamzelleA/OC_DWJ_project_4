<?php
$this->title = $chapter['title_chap'];
?>
<div class="row">
	<div class="col-md-12">
		<h2 class="text-left ml-md-5 mb-0 chapter-title-h2">Chapitre <span class="badge badge-pill badge-primary" id="bg-num-chap"><?= $chapter['num_chap'] ?></span> | <?= $chapter['title_chap'] ?></h2>
		<?php
		if (NULL !== $chapter['modify_date_fr']) {
			echo '<p class="small-p ml-md-5 mt-0">écrit le ' .$chapter['create_date_fr']. ', modifié le ' .$chapter['modify_date_fr']. '</p>';
		} else {
			echo '<p class="small-p ml-md-5 mt-0"><i>écrit le ' .$chapter['create_date_fr']. '</i></p>';
		}
		?>
	</div>
</div>
<div class="row">
	<div class="col-md-9 offset-md-1">
		<?php echo $chapter['content_chap']; ?>
	</div>
	<div class="col-md-9 offset-md-1 mr-3 mt-3 btn-chap">
		<button class="btn btn-outline-primary btn-sm mr-1" title="chapitres" role="button"><a href=<?="index.php?action=chaptersList"?>><i class="fas fa-list-ol"></i></a></</button>
		<button class="btn btn-outline-primary btn-sm mr-1" title="accueil" role="button"><a href=<?="index.php?action=admin"?>><i class="fas fa-home"></i></a></</button>
		<button class="btn btn-outline-primary btn-sm mr-1" title="modifier" role="button"><a href="<?='index.php?action=modify&id=' .$chapter['id']?>"><i class="far fa-edit"></i></a></button>
	</div>
</div>
	<div class="row">
		<div class="col-md-9 offset-md-1">
			<hr>
			<?php
			if ($chapter['status_chap'] == 'published') {
				?>
				<h3 id="comment-list">COMMENTAIRES <b>ASSOCIES</b></h3>
			</div>
			<div class="col-md-9 offset-md-1">
				<?php
				if (isset($confirm)){
				?>
					<div class="alert alert-primary alert-dismissible fade show" role="alert">
						<?php echo $confirm;?>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
				<?php
				}
				$countInt = intval($count[0]['COUNT(*)']);
				if ($countInt == 0) {
					echo "<p> Il n'y a encore aucun commentaire associé à ce chapitre.</p>";
				} else {
					echo "<p>Nombre de commentaires associés : <span class=\"badge badge-primary badge-pill\">" .$countInt. "</span></p>";
					foreach($comments as $com):
					?>
						</div>
						<div class="col-md-9 offset-md-1">
							<p>
								<b>auteur : <?= $com['author'] ?></b><br>
								date : <?= $com['add_date_fr'] ?>
								<?php
								if(isset($chapter['modify_date_fr'])) {
									$dateChap = explode('/', $chapter['modify_date_fr']);
									$dateChap = $dateChap[2].$dateChap[1].$dateChap[0];
									$dateCom = explode('/', $com['add_date_fr']);
									$dateCom = $dateCom[2].$dateCom[1].$dateCom[0];
									if($dateChap > $dateCom) {
										echo '<span class="font-italic"> (à propos d\'une ancienne version du chapitre.)</span><br>';
									}
								}
								?>
								statut :  <span class="status"><?= $com['status_co'] ?></span>
							</p>
							<p class="text-justify"><?= $com['content_co'] ?></p>
							<form action="#comment-list" method="post">
								<input type="hidden" name="commentId" value="<?= $com['id'] ?>"/>
								<?php
								if ($com['status_co'] != 'moderate') {
								?>
									<input class="btn btn-outline-primary btn-sm" type="submit" name="moderate" value="MODERER" />
								<?php
								} else {
								?>
									<input class="btn btn-outline-primary btn-sm" type="submit" name="cancel" value="ANNULER" />
									<input class="btn btn-outline-primary btn-sm" type="submit" name="trash" value="SUPPRIMER" />
								<?php } ?>
							</form>
							<hr class="small-hr">
						</div>
					<?php
					endforeach;
				}
			}
		?>
	</div>
</div><!-- //ROW -->
