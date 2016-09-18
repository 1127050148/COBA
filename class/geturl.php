<?php
	/**
	* 
	*/
	class GetUrl
	{
		var $feed;
		// function __construct(argument)
		// {
		// 	# code...
		// }
		function GetUrl($feed)
		{
			$this->feed = $feed;
		}

		function parse()
		{
			$rss = simplexml_load_file($this->feed);
			$rss_split = array();

			foreach ($rss->channel->item as $item)
			{
				$title = (string) $item->title; //Judul
				$link = (string) $item->link; //Link
				$description = (string) $item->description; //Deskripsi
				$rss_split[] = '
					<div>
        				<a href="'.$link.'" target="_blank" title="" >
            				'.$title.'
        				</a>
            			<hr>
        			</div>
				';
    		}
  			return $rss_split;
  		}

  	// 	function insert()
  	// 	{
			// $host = "localhost";
			// $user = "root";
			// $password = "";
			// $database_name = "db_berita";
			// $pdo = new PDO("mysql:host=$host;dbname=$database_name", $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

			// try {
			// 	$sql= $pdo->prepare("INSERT INTO berita values (:id, :judul, :isi, :link, :sumber, :tgl, :jumlah)");
			// 	$input = array(':id'=>'', ':judul'=>$judul, ':isi'=>'', ':link'=>'', ':sumber'=>'detik.com', 'tgl'=>'', ':jumlah'=>'');
				
			// 	$query->execute($input);
			// 	echo "Tersimpan";
			// } catch (PDOException $e) {
			// 	echo "Gagal";
			// }
  	// 	}

		function display($numrows,$head)
  		{
		    $rss_split = $this->parse();
		    $i = 0;
		    $rss_data = '
		             <div class="kotak-berita">
		           <div class="judul">
		         '.$head.'
		           </div>
		         <div class="link-feed">';
  			while ( $i < $numrows )
		    {
		      $rss_data .= $rss_split[$i];
		      $i++;
		    }
		    $trim = str_replace('', '',$this->feed);
		    $user = str_replace('&lang=en-us&format=rss_200','',$trim);
  
		    $rss_data.='</div></div>';
      
    		return $rss_data;
  		}
	}
?>