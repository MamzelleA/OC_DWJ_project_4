<?php
require_once('controller/Controller.php');

class Frontend_controller extends Controller
{
	public function home ($statusCo, $statusCh) {
		$lastCh = $this->chapters->getLastThreeCh();
		$lastCo = $this->comments->lastThreeCo($statusCo);
		$countCh = $this->chapters->countStatusCh($statusCh);
		$view = $this->view->genView(array('lastCh'=>$lastCh, 'lastCo' =>$lastCo, 'countCh' => $countCh));
		return $view;
	}
}
