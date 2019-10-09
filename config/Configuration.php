<?php
class Configuration {

  private static $datas;

  public static function get($key) {
    SELF::getDatas();
    if(isset(SELF::getDatas()[$key])) {
      $value = SELF::$datas[$key];
      return $value;
    } else {
      throw new exception('Aucune donnée de configuration n\'a été trouvée.');
    }
  }

  private static function getDatas() {
    $filePath = 'config.ini';
    $result = file_exists($filePath);
    if(SELF::$datas == null) {
      //if(file_exists($filePath)){
        SELF::$datas = parse_ini_file($filePath);
      //} else {
      //throw new exception('Aucune donnée de configuration n\'a été trouvée.');
      //}
    }
    return SELF::$datas;
  }
}
