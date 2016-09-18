<?php
	include('simple_html_dom.php');

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

	
// class News {
//     var $image;
//     var $fechanoticia;
//     var $title;
//     var $description;
//     var $sourceurl;

//     function get_image( ) {
//         return $this->image;
//     }

//     function set_image ($image, $new_image) {
//         $image->src = $new_image;
//     }

//     function get_fechanoticia( ) {
//         return $this->fechanoticia;
//     }

//     function set_fechanoticia ($new_fechanoticia) {
//         $this->fechanoticia = $new_fechanoticia;
//     }

//     function get_title( ) {
//         return $this->title;
//     }

//     function set_title ($new_title) {
//         $this->title = $new_title;
//     }

//     function get_description( ) {
//         return $this->description;
//     }

//     function set_description ($new_description) {
//         $this->description = $new_description;
//     }

//     function get_sourceurl( ) {
//         return $this->sourceurl;
//     }

//     function set_sourceurl ($new_sourceurl) {
//         $this->sourceurl = $new_sourceurl;
//     }
// }

	$query = "SELECT * FROM berita"; 
	$result = mysql_query($query); 
    while($data=mysql_fetch_array($result))
    {
    	$sourcelink = $data['link']; //sudah benar

    	$html = file_get_html($sourcelink);

    	if (!$html) {
    		continue;
    	}
    	else
    	{
    		$parsedNews = array();
            foreach($html->find('div .kcm-read') as $element) 
            {
                // $newItem = new News;
                foreach($html->find('img') as $image) 
                
                foreach ($html->find('div .kcm-read-text p') as $artikel) 
                
                // foreach ($html->find('div .clearfix kcm-date msmall grey') as $date)

                $update = mysql_query("UPDATE berita set isi_berita='".$artikel."', sumber='Kompas.com' where link='".$sourcelink."'");
                if($update) 
                   echo "Berhasil Update";
                else
                    echo "Gagal Update";
            }
            echo "<br />";
    	}
		
		// //persiapkan array untuk diambil datanya
		// $data = array();
		// foreach ($link as $val)
		// {
		// 	$data[] = array(
		// 			"isi_berita" => $link->item($no)->nodeValue
		// 		);
		// 	$no++;
		// }
		// foreach ($data as $val) {
		// 	$input = mysql_query("UPDATE berita set ('','','$val[isi_berita]','','Kompas.com','','$val[jumlah]')");
		// 	$no++;
		// }
		// if($input)
		// 	echo "Tersimpan!!!!";
		// else
		// 	echo "Gagal menyimpan!!!";
    }
?>