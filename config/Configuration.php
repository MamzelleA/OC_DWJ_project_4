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
    $filePath = 'C:\wamp64\www\OC_DWJ_project_4\config\access\config.ini';
    if(SELF::$datas == null) {
      if(file_exists($filePath)){
        SELF::$datas = parse_ini_file($filePath);
      } else {throw new exception('Aucune donnée de configuration n\'a été trouvée.');}
    }
    return SELF::$datas;
  }
}
