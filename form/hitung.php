<?php
	include('/../simple_html_dom.php');
	$conn = mysql_connect("localhost", "root", "");
	$database = mysql_select_db("db",$conn);

	session_start();
	$url = $_POST['url'];

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

	$html = file_get_html($url);
	if(!$html){
		continue;
	}
	else
	{
		$parsedNews = array();
		foreach($html->find('.kcm-read') as $element) {

			$newItem = new htmlDOM;
			// Parse the news item's thumbnail image.
            foreach ($element->find('src') as $image) {
                $property = 'img';
                $image->removeAttribute('class');
                $newItem->set_image($image , $image->$property);
                // echo $newItem->get_image() . "<br />";
                $linkgambar = $image->$property;
            }

            foreach ($element->find('href') as $link) {
                $link->outertext = '';
            }
                
            // Parse the news item's title.
            foreach ($element->find('h2') as $title) {
                $newItem->set_title($title->innertext);
                $judul = $newItem->get_title(); echo $judul."<br /><br>";
            }

            foreach ($element->find('h2') as $link) {
                $link->outertext = '';
            }

            foreach ($element->find('.meta') as $link) {
                $link->outertext = '';
            }

            foreach ($element->find('p') as $text) {
            	$newItem->set_description($text->innertext);
            	$term = $newItem->get_description();

            	$term = strip_tags($term);
            	$term = strtolower($term);

                //menghilangkan tanda baca
                $term = str_replace(".", "", $term);
                $term = str_replace(",", "", $term);
                $term = str_replace("'", "", $term);
                $term = str_replace("-", "", $term);
                $term = str_replace(")", "", $term);
                $term = str_replace("(", "", $term);
                $term = str_replace("\'", "", $term);
                $term = str_replace("/", "", $term);
                $term = str_replace("=", "", $term);
                $term = str_replace(":", "", $term);
                $term = str_replace("!", "", $term);
                $term = str_replace("?", "", $term);
                $term = str_replace("*", "", $term);
                $term = str_replace("&", "", $term);
                $term = str_replace("%", "", $term);
                $term = str_replace(";", "", $term);
                $term = str_replace("nbsp", "", $term);
                $term = str_replace("—", "", $term);

                //Hapus stoplist
                $query = mysql_query("SELECT * from stopword");
                while ($daftar=mysql_fetch_array($query)) {
                    $stoplist = $daftar['daftar'];

                    $term = str_replace($stoplist, " ", $term);
                } echo $term."<br><br>";
            }
        }
    }


	// function bacaHTML($url){
	//     // inisialisasi CURL
	//     $data = curl_init();
	//     // setting CURL
	//     curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
	//     curl_setopt($data, CURLOPT_URL, $url);
	//     // menjalankan CURL untuk membaca isi file
	//     $hasil = curl_exec($data);
	//     curl_close($data);
	//     return $hasil;
	// }
	// $kodeHTML = bacaHTML($url);
	// $pecah = explode('<kcm-read-text>', $kodeHTML);
	// $pecahLagi = explode('</div>', $pecah[1]);
	// echo $pecahLagi[0];
?>