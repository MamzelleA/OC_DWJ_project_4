<?php
ob_start();
?>
<header>
	<div class="container-fluid px-0">
		<nav class="navbar navbar-dark navbar-expand-lg d-flex align-items-center py-0 px-sm-1 px-0">
			<div class="navbar-header d-flex justify-content-start">
				<div class="navbar-text ml-3">
					<h1 class="py-0 my-0 ml-sm-0 ml-1 text-white nav-title">ESPACE ADMIN</h1>
					<h2 class="py-0 my-0 ml-sm-0 ml-1 text-white logo">Jean Forteroche</h2>
				</div>
			</div>
			<button class="navbar-toggler mx-1 mb-0" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<i class="fas fa-bars mr-1"></i>
			</button>
			<div class="collapse navbar-collapse justify-content-end pb-3" id="navbarSupportedContent">
				<div class="navbar-nav">
					<a <?php if($title == 'Administration') {echo('class="active text-primary nav-item nav-link text-center"');} ?> class="nav-item nav-link text-white text-center" href="<?='index.php?action=admin'?>">Accueil</a>
					<a <?php if($title == 'Rédiger') {echo('class="active text-primary nav-item nav-link text-center"');} ?> class="nav-item nav-link text-white text-center" href="<?='index.php?action=write'?>">Rédiger</a>
					<a <?php if($title == 'Chapitres') {echo('class="active text-primary nav-item nav-link text-center"');} ?> class="nav-item nav-link text-white text-center" href="<?='index.php?action=chaptersList'?>">Chapitres</a>
					<a <?php if($title == 'Commentaires') {echo('class="active text-primary nav-item nav-link text-center"');} ?> class="nav-item nav-link text-white text-center" href="<?='index.php?action=commentsList'?>">Commentaires</a>
					<a <?php if($title == 'Corbeille') {echo('class="active text-primary nav-item nav-link text-center"');} ?> class="nav-item nav-link text-white text-center" href="<?='index.php?action=trash'?>">Corbeille</a>
					<a <?php if($title == 'Déconnexion') {echo('class="active text-primary nav-item nav-link text-center"');} ?> class="nav-item nav-link text-white text-center" href="<?='index.php?action=disconnect'?>"><i class="fas fa-sign-out-alt" title="Déconnexion"></i></a>

				</div>
			</div>
		</nav>
	</div>
</header>
<!--SECTION -->
<section>
	<?= $content ?>
</section>
<?php
$template = ob_get_clean();
require('template.php');
