<?php
require_once('Manager.php');

class Chapters_manager extends Manager
{
	public function getLastSixCh () { //admin
	   $sql = 'SELECT ch.id, num_chap, title_chap, DATE_FORMAT(create_date, \'%d/%m/%Y\') AS create_date_fr, DATE_FORMAT (modify_date, \'%d/%m/%Y\') AS modify_date_fr
				     FROM chapters ch
				     INNER JOIN status_chapter sch
				     ON ch.id = sch.id_chap
				     WHERE NOT status_chap = \'trashed\'
				     ORDER BY num_chap DESC
				     LIMIT 6';
		$chap = $this->execRequest($sql);
		$result = $chap->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}

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

  public function countStatusCh ($status) {
    $sql = 'SELECT COUNT(*)
				    FROM status_chapter
				    WHERE status_chap = ?';
		$count = $this->execRequest($sql, array($status));
		$result = $count->fetch();
		return $result;
  }

	public function getChapters (array $status) {
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
}
