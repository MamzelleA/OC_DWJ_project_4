<?php
namespace OC_project_4\controller;
require_once ('model/Chapters_manager.php');
require_once ('model/Comments_manager.php');
require_once ('model/Admin_manager.php');
require_once ('view/View.php');

//parent class of FrontendController and BackendController
abstract class Controller
{
	protected $chapters;
	protected $comments;
	protected $config;
	protected $view;

	public function __construct($type, $action, $side)
	{
		$this->chapters = new \OC_project_4\model\Chapters_manager();
		$this->comments = new \OC_project_4\model\Comments_manager();
		$this->view = new \OC_project_4\view\View ($type, $action, $side);
	}

	abstract public function home(...$status);

}
