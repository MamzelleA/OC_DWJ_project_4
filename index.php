<?php
session_start();
require ('Routeur.php');

	if (!empty($_GET['action'])){
		$action = $_GET['action'];
		$routeur = new Routeur($_GET['action']);
		$routeur->driveRequest();
	} else {
		$routeur = new Routeur('home');
		$routeur->driveRequest();
	}
