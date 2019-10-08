<?php
require_once('Manager.php');

class Admin_manager extends Manager {

  public function getLog ($login, $password) {
    $sql = 'SELECT *
            FROM admin_id
            WHERE login = ?
            AND password = PASSWORD(?)';
    $log = $this->execRequest($sql, array($login, $password));
    $result = $log->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }


}
