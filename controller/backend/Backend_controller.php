<?php
require_once('controller/Controller.php');

class Backend_controller extends Controller
{
//ACTION METHODS
	public function admin ($statCo, $lastCo) {
		if(isset($_SESSION['login']) && isset($_SESSION['password'])) {
			$lastCh = $this->chapters->getLastSixCh();
			$reported = $this->comments->getCommentsByStatus($statCo);
			$lastCo = $this->comments->lastThreePublishedCo($lastCo);
			$view = $this->view->genView(array('lastCh'=> $lastCh, 'reported'=> $reported, 'lastCo' => $lastCo));
			return $view;
		} else {
			header('Location: index.php?action=adminConn');
			exit;
		}
	}

	public function chaptersList() {
		if(isset($_SESSION['login']) && isset($_SESSION['password'])) {
			$confirm = NULL;
			$chapters = $this->chaptersNoTrashAndCount();
			$listNums = $this->listNumsNoTrashCh(); //to control if num already exists in db
			$arrayDuplicate = array_count_values($listNums);
			if (isset($_POST['trash'])) {
				$this->chapters->updateStatusCh('trashed', $_POST['chapterId']);
				$confirm = 'Le chapitre a bien été placé dans la corbeille.';
				$chapters = $this->chaptersNoTrashAndCount();
			} elseif (isset($_POST['valid'])) {
				$select = $_POST['select'];
				if ($select == 'published') {$chapters = $this->chaptersByStatusAndCount('published');}
				elseif ($select == 'draft') {$chapters = $this->chaptersByStatusAndCount('draft');}
				elseif ($select == 'all') {$chapters = $this->chaptersNoTrashAndCount();}
			}
			$view = $this->view->genView(array('chapters' => $chapters, 'arrayDuplicate' => $arrayDuplicate, 'confirm' => $confirm));
			return $view;
		} else {
			header('Location: index.php?action=adminConn');
			exit;
		}
	}

	public function commentsList () {
			if(isset($_SESSION['login']) && isset($_SESSION['password'])) {
				$confirm = NULL;
				if (!empty($_POST)) {
					if (isset($_POST['commentId'])) {
						if (isset($_POST['moderate'])) {
							$this->comments->updateStatusCo('moderate', $_POST['commentId']);
							$confirm = 'Le commentaire a bien été modéré.';
							$comments = $this->comments->getCommentsNoTrash();
						} elseif (isset($_POST['cancel'])) {
							$this->comments->updateStatusCo('published', $_POST['commentId']);
							$confirm = 'Le signalement du commentaire a bien été annulé.';
							$comments = $this->comments->getCommentsNoTrash();
						} elseif (isset($_POST['trash'])) {
							$this->comments->updateStatusCo('trashed' , $_POST['commentId']);
							$confirm = 'Le commentaire a bien été supprimé.';
							$comments = $this->comments->getCommentsNoTrash();
						}
					} elseif (isset($_POST['valid'])) {
						$selection = $_POST['selection'];
						if ($selection == 'published') {$comments = $this->comments->getCommentsByStatus('published');}
						elseif ($selection == 'reported') {$comments = $this->comments->getCommentsByStatus('reported');}
						elseif ($selection == 'moderate') {$comments = $this->comments->getCommentsByStatus('moderate');}
						elseif ($selection == 'all') {$comments = $this->comments->getCommentsNoTrash();}
					}
			} else {$comments = $this->comments->getCommentsNoTrash();}
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
			$chapters = $this->chapters->getChaptersByStatus('trashed');
			$comments = $this->comments->getCommentsByStatus($statusCo);
			if(isset($_POST['delChap'])) {
				$this->chapters->deleteCh($_POST['chapterId']);
				$confirm = 'Le chapitre a été définitivement supprimé.';
				$chapters = $this->chapters->getChaptersByStatus($statusCh);
				$comments = $this->comments->getCommentsByStatus($statusCo);
			} elseif(isset($_POST['restoreChap'])) {
				$this->chapters->updateStatusCh('draft', $_POST['chapterId']);
				$confirm = 'Le chapitre a été restauré avec un statut = "brouillon".';
				$chapters = $this->chapters->getChaptersByStatus($statusCh);
				$comments = $this->comments->getCommentsByStatus($statusCo);
			} elseif (isset($_POST['delCom'])) {
				$this->comments->deleteCo($_POST['commentId']);
				$confirm = 'Le commentaire a été définitivement supprimé.';
				$chapters = $this->chapters->getChaptersByStatus($statusCh);
				$comments = $this->comments->getCommentsByStatus($statusCo);
			} elseif(isset($_POST['restoreCom'])) {
				$this->comments->updateStatusCo('moderate', $_POST['commentId']);
				$confirm = 'Le chapitre a été restauré avec un statut = "modéré".';
				$chapters = $this->chapters->getChaptersByStatus($statusCh);
				$comments = $this->comments->getCommentsByStatus($statusCo);
			}
			$view = $this->view->genView(array('chapters' => $chapters, 'comments' => $comments, 'confirm' => $confirm));
			return $view;
		} else {
			header('Location: index.php?action=adminConn');
			exit;
		}
	}

