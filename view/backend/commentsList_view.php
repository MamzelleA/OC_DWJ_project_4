<?php
$this->title = 'Commentaires';
?>
<div class="row">
	<div class="col-md-12 my-3">
		<h2 class="mx-3 text-center" id="reported">LISTE DES <b>COMMENTAIRES
		<?php
			 if (isset($_POST['selection'])) {
				if ($_POST['selection'] == 'published') {echo 'PUBLIES';}
				elseif($_POST['selection'] == 'reported') {echo 'SIGNALES';}
				elseif($_POST['selection'] == 'moderate') {echo 'MODERES';}
			}
		?>
		</b></h2>
		<?php
			if (isset($confirm)){
		?>
			<div class="alert alert-primary alert-dismissible fade show" role="alert">
				<?php echo $confirm;?>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
		<?php } ?>
<div class="row">
	<div class="col-md-12 d-flex justify-content-end">
		<form action="" method="post" class="form-inline">
			<label for="selection" class="mr-3">Choisir le statut :</label>
			<select name="selection" id="selection">
				<option selected value="all">Tous</option>
				<option value="published">Publié</option>
				<option value="reported">Signalé</option>
				<option value="moderate">Modéré</option>
			</select>
			<button class="btn btn-outline-primary btn-sm btn-fa ml-3" title="valider" type="submit" name="valid">OK</button>
		</form>
	</div>
</div>
<?php
	if(empty($comments)) {
		if (isset ($_POST['selection'])) {
			$select = $_POST['selection'];
			if ($select == 'published') {$select = 'publié';}
			elseif ($select == 'reported') {$select = 'signalé';}
			elseif ($select == 'moderate') {$select = 'modéré';}
			if ($select == 'publié' || $select == 'signalé' || $select == 'modéré') {
				echo '<div class="row"><div class="col-sm-12"><p class="text-center">Il n\'y a actuellement aucun commentaire avec un statut '.$select. '.</p></div></div>';
			} elseif ($select == 'all') {echo '<div class="row"><div class="col-sm-12"><p class="text-center">Il n\'y a actuellement aucun commentaire.</p></div></div>';}
		} else {echo '<div class="row"><div class="col-sm-12"><p class="text-center">Il n\'y a actuellement aucun commentaire.</p></div></div>';}

	} else {
?>
		<table class="table table-responsive-lg table-hover">
			<thead class="thead-primary">
				<tr>
					<th class="text-center" scope="col">Chapitre</th>
					<th scope="col">Auteur</th>
					<th class="text-center"scope="col">Statut</th>
					<th scope="col">Contenu</th>
					<th class="text-center" scope="col">Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
					foreach ($comments as $com) {
				?>
				<tr>
					<td class="text-center"><?= $com['num_chap']?></td>
					<td><?= $com['author']?></td>
					<td class="text-center"><span class="status"><?= $com['status_co']?></span></td>
					<td class="text-justify"><?= $com['content_co']?></td>
					<td class="text-center">
						<form name="admin-modify-status" method="post" action="">
							<input type="hidden" name="commentId" value="<?= $com['id_co'] ?>"/>
							<?php
							if ($com['status_co'] == 'reported') {
							?>
								<button class="moderate-btn btn btn-outline-primary btn-sm btn-block fa fa-input no-border-btn py-3" type="submit" name="moderate" title="modérer"><i class="fas fa-comment-slash"></i></button>
								<button class="moderate-btn btn btn-outline-primary btn-sm btn-block fa fa-input no-border-btn py-3" type="submit" name="cancel" title="annuler"><i class="fas fa-comment"></i></button>
							<?php
							} elseif ($com['status_co'] == 'moderate') {
							?>
								<button class="moderate-btn btn btn-outline-primary btn-sm btn-block fa fa-input no-border-btn py-3" type="submit" name="cancel" title="annuler"><i class="fas fa-comment"></i></button>
								<button class="erase-btn btn btn-outline-primary btn-sm btn-block fa fa-input no-border-btn py-3" title="corbeille" type="submit" name="trash"><i class="fas fa-trash-alt"></i></button>
							<?php
							} elseif ($com['status_co'] == 'published') {
							?>
								<button class="moderate-btn btn btn-outline-primary btn-sm btn-block fa fa-input no-border-btn py-3" type="submit" name="moderate" title="modérer"><i class="fas fa-comment-slash"></i></button>

							<?php }	?>
						</form>
					</td>
				</tr>
				<?php
				}
				unset($list);
			}
				?>
			</tbody>
		</table>
	</div>
</div>
