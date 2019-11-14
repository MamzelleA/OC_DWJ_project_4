<?php
require_once('Manager.php');

Class Comments_Manager extends Manager
{
  //Create
  public function addCo ($author, $content, $chapterId) { // USER chapter
		$sqlCom = 'INSERT INTO comments(author, content_co, id_chap, add_Date) VALUES (?, ?, ?, NOW())';
		$this->execRequest($sqlCom, array($author, $content, $chapterId));
		$commentId = $this->recoverId();
		$sqlStat = 'INSERT INTO status_comment(id_co, status_co)
					VALUES (?, DEFAULT)';
		$this->execRequest($sqlStat, array($commentId));
	}

	public function addAuthorCo ($author, $email)	{ //USER chapter
		$sql = 'INSERT INTO author_comment(author, email) VALUES (?,?)';
		$this->execRequest($sql, array($author, $email));
	}

  //Read
  public function lastThreePublishedCo ($status) //USER home and ADMIN admin
	{
    $sql = 'SELECT co.id, id_chap, author, content_co, DATE_FORMAT(add_date, \'%d/%m/%Y\') AS add_date_fr, ch.id, num_chap, title_chap, id_co, status_co
				    FROM comments AS co, chapters AS ch, status_comment AS sco
				    WHERE sco.status_co = ?
            AND co.id_chap = ch.id
				    AND co.id = sco.id_co
				    ORDER BY co.id DESC
				    LIMIT 3';
		$com = $this->execRequest($sql, array($status));
		$result = $com->fetchAll(PDO::FETCH_ASSOC);
    $com->closeCursor();
		return $result;
	}

  public function getLinkCo ($chapterId) { //USER chapter, ADMIN see
    $sql = 'SELECT co.id, author, content_co, id_chap, DATE_FORMAT(add_date, \'%d/%m/%Y\') AS add_date_fr, id_co, status_co
				    FROM comments AS co, status_comment AS sco
				    WHERE NOT sco.status_co = \'trashed\'
				    AND co.id = sco.id_co
				    AND co.id_chap = ?
				    ORDER BY co.id DESC';
		$com = $this->execRequest($sql, array($chapterId));
		$result = $com->fetchAll(PDO::FETCH_ASSOC);
    $com->closeCursor();
		return $result;
	}

  public function countCo ($chapId) { //USER chapter, chaptersList, ADMIN see
		$sql = 'SELECT COUNT(*)
						FROM comments co
						INNER JOIN status_comment sco
						ON co.id = sco.id_co
						WHERE NOT sco.status_co = \'trashed\'
						AND co.id_chap = ?';
		if(is_null($sql)){$result = 0;}
		else {
			$count = $this->execRequest($sql, array($chapId));
			$result = $count->fetchAll(PDO::FETCH_ASSOC);
      $count->closeCursor();
		}
		return $result;
	}

  public function getAuthorInformation () { //USER chapter
		$sql = 'SELECT *
						FROM author_comment';
		$com = $this->execRequest($sql);
		$result = $com->fetchAll(PDO::FETCH_ASSOC);
    $com->closeCursor();
		return $result;
	}

	public function getLinkAuthorCo ($email) { //USER chapter
		$sql = 'SELECT author
						FROM author_comment
						WHERE email = ?';
		$com = $this->execRequest($sql, array($email));
		$result = $com->fetchAll(PDO::FETCH_ASSOC);
    $com->closeCursor();
		return $result;
	}

	public function getLinkEmailCo ($author) { //USER chapter
		$sql = 'SELECT email
						FROM author_comment
						WHERE author = ?';
		$com = $this->execRequest($sql, array($author));
		$result = $com->fetchAll(PDO::FETCH_ASSOC);
    $com->closeCursor();
		return $result;
	}

  public function getCommentsNoTrash () { //ADMIN commentsList
    $sql = 'SELECT co.id, id_chap, author, content_co, DATE_FORMAT(add_date, \'%d/%m/%Y\') AS add_date_fr, ch.id, num_chap, title_chap, id_co, status_co
				    FROM comments AS co, chapters AS ch, status_comment AS sco
				    WHERE NOT sco.status_co = \'trashed\'
				    AND co.id = sco.id_co
				    AND co.id_chap = ch.id
				    ORDER BY co.id DESC';
		$com = $this->execRequest($sql);
		$result = $com->fetchAll(PDO::FETCH_ASSOC);
    $com->closeCursor();
		return $result;
  }

  public function getCommentsByStatus ($status) { //ADMIN admin, trash
    $sql = 'SELECT co.id, id_chap, author, content_co, DATE_FORMAT(add_date, \'%d/%m/%Y\') AS add_date_fr, ch.id, num_chap, title_chap, id_co, status_co
            FROM comments AS co, chapters AS ch, status_comment AS sco
            WHERE sco.status_co = ?
            AND co.id = sco.id_co
            AND co.id_chap = ch.id
            ORDER BY co.id DESC';
    $com = $this->execRequest($sql, array($status));
    $result = $com->fetchAll(PDO::FETCH_ASSOC);
    $com->closeCursor();
    return $result;
  }

  //Update
  public function updateStatusCo ($status, $commentId)	{ //USER chapter, ADMIN commentsList
		$sql = 'UPDATE status_comment
				    SET status_co = ?
				    WHERE id_co = ?';
		$this->execRequest($sql, array($status, $commentId));
	}

  //Delete
  public function deleteCo ($commentId) { //ADMIN trash
		$sql = 'DELETE
				    FROM comments
				    WHERE id = ?';
		$this->execRequest($sql, array($commentId));

	}
}
