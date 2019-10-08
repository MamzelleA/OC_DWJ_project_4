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
		if (isset($table[$name]))
		{
			return $table[$name];
		} else
		{
			throw new Exception('Le paramètre "' .$name. '" n\'est pas défini.');

		}
	}

	public function driveRequest ()
	{
		try
		{
			$action = $this->getParameter($_GET, 'action');
			if (isset($action)) {
				//USER
				if($action == 'home') {$this->frontendCtrl->home(array('published', 'reported'), 'published');}
				elseif ($action == 'chapters') {$this->frontendCtrl->chapters();}
				elseif ($action == 'chapter'){
					$num = $this->getParameter($_GET, 'num');
					if(!empty($num) && is_numeric($num)) {
						$this->frontendCtrl->chapter($num, 'published'); // return the chapter asked page
					} else {throw new Exception('Le paramètre "' .$num. '" renseigné n\'est pas valide');}
				}
				elseif ($action == 'about'){$this->frontendCtrl->genericView('about');}
				elseif ($action == 'legal'){$this->frontendCtrl->genericView('legal');}
				elseif ($action == 'adminConn'){$this->frontendCtrl->adminConn();}
				//ADMIN
				elseif ($action == 'admin'){$this->backendCtrl->admin('published', 'reported');}
			} else	{throw new Exception('Aucune action n\'est définie.');}
		}
		catch (Exception $e) { //A REVOIR
			$errMessage = $e->getMessage();
			$errCode =$e->getCode();
			require ('view/frontend/err_view.php');
		}
	}
}
