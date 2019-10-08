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

	public function getChapters (array $status) { //chapters
		$sql = 'SELECT ch.id, num_chap, title_chap, content_chap, DATE_FORMAT(create_date, \'%d/%m/%Y\') AS create_date_fr, DATE_FORMAT (modify_date, \'%d/%m/%Y\') AS modify_date_fr
						FROM chapters ch
						INNER JOIN status_chapter sch
						ON ch.id = sch.id_chap
						WHERE sch.status_chap IN (?, ?)
						ORDER BY num_chap DESC';
		$chap = $this->execRequest($sql, array($status[0], $status[1]));
		$result = $chap->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}

	public function getChapterByNum ($num, $status) {//chapter
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

	public function getListNumsCh ($status)
	{
		$sql = 'SELECT ch.id, num_chap, sch.id, id_chap
				FROM chapters AS ch, status_chapter AS sch
				WHERE sch.status_chap IN (?, ?)
				AND ch.id = sch.id_chap
				ORDER BY num_chap';
		$chap = $this->execRequest($sql, array($status[0], $status[1]));
		$result = $chap->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}
}
