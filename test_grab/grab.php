<?php
     include "simple_html_dom.php";
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

     class News 
     {
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

     // function bacaHTML($url)
     // {
     //      // inisialisasi CURL
     //      $data = curl_init();
     //      // setting CURL
     //      curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
     //      curl_setopt($data, CURLOPT_URL, $url);
     //      // menjalankan CURL untuk membaca isi file
     //      $hasil = curl_exec($data);
     //      curl_close($data);
     //      return $hasil;
     // }

     while (1)
     {
          $query = "SELECT COUNT(*) as jum from berita where isi_berita=0 and sumber=0 and tanggal=0";
          $result = mysql_query($query);
          $data= mysql_fetch_assoc($result);

          if ($data['jum']>0)
          {
               $select = "SELECT * from berita where isi_berita=0 and sumber=0 and tanggal=0 order by id_berita asc";
               $rows = mysql_query($select);
               while($row = mysql_fetch_array($rows))
               {
                    $sourcelink = $row['link'];
                    $id = $row['id_berita'];
                    $name = isset($row['judul_berita']) ? $name['judul_berita'] : '';

                    $html = file_get_html($sourcelink);
                    if(!$html)
                    {
                         continue;
                    }
                    else
                    {
                         $parsedNews = array();
                         foreach($html->find('.entry') as $element) 
                         {
                              $newItem = new News;
                              foreach ($element->find('.lazy') as $image) 
                              {
                                  $property = 'data-original';
                                  $image->removeAttribute('class');
                                  $newItem->set_image($image , $image->$property);
                                  //echo $newItem->get_image() . "<br />";
                                  $linkgambar = $image->$property;
                              }
                              foreach ($element->find('.xc_pin') as $link)
                              {
                                  $link->outertext = '';
                              }
                          
                              // Parse the news item's title.
                              foreach ($element->find('h1 a') as $title) 
                              {
                                  $newItem->set_title($title->innertext);
                                  $judul = $newItem->get_title();
                              }

                              foreach ($element->find('h1') as $link) 
                              {
                                  $link->outertext = '';
                              }

                              foreach ($element->find('.ezAdsense') as $link) 
                              {
                                  $link->outertext = '';
                              }

                              foreach ($element->find('.addtoany_share_save_container') as $link) 
                              {
                                  $link->outertext = '';
                              }

                              foreach ($element->find('.meta') as $link) 
                              {
                                  $link->outertext = '';
                              }

                              foreach ($element->find('comment') as $link) 
                              {
                                  $link->outertext = '';
                              }
                              $artiketl = str_ireplace('www.kompas.com</p>', '</p>', $element->innertext);
                              $artiketl = str_ireplace('kompas.com</p>', '</p>', $artiketl);
                              //echo $artiketl;
                              $a=array(1,2,3,4,5,6,7,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21);
                              $random_keys=array_rand($a,2);
                              $author = $a[$random_keys[0]];
                              $tanggalposting = date('Y-m-d H:i:s');
                              $insert = "INSERT INTO berita (id_berita,judul_berita,isi_berita,link,sumber,tanggal,jumlah) VALUES ('','','".$artiketl."','','Kompas.com','".$tanggalposting."','')";

                              mysql_query($insert) or die ("tidak dapat memasukkan data ke tabel"); 
                              //mysql_query("UPDATE article_url SET flag=1 WHERE urlid=".$id);
                              echo $id.' - ';
                          }
                    }
               }
          }
     }



     // $no=0;
     // $sql=mysql_query("select * from berita");
     // while ($data=mysql_fetch_array($sql))
     // {
     // 	$kodeHTML =  bacaHTML('$data[link]');
     	
     // 	$pecah = explode('<div class="kcm-read-text-wrap">', $kodeHTML);
     // 	$pecahLagi = explode('</table>', $pecah[1]);
     // 	echo $pecahLagi[0];
     // 	$no++;
?>
