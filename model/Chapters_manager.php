<?php
require_once('Manager.php');

class Chapters_manager extends Manager
{
  public function getLastThreeCh () { //home
	  $sql = 'SELECT ch.id, num_chap, title_chap, DATE_FORMAT(create_date, \'%d/%m/%Y\') AS create_date_fr, DATE_FORMAT (modify_date, \'%d/%m/%Y\') AS modify_date_fr
				    FROM chapters ch
				    INNER JOIN status_chapter sch
				    ON ch.id = sch.id_chap
				    WHERE status_chap = \'published\'
				    ORDER BY num_chap DESC
				    LIMIT 3';
		$chap = $this->execRequest($sql);
		$result = $chap->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}

  public function countStatusCh ($status) { //home
    $sql = 'SELECT COUNT(*)
				    FROM status_chapter
				    WHERE status_chap = ?';
		$count = $this->execRequest($sql, array($status));
		$result = $count->fetch();
		return $result;
  }

    public function getChaptersNoTrash () { // chaptersList
  		$sql = 'SELECT ch.id, num_chap, title_chap, content_chap, DATE_FORMAT(create_date, \'%d/%m/%Y\') AS create_date_fr, DATE_FORMAT (modify_date, \'%d/%m/%Y\') AS modify_date_fr, sch.id, id_chap, status_chap
  						FROM chapters AS ch, status_chapter AS sch
  						WHERE NOT sch.status_chap = \'trashed\'
              AND ch.id = sch.id_chap
  						ORDER BY num_chap DESC';
  		$chap = $this->execRequest($sql);
  		$result = $chap->fetchAll(PDO::FETCH_ASSOC);
  		return $result;
  	}

	public function getChaptersByStatus ($status) { //chapters, trash
		$sql = 'SELECT ch.id, num_chap, title_chap, content_chap, DATE_FORMAT(create_date, \'%d/%m/%Y\') AS create_date_fr, DATE_FORMAT (modify_date, \'%d/%m/%Y\') AS modify_date_fr, sch.id, id_chap, status_chap
						FROM chapters AS ch, status_chapter AS sch
						WHERE sch.status_chap = ?
            AND ch.id = sch.id_chap
						ORDER BY num_chap DESC';
		$chap = $this->execRequest($sql, array($status));
		$result = $chap->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}

	public function getChapterByNum ($num, $status) { //chapter
		$sql = 'SELECT ch.id, num_chap, title_chap, content_chap, DATE_FORMAT(create_date, \'%d/%m/%Y\') AS create_date_fr, DATE_FORMAT (modify_date, \'%d/%m/%Y\') AS modify_date_fr
						FROM chapters ch
						INNER JOIN status_chapter sch
						ON ch.id = sch.id_chap
						WHERE ch.num_chap = ?
						AND sch.status_chap = ?';
		$chap = $this->execRequest($sql, array($num, $status));
		$result = $chap->fetch(PDO::FETCH_ASSOC);
		return $result;
	}

	public function getListNumsNoTrashCh () { // chaptersList, modify
		$sql = 'SELECT ch.id, num_chap, sch.id, id_chap
				FROM chapters AS ch, status_chapter AS sch
				WHERE NOT sch.status_chap = \'trashed\'
				AND ch.id = sch.id_chap
				ORDER BY num_chap';
		$chap = $this->execRequest($sql);
		$result = $chap->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}

  public function getListNumsByStatusCh ($status) { // chapter
		$sql = 'SELECT ch.id, num_chap, sch.id, id_chap
				FROM chapters AS ch, status_chapter AS sch
				WHERE sch.status_chap = ?
				AND ch.id = sch.id_chap
				ORDER BY num_chap';
		$chap = $this->execRequest($sql, array($status));
		$result = $chap->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}

  public function getLastSixCh () { //admin
  	$sql = 'SELECT ch.id, num_chap, title_chap, DATE_FORMAT(create_date, \'%d/%m/%Y\') AS create_date_fr, DATE_FORMAT (modify_date, \'%d/%m/%Y\') AS modify_date_fr, sch.id, id_chap, status_chap
  			    FROM chapters AS ch, status_chapter AS sch
  			    WHERE ch.id = sch.id_chap
  			   	AND NOT status_chap = \'trashed\'
  			    ORDER BY num_chap DESC
  			    LIMIT 6';
  	$chap = $this->execRequest($sql);
  	$result = $chap->fetchAll(PDO::FETCH_ASSOC);
  	return $result;
  }

  public function getChapterById ($chapterId) //see, modify
	{
		$sql = 'SELECT ch.id, num_chap, title_chap, content_chap, DATE_FORMAT(create_date, \'%d/%m/%Y\') AS create_date_fr, DATE_FORMAT (modify_date, \'%d/%m/%Y\') AS modify_date_fr, id_chap, status_chap
				FROM chapters AS ch, status_chapter AS sch
				WHERE ch.id = sch.id_chap
				AND ch.id = ?';
		$chap = $this->execRequest($sql, array($chapterId));
		$result = $chap->fetch(PDO::FETCH_ASSOC);
		return $result;
	}

  public function getListIdsCh(array $status)	{ //see, modify
    $sql = 'SELECT ch.id, sch.id, id_chap, status_chap
				    FROM chapters AS ch, status_chapter AS sch
				    WHERE sch.status_chap IN (?, ?)
				    AND ch.id = sch.id_chap
				    ORDER BY ch.id';
		$chap = $this->execRequest($sql, array($status[0], $status[1]));
		$result = $chap->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}

  public function lastNum ($status) { //modify, write
		$sql = 'SELECT ch.id, num_chap
						FROM chapters ch
						INNER JOIN status_chapter sch
						ON ch.id = sch.id_chap
						AND sch.status_chap = ?
						ORDER BY num_chap DESC
						LIMIT 1';
		$chap = $this->execRequest($sql, array($status));
		$result = $chap->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}

  //Create / Update
  public function updateStatusCh ($status, $chapterId) { //chaptersList

		$sql = 'UPDATE status_chapter
						SET status_chap = ?
						WHERE id_chap = ?';
		$stat = $this->execRequest($sql, array($status, $chapterId));
	}

  public function updateDraft ($number, $title, $content, $chapterId) {  //modify
		$sqlChap = 'UPDATE chapters
								SET num_chap = ?,
										title_chap = ?,
										content_chap = ?,
										modify_date = NOW()
								WHERE id = ?';
		$this->execRequest($sqlChap, array($number, $title, $content, $chapterId));
	}

	public function updatePublished ($num = null, $title, $content, $chapterId) { //modify
		$sqlChap = 'UPDATE chapters
								SET num_chap = ?,
                    title_chap = ?,
										content_chap = ?,
										modify_date = NOW()
								WHERE id = ?';
		$this->execRequest($sqlChap, array($title, $content, $chapterId));
	}


    public function deleteCh ($chapterId)	{ //trash
  		$sql = 'DELETE
  						FROM chapters
  						WHERE id = ?';
  		$this->execRequest($sql, array($chapterId));
  	}

  public function addCh ($number, $title, $content, $status) { //write
		$sqlChap = 'INSERT INTO chapters(num_chap, title_chap, content_chap, create_date)
								VALUES (?, ?, ?, NOW())';
		$this->execRequest($sqlChap, array($number, $title, $content));
		$chapterId = $this->recoverId();
		$sqlStat = 'INSERT INTO status_chapter(id_chap, status_chap)
								VALUES (?, ?)';
		$this->execRequest($sqlStat, array($chapterId, $status));
	}
}
