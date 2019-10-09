<?php
require_once('controller/Controller.php');

class Backend_controller extends Controller
{

	public function admin ($statCo, $lastCo) {
			$lastCh = $this->chapters->getLastSixCh();
			$reported = $this->comments->getComments(array($statCo, NULL, NULL));
			$lastCo = $this->comments->lastThreeCo(array($lastCo, NULL));
			$view = $this->view->genView(array('lastCh'=> $lastCh, 'reported'=> $reported, 'lastCo' => $lastCo));
			return $view;
	}

	public function chaptersList() {
		if(isset($_SESSION['login']) && isset($_SESSION['password'])) {
			$confirm = NULL;
			$chapters = $this->chaptersAndCount('published', 'draft');
			$listNums = $this->listNumsCh(array('published', 'draft'));
			$arrayDuplicate = array_count_values($listNums);
			if (isset($_POST['trash'])) {
				$this->chapters->updateStatusCh('trashed', $_POST['chapterId']);
				$confirm = 'Le chapitre et les commentaires associés ont bien été placés dans la corbeille.';
				$chapters = $this->chaptersAndCount('published', 'draft');
			} elseif (isset($_POST['valid'])) {
				$select = $_POST['select'];
				if ($select == 'published') {$chapters = $this->chaptersAndCount('published', NULL);}
				elseif ($select == 'draft') {$chapters = $this->chaptersAndCount('draft', NULL);}
				elseif ($select == 'all') {$chapters = $this->chaptersAndCount('published', 'draft');}
			}
			$view = $this->view->genView(array('chapters' => $chapters, 'arrayDuplicate' => $arrayDuplicate, 'confirm' => $confirm));
			return $view;
		} else {
			header('Location: index.php?action=adminConn');
			exit;
		}
	}

	private function chaptersAndCount(...$status) { //use in chaptersList()
		$chapters = $this->chapters->getChapters($status);
		for($i = 0; $i<count($chapters); $i++) {
			$chapId = $chapters[$i]['id'];
			$chapters[$i]['countCom'] = $this->comments->countCo($chapId);
		}
		return $chapters;
	}

	public function commentsList () {
			if(isset($_SESSION['login']) && isset($_SESSION['password'])) {
				$confirm = NULL;
				if (!empty($_POST)) {
					if (isset($_POST['commentId'])) {
						if (isset($_POST['moderate'])) {
							$this->comments->updateStatusCo('moderate', $_POST['commentId']);
							$confirm = 'Le commentaire a bien été modéré.';
							$comments = $this->comments->getComments(array('published', 'reported', 'moderate'));
						} elseif (isset($_POST['cancel'])) {
							$this->comments->updateStatusCo('published', $_POST['commentId']);
							$confirm = 'Le signalement du commentaire a bien été annulé.';
							$comments = $this->comments->getComments(array('published', 'reported', 'moderate'));
						} elseif (isset($_POST['trash'])) {
							$this->comments->updateStatusCo('trashed' , $_POST['commentId']);
							$confirm = 'Le commentaire a bien été supprimé.';
							$comments = $this->comments->getComments(array('published', 'reported', 'moderate'));
						}
						$comments = $this->comments->getComments(array('published', 'reported', 'moderate')); // return array published / reported / moderate comments
					} elseif (isset($_POST['valid'])) {
						$selection = $_POST['selection'];
						if ($selection == 'published') {$comments = $this->comments->getComments(array('published', NULL, NULL));}
						elseif ($selection == 'reported') {$comments = $this->comments->getComments(array('reported', NULL, NULL));}
						elseif ($selection == 'moderate') {$comments = $this->comments->getComments(array('moderate', NULL, NULL));}
						elseif ($selection == 'all') {$comments = $this->comments->getComments(array('published', 'reported', 'moderate'));}
					}
			} else {$comments = $this->comments->getComments(array('published', 'reported', 'moderate'));} // return array published / reported / moderate comments
			$view = $this->view->genView(array('comments' => $comments, 'confirm' => $confirm));
			return $view;
		} else {
			header('Location: index.php?action=adminConn');
			exit;
		}
	}

	public function trash ($statusCh, $statusCo){
		if(isset($_SESSION['login']) && isset($_SESSION['password'])) {
			$confirm = NULL;
			$chapters = $this->chapters->getChapters(array($statusCh, NULL));
			$comments = $this->comments->getComments(array($statusCo, NULL, NULL));
			$view = $this->view->genView(array('chapters' => $chapters, 'comments' => $comments, 'confirm' => $confirm));
			return $view;
		} else {
			header('Location: index.php?action=adminConn');
			exit;
		}
	}

