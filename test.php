<?php

$conn = mysql_connect("localhost", "root", "");
	$database = mysql_select_db("db",$conn);

function bacaHTML($url){
     // inisialisasi CURL
     $data = curl_init();
     // setting CURL
     curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
     curl_setopt($data, CURLOPT_URL, $url);
     // menjalankan CURL untuk membaca isi file
     $hasil = curl_exec($data);
     curl_close($data);
     return $hasil;
}

$kodeHTML =  bacaHTML('http://localhost/COBA/parkir.php');
$pecah = explode('<div class="kcm-read-text">', $kodeHTML);

$pecahLagi = explode('</p>', $pecah[1]);

$term = strtolower($pecahLagi[0]);
$term = strip_tags($term);

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

                $query = mysql_query("INSERT INTO coba VALUES ('','$term')");
 
 // $pecah = strtok($term, " ");
 //                while ($pecah) {
 //                    echo "<br><br> $pecah";
 //                    $pecah = strtok("");
 //                }

// $query = mysql_query("SELECT * from stopword");
//                 while ($daftar=mysql_fetch_array($query)) {
//                     $stoplist = $daftar['daftar'];

//                     if ($stoplist==$term) {
//                     	 $term = str_replace($stoplist, "", $term);
//                     }
                    
//                 } echo $term."<br>";

?>
