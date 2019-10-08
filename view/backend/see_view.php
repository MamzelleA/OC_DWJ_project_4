<?php
if (empty($chapter)) {
	$this->title = 'Oups...';
?>
	<div class="row mx-3">
		<div class="col-md-12">
			<h2 class="text-center"><i class="far fa-surprise"></i> Oups, le chapitre demandé n'existe pas !</h2>
			<p class="text-center">Et si vous en écriviez un maintenant : <a class="btn btn-outline-primary btn-sm btn-fa no-border-btn py-1" href="index.php?action=write"><i class="fas fa-feather-alt btn-fa"></i></a></p>
		</div>
	</div>
<?php
}
else {
	$this->title = $chapter['title_chap'];
	$numChap = $chapter['num_chap'];
?>
<div class="row mx-3">
	<div class="col-md-12">
		<h2 class="text-left">Chapitre <span class="badge badge-pill badge-primary" id="bg-num-chap"><?= $chapter['num_chap'] ?></span> | <?= $chapter['title_chap'] ?></h2>
		<?php
		if (NULL !== $chapter['modify_date_fr']) {
			echo '<p><i>modifié le ' .$chapter['modify_date_fr']. ' | écrit le ' .$chapter['create_date_fr']. '</i></p>';
		} else {
			echo '<p><i>écrit le ' .$chapter['create_date_fr']. '</i></p>';
		}
		?>
	</div>
</div>
<?php } ?>
<div class="row">
		<div class="col-md-10 offset-md-2 mr-3 content_chap">
				<p class="content-chap fr-view"><span id="lettrine"><?= substr($chapter['content_chap'], 0, 1) ?></span><?=substr($chapter['content_chap'], 1) ?></p>
		</div>
		<div class="col-md-10 offset-md-2 mr-3 mt-3 btn-chap">
			<button class="btn btn-outline-primary btn-sm mr-1" title="chapitres" role="button"><a href=<?="index.php?action=chaptersList"?>><i class="fas fa-list-ol"></i></a></</button>
			<button class="btn btn-outline-primary btn-sm mr-1" title="accueil" role="button"><a href=<?="index.php?action=admin"?>><i class="fas fa-home"></i></a></</button>
			<button class="btn btn-outline-primary btn-sm mr-1" title="modifier" role="button"><a href="<?='index.php?action=modify&id=' .$chapter['id']?>"><i class="far fa-edit"></i></a></button>
		</div>
	</div>
	<div class="row">
		<div class="col-md-10 offset-md-2">
			<hr>
			<?php
			if ($chapter['status_chap'] == 'published') {
				?>
				<h3 id="comment-list">COMMENTAIRES <b>ASSOCIES</b></h3>
			</div>
			<div class="col-md-10 offset-md-2">
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
					foreach($comments as $com) {
					?>
						</div>
						<div class="col-md-10 offset-md-2">
							<p>
								<b>auteur : <?= $com['author'] ?></b><br>
								date : <?= $com['add_date_fr'] ?><br>
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
								<?php }
								?>
							</form>
							<hr class="small-hr">
						</div>

						<?php
					}
					unset($comment);
				}
			}
		?>
	</div>
</div><!-- //ROW -->