	public function see ($chapId) {
		if(isset($_SESSION['login']) && isset($_SESSION['password'])) {
			$confirm = NULL;
			$idsList = $this->chapters->getListIdsCh(array('published', 'draft')); //return array with number of all published and draft chapters
var_dump($idsList);
			if(in_array($chapId, $idsList)) {
				$chapter = $this->chapters->getChapterById($chapId);
				$comments = $this->comments->getLinkCo($chapId);
				$count = $this->comments->countCo($chapId);
				if(isset($_POST['moderate'])) {
					$this->comments->updateStatusCo('moderate', $_POST['commentId']);
					$confirm = 'Le commentaire a bien été modéré.';
					$chapter = $this->chapters->getChapterById($chapId);
					$comments = $this->comments->getLinkCo($chapId);
				} elseif(isset($_POST['cancel'])) {
					$this->comments->updateStatusCo('published', $_POST['commentId']);
					$confirm = 'Le statut du commentaire a bien été modifié.';
					$chapter = $this->chapters->getChapterById($chapId);
					$comments = $this->comments->getLinkCo($chapId);
				} elseif(isset($_POST['trash'])) {
					$this->comments->updateStatusCo('trashed', $_POST['commentId']);
					$confirm = 'Le commentaire a bien été envoyé vers la corbeille.';
					$chapter = $this->chapters->getChapterById($chapId);
					$comments = $this->comments->getLinkCo($chapId);
				}
				$view = $this->view->genView(array('chapter'=>$chapter,'comments'=>$comments, 'count'=>$count, 'confirm' => $confirm));
				return $view;
			} else {throw new Exception('La page demandée n\'existe pas.');}
		} else {
			header('Location: index.php?action=adminConn');
			exit;
		}
	}

	public function modify ($chapId) {
		if(isset($_SESSION['login']) && isset($_SESSION['password'])) {
			$idsList = $this->listIdsCh(array('published', 'draft')); //return array with number of all published and draft chapters
		  if(in_array($chapId, $idsList)) {
				$lastNum = NULL;
			  $confirm = NULL;
			  $trouble = NULL;
				$chapter = $this->chapters->getChapterById($chapId);
				if(isset($_POST['num']) && $_POST['num'] != ''){$_SESSION['num'] = $_POST['num'];}
			  if(isset($_POST['title']) && $_POST['title'] != ''){$_SESSION['title'] = $_POST['title'];}
			  if(isset($_POST['content']) && $_POST['content'] != ''){$_SESSION['content'] = $_POST['content'];}
				if(isset($_POST['published'])) {
					if($chapter['status_chap'] == 'published') {
						if(!empty($_POST['title']) && !empty($_POST['content'])){
							$this->chapters->updatePublished($_POST['title'], $_POST['content'], $chapId);
							$confirm = 'Votre chapitre a bien été modifié.';
						} else {
				      $trouble = 'Tous les champs doivent être renseignés.';
				    }
					} elseif ($chapter['status_chap'] == 'draft') {
						if(!empty($_POST['num']) && !empty($_POST['title']) && !empty($_POST['content'])) {
								$lastNum = $this->chapters->lastNum('published');//return the number (str) of the last published chapter in a bi-dimension array
								$next = intval($lastNum[0]['num_chap']) + 1;
							if($_POST['num'] == $next) {
						 		$this->chapters->updatePublished ($_POST['title'], $_POST['content'], $chapId);
							 	$this->chapters->updateStatusCh('published', $chapId);
							 	$confirm = 'Votre chapitre a bien été modifié et publié';
							} else {
							 	$trouble = 'ATTENTION ! Les modifications n\'ont pas pu être prises en compte et publiées car : le numéro du chapitre n\'est pas cohérent, il devrait être égal à ' .$next.  '.';
							}
						} else {
					   $trouble = 'Tous les champs doivent être renseignés.';
					  }
					}
				} elseif(isset($_POST['draft'])) {
					$numChaps = $this->listNumsCh(array('published', 'draft')); //return bi-dimension array with all the chap numbers not trashed
					if(in_array($_POST['num'], $numChaps)) {
						$confirm = 'Le chapitre a bien été enregistré en brouillon.<br>ATTENTION ! Le numéro de chapitre <span class="font-bold">' .$_POST['numChap']. '</span> existe déjà.';
					} else {
						$confirm = 'Le chapitre a bien été enregistré en brouillon.';
					}
					$this->chapters->updateDraft ($_POST['num'], $_POST['title'], $_POST['content'], $chapId);
				} elseif (isset($_POST['trash'])) {
					$this->chapters->updateStatusCh('trashed', $chapId);
					$confirm = 'Le chapitre a bien été placé dans la corbeille.';
				}
				$view = $this->view->genView(array('chapter' => $chapter, 'lastNum' => $lastNum, 'confirm' => $confirm, 'trouble' => $trouble));
				unset ($_SESSION['num'], $_SESSION['title'], $_SESSION['content']);
				return $view;
			} else {throw new Exception('Le chapitre demandé n\'existe pas.');}
		} else {
			header('Location: index.php?action=adminConn');
			exit;
		}
	}

	private function listIdsCh ($status) { //use in modify()
		$list = $this->chapters->getListIdsCh($status); //return array with number of all chapters according to status
	  for($i = 0; $i<count($list); $i++) {
	    $idsList[] = $list[$i]['id'];
	  }
		return $idsList;
	}

}
