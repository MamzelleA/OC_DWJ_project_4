<?php
require_once ('model/Chapters_manager.php');
require_once ('model/Comments_manager.php');
require_once ('model/Admin_manager.php');
require_once ('view/View.php');

//parent class of FrontendController and BackendController
abstract class Controller
{
	protected $chapters;
	protected $comments;
	protected $admin;
	protected $view;

	public function __construct($type, $action, $side)
	{
		$this->chapters = new Chapters_manager();
		$this->comments = new Comments_manager();
		$this->admin = new Admin_manager();
		$this->view = new View ($type, $action, $side);
	}
}
