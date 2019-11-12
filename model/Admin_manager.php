<?php
require_once('Manager.php');

class Admin_manager extends Manager {

  //compare datas in DB with write down POST to connect to admin
  public function getLog ($login, $password) {
    $sql = 'SELECT *
            FROM admin_id
            WHERE login = ?
            AND password = PASSWORD(?)';
    $log = $this->execRequest($sql, array($login, $password));
    $result = $log->fetchAll(PDO::FETCH_ASSOC);
    $log->closeCursor();
    return $result;
  }
}
