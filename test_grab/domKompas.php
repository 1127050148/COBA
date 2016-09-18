<?xml version="1.0" encoding="UTF-8"?>
<?php
	//database
	$conn = mysql_connect("localhost", "root", "");
	if ($conn)
		echo "Terhubung <br />";
	else
		echo "Gagal Terhubung <br />";
	$database = mysql_select_db("db_berita",$conn);
	if($database)
		echo "Terkoneksi ke database <br />";
	else
		echo "Gagal mengambil database <br />";
	function bacaHTML($url)
	{
		//inisialisasi CURL
		$data = curl_init();

		//setting CURL
		curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($data, CURLOPT_URL, $url);

		//menjalankan CURL untuk membaca isi file
		$hasil = curl_exec($data);
		curl_close($data);
		return $hasil;
	}

	//Mengambil data dari Kompas
	$bacaHTML = bacaHTML('http://www.kompas.com');

	//Membuat dom dokumen
	$dom = new DomDocument();

	//Mengambil html dari Kompas untuk di parse
	@$dom->loadHTML($bacaHTML);

	//Nama class yang akan dicari
	$classname = "most__wrap clearfix";

	//mencari class memakai dom query
	$finder = new DomXPath($dom);
	$spaner = $finder->query("//*[contains(@class, '$classname')]");

	//mengambil data dari class pertama
	$span = $spaner->item(0);

	//dari class pertama mengambil 2 elemen yaitu a yang menyimpan judul dan link dan span yang menyimpan tanggal
	$link = $span->getElementsByTagName('a');
	$jumlah = $span->getElementsByTagName('span');

	$no=0;

	//persiapkan array untuk diambil datanya
	$data = array();
	foreach ($link as $val)
	{
		$data[] = array(
				"judul" => $link->item($no)->nodeValue,
				"link" => $link->item($no)->getAttribute('href'),
				"jumlah" => $jumlah->item($no)->nodeValue
			);
		$no++;
	}
	foreach ($data as $val) {
			$input = mysql_query("INSERT INTO berita values ('','$val[judul]','','$val[link]','','','$val[jumlah]')");
			$no++;
		}
		if($input)
			echo "Tersimpan!!!!";
		else
			echo "Gagal menyimpan!!!";
?>