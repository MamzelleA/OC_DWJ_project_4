<?php
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

	public function driveRequest ()
	{
		try {
			if (!empty($_GET)) {
				if (isset($_GET['action'])) {
					$action = $_GET['action'];
					//USER
					if($action == 'home') {$this->frontendCtrl->home('published', 'published');}
					elseif ($action == 'chapters') {$this->frontendCtrl->chapters('published');}
					elseif ($action == 'chapter'){
						$num = $_GET['num'];
						if(!empty($num) && is_numeric($num)) {
							$this->frontendCtrl->chapter('published', $num);
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
					elseif ($action == 'modify') {
						$id = $_GET['id'];
						if(!empty($id) && is_numeric($id)){$this->backendCtrl->modify(array('published', 'draft'), $id);}
						else {throw new Exception('Le paramètre "' .$id.'" renseigné n\'est pas valide.');
						}
					}
					elseif ($action == 'write'){$this->backendCtrl->write();}
					elseif($action == 'disconnect'){$this->backendCtrl->disconnect();}
					else {throw new Exception('L\'action définie n\'existe pas.');}
				} else {throw new Exception('Le paramètre défini n\'est pas valide.');}
			} else	{$this->frontendCtrl->home('published', 'published');}
		}
		catch (Exception $e) {
			$errMessage = $e->getMessage();
			$errLine = $e->getLine();
			$errFile = $e->getFile();
			$view = new View('frontend', 'err', 'user');
			$err = $view->genView(array('errMessage' => $errMessage, 'errLine' => $errLine, 'errFile' => $errFile));
		}
	}
}
