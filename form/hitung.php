<?php
	include('../simple_html_dom.php');
	include('preprocessing.php');
	require ('stem.php');
	$conn = mysql_connect("localhost", "root", "");
	$database = mysql_select_db("db_berita",$conn);

	session_start();
	// $url = $_POST['url'];

	class htmlDOM {
	    var $title;
	    var $description;
	    var $sourceurl;

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
	}

	$newItem = new htmlDOM;
	$parsedNews = array();
	// $html = file_get_html("http://news.detik.com/read/2016/07/25/105950/3260305/10/menanti-eksekusi-mati-freddy-pencopet-yang-jadi-gembong-narkoba-kelas-wahid");
	// $html = file_get_html("http://otomotif.news.viva.co.id/news/read/834386-apes-mobil-sport-masuk-got-saat-dites-calon-pembeli");
	$html = file_get_html("http://nasional.kompas.com/read/2016/08/02/06571811/megawati.di.sekitar.jokowi.?utm_source=WP&utm_medium=box&utm_campaign=Kpopwp");
	// $html = file_get_html("http://showbiz.liputan6.com/read/2567567/kata-ibunda-tentang-kekasih-mike-mohede?medium=Headline&amp;campaign=Headline_click_5");
	// $html = file_get_html("http://www.tribunnews.com/superskor/2016/08/04/barcelona-permalukan-juara-liga-inggris");
	if(!$html){
		// continue;
	}
	else
	{
		// if ($html == "detik.com") { 
			// foreach($html->find('article') as $element) {	                
	  //           // Parse the news item's title.
	  //           foreach ($element->find('.jdl') as $title) {
	  //               $newItem->set_title($title->innertext);
	  //               $judul = $newItem->get_title(); 
	  //           }
	  //           foreach ($element->find('.detail_text') as $text) {
	  //           	$newItem->set_description($text->innertext);
	  //           	$term = $newItem->get_description();    
	  //           }
	  //       }
	  //       echo "$judul<br><br>";
	  //       echo "$term";
		// }
		// elseif ($html == "viva.co.id") {
			// foreach($html->find('article') as $element) {	 // bener semua yg viva               
	  //           // Parse the news item's title.
	  //           foreach ($element->find('.title') as $title) {
	  //               $newItem->set_title($title->innertext);
	  //               $judul = $newItem->get_title(); 
	  //           }
	  //           foreach ($element->find('span') as $text) {
	  //           	$newItem->set_description($text->innertext);
	  //           	$term = $newItem->get_description();    
	  //           }
	  //       }
	  //       echo "<b>$judul<br><br></b>$term";
		// }
		// elseif ($html == "kompas.com") {
			// foreach($html->find('.kcm-read') as $element) {	  //bener semua yg kompas              
	  //           // Parse the news item's title.
	  //           foreach ($element->find('h2') as $title) {
	  //               $newItem->set_title($title->innertext);
	  //               $judul = $newItem->get_title(); 
	  //           }
	  //           foreach ($element->find('.kcm-read-text') as $text) {
	  //           	$newItem->set_description($text->innertext);
	  //           	$term = $newItem->get_description();    
	  //           }
	  //       }
	  //       echo "$judul<br><br>";
	  //       echo "$term";
		// }
		// elseif ($html == "liputan6.com") {
			// foreach($html->find('.inner-container-article') as $element) {	                
	  //           // Parse the news item's title.
	  //           foreach ($element->find('h1') as $title) {
	  //               $newItem->set_title($title->innertext);
	  //               $judul = $newItem->get_title(); 
	  //           }
	  //           foreach ($element->find('.article-content-body__item-content p') as $text) {
	  //           	$newItem->set_description($text->innertext);
	  //           	$term = $newItem->get_description();    
	  //           }
	  //       }
	  //       echo "$judul<br><br>";
	  //       echo "$term";
		// }
		// elseif ($html == "tribunnews.com") {
			// foreach($html->find('.pos_rel') as $element) {	  // sudah benar              
	  //           // Parse the news item's title.
	  //           foreach ($element->find('h1') as $title) {
	  //               $newItem->set_title($title->innertext);
	  //               $judul = $newItem->get_title(); // sudah benar
	  //           }
	  //           foreach ($element->find('.side-article txt-article') as $text) {
	  //           	$newItem->set_description($text->innertext);
	  //           	$term = $newItem->get_description();    
	  //           }
	  //       }
	  //       echo "$judul<br><br>";
	  //       echo "$term";
		// }	
    }

  //   $ir = new Preprocessing();
  //   $stem = new Stem();

  //   $term = strip_tags($term);
  //   $data = $ir->casefolding($term);
    
  //   foreach ($data as $keyCase => $valCase) {
  //   	$data[$keyCase] = $valCase;
  //   	foreach ($ir->tokenizing($valCase) as $keyToken => $valToken) {
		// 	$data[$keyToken] = $valToken;
		// 	foreach ($ir->filtering($valToken) as $keyFilter => $valFilter) {
		// 		$data[$keyFilter] = $valFilter;
		// 		$hasil_stem = $stem->stemming($data[$keyFilter]);
		// 		// echo $hasil_stem."<br>";
		// 		$tf = $ir->tf_idf($hasil_stem);
		// 		$bobot = $ir->hitungBobot();
		// 	}
		// }
  //   }
?>