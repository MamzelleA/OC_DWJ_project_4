<?php
$this->title = 'Rédiger';
?>
	<div class="row">
		<div class="col">
			<h2 class="text-center">REDIGER UN <b>CHAPITRE</b></h2>
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
			<form name="chapter_writer_form" action="" method="post">
					<div class="form-group row">
						<div class="col-sm-2">
							<label for="numChap">Numéro :</label>
							<input class="form-control " type="number" id="num-chap" name="num" value="<?php if(isset($_SESSION['num'])){echo $_SESSION['num'];} ?>"/>
						</div>
						<div class="col-sm-10">
							<label for="titleChap">Titre :</label>
							<input class="form-control" type="text" id="title" name="title" value="<?php if(isset($_SESSION['title'])){echo $_SESSION['title'];} ?>"/>
						</div>
					</div>
					<div class="form-group col-sm-12">
						<textarea class="form-control" id="editor" name="content"><?php if(isset($_SESSION['content'])){echo $_SESSION['content'];} ?></textarea>
					</div>
					<div class="col-sm-12">
						<input class="btn btn-outline-primary btn-sm mr-3" name="published" type="submit" onclick="return confirm('ATTENTION ! Une fois le chapitre publié vous ne pourrez plus le supprimer.');" value="PUBLIER" />
						<input class="btn btn-outline-primary btn-sm mr-3" name="draft" type="submit" value="BROUILLON"/>
						<button class="btn btn-outline-primary btn-sm mt-1 mr-1 ml-0 m-md-3 btn-back"><a href="<?= 'index.php?action=chaptersList' ?>" onclick="return confirm('ATTENTION ! Si vous continuez, vous perdrez toutes vos modifications.');">RETOUR A LA LISTE</a></</button>
				    <button class="btn btn-outline-primary btn-sm mt-1 mr-1 ml-0 m-md-3 btn-back"><a href= "<?= 'index.php?action=admin' ?>" onclick="return confirm('ATTENTION ! Si vous continuez, vous perdrez toutes vos modifications.');">RETOUR A L'ACCUEIL</a></</button>
					</div>
			</form>
		<?php
		}
		unset ($_SESSION['num'], $_SESSION['title'], $_SESSION['content']);
		?>
		</div>
	</div>
</div>
