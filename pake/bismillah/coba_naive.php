<?php
	$conn = mysql_connect("localhost","root","");
	if (!$conn) die ("Koneksi gagal");
	mysql_select_db("db_berita",$conn) or die ("Database tidak ditemukan");

	// // jumlah kata dalam data latih
	// $queryTerm = mysql_query("SELECT tbindex.term AS term, tbindex.id_doc AS id_doc, tbindex.jumlah AS Frekuensi,
	// 						berita_training.kategori AS kategori FROM tbindex 
	// 						JOIN berita_training ON tbindex.id_doc = berita_training.id_berita_training");
	// $kosakataLatih = mysql_num_rows($queryTerm); //2513 kata
	// while ($data = mysql_fetch_array($queryTerm)) {
	// 	$term = $data['term'];
	// 	$id = $data['id_doc'];
	// 	$frek = $data['Frekuensi'];
	// 	$kat = $data['kategori'];

	// 	$qCekData = mysql_query("SELECT * FROM naive_bayes WHERE term = '".$term."' AND no_preprocess_training = '".$id."'");
	// 	$cekData = mysql_num_rows($qCekData);
	// 	if ($cekData > 0) {
	// 		echo "";
	// 	}
	// 	else {
	// 		mysql_query("INSERT INTO naive_bayes (term, no_preprocess_training, frekuensi, kategori) VALUES
	// 					('".$term."', '".$id."', '".$frek."', '".$kat."')");
	// 	}
	// }

	// // jumlah seluruh dokumen latih
	// $nDok = mysql_query("SELECT DISTINCT no_preprocess_training FROM naive_bayes");
	// $jumDoc = mysql_num_rows($nDok); //28 Data

	// // jumlah dokumen dengan kategori Politik
	// $dokPol = mysql_query("SELECT DISTINCT no_preprocess_training FROM naive_bayes WHERE kategori = 'Politik'");
	// $jumPol = mysql_num_rows($dokPol); //5 Data
	// $pvjPol = $jumPol / $jumDoc;
	// $qJumPol = mysql_query("SELECT * FROM naive_bayes WHERE kategori = 'Politik'");
	// $jumKataPol = mysql_num_rows($qJumPol); // 366 kata

	// // jumlah dokumen dengan kategori Olahraga
	// $dokOlg = mysql_query("SELECT DISTINCT no_preprocess_training FROM naive_bayes WHERE kategori = 'Olahraga'");
	// $jumOlg = mysql_num_rows($dokOlg); //5 Data
	// $pvjOlg = $jumOlg / $jumDoc;
	// $qJumOlg = mysql_query("SELECT * FROM naive_bayes WHERE kategori = 'Olahraga'");
	// $jumKataOlg = mysql_num_rows($qJumOlg); // 406 kata

	// // jumlah dokumen dengan kategori Pendidikan
	// $dokPend = mysql_query("SELECT DISTINCT no_preprocess_training FROM naive_bayes WHERE kategori = 'Pendidikan'");
	// $jumPend = mysql_num_rows($dokPend); //5 Data
	// $pvjPend = $jumPend / $jumDoc;
	// $qJumPend = mysql_query("SELECT * FROM naive_bayes WHERE kategori = 'Pendidikan'");
	// $jumKataPend = mysql_num_rows($qJumPend); // 509 kata

	// // jumlah dokumen dengan kategori Otomotif
	// $dokOto = mysql_query("SELECT DISTINCT no_preprocess_training FROM naive_bayes WHERE kategori = 'Otomotif'");
	// $jumOto = mysql_num_rows($dokOto); //5 Data
	// $pvjOto = $jumOto / $jumDoc;
	// $qJumOto = mysql_query("SELECT * FROM naive_bayes WHERE kategori = 'Otomotif'");
	// $jumKataOto = mysql_num_rows($qJumOto); // 525 kata

	// // jumlah dokumen dengan kategori Umum
	// $dokUmum = mysql_query("SELECT DISTINCT no_preprocess_training FROM naive_bayes WHERE kategori = 'Umum'");
	// $jumUmum = mysql_num_rows($dokUmum); //8 Data
	// $pvjUmum = $jumUmum / $jumDoc;
	// $qJumUmum = mysql_query("SELECT * FROM naive_bayes WHERE kategori = 'Umum'");
	// $jumKataUmum = mysql_num_rows($qJumUmum); // 707 kata

	
	// $qJumPol = mysql_query("SELECT * FROM naive_bayes WHERE kategori = 'Politik'");
	// while ($i = mysql_fetch_array($qJumPol)) {
	// 	$termPol = $i['term'];
	// 	$qPol = mysql_query("SELECT term, no_preprocess_training, SUM(frekuensi) AS frekuensi 
	// 						FROM naive_bayes WHERE kategori = 'Politik' AND term = '".$termPol."'");
	// 	while ( $a = mysql_fetch_array($qPol)) {
	// 		$tPol = $a['term'];
	// 		$idPol = $a['no_preprocess_training'];
	// 		$frekPol = $a['frekuensi'];
	// 		$pwkvjPol = ($frekPol + 1) / ($jumKataPol + $kosakataLatih);
	// 		// echo "$tPol >< $idPol >< $frekPol	=> $pwkvjPol<br>";
	// 		mysql_query("UPDATE naive_bayes SET pwk = '".$pwkvjPol."', pvj = '".$pvjPol."' WHERE term = '".$tPol."' AND kategori = 'Politik'");
	// 	}
	// }
		
	// $qJumOlg = mysql_query("SELECT * FROM naive_bayes WHERE kategori = 'Olahraga'");
	// while ($i = mysql_fetch_array($qJumOlg)) {
	// 	$termOlg = $i['term'];			
	// 	$qOlg = mysql_query("SELECT term, no_preprocess_training, SUM(frekuensi) AS frekuensi 
	// 						FROM naive_bayes WHERE kategori = 'Olahraga' AND term = '".$termOlg."'");
	// 	while ( $a = mysql_fetch_array($qOlg)) {
	// 		$tOlg = $a['term'];
	// 		$idOlg = $a['no_preprocess_training'];
	// 		$frekOlg = $a['frekuensi'];
	// 		$pwkvjOlg = ($frekOlg + 1) / ($jumKataOlg + $kosakataLatih);
	// 		// echo "$tPol >< $idPol >< $frekPol	=> $pwkvjPol<br>";
	// 		mysql_query("UPDATE naive_bayes SET pwk = '".$pwkvjOlg."', pvj = '".$pvjOlg."' WHERE term = '".$tOlg."' AND kategori = 'Olahraga'");
	// 	}
	// }
		
	// $qJumPend = mysql_query("SELECT * FROM naive_bayes WHERE kategori = 'Pendidikan'");
	// while ($i = mysql_fetch_array($qJumPend)) {
	// 	$termPend = $i['term'];
	// 	$qPend = mysql_query("SELECT term, no_preprocess_training, SUM(frekuensi) AS frekuensi 
	// 						FROM naive_bayes WHERE kategori = 'Pendidikan' AND term = '".$termPend."'");
	// 	while ( $a = mysql_fetch_array($qPend)) {
	// 		$tPend = $a['term'];
	// 		$idPend = $a['no_preprocess_training'];
	// 		$frekPend = $a['frekuensi'];
	// 		$pwkvjPend = ($frekPend + 1) / ($jumKataPend + $kosakataLatih);
	// 		// echo "$tPol >< $idPol >< $frekPol	=> $pwkvjPol<br>";
	// 		mysql_query("UPDATE naive_bayes SET pwk = '".$pwkvjPend."', pvj = '".$pvjPend."' WHERE term = '".$tPend."' AND kategori = 'Pendidikan'");
	// 	}
	// }
		
	// $qJumOto = mysql_query("SELECT * FROM naive_bayes WHERE kategori = 'Otomotif'");
	// while ($i = mysql_fetch_array($qJumOto)) {
	// 	$termOto = $i['term'];
	// 	$qOto = mysql_query("SELECT term, no_preprocess_training, SUM(frekuensi) AS frekuensi 
	// 						FROM naive_bayes WHERE kategori = 'Otomotif' AND term = '".$termOto."'");
	// 	while ( $a = mysql_fetch_array($qOto)) {
	// 		$tOto = $a['term'];
	// 		$idOto = $a['no_preprocess_training'];
	// 		$frekOto = $a['frekuensi'];
	// 		$pwkvjOto = ($frekOto + 1) / ($jumKataOto + $kosakataLatih);
	// 		// echo "$tPol >< $idPol >< $frekPol	=> $pwkvjPol<br>";
	// 		mysql_query("UPDATE naive_bayes SET pwk = '".$pwkvjOto."', pvj = '".$pvjOto."' WHERE term = '".$tOto."' AND kategori = 'Otomotif'");
	// 	}
	// }
		
	// $qJumUmum = mysql_query("SELECT * FROM naive_bayes WHERE kategori = 'Umum'");
	// while ($i = mysql_fetch_array($qJumUmum)) {
	// 	$termUmum = $i['term'];
	// 	$qUmum = mysql_query("SELECT term, no_preprocess_training, SUM(frekuensi) AS frekuensi 
	// 						FROM naive_bayes WHERE kategori = 'Umum' AND term = '".$termUmum."'");
	// 	while ( $a = mysql_fetch_array($qUmum)) {
	// 		$tUmum = $a['term'];
	// 		$idUmum = $a['no_preprocess_training'];
	// 		$frekUmum = $a['frekuensi'];
	// 		$pwkvjUmum = ($frekUmum + 1) / ($jumKataUmum + $kosakataLatih);
	// 		// echo "$tPol >< $idPol >< $frekPol	=> $pwkvjPol<br>";
	// 		mysql_query("UPDATE naive_bayes SET pwk = '".$pwkvjUmum."', pvj = '".$pvjUmum."' WHERE term = '".$tUmum."' AND kategori = 'Umum'");
	// 	}
	// }


	// // insert data uji ke tabel naive_bayes
	// $querySelectDataUji = mysql_query("SELECT * FROM tbindex_baru");
	// while ($y = mysql_fetch_array($querySelectDataUji)) {
	// 	$term = $y['term'];
	// 	$id = $y['id_doc'];

	// 	$queryCekData = mysql_query("SELECT * FROM nb_uji WHERE term = '".$term."' AND id_doc_uji = '".$id."'");
	// 	$cekIsi = mysql_num_rows($queryCekData);
	// 	if ($cekIsi > 0) {
	// 		echo "";
	// 	}
	// 	else {
	// 		mysql_query("INSERT INTO nb_uji(term, id_doc_uji) SELECT term, id_doc FROM tbindex_baru");
	// 	}
	// }

	// hitung vmap data uji politik  BELUM BERES SAMPE SINI
	$selectpvjPol = mysql_query("SELECT DISTINCT pvj FROM naive_bayes WHERE kategori = 'politik'");
	while ($p = mysql_fetch_array($selectpvjPol)) {
		$pvjPol = $p['pvj'];	
	}

	$jumDok = mysql_query("SELECT DISTINCT(id_doc_uji) FROM nb_uji");
	$cDok = mysql_num_rows($jumDok) + 3;

	for ($i=1; $i < $cDok; $i++) { 
		$selectPol = mysql_query("SELECT nb_uji.id_doc_uji AS id, nb_uji.term AS term, naive_bayes.term, 
								naive_bayes.pwk AS pwk FROM nb_uji JOIN naive_bayes on nb_uji.term = naive_bayes.term 
								WHERE naive_bayes.kategori = 'Politik' AND id_doc_uji = ".$i);
		$c = mysql_num_rows($selectPol);
		$vmapPol = 1;
		while ($sPol = mysql_fetch_array($selectPol)) {
			$iPol = $sPol['id'];
			$kPol = $sPol['term'];
			$pwkPol = $sPol['pwk'];

			
			foreach ((array)$pwkPol as $key => $val) {
				$val;	
				$vmapPol = $vmapPol * $val;
			}
			$Hasil = $vmapPol * $pvjPol;
			// echo "$iPol |<br>";
			// echo "Hasil value asal = $val<br>";
			// echo "hasil kali value = $vmapPol<br>";
			// echo "hasil akhir = $Hasil<br>";
		}
		echo "$iPol | $kPol >< $vmapPol * $pvjPol = $Hasil<br>";
	}

	




	
	// $nilai = array(1,2,3,4,5,6,7,8,9,10);
	// $pPol = 0.178571;
	// $result = 1;

	// foreach ($nilai as $key) {
	// 	$result = $result * $key;
	// }
	// echo $result * $pPol;	
?>