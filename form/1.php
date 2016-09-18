<?php
	$all_token	= array();
	$freq_token	= array();
	$df_token	= array();
	$inv_index	= array();

	$stopword = file_get_contents("stopwords.txt");
	$stopword = preg_split("/[\s]+/", $stopword);

	$con = mysql_connect("localhost","root","");
	mysql_select_db("db", $con);    
	$result = mysql_query("SELECT * FROM berita_baru WHERE id_berita_baru = 1");
	while($row = mysql_fetch_array($result)) {
		$id = $row['id_berita_baru'];
		$id_link = $row['id_link'];
		$judul = $row['judul_berita'];
    	$berita = $row['isi_berita'];
    	$kategori = $row['kategori'];

    	echo $berita."<br /><br />";
    	$token = strtolower($berita);
    	$token = str_replace("'", " ", $berita);
    	$token = str_replace(";", " ", $berita);           
    	$token = str_replace(",", " ", $berita);

    	foreach ($stopword as $i => $value) {
    	 	$token = str_replace($stopword[$i], " ", $token);
    	}
    	$token = trim($token);
    	print("<br />Setelah stop word removal:<br />" .  $token);

    	$restem = mysql_query("SELECT * FROM kata_dasar ORDER BY id_katadasar");
    	while($rowstem = mysql_fetch_array($restem)) {              
        	$token = str_replace($token, $rowstem['katadasar'], $token);
    	}
    	echo "<br /><br />";      
    	print("<br />Setelah stemming:<br />" .  $berita);	
	}
	print("<hr />");
?>