<?php
	include_once('simple_html_dom.php');
	
	//create html DOM from URL
	$detik = file_get_html('http://www.kompas.com');

	//Membuat dom dokumen
	$dom = new DomDocument();

	//Mengambil html dari Kompas untuk di parse
	@$dom->loadHTML($detik);

	//Nama class yang akan dicari
	$classname = "most__wrap clearfix";

	//mencari class memakai dom query
	$finder = new DomXPath($dom);
	$spaner = $finder->query("//*[contains(@id, '$classname')]");

	//mengambil data dari class pertama
	$span = $spaner->item(0);

	//dari class pertama mengambil 2 elemen yaitu a yang menyimpan judul dan link dan span yang menyimpan tanggal
	$link = $span->getElementsByTagName('div'); echo $link;
	// $tanggal = $span->getElementsByTagName('span');

	$no=0;

	//persiapkan array untuk diambil datanya
	$data = array();
	foreach ($link as $val)
	{
		$data[] = array(
				'judul' => $link->item($no)->nodeValue,
				'link' => $link->item($no)->getAttribute('href')
				'tanggal' => $tanggal->item($no)->nodeValue
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
		<th>Judul</th>
		<th>Link</th>
		<th>Tanggal</th>
	</thead>
	<tbody>
		<?php
			$no=1;
			foreach ($data as $val) 
			{
				?>
				<tr>
					<td><?php echo $no;?></td>
					<td><?php echo $val['judul'];?></td>
					<td><?php echo $val['link'];?></td>
					<td><?php echo $val['tanggal'];?></td>
				</tr>
				<?php
				$no++;
			}
		?>
	</tbody>
</table>
?>