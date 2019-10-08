<?php
if (isset($chapter['num_chap'])) {
	$this->title = 'Modification du chapitre ' .$chapter['num_chap'];
} else {
	$this->title = 'Modification du chapitre';
}
?>
<div class="row">
	<div class="col-12" id="confirm-message">
		<h2 class="text-center">MODIFIER UN <b>CHAPITRE</b></h2>
		<?php
		if (isset($confirm)){
			echo '<div class="alert alert-primary alert-dismissible fade show m-3" role="alert">' .$confirm. '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
		?>
		<div class="col-sm-10 offset-1">
			<button class="btn btn-outline-primary btn-sm mr-3" role="button"><a href=<?="index.php?action=chaptersList"?>>RETOUR A LA LISTE</a></</button>
			<button class="btn btn-outline-primary btn-sm" role="button"><a href=<?="index.php?action=admin"?>>RETOUR A L'ACCUEIL</a></</button>
		</div>
		<?php
		} else {
			if (isset($trouble)){
				echo '<div class="alert alert-primary alert-dismissible fade show m-3" role="alert">' .$trouble. '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
			}
		?>
		<form name="chapter_modify_form" action="" method="post">
			<div class="form-group row">
				<div class="col-sm-2">
					<label for="numChap">Numéro :</label>
					<?php if($chapter['status_chap'] == 'draft'){ ?><input class="form-control " type="text" name="num" value="<?php if(isset($_SESSION['num'])){ echo $_SESSION['num'];} else{echo $chapter['num_chap'];} ?>"/>
					<?php } else {echo '<p>' .$chapter['num_chap']. '</p>';} ?>
				</div>
				<div class="col-sm-10">
					<label for="titleChap">Titre :</label>
					<input class="form-control" type="text" name="title" value="<?php if(isset($_SESSION['title'])){ echo $_SESSION['title'];} else{echo $chapter['title_chap'];} ?>"/>
				</div>
			</div>
			<div class="form-group col-sm-12">
				<textarea class="form-control fr-view" id="editor" name="content" ><?php if(isset($_SESSION['content'])){ echo $_SESSION['content'];} else{echo $chapter['content_chap'];} ?></textarea>
			</div>
			<div class="col-sm-12">
				<input class="btn btn-outline-primary btn-sm m-1" name="published" type="submit" value="PUBLIER" <?php if($chapter['status_chap'] == 'draft'){?> onclick="return confirm('ATTENTION ! Une fois le chapitre publié vous ne pourrez plus le supprimer.');" <?php } ?> />
				<?php
				if($chapter['status_chap'] == 'draft') {
					echo '<input class="btn btn-outline-primary btn-sm m-1" name="draft" type="submit" value="BROUILLON"/>';
					echo '<input class="btn btn-outline-primary btn-sm m-1" name="trash" type="submit" value="SUPPRIMER"/>';
				}
				?>
				<button class="btn btn-outline-primary btn-sm m-3 btn-back"><a href="<?= 'index.php?action=chaptersList' ?>" onclick="return confirm('ATTENTION ! Si vous continuez, vous perdrez toutes vos modifications.');">RETOUR A LA LISTE</a></</button>
				<button class="btn btn-outline-primary btn-sm m-1 btn-back"><a href= "<?= 'index.php?action=admin' ?>" onclick="return confirm('ATTENTION ! Si vous continuez, vous perdrez toutes vos modifications.');">RETOUR A L'ACCUEIL</a></</button>
			</div>
			</div>
		</form>
		<?php
		}
		?>
	</div>
</div>
