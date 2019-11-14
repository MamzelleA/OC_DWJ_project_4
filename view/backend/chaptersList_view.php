<?php
$this->title = 'Chapitres';
?>
<div class="row">
	<div class="col-md-12">
		<h2 class="text-center">LISTE DES <b>CHAPITRES
			<?php
			if (isset($_POST['select'])) {
				if ($_POST['select'] == 'published') {echo 'PUBLIES';}
				elseif($_POST['select'] == 'draft') {echo 'EN BROUILLON';}
			}
			?>
			</b>
		</h2>
		<?php
		if (isset($confirm)){
		?>
			<div class="alert alert-primary alert-dismissible fade show" role="alert">
				<?php echo $confirm;?>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
		<?php } ?>
	</div>
</div>
<div class="row">
	<div class="col-md-12 d-flex justify-content-end">
		<form action="" method="post" class="form-inline">
			<label for="selection" class="mr-3">Choisir le statut :</label>
			<select name="select" id="selection">
				<option selected value="all">Tous</option>
				<option value="published">Publié</option>
				<option value="draft">Brouillon</option>
			</select>
			<button class="btn btn-outline-primary btn-sm btn-fa ml-3" title="valider" type="submit" name="valid">OK</button>
		</form>
	</div>
</div>
<?php
if(empty($chapters)) {
	if (isset($_POST['select'])) {
		$select = $_POST['select'];
		if ($select == 'published') {$select = 'publié';}
		elseif ($select == 'draft') {$select = 'brouillon';}
		if ($select == 'publié' || $select == 'brouillon') {echo '<div class="row"><div class="col-sm-12"><p class="text-center">Il n\'y a actuellement aucun chapitre avec un statut '.$select. '.</p></div></div>';}
		elseif ($select == 'all') {echo '<div class="row"><div class="col-sm-12"><p class="text-center">Il n\'y a actuellement aucun chapitre.';}
}	else {echo '<div class="row"><div class="col-sm-12"><p class="text-center">Il n\'y a actuellement aucun chapitre.';}
} else {
?>
<div class="row">
	<div class="col-md-12">
		<table class="table table-responsive-lg table-hover">
			<thead class="thead-primary">
				<tr>
					<th scope="col">#</th>
					<th scope="col">titre</th>
					<th scope="col">créé le</th>
					<th scope="col">modifié le</th>
					<th scope="col">statut</th>
					<th scope="col" class="text-center">commentaires</th>
					<th class="text-center" scope="col" colspan="3">actions</th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach ($chapters as $chap):
				?>
					<tr>
						<th scope="row" <?php if($arrayDuplicate[$chap['num_chap']] > 1){ ?> class="text-danger" <?php ;} ?>><?= $chap['num_chap']?></th>
						<td><?= $chap['title_chap']?></td>
						<td><?= $chap['create_date_fr']?></td>
						<td><?= $chap['modify_date_fr']?></td>
						<td><span class="status"><?= $chap['status_chap']?></span></td>
						<td class="text-center">
						<?php
							$countResult = intval($chap['countCom'][0]['COUNT(*)']);
							if ($countResult == 0) {echo '<i class="fas fa-ban"></i>';}
							else {echo '<span class="badge badge-dark badge-pill">' .$countResult.'</span>';}
						?>
						</td>
						<td>
							<a href="<?='index.php?action=see&id=' . $chap['id']?>" class="btn btn-outline-primary btn-sm btn-block btn-fa no-border-btn py-3" role="button" title="lire"><i class="fas fa-book-reader"></i></a>
						</td>
						<td>
							<a href="<?='index.php?action=modify&id=' .$chap['id']?>" class="btn btn-outline-primary btn-sm btn-block btn-fa no-border-btn py-3" title="modifier" role="button"><i class="far fa-edit"></i></a>
						</td>
						<td>
							<?php
							if($chap['status_chap'] == 'draft') {
							?>
								<form name="admin-modify-status" method="post" action="">
									<input type="hidden" name="chapterId" value="<?= $chap['id'] ?>"/>
									<button class="btn btn-outline-primary btn-sm btn-block btn-fa no-border-btn py-3" title="corbeille" type="submit" name="trash"><i class="fas fa-trash-alt"></i></button>
								</form>
							<?php
							}
							?>
						</td>
					</tr>
				<?php
				endforeach;
				?>
			</tbody>
		</table>
	</div>
</div>
<?php } ?>
