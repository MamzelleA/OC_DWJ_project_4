<?php
require_once('Manager.php');

Class Comments_Manager extends Manager
{
  public function lastThreeCo ($status) //home() front and back
	{
		$sql = 'SELECT id_chap, author, content_co, DATE_FORMAT(add_date, \'%d/%m/%Y\') AS add_date_fr
				FROM comments AS co, chapters AS ch, status_comment AS sco
				WHERE co.id_chap = ch.id
				AND co.id = sco.id_co
				AND sco.status_co= ?
				ORDER BY co.id DESC
				LIMIT 3';
		$com = $this->execRequest($sql, array($status));
		$result = $com->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}
}
