<?php
$expire = time()+90*24*3600;
setcookie('numLastChap', $_GET['num'], $expire, null, null, false, true);
setcookie('titleLastChap', $chapter['title_chap'], $expire, null, null, false, true);
setcookie('readDate', time(), $expire, null, null, false, true);
if (isset($_POST['author']) && $_POST['author'] != ''){setcookie('author',$_POST['author'], time()+30*24*3600, null, null, false, true);}
$this->title = $chapter['title_chap'];
?>
<div class="row">
	<div class="col-md-12">
		<h2 class="text-left ml-5 mb-0">Chapitre <span class="badge badge-pill badge-primary" id="bg-num-chap"><?= $chapter['num_chap'] ?></span> | <?= $chapter['title_chap'] ?></h2>
		<?php
		if (NULL !== $chapter['modify_date_fr']) {
			echo '<p class="small-p ml-5 mt-0">écrit le ' .$chapter['create_date_fr']. ', modifié le ' .$chapter['modify_date_fr']. '</p>';
		} else {
			echo '<p class="small-p ml-5 mt-0"><i>écrit le ' .$chapter['create_date_fr']. '</i></p>';
		}
		?>
	</div>
</div>
<div class="row">
		<div class="col-md-9 offset-md-1">
			<?php echo $chapter['content_chap']; ?>
		</div>
		<div class="col-md-9 offset-md-1 btn-chap">
			<?php
			$countChapInt = intval($countChap[0]);
			$prevChap = $chapter['num_chap'] - 1;
			$nextChap = $chapter['num_chap'] + 1;
			if ($chapter['num_chap'] > 1) {
				?>
				<button class="btn btn-outline-primary btn-sm mr-1" role="button"><a href=<?="index.php?action=chapter&num=$prevChap"?>><i class="fas fa-backward"></i></a></</button>
			<?php } ?>
			<button class="btn btn-outline-primary btn-sm mr-1" role="button"><a href=<?="index.php?action=chapters"?>><i class="fas fa-list-ol"></i></a></</button>
			<button class="btn btn-outline-primary btn-sm mr-1" role="button"><a href=<?="index.php?action=home"?>><i class="fas fa-home"></i></a></</button>
			<?php
			if ($chapter['num_chap'] < $countChapInt) {
				?>
				<button class="btn btn-outline-primary btn-sm mr-1" role="button"><a href=<?="index.php?action=chapter&num=$nextChap"?>><i class="fas fa-forward"></i></a></</button>
			<?php } ?>
		</div>
</div>
<div class="row">
	<div class="col-md-9 offset-md-1" id="comment-place">
		<hr>
		<h3>REDIGER UN <b>COMMENTAIRE</b></h3>
		<p class="text-justify">Vous êtes libres de laisser vos commentaires dans cet espace. Toutefois, ceux-ci doivent respecter la "Charte des commentaires" consultable <a class="visible-link" href="<?='index.php?action=legal#charte'?>">ici</a>.</p>
		<p class="comment_note">Tous les champs sont requis</p>
		<?php
		if (isset($pConfirm)){
			?>
			<div class="alert alert-primary alert-dismissible fade show" role="alert">
				<?php echo $pConfirm;?>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
		<?php } ?>
		<form name="comment_form" action="#comment-place" method="post">
			<div class="form-group">
				<label for="email">Email : <span data-toggle="collapse" role="button" href="#dropdownP" aria-expanded="false" aria-controls="author-resume" title="Pourquoi je dois laisser un email ?"><i class="far fa-question-circle"></i></span></label></i>
				<p class="p-little collapse" id="dropdownP">Dans un souci de responsabilisation, nous vous demandons d'indiquer un email valide pour laisser un commentaire. ATTENTION ! Un email ne peut être associé qu'à un seul auteur. Pour plus d'informations sur l'utilisation de vos données personnelles, reportez-vous aux Mentions légales <a href="index.php?action=legal#cookie">ici</a></p>
				<input class="form-control text-field" type="email" id="email" name="email" value="<?php if(isset($_SESSION['email'])){echo $_SESSION['email'];} ?>"/>
			</div>
			<div class="form-group">
				<label for="author">Auteur :</label>
				<input class="form-control text-field" type="text" id="author" name="author" value="<?php if(isset($_SESSION['author'])){ echo $_SESSION['author'];} elseif(isset($_COOKIE['author'])){ echo $_COOKIE['author'];} ?>"/>
			</div>
			<div class="form-group">
				<label for="message">Votre message :</label>
				<textarea class="form-control" rows="5" id="content_co" name="message"><?php if(isset($_SESSION['message'])){echo $_SESSION['message'];} ?></textarea>
			</div>
			<div class="col-sm-2 offset-sm-10 col-xs-12">
				<input class="btn btn-outline-primary btn-sm" name="published" type="submit" value="ENVOYER" />
			</div>
			<input type="hidden" name="chapterId" value="<?= $chapter['id'] ?>"/>
		</form>
		<hr>
		<h3 id="comment-list">IMPRESSIONS & <b>COMMENTAIRES </b></h3>
		<?php
		if (isset($rConfirm)){
			?>
			<div class="alert alert-primary alert-dismissible fade show" role="alert">
				<?php echo $rConfirm;?>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<?php
		}
		$countComInt = intval($countCom[0]['COUNT(*)']);
		if ($countComInt == 0) {
			echo "<p> Il n'y a encore aucun commentaire publié, soyez le premier !</p>";
		} else {
			echo "<p>Commentaires publiés : <span class=\"badge badge-primary badge-pill\">" .$countComInt. "</span></p>";
		}
		foreach($comment as $com):
			?>
			<p>le <?= $com['add_date_fr'] ?> | <b><?= $com['author'] ?></b> a écrit :<br>
			<?php
			if(isset($chapter['modify_date_fr'])) {
				$dateChap = explode('/', $chapter['modify_date_fr']);
				$dateChap = $dateChap[2].$dateChap[1].$dateChap[0];
				$dateCom = explode('/', $com['add_date_fr']);
				$dateCom = $dateCom[2].$dateCom[1].$dateCom[0];
				if($dateChap > $dateCom) {
					echo '<span class="font-italic">à propos d\'une ancienne version du chapitre.</span></p>';
				}
			}
			if ($com['status_co'] == 'reported') {
				echo '<p class="font-italic text-justify">Ce commentaire a été signalé et est en attente de modération ou non par l\'administrateur. Pour plus d\'information, veuillez vous référer <a class="visible-link" href="index.php?action=legal#charte">ici</a>.</p>
				<p class="text-justify">' .$com['content_co'].'</p>';
			} elseif ($com['status_co'] == 'moderate') {
				echo '<p class="font-italic text-justify">Ce commentaire a été modéré par l\'administrateur. Pour plus d\'information, veuillez vous référer <a class="visible-link" href="index.php?action=legal#charte">ici</a>.</p>';
			} elseif ($com['status_co'] == 'published') {
				echo '<p class="text-justify">' .$com['content_co'].'</p>';
			}
			if ($com['status_co'] == 'published')
			{
			?>
			<div class="col-sm-2 offset-sm-10">
				<form action="#comment_list" method="post">
					<input type="hidden" name="commentId" value="<?= $com['id'] ?>"/>
					<input class="btn btn-outline-primary btn-sm" type="submit" name="reported" value="SIGNALER" />
				</form>
			</div>
			<?php
			}
			echo '<hr class="small-hr">';
		endforeach;
		?>
	</div>
</div><!-- //ROW -->
<?php
session_destroy();
?>
