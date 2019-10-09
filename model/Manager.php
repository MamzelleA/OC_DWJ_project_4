<?php
require_once('config/Configuration.php');

abstract class Manager {

	private static $db;

	protected function execRequest ($sql, $parameters = null)
	{
		if ($parameters == null) {
			$req = self::getConnexion()->query($sql);
		}
		else {
			$req = self::getConnexion()->prepare($sql);
			$req->execute($parameters);
		}
		return $req;
	}

	protected function recoverId ()
	{
		$recover = self::getConnexion()->lastInsertId();
		return $recover;
	}

	private static function getConnexion () {
		if (self::$db == null)
		{
			$dsn = Configuration::get('dsn');
			$loginDb = Configuration::get('loginDb');
			$pwDb = Configuration::get('pwDb');
			self::$db = new PDO($dsn, $loginDb, $pwDb, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		}
		return self::$db;
	}
}
