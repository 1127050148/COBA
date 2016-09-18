<?php
 
	class Database {
		var $koneksi ;
		var $selectDb;
		 
		function database()
		{
			$this->koneksi = mysql_connect("localhost","root","");
			$this->selectDb = mysql_select_db("db_berita" , $this->koneksi);
			if ( !$this->selectDb )
			{
				echo "gagal";
			}
		}
	}
 
?>