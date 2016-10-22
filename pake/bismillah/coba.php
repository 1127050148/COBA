<?php
	$conn = mysql_connect("localhost","root","");
	if (!$conn) die ("Koneksi gagal");
	mysql_select_db("db_berita",$conn) or die ("Database tidak ditemukan");

	// $query = mysql_query("SELECT update_bobotuji.term AS termUji, update_bobotuji.id_doc AS idUji,
	// 					update_bobotuji.bobot AS bobotUji,
	// 					update_bobotlatih.term AS termLatih, update_bobotlatih.id_doc AS idLatih,
	// 					update_bobotlatih.bobot AS bobotLatih FROM update_bobotuji
	// 					JOIN update_bobotlatih on update_bobotuji.term = update_bobotlatih.term
	// 					ORDER BY update_bobotuji.id_doc ASC");

	// // insert ke tabel cosine
	// while ($row = mysql_fetch_array($query)) {
	// 	$rowTermLatih = $row['termLatih'];
	// 	$rowIDLatih = $row['idLatih'];
	// 	$rowBobotLatih = $row['bobotLatih'];
	// 	$rowTermUji = $row['termUji'];
	// 	$rowIDUji = $row['idUji'];
	// 	$rowBobotUji = $row['bobotUji'];

	// 	$qCosine = mysql_query("SELECT * FROM cosine WHERE term_uji = '".$rowTermUji."' AND id_doc_uji = '".$rowIDUji."'");
	// 	$cCosine = mysql_num_rows($qCosine);
	// 	if ($cCosine > 0) {
	// 		echo "";
	// 	}
	// 	else {
	// 		mysql_query("INSERT INTO cosine VALUES ('','".$rowTermUji."',".$rowIDUji. ", '".$rowBobotUji."', '".$rowTermLatih."',
	// 					".$rowIDLatih.", '".$rowBobotLatih."', '')");
	// 	}
	// }

	// // perkalian data W-uji dengan semua bobot W dokumen
	// $selectJumData = mysql_query("SELECT * FROM cosine");
	// while ($jumData = mysql_fetch_array($selectJumData)) {
	// 	$id = $jumData['id_cos'];
	// 	$dBobotUji = $jumData['bobot_dok_uji'];
	// 	$dBobotLatih = $jumData['bobot_dok_latih'];

	// 	$wPerDok = $dBobotUji * $dBobotLatih;
	// 	mysql_query("UPDATE cosine SET bobot_kali_dok = '".$wPerDok."' WHERE id_cos = '".$id."'");
	// }

	// // hitung semua penjumlahan dari data uji dan latih
	// $aa = array();
	// $bobot = array();
	// $id = array();

	// $selectCosine = mysql_query("SELECT * FROM cosine");
	// while ($y = mysql_fetch_array($selectCosine)) {
	// 	$id = $y['id_doc_uji'];

	// 	for ($i=1; $i <= 30; $i++) { 
	// 		for ($j=1; $j <= 30; $j++) { 
	// 			$l = mysql_query("SELECT SUM(bobot_kali_dok) AS jum FROM cosine WHERE id_doc_uji = $i AND id_doc_latih = $j");
	// 			while ($k = mysql_fetch_array($l)) {
	// 				$bobot = $k['jum'];

	// 				mysql_query("UPDATE cosine SET jum_bobot_kali_dok = '".$bobot."' WHERE id_doc_uji = '".$i."' AND id_doc_latih = '".$j."'");
	// 				// echo "$i.$j = $bobot<br>";
	// 			}
	// 		}
			
	// 	}
	// }

	// // bagian bobot data latih
	// $queryVektorLatih = mysql_query("SELECT * FROM update_bobotlatih");
	// while ($latih = mysql_fetch_array($queryVektorLatih)) {
	// 	$termLatih = $latih['term'];
	// 	$idLatih = $latih['id_doc'];
	// 	$bobotLatih = $latih['bobot'];
	// 	// perkalian untuk panjang vektor dari tiap bobot
	// 	$hasilKaliVektor = $bobotLatih * $bobotLatih;
	// 	mysql_query("UPDATE update_bobotlatih SET bobot_vektor = '".$hasilKaliVektor."' WHERE term = '".$termLatih."' AND id_doc = '".$idLatih."'");
	// }

	// $jumDocLatih = mysql_query("SELECT id_doc, SUM(bobot_vektor) AS bobot_kuadrat FROM update_bobotlatih GROUP BY id_doc");
	// while ($aa = mysql_fetch_array($jumDocLatih)) {
	// 	$id = $aa['id_doc'];
	// 	$bobot = $aa['bobot_kuadrat'];
	// 	$sqrtBobotLatih = sqrt($bobot);
	// 	echo "$id : $bobot : $sqrtBobotLatih <br>";
	// 	mysql_query("UPDATE update_bobotlatih SET sum_bobot_vektor = '".$bobot."', akar_bobot_vektor = '".$sqrtBobotLatih."' WHERE id_doc = '".$id."'");
	// }

	// echo "<br><br>";
	// // bagian bobot data uji
	// $queryVektorUji = mysql_query("SELECT * FROM update_bobotuji ");
	// while ($uji = mysql_fetch_array($queryVektorUji)) {
	// 	$termUji = $uji['term'];
	// 	$idUji = $uji['id_doc'];
	// 	$bobotUji = $uji['bobot'];
	// 	// perkalian untuk panjang vektor dari tiap bobot
	// 	$hasilKaliVektorUji = $bobotUji * $bobotUji;
	// 	mysql_query("UPDATE update_bobotuji SET bobot_vektor = '".$hasilKaliVektorUji."' WHERE term = '".$termUji."' AND id_doc = '".$idUji."'");
	// }
	
	// $jumDocUji = mysql_query("SELECT id_doc,SUM(bobot_vektor) AS bobot_kuadratUji FROM update_bobotuji GROUP BY id_doc");
	// while ($bb = mysql_fetch_array($jumDocUji)) {
	// 	$id_uji = $bb['id_doc'];
	// 	$bobot_uji = $bb['bobot_kuadratUji'];
	// 	$sqrtBobotUji = sqrt($bobot_uji);
	// 	echo "$id_uji : $bobot_uji : $sqrtBobotUji <br>";
	// 	mysql_query("UPDATE update_bobotuji SET sum_bobot_vektor = '".$bobot_uji."', akar_bobot_vektor = '".$sqrtBobotUji."' WHERE id_doc = '".$id_uji."'");
	// }


	// // hitung cosine similarity
	// $cos = array();
	// for ($i=1; $i <= 30 ; $i++) { 
	// 	$selDataUji = mysql_query("SELECT akar_bobot_vektor FROM update_bobotuji WHERE id_doc = '".$i."' GROUP BY id_doc");
	// 	while ($w = mysql_fetch_array($selDataUji)) {
	// 		$akarVektorUji = $w['akar_bobot_vektor'];

	// 		for ($j=1; $j < 30; $j++) { 

	// 			$selDataLatih = mysql_query("SELECT akar_bobot_vektor FROM update_bobotlatih WHERE id_doc = '".$j."' GROUP BY id_doc");
	// 			while ($r = mysql_fetch_array($selDataLatih)) {
	// 				$akarVektorLatih = $r['akar_bobot_vektor'];
	// 				// echo "$akarVektorUji ---- $akarVektorLatih<br> ";

	// 				$selJum = mysql_query("SELECT DISTINCT jum_bobot_kali_dok AS bobot FROM cosine WHERE id_doc_uji = '".$i."' AND id_doc_latih = '".$j."'");
	// 				$dt = mysql_fetch_array($selJum);
	// 				$jum_bobot = $dt['bobot'];

	// 				$cos = $jum_bobot / ($akarVektorUji * $akarVektorLatih);
	// 				echo "Cos(D$i,D$j) : $jum_bobot / ($akarVektorUji * $akarVektorLatih) = $cos <br>";
	// 				mysql_query("UPDATE cosine SET similarity = '".$cos."' WHERE id_doc_uji = ".$i." AND id_doc_latih = ".$j);
	// 			}
	// 		}
	// 	}	
	// }

	$k = 9;
	$dKat = array();
	
	for ($docUji=1; $docUji < 30; $docUji++) {
	// $seljum = mysql_query("SELECT id_doc_uji FROM cosine");
	// while ($rowcount = mysql_fetch_array($seljum)) {
	// 	$docUji = $rowcount['id_doc_uji'];

		$selDataCosine = mysql_query("SELECT id_kategori, count(id_kategori) as jum from(SELECT id_kategori FROM cosine 
									WHERE id_doc_uji = $docUji GROUP BY id_doc_latih  ORDER BY similarity DESC LIMIT $k) as xxx 
									GROUP BY id_kategori  ORDER BY jum DESC");
		while ($rCos = mysql_fetch_array($selDataCosine)) {
			$freq = $rCos['jum'];
			$dKat = $rCos['id_kategori'];
			foreach ((array)$freq as $value) {
				$pilih = max(array($value));
			}
			echo "----$pilih----<br>";

			// for ($j=0; $j < 10; $j++) { 
			// 	$count[$j] = 0;
			// 	for ($k=0; $k < $k; $k++) { 
			// 		if ($dKat[$j] == $dKat[$k]) {
			// 			$count[$j] = $count[$j]+1;
			// 		}
			// 	}
			// }
			// $indeks = 0;
			// $modus = 0;
			// for ($l=0; $l < 10; $l++) { 
			// 	if ($modus < $count[$l]) {
			// 		$modus = $count[$l];
			// 		$indeks = $l;
			// 	}
			// }
			// echo "Modus = <b>".$dKat[$indeks]."</b> dengan frekuensi = <b>".$modus." </b> kali<br>";

			// $freq = array();
			// for ($i=0; $i < count($dKat); $i++) { 
			// 	if (isset($freq[$dKat[$i]]) == FALSE) {
			// 		$freq[$dKat[$i]] = 1;
			// 	}
			// 	else {
			// 		$freq[$dKat[$i]]++;
			// 	}
			// }
			// $max = array_keys($freq, max($freq));
			// for ($i=0; $i < count($max); $i++) { 
			// 	// echo "nilai modus =" .$max[$i];
			// 	echo '<br/>';
			// }

		}
		echo "<br>";
	}
	echo "<br>";
?>