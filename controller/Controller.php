<?php
require_once ('model/Chapters_manager.php');
require_once ('model/Comments_manager.php');
require_once ('view/View.php');

//parent class of FrontendController and BackendController
abstract class Controller
{
	protected $chapters;
	protected $comments;
	protected $view;

	public function __construct($type, $action, $side)
	{
		$this->chapters = new Chapters_manager();
		$this->comments = new Comments_manager();
		$this->view = new View ($type, $action, $side);
	}

	public function listNumsCh ($status) {
		$list = $this->chapters->getListNumsCh($status); //return array with number of all published chapters
	  for($i = 0; $i<count($list); $i++) {
	    $numsList[] = $list[$i]['num_chap'];
	  }
		return $numsList;
	}
}
