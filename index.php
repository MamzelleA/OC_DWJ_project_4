<?php
require ('Routeur.php');

	if (isset($_GET['action'])){
		$routeur = new Routeur($_GET['action']);
		$routeur->driveRequest();
	} else {
		$routeur = new Routeur('home');
		$routeur->driveRequest();
	}
