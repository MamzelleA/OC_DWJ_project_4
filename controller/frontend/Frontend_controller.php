<?php
require_once('controller/Controller.php');

class Frontend_controller extends Controller
{
	public function home (array $statusCo, $statusCh) {
		$lastCh = $this->chapters->getLastThreeCh();
		$lastCo = $this->comments->lastThreeCo($statusCo);
		$countCh = $this->chapters->countStatusCh($statusCh);
		$view = $this->view->genView(array('lastCh'=>$lastCh, 'lastCo' =>$lastCo, 'countCh' => $countCh));
		return $view;
	}

	public function chapters () {
		$list = $this->chapters->getChapters(array('published', NULL));
		$view = $this->view->genView(array('list' => $list));
		return $view;
	}

	public function chapter ($num, $status) { //return chapter_view
		$pConfirm = NULL;
		$rConfirm = NULL;
		$numsList = $this->listNumsCh(array('published', NULL)); //return array with number of all published chapters numbers
	  if(in_array($num, $numsList)) {
	    $chap = $this->chapters->getChapterByNum($num, $status);
	    $chapId = $chap['id'];
	    $com = $this->comments->getLinkCo($chapId);
	    $countCom = $this->comments->countCo($chapId); // count comments published, reported or moderate
	    $countChap = $this->chapters->countStatusCh('published'); //for prev/next button
			if(isset($_POST)) {
				if(isset($_POST['email']) && !empty($_POST['email'])){$_SESSION['email'] = $_POST['email'];}
				if(isset($_POST['author']) && !empty($_POST['author'])){$_SESSION['author'] = $_POST['author'];}
				if(isset($_POST['message']) && !empty($_POST['message'])){$_SESSION['message'] = $_POST['message'];}
				if(isset($_POST['email']) && isset($_POST['author']) && isset($_POST['message'])) {
					if(!empty($_POST['email']) && !empty($_POST['author']) && !empty($_POST['message'])) {
						$regex = '#^[a-z0-9.-_]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#';
						if(preg_match($regex, $_POST['email'])) {
							$authorDb = $this->comments->getLinkAuthorCo($_POST['email']); //return array if there is an author connect to input email
	            $emailDb = $this->comments->getLinkEmailCo($_POST['author']); //return array if there is an email connect to input author
	            $listAuthor = $this->comments->getAuthorInformation(); //return array with all authors and emails
	            for($i=0; $i<count($listAuthor); $i++) {
	              $authors[] = $listAuthor[$i]['author'];
	              $emails[] = $listAuthor[$i]['email'];
	            }
							$inArrayE = in_array($_POST['email'], $emails);
							$inArrayA = in_array($_POST['author'], $authors);
							if($inArrayE == true && ($_POST['author'] !== $authorDb[0]['author'])) {
								$pConfirm = 'L\'email renseigné existe déjà avec un auteur différent. Un email ne peut être associé qu\'à un seul auteur.';
							} elseif ($inArrayA == true && ($_POST['email'] !== $emailDb[0]['email'])) {
								$pConfirm = 'L\'auteur renseigné existe déjà avec un email différent. Un auteur ne peut être associé qu\'à un seul email.';
							} else {
								$this->comments->addCo(htmlspecialchars($_POST['author']), htmlspecialchars($_POST['message']), $_POST['chapterId']);
								if($inArrayE == false && $inArrayA == false) {$this->comments->addAuthorCo(htmlspecialchars($_POST['author']), htmlspecialchars($_POST['email']));}
								$pConfirm = 'Votre commentaire a bien été pris en compte et publié';
	              unset($_SESSION['message']);
							}
						} else {$pConfirm = 'Le format de l\'email est invalide.';}
					} else {$pConfirm = 'Tous les champs doivent être renseignés.';}
				} elseif (isset($_POST['reported'])) {
						$this->comments->updateStatusCo('reported', $_POST['commentId']);
						$rConfirm = 'Votre signalement du commentaire a bien été pris en compte, merci.';
				}
			}
			$view = $this->view->genView(array('chapter'=> $chap,'comment'=> $com, 'countCom'=> $countCom, 'countChap' => $countChap,  'pConfirm' => $pConfirm, 'rConfirm' => $rConfirm));
	    return $view;
	  } else {
	    throw new Exception('La page demandée n\'existe pas.');
		}
	}

	public function genericView ($action) { //legal and about
		$view = $this->view->genView(array($action));
		return $view;
	}

	public function adminConn () {
		$confirm = NULL;
		$login = NULL;
		$password = NULL;
		if(!empty($_POST)){
			if(isset($_POST['connexion'])){
				if(empty($_POST['login']) || empty($_POST['password'])){
					$confirm = 'Tous les champs doivent être renseignés';
				} else {
					$log = $this->admin->getLog($_POST['login'], $_POST['password']);
					var_dump($log);
					if(!empty($log)) {
						$_SESSION['login'] = $log['login'];
						$_SESSION['password'] = $log['password'];
						header('Location: index.php?action=admin');
						exit;
					} else {$confirm = 'L\'identifiant et/ou le mot de passe renseigné est invalide.';}
				}
			}
		}
		$view = $this->view->genView(array('login' => $login, 'password' => $password, 'confirm' => $confirm));
		return $view;
	}
}
