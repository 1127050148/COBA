<?php
//bangun koneksi ke database server MySQL
$con = mysql_connect("localhost","root","");
 
//pilih database dbstbi
mysql_select_db("db", $con);    
 
//query semua record dalam tabel tbberita
$result = mysql_query("SELECT * FROM berita_baru WHERE id_berita_baru = 1");
 
//proses setiap record, satu demi satu
while($row = mysql_fetch_array($result)) {
    $berita = $row['isi_berita'];
     
    //tampilkan berita  
    print("<hr />Berita asli: <br />" . $berita);
     
    //ubah ke huruf kecil   
    $berita = strtolower($berita);
     
    //hilangkan beberapa tanda baca
    $berita = str_replace("'", " ", $berita);
 
    $berita = str_replace(";", " ", $berita);           
    $berita = str_replace(",", " ", $berita);           
    
    $berita = explode("\t", $berita);   
    print("<br /><br />Setelah Explode :<br />" .  $berita);

    // //daftar stop list    
    // $astoplist = array ("yang", "juga", "dari", "dia", "kami", "kamu", "ini", "itu", 
    //                            "atau", "dan", "tersebut", "pada", "dengan", "adalah", "yaitu"); 
 
    // //hapus term yang sama dengan stop word
    // foreach ($astoplist as $i => $value) {
    // $berita = str_replace($astoplist[$i], "", $berita);
    // } //end foreach
     
    // $berita = trim($berita); 
    // $berita = explode("\t", $berita);   
    // print("<br /><br />Setelah stop word removal:<br />" .  $berita);
     
    // //query daftar stem dalam tabel tbstem  
    // $restem = mysql_query("SELECT * FROM kata_dasar ORDER BY id_katadasar");
     
    // //ganti setiap term ke bentuk stemnya
    // while($rowstem = mysql_fetch_array($restem)) {              
    //     $berita = str_replace($rowstem['Term'], $rowstem['Stem'], $berita);
    // }               
     
    // print("<br />Setelah stemming:<br />" .  $berita);
} //end while   
print("<hr />");
?>