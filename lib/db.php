<?php
	/**
	* Database Class
	*/
	class db
	{
		public static function conn()
		{
			try {
				$db = new mysqli('localhost', 'root', '', 'db_KadoMoe');
				return $db;
			} catch (Exception $e) {
				die('Unable to connect ! '.$e->getMessage());
			}
		}

		public static function select($query)
		{
			$result = self::conn()->query($query);
			return $result;
		}

		public static function insert($query)
		{
			$result = self::conn()->query($query);
			return $result;
		}

		public static function update($query)
		{
			$result = self::conn()->query($query);
			return $result;
		}

		public static function delete($query)
		{
			$result = self::conn()->query($query);
			return $result;
		}

	}
?>