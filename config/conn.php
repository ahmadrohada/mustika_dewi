<?php
class Connect {
	protected static $_connection;
	public static function getConnection(){
		if(!self::$_connection){
			$dbhost = 'localhost';
			$dbuser = 'root';
			$dbpassword = '';
			$dbname ='db_pare';
			self::$_connection = @mysql_connect($dbhost, $dbuser, $dbpassword);
			if(!self::$_connection){
				throw new Exception('Gagal melakukan koneksi ke database. '.mysql_error());
			}
			$result = @mysql_select_db($dbname, self::$_connection);
			if(!$result){
				throw new Exception('Koneksi gagal:'.mysql_error() );
			}
		}		return self::$_connection;
	}
	
	public static function getConnection_2(){
		if(!self::$_connection){
			$dbhost = 'localhost';
			$dbuser = 'root';
			$dbpassword = '';
			$dbname ='db_siap';
			self::$_connection = @mysql_connect($dbhost, $dbuser, $dbpassword);
			if(!self::$_connection){
				throw new Exception('Gagal melakukan koneksi ke database. '.mysql_error());
			}
			$result = @mysql_select_db($dbname, self::$_connection);
			if(!$result){
				throw new Exception('Koneksi gagal:'.mysql_error() );
			}
		}
		return self::$_connection;
	}

	public static function close(){
		if(self::$_connection){
			mysql_close(self::$_connection);
		}
	}
} 


?>
