<?php
	$conn = mysql_connect("localhost","root","");
	if (!$conn) die ("Koneksi gagal");
	mysql_select_db("db_berita",$conn) or die ("Database tidak ditemukan");

	include('../simple_html_dom.php');

	class GrabFromDB {
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

	$newItem = new GrabFromDB;
	$selSumber = mysql_query("SELECT * FROM url");
	while ($rowSumber = mysql_fetch_array($selSumber)) {
		$url = $rowSumber['link'];
		$sumber = $rowSumber['sumber'];

		$html = file_get_html($url);
		if(!$html){
		// continue;
		}
		else
		{
			if ($sumber == "detik.com") { 
				foreach($html->find('article') as $element) {	                
		            // Parse the news item's title.
		            foreach ($element->find('.jdl') as $title) {
		                $newItem->set_title($title->innertext);
		                $judul = $newItem->get_title(); 
		            }
		            foreach ($element->find('.detail_text') as $text) {
		            	$newItem->set_description($text->innertext);
		            	$term = $newItem->get_description();    
		            }
		        }
		        echo "$judul<br><br>";
		        echo "$term";
			}
			elseif ($sumber == "viva.co.id") {
				foreach($html->find('article') as $element) {	 // bener semua yg viva               
		            // Parse the news item's title.
		            foreach ($element->find('.title') as $title) {
		                $newItem->set_title($title->innertext);
		                $judul = $newItem->get_title(); 
		            }
		            foreach ($element->find('span') as $text) {
		            	$newItem->set_description($text->innertext);
		            	$term = $newItem->get_description();    
		            }
		        }
		        echo "<b>$judul<br><br></b>$term";
			}
			elseif ($sumber == "kompas.com") {
				foreach($html->find('.kcm-read') as $element) {	  //bener semua yg kompas              
		            // Parse the news item's title.
		            foreach ($element->find('h2') as $title) {
		                $newItem->set_title($title->innertext);
		                $judul = $newItem->get_title(); 
		            }
		            foreach ($element->find('.kcm-read-text') as $text) {
		            	$newItem->set_description($text->innertext);
		            	$term = $newItem->get_description();    
		            }
		        }
		        echo "$judul<br><br>";
		        echo "$term";
			}
			elseif ($sumber == "liputan6.com") {
				foreach($html->find('.inner-container-article') as $element) {	                
		            // Parse the news item's title.
		            foreach ($element->find('h1') as $title) {
		                $newItem->set_title($title->innertext);
		                $judul = $newItem->get_title(); 
		            }
		            foreach ($element->find('.article-content-body__item-content p') as $text) {
		            	$newItem->set_description($text->innertext);
		            	$term = $newItem->get_description();    
		            }
		        }
		        echo "$judul<br><br>";
		        echo "$term";
			}
			elseif ($sumber == "tribunnews.com") {
				foreach($html->find('.pos_rel') as $element) {	  // sudah benar              
		            // Parse the news item's title.
		            foreach ($element->find('h1') as $title) {
		                $newItem->set_title($title->innertext);
		                $judul = $newItem->get_title(); // sudah benar
		            }
		            foreach ($element->find('.side-article txt-article') as $text) {
		            	$newItem->set_description($text->innertext);
		            	$term = $newItem->get_description();    
		            }
		        }
		        echo "$judul<br><br>";
		        echo "$term";
			}	
		}
	}
?>