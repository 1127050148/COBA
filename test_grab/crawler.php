<?php
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	// public function index()
	// {
	// 	// $this->load->view('vclassification');
	// }

	// function readHTML($url)
	// {
	// 	// inisialisasi CURL
	//     $data = curl_init();
	//     // setting CURL
	//     curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
	//     curl_setopt($data, CURLOPT_URL, $url);
	//     // menjalankan CURL untuk membaca isi file
	//     $hasil = curl_exec($data);
	//     curl_close($data);
	//     return $hasil;
	// }

	// // function striptag($text)
	// // {
		
	// // }

	// // fungsi token($hasil)
	// // {
	// 		// $pecah=explode("", $hasil);
	// 		// $kecil=strtolower($pecah);
	// // }

	// function tf($term)
	// {
		
	// }

	// function display()
	// {

	// }
	// $kodeHTML =  readHTML('http://localhost/COBA/parkir.php');
	// $pecah = explode('<div class="kcm-read-text">', $kodeHTML);
	// $pecahLagi = explode('<table class="grey">', $pecah[1]);
	// $hsl = strip_tags($pecahLagi[0]);

	// // echo $hsl;

	// //tokenisasi
	// $explode=explode(" ", $hsl);
	// $jum = count($explode);
	// for ($i=0; $i<$jum ; $i++) { 
	// 	$ex = $explode[$i];
	// 	$x = preg_replace("/[^A-Za-z0-9 ]/", " ", $ex);
	// 	$term = strtolower($x);

	// 	echo trim($term);
	// 	echo "<br>";
	// }


	include('simple_html_dom.php');
	// $conn = mysql_connect("localhost", "root", "");
	// $database = mysql_select_db("db",$conn);
	
	class htmlDOM {
	    var $image;
	    var $fechanoticia;
	    var $title;
	    var $description;
	    var $sourceurl;

	    function get_image( ) {
	        return $this->image;
	    }

	    function set_image ($image, $new_image) {
	        $image->src = $new_image;
	    }

	    function get_fechanoticia( ) {
	        return $this->fechanoticia;
	    }

	    function set_fechanoticia ($new_fechanoticia) {
	        $this->fechanoticia = $new_fechanoticia;
	    }

	    function get_title( ) {
	        return $this->title;
	    }

	    function set_title ($new_title) {
	        $this->title = $new_title;
	    }

	    function get_description( ) {
	        return $this->description;
	    }

	    function set_description ($new_description) {
	        $this->description = $new_description;
	    }

	    function get_sourceurl( ) {
	        return $this->sourceurl;
	    }

	    function set_sourceurl ($new_sourceurl) {
	        $this->sourceurl = $new_sourceurl;
	    }
	}

	$html = file_get_html('https://www.google.co.id/?gws_rd=ssl#q=fiqih+wanita');
	if(!$html){
		continue;
	}
	else
	{
		$parsedNews = array();
		foreach($html->find('.mw') as $element) {

			$newItem = new htmlDOM;
			// Parse the news item's thumbnail image.
            // foreach ($element->find('src') as $image) {
            //     $property = 'img';
            //     $image->removeAttribute('class');
            //     $newItem->set_image($image , $image->$property);
            //     // echo $newItem->get_image() . "<br />";
            //     $linkgambar = $image->$property;
            // }

            foreach ($element->find('href') as $link) {
                $link->outertext = '';
            }
                
            // // Parse the news item's title.
            // foreach ($element->find('h2') as $title) {
            //     $newItem->set_title($title->innertext);
            //     $judul = $newItem->get_title(); echo $title;
            // }

            // foreach ($element->find('h2') as $link) {
            //     $link->outertext = '';
            // }

            // foreach ($element->find('.meta') as $link) {
            //     $link->outertext = '';
            // }

            // foreach ($element->find('p') as $text) {
            // 	$newItem->set_description($text->innertext);
            // 	$term = $newItem->get_description();

            // 	//case folding
            // 	$striptag = strtolower(strip_tags($term));
            // 	$preg_replace = preg_replace("/[^A-Za-z0-9 ]/", "<br />", $striptag); echo $preg_replace;
            	
            	//tokenizing
            	// $strtok = array();
            	// $strtok = strtok($preg_replace, " "); echo $strtok;

            	// $i=0;
            	// while ($strtok) {
            	// 	$strtok;
            	// 	// $text = $i[$strtok];
            	// 	$strtok = strtok(" ");
            	// 	$i++;
            	// }

    //         	$query = mysql_query("SELECT * from stopword order by daftar asc");
    //         	while ($row = mysql_fetch_array($query)) {
				//     $stopword = $row['daftar'];
				//     $word = str_replace($stopword, " ", $strtok);
				//     echo $word;
				// }

				// $kalimat = ("hal ini terlihat dari pendapatan retribusi parkir di lokasi yang naik signifikan");
				// $stopword = array('hal', 'ini', 'dari', 'di', 'yang');
				// $jadi = str_replace($stopword, "", $kalimat);
				// echo $jadi;
            // }
        }
	}
?>