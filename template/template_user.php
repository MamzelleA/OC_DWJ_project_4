<?php
ob_start();
?>
<!-- HEADER -->
<header>
	<div class="container-fluid px-0">
		<nav class="navbar navbar-dark navbar-expand-lg d-flex align-items-center py-0 px-sm-1 px-0">
			<div class="navbar-header d-flex justify-content-start px-0 col-9 col-md-auto">
				<div class="navbar-brand mx-1">
					<a href="<?='index.php?action=home'?>">
		    		<img class="img-fluid" id="logo-avion" src="public/images/logo_brand.png" alt="logo avion papier">
		  		</a>
	  		</div>
				<div class="navbar-text mx-1">
					<h1 class="py-0 my-0 ml-sm-0 ml-1 text-white nav-title">BILLET SIMPLE POUR L'ALASKA</h1>
					<h2 class="py-0 my-0 ml-sm-0 ml-1 text-white logo">Jean Forteroche</h2>
				</div>
			</div>
			<button class="navbar-toggler mx-1 mb-0 col-2" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<i class="fas fa-bars mr-1"></i>
			</button>
			<div class="collapse navbar-collapse col-auto justify-content-md-end" id="navbarSupportedContent">
					<div class="navbar-nav">
						<a <?php if($title == 'Jean Forteroche') {echo('class="active text-primary nav-item nav-link text-center"');} ?> class="nav-item nav-link text-white text-center" href="<?='index.php?action=home'?>">Accueil</a>
						<a <?php if($title == 'L\'auteur') {echo('class="active text-primary nav-item nav-link text-center"');} ?> class="nav-item nav-link text-white text-center" href="<?='index.php?action=about'?>">L'auteur</a>
						<a <?php if($title == 'Les chapitres') {echo('class="active text-primary nav-item nav-link text-center"');} ?> class="nav-item nav-link text-white text-center" href="index.php?action=chapters">Les chapitres</a>
					</div>
			</div>
		</nav>
	</div>
</header>
<section>
	<div class="container-fluid px-0">
		<?= $content ?>
	</div>
</section>
<!--FOOTER-->
<footer class="page-footer container-fluid text-white px-1">
	<div class="row px-1">
		<div class="col-md-3 px-1">
			<div class="card-body px-1">
				<h2 class="card-title title-footer">LES RUBRIQUES</h2>
				<ul class="card-text">
					<li class="link-footer"><a href="<?='index.php'?>">Accueil</a></li>
					<li class="link-footer"><a href="<?='index.php?action=about'?>">L'auteur</a></li>
					<li class="link-footer"><a href="<?='index.php?action=chapters'?>">Les chapitres</a></li>
					<li class="link-footer"><a href="<?='index.php?action=legal'?>">Mentions Légales</a></li>
				</ul>
			</div>
		</div>
		<div class="col-md-4 px-1">
			<div class="card-body px-1">
				<h2 class="card-title title-footer">RESEAUX SOCIAUX</h2>
				<ul class="list-inline">
					<li class="list-inline-item"><a href="https://twitter.com" title="twitter"><i class="fab fa-twitter-square social"></i></a></li>
					<li class="list-inline-item"><a href="https://flickr.com" title="flickr"><i class="fab fa-flickr social"></i></a></li>
					<li class="list-inline-item"><a href="https://instagram.com/" title="instagram"><i class="fab fa-instagram social"></i></a></li>
					<li class="list-inline-item"><a href="https://www.facebook.com" title="facebook"><i class="fab fa-facebook-square social"></i></a></li>
				</ul>
			</div>
		</div>
		<div class="col-md-5 px-1">
			<div class="card-body px-1">
				<h2 class="card-title title-footer">PROPOS DU SITE</h2>
				<p class="card-text text-justify">L'auteur Jean Forteroche vous propose de découvrir son nouveau roman "Billet simple pour l'Alaska" au fur et à mesure de sa création.<br>
				A travers les tribulations d'un trublion peu ordinaire, il vous présente l'Alaska, ses paysages et ses coutumes. Une invitation à un voyage magique. Un aller simple pour vous mesurer à une région de la démesure.</p>
			</div>
		</div>
	</div>
	<div class="col-12 p-1">
		<h4 class="small-h4 text-center">Site créé par Agnès Masetty dans le cadre de la formation Développeur Web Junior d'OpenClassrooms | octobre 2019</h4>

	</div>
</footer>
<script src="public/js/cookiechoices.js"></script>
<script>document.addEventListener('DOMContentLoaded', function(event){cookieChoices.showCookieConsentBar('Ce site utilise des cookies pour vous offrir une meilleure expérience. En poursuivant votre navigation, vous acceptez l’utilisation des cookies.', 'J’ai compris', 'En savoir plus', 'http://localhost/OC_DWJ_project_4/index.php?action=legal#cookie');});</script>
<?php
$template = ob_get_clean();
require('template.php');
?>
