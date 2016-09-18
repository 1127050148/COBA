<?php
	include('simple_html_dom.php');
	$conn = mysql_connect("localhost", "root", "");
	$database = mysql_select_db("db",$conn);
	
	class htmlDOM {
	    var $image;
	    var $fechanoticia;
	    var $title;
	    var $description;
	    var $sourceurl;
        var $text;
        var $convertToLower;

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

        function clear(){
            $this->text='';
            $this->processed=FALSE;
            $this->removeStopWords=TRUE;
            $this->convertToLower=FALSE;
        }

        function process(){
            $this->cleanText();
            $this->processed = TRUE;
        }

        function getText(){
            return $this->text;
        }

        function setText($text){
            $this->text = $text;
        }
    }

	$html = file_get_html('http://localhost/COBA/parkir.php');
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
                $judul = $newItem->get_title(); //echo $judul."<br /><br>";
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
            	// $term = str_replace("/^\s*/", " ", $term);
            	// $term = str_replace("/\s*$/", " ", $term);
            	$term = strtolower($term); 
             //    // $query = mysql_query("INSERT INTO coba VALUES ('','$term')");

            	// //menghilangkan tanda baca
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
                $term = str_replace('"', "", $term); 

                // $term = explode(" ", $term);
                // echo $term."<br /><br />";

                
                //Hapus stoplist
                $query = mysql_query("SELECT * from stopword");
                while ($daftar=mysql_fetch_array($query)) {
                    $stoplist = $daftar['daftar'];
                    $term = str_replace($stoplist, "", $term);
                } //echo $term;
                $pecah = strtok($term, " ");
                while ($pecah) {
                    echo "<br><br> $pecah";
                    $pecah = strtok("");
                }
            }
        }
    }
?>