	public function see (array $statusCh, $chapId) {
		if(isset($_SESSION['login']) && isset($_SESSION['password'])) {
			$confirm = NULL;
			$idsList = $this->listIdsCh($statusCh); //to control if id send by URL exist in draft and published ch
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

	public function modify (array $status, $chapId) {
		if(isset($_SESSION['login']) && isset($_SESSION['password'])) {
			$idsList = $this->listIdsCh($status); //to control if id send by URL exist
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
								$lastNum = $this->chapters->lastNum('published');//return num (str) of the last published chapter in a bi-dimension array, control if POSTnum is consistent
								$next = intval($lastNum[0]['num_chap']) + 1;
							if($_POST['num'] == $next) {
						 		$this->chapters->updatePublished ($_POST['num'], $_POST['title'], $_POST['content'], $chapId);
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
					$numChaps = $this->listNumsNoTrashCh(); //to control if POSTnum exist in db
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
				Session::unset(array('num', 'title', 'content'));
				return $view;
			} else {throw new Exception('Le chapitre demandé n\'existe pas.');}
		} else {
			header('Location: index.php?action=adminConn');
			exit;
		}
	}

	public function write () {
		if (null !== Session::getSession('login') && null !== Session::getSession('password')) {
			$lastNum = NULL;
		  $confirm = NULL;
		  $trouble = NULL;
			if (isset($_POST['num']) && $_POST['num'] != ''){$_SESSION['num'] = $_POST['num'];}
		  if (isset($_POST['title']) && $_POST['title'] != ''){$_SESSION['title'] = $_POST['title'];}
		  if (isset($_POST['content']) && $_POST['content'] != ''){$_SESSION['content'] = $_POST['content'];}
			if (isset($_POST['published'])) {
		    if (!empty($_POST['num'] && !empty($_POST['title']) && !empty($_POST['content']))){
		      $lastNum = $this->chapters->lastNum('published'); //return num (str) of the last published chapter in a bi-dimension array, control if POSTnum is consistent
		      $next = intval($lastNum[0]['num_chap']) + 1;
		      if ($_POST['num'] == $next) {
		        $this->chapters->addCh ($_POST['num'], $_POST['title'], $_POST['content'], 'published');
		        $confirm = 'Votre chapitre a bien été publié';
		      } else {
		        $trouble = 'ATTENTION ! Le chapitre n\'a pas pu être publié car : le numéro du chapitre n\'est pas cohérent, il devrait être égal à ' .$next.  '.';
		      }
		    } else {
		      $trouble = 'Tous les champs doivent être renseignés.';
		    }
		  } elseif (isset($_POST['draft'])) {
		    $numChaps = $this->listNumsNoTrashCh(array('published', 'draft')); //return bi-dimension array with all the chap numbers not trashed
		    if(in_array($_POST['num'], $numChaps)) {
		      $confirm = 'Le chapitre a bien été enregistré en brouillon.<br>ATTENTION ! Le numéro de chapitre <span class="font-bold">' .$_POST['num']. '</span> existe déjà.';
		    } else {
		      $confirm = 'Le chapitre a bien été enregistré en brouillon.';
		    }
		    $this->chapters->addCh ($_POST['num'], $_POST['title'], $_POST['content'], 'draft');
		  }
			$view = $this->view->genView(array('lastNum' => $lastNum, 'confirm' => $confirm, 'trouble' => $trouble));
		  return $view;
		} else {
	  	header('Location: index.php?action=adminConn');
	  	exit;
		}
	}

	public function disconnect () {
		session_unset();
		session_destroy();
		header('Location: index.php?action=home');
		exit;
	}

//SUPPORT METHODS FOR ACTIONS
	private function chaptersNoTrashAndCount() { //use in chaptersList()
		$chapters = $this->chapters->getChaptersNoTrash();
		for($i = 0; $i<count($chapters); $i++) {
			$chapId = $chapters[$i]['id'];
			$chapters[$i]['countCom'] = $this->comments->countCo($chapId); //integrate a new line in array $chapters
		}
		return $chapters;
	}

	private function chaptersByStatusAndCount ($status) { //use in chaptersList()
		$chapters = $this->chapters->getChaptersByStatus($status);
		for($i = 0; $i<count($chapters); $i++) {
			$chapId = $chapters[$i]['id'];
			$chapters[$i]['countCom'] = $this->comments->countCo($chapId); //integrate a new line in array $chapters
		}
		return $chapters;
	}

	private function listNumsNoTrashCh () { //use in chaptersList,
		$list = $this->chapters->getListNumsNoTrashCh();
		for ($i=0; $i<count($list); $i++) {
			$numsList[] = $list[$i]['num_chap'];
		}
		return $numsList;
	}

	private function listIdsCh (array $status) { //use in modify()
		$list = $this->chapters->getListIdsCh($status);
	  for($i = 0; $i<count($list); $i++) {
	    $idsList[] = $list[$i]['id'];
	  }
		return $idsList;
	}
}
