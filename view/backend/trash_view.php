<?php
$this->title = 'Corbeille';
?>
<div class="row">
	<div class="col-sm-12">
		<h2 class="text-center">CHAPITRES <b>SUPPRIMES</b></h2>
		<?php
		if (isset($confirm)){
		?>
			<div class="alert alert-primary alert-dismissible fade show" role="alert">
				<?php echo $confirm;?>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
		<?php
		}
		?>
	</div>
</div>
<div class ="row mx-3">
	<?php
	if (empty($chapters)){
		echo '<p class="text-center">Il n\'y a actuellement aucun chapitre supprimé</p>';
	} else {
	?>
		<table class="col-sm-12 table">
			<thead class="thead-primary">
				<tr>
					<th scope="col-1" class="text-center">Chapitre</th>
					<th scope="col-5">Titre</th>
					<th scope="col-3">Ecrit le</th>
					<th class="text-center" scope="col-1" colspan="2">Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach ($chapters as $tchap):
				?>
					<tr>
						<td class="text-center"><?= $tchap['num_chap'] ?></td>
						<td><?= $tchap['title_chap'] ?></td>
						<td><?= $tchap['create_date_fr'] ?></td>
						<form name="admin-delete" method="post" action="">
							<input type="hidden" name="chapterId" value="<?= $tchap['id'] ?>"/>
							<td class="text-center">
								<button class="btn btn-outline-primary  btn-fa no-border-btn" title="restaurer" type="submit" name="restoreChap"><i class="fas fa-file-upload"></i></button>
							</td>
							<td class="text-center">
								<button class="btn btn-outline-primary  btn-fa no-border-btn" title="supprimer" type="submit" name="delChap" onclick="return confirm('ATTENTION ! Cette action entrainera la suppression définitive du chapitre.');"><i class="fas fa-times"></i></button>
							</td>
						</form>
					</tr>
				<?php
				endforeach;
				?>
			</tbody>
		</table>
	<?php
	}
	?>
</div>
<div class="row">
	<div class="col-sm-12">
		<h2 class="text-center">COMMENTAIRES <b>SUPPRIMES</b></h2>
	</div>
</div>
<div class ="row mx-3">
	<?php
	if (empty($comments)){
		echo '<p class="text-center">Il n\'y a actuellement aucun commentaire supprimé.</p>';
	} else {
	?>
		<table class="col-md-12 table">
			<thead class="thead-primary">
				<tr>
					<th scope="col-1" class="text-center">Chapitre</th>
					<th scope="col-3">Auteur</th>
					<th scope="col-3">Ecrit le</th>
					<th scope="col-4">Contenu</th>
					<th class="text-center" scope="col-1" colspan="2">Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach ($comments as $tcom):
				?>
					<tr>
						<td class="text-center"><?= $tcom['num_chap'] ?></td>
						<td><?= $tcom['author'] ?></td>
						<td><?= $tcom['add_date_fr'] ?></td>
						<td><?= $tcom['content_co'] ?></td>
						<form name="admin-delete" method="post" action="">
							<input type="hidden" name="commentId" value="<?= $tcom['id_co'] ?>"/>
							<td class="text-center">
								<button class="btn btn-outline-primary  btn-fa no-border-btn" title="restaurer" type="submit" name="restoreCom"><i class="fas fa-file-upload"></i></button>
							</td>
							<td class="text-center">
								<button class="btn btn-outline-primary  btn-fa no-border-btn" title="supprimer" type="submit" name="delCom" onclick="return confirm('ATTENTION ! Cette action entrainera la suppression définitive du commentaire.');"><i class="fas fa-times"></i></button>
							</td>
						</form>
					</tr>
				<?php
				endforeach;
				?>
			</tbody>
		</table>
	<?php
	}
	?>
</div>
