<?php
require_once('controller/Controller.php');

class Backend_controller extends Controller
{

	public function admin ($statCo, $lastCo) //use in action admin
	{
			$lastCh = $this->chapters->getLastSixCh();
			$reported = $this->comments->getComments(array($statCo, NULL, NULL));
			$lastCo = $this->comments->lastThreeCo(array($lastCo, NULL));
			$view = $this->view->genView(array('lastCh'=> $lastCh, 'reported'=> $reported, 'lastCo' => $lastCo));
			return $view;
	}
}
