<?php
session_start();
require_once ('controller/frontend/Frontend_controller.php');
require_once ('controller/backend/Backend_controller.php');
require_once ('view/View.php');

class Routeur {

	private $frontendCtrl;
	private $backendCtrl;

	public function __construct($action)
	{
		$this->frontendCtrl = new Frontend_controller('frontend', $action, 'user');
		$this->backendCtrl = new Backend_controller('backend', $action, 'admin');
	}

	private function getParameter ($table, $name)
	{
		if (isset($table[$name])) {return $table[$name];}
		else {throw new Exception('Le paramètre "' .$name. '" n\'est pas défini.');}
	}

	private function errorCatcher ($action, Exception $e) {
		$objectView = new View('frontend', $action, 'user');
		$errMessage = $e->getMessage();
		$errCode =$e->getCode();
		$errLine = $e->getLine();
		$errFile = $e->getFile();
		$view = $objectView->genView(array('errMessage' => $errMessage, 'errCode' => $errCode, 'errLine' => $errLine, 'errFile' => $errFile));
		return $view;
	}

	public function driveRequest ()
	{
		$action = $_GET['action'];
		try
		{
			if (isset($action)) {
				//USER
				if($action == 'home') {$this->frontendCtrl->home('published', 'published');}
				elseif ($action == 'chapters') {$this->frontendCtrl->chapters();}
				elseif ($action == 'chapter'){
					$num = $_GET['num'];
					if(!empty($num) && is_numeric($num)) {
						$this->frontendCtrl->chapter($num, 'published');
					} else {throw new Exception('Le paramètre "' .$num. '" renseigné n\'est pas valide');}
				}
				elseif ($action == 'about'){$this->frontendCtrl->genericView('about');}
				elseif ($action == 'legal'){$this->frontendCtrl->genericView('legal');}
				elseif ($action == 'adminConn'){$this->frontendCtrl->adminConn();}
				//ADMIN
				elseif ($action == 'admin'){$this->backendCtrl->admin('reported', 'published');}
				elseif ($action == 'chaptersList') {$this->backendCtrl->chaptersList();}
				elseif ($action == 'commentsList'){$this->backendCtrl->commentsList();}
				elseif ($action == 'trash'){$this->backendCtrl->trash('trashed', 'trashed');}
				elseif ($action == 'see'){
					$id = $_GET ['id'];
					if(!empty($id) && is_numeric($id)) {
						$this->backendCtrl->see(array('published', 'draft'), $id);
					} else {throw new Exception('Le paramètre "' .$id. '" renseigné n\'est pas valide');}
				}
				elseif ($action = 'modify'){
					$id = $_GET ['id'];
					if(!empty($id) && is_numeric($id)) {
						$this->backendCtrl->modify(array('published', 'draft'), $id);
					} else {throw new Exception('Le paramètre"' .$id. '"renseigné n\'est pas valide');}
				}
				elseif ($action == 'write'){$this->backendCtrl->write();}
				elseif($action == 'disconnect'){$this->backendCtrl->disconnect();}
				else {throw new Exception('L\'action définie n\'existe pas.');}
			} else	{throw new Exception('Aucune action n\'est définie.');}
		}
		catch (Exception $e) { //A REVOIR
			$action = 'err';
			$err = $this->errorCatcher($action, $e);
		}
	}
}
