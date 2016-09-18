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
	$bacaHTML = bacaHTML('http://www.detik.com');

	//Membuat dom dokumen
	$dom = new DomDocument();

	//Mengambil html dari Kompas untuk di parse
	@$dom->loadHTML($bacaHTML);

	//Nama class yang akan dicari
	$classname = "box_pop";

	//mencari class memakai dom query
	$finder = new DomXPath($dom);
	$spaner = $finder->query("//*[contains(@class, '$classname')]");

	//mengambil data dari class pertama
	$span = $spaner->item(0);

	//dari class pertama mengambil 2 elemen yaitu a yang menyimpan judul dan link dan span yang menyimpan tanggal
	$link = $span->getElementsByTagName('a');

	$no=0;

	//persiapkan array untuk diambil datanya
	$data = array();
	foreach ($link as $val)
	{
		$data[] = array(
				"link" => $link->item($no)->getAttribute('href')
			);
		$no++;
	}
?>
<style>
	table,th,td
	{
		border: 1px solid #000;
		font-size: 12px;
	}
</style>
<h2>Belajar Grabbing Berita Kompas</h2>
<table>
	<thead>
		<th>No</th>
		<th>Link</th>
	</thead>
	<tbody>
		<?php
			$no=1;
			foreach ($data as $val) 
			{
				?>
				<tr>
					<td><?php echo $no;?></td>
					<td><?php echo $val['link'];?></td>
				</tr>
				<?php
				$no++;
			}
		?>
	</tbody>
</table>