<?php
	$conn = mysql_connect("localhost","root","");
	if (!$conn) die ("Koneksi gagal");
	mysql_select_db("db_berita",$conn) or die ("Database tidak ditemukan");

			//hitung doc data latih
			$sqlJumLatih = mysql_query("SELECT DISTINCT id_doc FROM tbindex");
			$numRowLatih = mysql_num_rows($sqlJumLatih);

			// hitung doc data uji
			$sqljumBaru = mysql_query("SELECT DISTINCT id_doc FROM tbindex_baru");
			$numRowBaru = mysql_num_rows($sqljumBaru);

			// jumlah dokumen update
			$n = $numRowLatih+$numRowBaru; echo $n;


			$resVektor = mysql_query("SELECT a.* FROM (SELECT tbindex_baru.term AS termBaru, tbindex_baru.jumlah AS jumBaru, tbindex_baru.id_doc AS idBaru, 
									tbindex_baru.bobot AS bobotBaru, tbindex.term AS termLatih, tbindex.jumlah AS jumLatih, 
									tbindex.id_doc AS idLatih, tbindex.bobot AS bobotLatih FROM tbindex_baru 
									left JOIN tbindex on tbindex_baru.term =  tbindex.term 
									UNION ALL
									SELECT tbindex_baru.term AS termBaru, tbindex_baru.jumlah AS jumBaru, tbindex_baru.id_doc AS idBaru, 
									tbindex_baru.bobot AS bobotBaru, tbindex.term AS termLatih, tbindex.jumlah AS jumLatih, 
									tbindex.id_doc AS idLatih, tbindex.bobot AS bobotLatih FROM tbindex_baru 
									right JOIN tbindex on tbindex_baru.term =  tbindex.term) a ORDER BY a.termBaru DESC");

			while ($row = mysql_fetch_array($resVektor)) {
				$termBaru = $row['termBaru'];
				$jumBaru = $row['jumBaru'];
				$idBaru = $row['idBaru'];
				$bobotBaru = $row['bobotBaru'];
				$termLatih = $row['termLatih'];
				$jumLatih = $row['jumLatih'];
				$idLatih = $row['idLatih'];
				$bobotLatih = $row['bobotLatih'];

				$idfBaru = mysql_query("SELECT COUNT(*) AS jum FROM tbindex_baru WHERE term = '".$termBaru."'");
				while ($rowJumBaru = mysql_fetch_array($idfBaru)) {
					$dfBaru = $rowJumBaru['jum'];
				}

				$idfLatih = mysql_query("SELECT COUNT(*) AS jum FROM tbindex WHERE term = '".$termLatih."'");
				while ($rowJumLatih = mysql_fetch_array($idfLatih)) {
					$dfLatih = $rowJumLatih['jum'];
				}
				// update nilai df
				$dfUpdate = $dfBaru + $dfLatih; // echo $termLatih." : ".$dfUpdate."<br>";


				if ($termBaru == $termLatih) {	
					// update bobot termBaru
					$sqlUpdateBaru = mysql_query("SELECT bobot FROM update_bobotuji WHERE term = '".$termBaru."' AND id_doc = '".$idBaru."'");
					$jumRowBaru = mysql_num_rows($sqlUpdateBaru);
					$wUpdate = $jumBaru * log10($n / $dfUpdate);
					if ($jumRowBaru > 0) {
						mysql_query("UPDATE update_bobotuji SET bobot = '".$wUpdate."' WHERE term = '".$termBaru."' AND id_doc = '".$idBaru."'");
					}
					else {
						mysql_query("INSERT INTO update_bobotuji VALUES ('".$termBaru."', '".$idBaru."' , '".$wUpdate."', '', '')");
					}

					// update bobot termLatih
					$sqlUpdateLatih = mysql_query("SELECT bobot FROM update_bobotlatih WHERE term = '".$termLatih."' AND id_doc = '".$idLatih."'");
					$jumRowLatih = mysql_num_rows($sqlUpdateLatih);
					$wUpdateLatih = $jumLatih * log10($n / $dfUpdate);
					if ($jumRowLatih > 0) {
						mysql_query("UPDATE update_bobotlatih SET bobot = '".$wUpdateLatih."' WHERE term = '".$termLatih."' AND id_doc = '".$idLatih."'");
					}
					else {
						mysql_query("INSERT INTO update_bobotlatih VALUES ('".$termLatih."', '".$idLatih."' , '".$wUpdateLatih."', '', '')");
					}
				}
				elseif ($termBaru == NULL) {
					// update bobot termLatih
					$sqlUpdateLatih = mysql_query("SELECT bobot FROM update_bobotlatih WHERE term = '".$termLatih."' AND id_doc = '".$idLatih."'");
					$jumRowLatih = mysql_num_rows($sqlUpdateLatih);
					$w = $jumLatih * log10($n / $dfLatih);
					if ($jumRowLatih > 0) {
						mysql_query("UPDATE update_bobotlatih SET bobot = '".$w."' WHERE term = '".$termLatih."' AND id_doc = '".$idLatih."'");
					}
					else {
						mysql_query("INSERT INTO update_bobotlatih VALUES ('".$termLatih."', '".$idLatih."' , '".$w."', '', '')");
					}
				}
				elseif ($termLatih == NULL) {
					// update bobot termUji
					$sqlUpdateBaru = mysql_query("SELECT bobot FROM update_bobotuji WHERE term = '".$termBaru."' AND id_doc = '".$idBaru."'");
					$jumRowBaru = mysql_num_rows($sqlUpdateBaru);
					$wBaru = $jumBaru * log10($n / $dfBaru);
					if ($jumRowBaru > 0) {
						mysql_query("UPDATE update_bobotuji SET bobot = '".$wBaru."' WHERE term = '".$termBaru."' AND id_doc = '".$idBaru."'");
					}
					else {
						mysql_query("INSERT INTO update_bobotuji VALUES ('".$termBaru."', '".$idBaru."', '".$wBaru."', '', '')");
					}
				}
			}
?>