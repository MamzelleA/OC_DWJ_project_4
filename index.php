<?php
namespace OC_project_4;
require ('Routeur.php');
try {
	if (isset($_GET['action'])){
		$action = $_GET['action'];
	} else {throw new Exception('Aucune action n\'est défini');}
}
catch (Exception $e) {
	$errMessage = $e->getMessage();
	$errCode =$e->getCode();
  require ('view/frontend/err_view.php');
}
$routeur = new \OC_project_4\Routeur($action);
$routeur->driveRequest();
