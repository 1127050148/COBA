<?php
	$conn = mysql_connect("localhost","root","");
	if (!$conn) die ("Koneksi gagal");
	mysql_select_db("db_berita",$conn) or die ("Database tidak ditemukan");

	require 'stem.php';

	class PraprosesBaru
	{
		protected $this;
		private $stopwords2 = array("a", "about", "above", "acara", "across", "ada", "adalah", "adanya", "after", "afterwards", "again", "against", "agar", "akan", 
	        	"akhir", "akhirnya", "akibat", "aku", "all", "almost", "alone", "along", "already", "also", "although", "always", "am", "among", "amongst", 
	        	"amoungst", "amount", "an", "and", "anda", "another", "antara", "any", "anyhow", "anyone", "anything", "anyway", "anywhere", "apa", "apakah", 
	        	"apalagi", "are", "around", "as", "asal", "at", "atas", "atau", "awal", "b", "back", "badan", "bagaimana", "bagi", "bagian", "bahkan", "bahwa", 
	        	"baik", "banyak", "barang", "barat", "baru", "bawah", "be", "beberapa", "became", "because", "become", "becomes", "becoming", "been", "before", 
	        	"beforehand", "begitu", "behind", "being", "belakang", "below", "belum", "benar", "bentuk", "berada", "berarti", "berat", "berbagai", 
	        	"berdasarkan", "berjalan", "berlangsung", "bersama", "bertemu", "besar", "beside", "besides", "between", "beyond", "biasa", "biasanya", "bila", 
	        	"bill", "bisa", "both", "bottom", "bukan", "bulan", "but", "by", "call", "can", "cannot", "cant", "cara", "co", "con", "could", "couldnt", "cry", 
	        	"cukup", "dalam", "dan", "dapat", "dari", "datang", "de", "dekat", "demikian", "dengan", "depan", "describe", "detail", "di", "dia", "diduga", 
	        	"digunakan", "dilakukan", "diri", "dirinya", "ditemukan", "do", "done", "down", "dua", "due", "dulu", "during", "each", "eg", "eight", "either", 
	        	"eleven", "else", "elsewhere", "empat", "empty", "enough", "etc", "even", "ever", "every", "everyone", "everything", "everywhere", "except", 
	        	"few", "fifteen", "fify", "fill", "find", "fire", "first", "five", "for", "former", "formerly", "forty", "found", "four", "from", "front", 
	        	"full", "further", "gedung", "get", "give", "go", "had", "hal", "hampir", "hanya", "hari", "harus", "has", "hasil", "hasnt", "have", "he", 
	        	"hence", "her", "here", "hereafter", "hereby", "herein", "hereupon", "hers", "herself", "hidup", "him", "himself", "hingga", "his", "how", 
	        	"however", "hubungan", "hundred", "ia", "ie", "if", "ikut", "in", "inc", "indeed", "ingin", "ini", "interest", "into", "is", "it", "its", 
	        	"itself", "itu", "jadi", "jalan", "jangan", "jauh", "jelas", "jenis", "jika", "juga", "jumat", "jumlah", "juni", "justru", "juta", "kalau", 
	        	"kali", "kami", "kamis", "karena", "kata", "katanya", "ke", "kebutuhan", "kecil", "kedua", "keep", "kegiatan", "kehidupan", "kejadian", "keluar", 
	        	"kembali", "kemudian", "kemungkinan", "kepada", "keputusan", "kerja", "kesempatan", "keterangan", "ketiga", "ketika", "khusus", "kini", "kita", 
	        	"kondisi", "kurang", "lagi", "lain", "lainnya", "lalu", "lama", "langsung", "lanjut", "last", "latter", "latterly", "least", "lebih", "less", 
	        	"lewat", "lima", "ltd", "luar", "made", "maka", "mampu", "mana", "mantan", "many", "masa", "masalah", "masih", "masing-masing", "masuk", "mau", 
	        	"maupun", "may", "me", "meanwhile", "melakukan", "melalui", "melihat", "memang", "membantu", "membawa", "memberi", "memberikan", "membuat", 
	        	"memiliki", "meminta", "mempunyai", "mencapai", "mencari", "mendapat", "mendapatkan", "menerima", "mengaku", "mengalami", "mengambil", 
	        	"mengatakan", "mengenai", "mengetahui", "menggunakan", "menghadapi", "meningkatkan", "menjadi", "menjalani", "menjelaskan", "menunjukkan", 
	        	"menurut", "menyatakan", "menyebabkan", "menyebutkan", "merasa", "mereka", "merupakan", "meski", "might", "milik", "mill", "mine", "minggu", 
	        	"misalnya", "more", "moreover", "most", "mostly", "move", "much", "mulai", "muncul", "mungkin", "must", "my", "myself", "nama", "name", "namely", 
	        	"namun", "nanti", "neither", "never", "nevertheless", "next", "nine", "no", "nobody", "none", "noone", "nor", "not", "nothing", "now", "nowhere", 
	        	"of", "off", "often", "oleh", "on", "once", "one", "only", "onto", "or", "orang", "other", "others", "otherwise", "our", "ours", "ourselves", 
	        	"out", "over", "own", "pada", "padahal", "pagi", "paling", "panjang", "para", "part", "pasti", "pekan", "penggunaan", "penting", "per", "perhaps", 
	        	"perlu", "pernah", "persen", "pertama", "pihak", "please", "posisi", "program", "proses", "pula", "pun", "punya", "put", "rabu", "rasa", "rather", 
	        	"re", "ribu", "ruang", "saat", "sabtu", "saja", "salah", "sama", "same", "sampai", "sangat", "satu", "saya", "sebab", "sebagai", "sebagian", 
	        	"sebanyak", "sebelum", "sebelumnya", "sebenarnya", "sebesar", "sebuah", "secara", "sedang", "sedangkan", "sedikit", "see", "seem", "seemed", 
	        	"seeming", "seems", "segera", "sehingga", "sejak", "sejumlah", "sekali", "sekarang", "sekitar", "selain", "selalu", "selama", "selasa", "selatan", 
	        	"seluruh", "semakin", "sementara", "sempat", "semua", "sendiri", "senin", "seorang", "seperti", "sering", "serious", "serta", "sesuai", "setelah", 
	        	"setiap", "several", "she", "should", "show", "side", "since", "sincere", "six", "sixty", "so", "some", "somehow", "someone", "something", 
	        	"sometime", "sometimes", "somewhere", "still", "suatu", "such", "sudah", "sumber", "system", "tahu", "tahun", "tak", "take", "tampil", "tanggal", 
	        	"tanpa", "tapi", "telah", "teman", "tempat", "ten", "tengah", "tentang", "tentu", "terakhir", "terhadap", "terjadi", "terkait", "terlalu", 
	        	"terlihat", "termasuk", "ternyata", "tersebut", "terus", "terutama", "tetapi", "than", "that", "the", "their", "them", "themselves", "then", 
	        	"thence", "there", "thereafter", "thereby", "therefore", "therein", "thereupon", "these", "they", "thickv", "thin", "third", "this", "those", 
	        	"though", "three", "through", "throughout", "thru", "thus", "tidak", "tiga", "tinggal", "tinggi", "tingkat", "to", "together", "too", "top", 
	        	"toward", "towards", "twelve", "twenty", "two", "ujar", "umum", "un", "under", "until", "untuk", "up", "upaya", "upon", "us", "usai", "utama", 
	        	"utara", "very", "via", "waktu", "was", "we", "well", "were", "what", "whatever", "when", "whence", "whenever", "where", "whereafter", 
	        	"whereas", "whereby", "wherein", "whereupon", "wherever", "whether", "which", "while", "whither", "who", "whoever", "whole", "whom", "whose", 
	        	"why", "wib", "will", "with", "within", "without", "would", "ya", "yaitu", "yakni", "yang", "yet", "you", "your", "yours", "yourself", "yourselves"
	        );

		public function casefolding($text){
			$replace = preg_replace('@[�?:;,."/\'+-=!~#()0-9]+@', " ", strtolower($text));
			$data[] = $replace;
			return $data;
		}

		public function tokenizing($text){
			$data = str_word_count($text, 1);
			foreach ($data as $key => $value) {
				$data[$key] = $value;
			}
			return $data;
		}

		public function filtering($text){
			$data = $this->tokenizing($text);
			$data = array_diff($data, $this->stopwords2);
			$word_count = array_count_values($data);
			return array_keys($word_count);
		}

		public function stemming($text){
			// $stem = Stem::stemming($text);
			// return $stem;
		}

		public function tf_idf($term) {
            if ($term != '') {
                $resCount = mysql_query("SELECT * FROM coba WHERE term = '$term' AND id_doc = 29");
                $num_rows = mysql_num_rows($resCount);
                if ($num_rows > 0) {
                    $rowcount = mysql_fetch_array($resCount);
                    $count = $rowcount['jumlah'];
                    $count++;
                    mysql_query("UPDATE coba SET jumlah = $count WHERE term = '$term' AND id_doc = 29");
                }
                else {
                    mysql_query("INSERT INTO coba (term, id_doc, jumlah) VALUES ('$term', 29, 1)");
                }
            }
        }

		public function hitungBobot(){
			// hitung jumlah dokumen
			$sqlJumDoc = mysql_query("SELECT DISTINCT id_doc from tbindex_baru");
			$jumDoc = mysql_num_rows($sqlJumDoc);

			// ambil setiap record dalam tabel tbindex
			// hitung bobot untuk setiap Term dalam setiap DocId
			$sqlJumTerm = mysql_query("SELECT * FROM tbindex_baru ORDER BY id_indexBaru");
			$jumTerm = mysql_num_rows($sqlJumTerm);
			while ($rowUji = mysql_fetch_array($sqlJumTerm)) {
				$term = $rowUji['term'];
				$tf = $rowUji['jumlah'];
				$id = $rowUji['id_indexBaru'];

				// jumlah dokumen dengan term tertentu
				$sqlTermInDoc = mysql_query("SELECT COUNT(*) as jumDoc from tbindex_baru where term = '".$term."'");
				$rowTerm = mysql_fetch_array($sqlTermInDoc);
				$nTerm = $rowTerm['jumDoc'];

				$w = $tf * (log10($jumDoc / $nTerm));

				// update bobot term di tabel tbindex
				$updateTbIndex = mysql_query("UPDATE tbindex_baru SET bobot = '".$w."' WHERE id_indexBaru = '".$id."'");
			}
		}

		public function updateBobot(){
			//hitung doc data latih
			$sqlJumLatih = mysql_query("SELECT DISTINCT id_doc FROM tbindex");
			$numRowLatih = mysql_num_rows($sqlJumLatih);

			// hitung doc data uji
			$sqljumBaru = mysql_query("SELECT DISTINCT id_doc FROM tbindex_baru");
			$numRowBaru = mysql_num_rows($sqljumBaru);

			// jumlah dokumen update
			$n = $numRowLatih+$numRowBaru;


			$resVektor = mysql_query("SELECT a.* FROM (SELECT tbindex_baru.term AS termBaru, tbindex_baru.jumlah AS jumBaru, tbindex_baru.id_doc AS idBaru, 
									tbindex_baru.bobot AS bobotBaru, tbindex.term AS termLatih, tbindex.jumlah AS jumLatih, 
									tbindex.id_doc AS idLatih, tbindex.bobot AS bobotLatih FROM tbindex_baru 
									left JOIN tbindex on tbindex_baru.term =  tbindex.term 
									UNION ALL
									SELECT tbindex_baru.term AS termBaru, tbindex_baru.jumlah AS jumBaru, tbindex_baru.id_doc AS idBaru, 
									tbindex_baru.bobot AS bobotBaru, tbindex.term AS termLatih, tbindex.jumlah AS jumLatih, 
									tbindex.id_doc AS idLatih, tbindex.bobot AS bobotLatih FROM tbindex_baru 
									right JOIN tbindex on tbindex_baru.term =  tbindex.term) a ORDER BY a.termBaru DESC");

			while ($row = mysql_fetch_array($resVektor)) {
				$termBaru = $row['termBaru'];
				$jumBaru = $row['jumBaru'];
				$idBaru = $row['idBaru'];
				$bobotBaru = $row['bobotBaru'];
				$termLatih = $row['termLatih'];
				$jumLatih = $row['jumLatih'];
				$idLatih = $row['idLatih'];
				$bobotLatih = $row['bobotLatih'];

				$idfBaru = mysql_query("SELECT COUNT(*) AS jum FROM tbindex_baru WHERE term = '".$termBaru."'");
				while ($rowJumBaru = mysql_fetch_array($idfBaru)) {
					$dfBaru = $rowJumBaru['jum'];
				}

				$idfLatih = mysql_query("SELECT COUNT(*) AS jum FROM tbindex WHERE term = '".$termLatih."'");
				while ($rowJumLatih = mysql_fetch_array($idfLatih)) {
					$dfLatih = $rowJumLatih['jum'];
				}
				// update nilai df
				$dfUpdate = $dfBaru + $dfLatih; // echo $termLatih." : ".$dfUpdate."<br>";


				if ($termBaru == $termLatih) {	
					// update bobot termBaru
					$sqlUpdateBaru = mysql_query("SELECT bobot FROM update_bobotuji WHERE term = '".$termBaru."' AND id_doc = '".$idBaru."'");
					$jumRowBaru = mysql_num_rows($sqlUpdateBaru);
					$wUpdate = $jumBaru * log10($n / $dfUpdate);
					if ($jumRowBaru > 0) {
						mysql_query("UPDATE update_bobotuji SET bobot = '".$wUpdate."' WHERE term = '".$termBaru."' AND id_doc = '".$idBaru."'");
					}
					else {
						mysql_query("INSERT INTO update_bobotuji VALUES ('".$termBaru."', '".$idBaru."' , '".$wUpdate."', '', '')");
					}

					// update bobot termLatih
					$sqlUpdateLatih = mysql_query("SELECT bobot FROM update_bobotlatih WHERE term = '".$termLatih."' AND id_doc = '".$idLatih."'");
					$jumRowLatih = mysql_num_rows($sqlUpdateLatih);
					$wUpdateLatih = $jumLatih * log10($n / $dfUpdate);
					if ($jumRowLatih > 0) {
						mysql_query("UPDATE update_bobotlatih SET bobot = '".$wUpdateLatih."' WHERE term = '".$termLatih."' AND id_doc = '".$idLatih."'");
					}
					else {
						mysql_query("INSERT INTO update_bobotlatih VALUES ('".$termLatih."', '".$idLatih."' , '".$wUpdateLatih."', '', '')");
					}
				}
				elseif ($termBaru == NULL) {
					// update bobot termLatih
					$sqlUpdateLatih = mysql_query("SELECT bobot FROM update_bobotlatih WHERE term = '".$termLatih."' AND id_doc = '".$idLatih."'");
					$jumRowLatih = mysql_num_rows($sqlUpdateLatih);
					$w = $jumLatih * log10($n / $dfLatih);
					if ($jumRowLatih > 0) {
						mysql_query("UPDATE update_bobotlatih SET bobot = '".$w."' WHERE term = '".$termLatih."' AND id_doc = '".$idLatih."'");
					}
					else {
						mysql_query("INSERT INTO update_bobotlatih VALUES ('".$termLatih."', '".$idLatih."' , '".$w."', '', '')");
					}
				}
				elseif ($termLatih == NULL) {
					// update bobot termUji
					$sqlUpdateBaru = mysql_query("SELECT bobot FROM update_bobotuji WHERE term = '".$termBaru."' AND id_doc = '".$idBaru."'");
					$jumRowBaru = mysql_num_rows($sqlUpdateBaru);
					$wBaru = $jumBaru * log10($n / $dfBaru);
					if ($jumRowBaru > 0) {
						mysql_query("UPDATE update_bobotuji SET bobot = '".$wBaru."' WHERE term = '".$termBaru."' AND id_doc = '".$idBaru."'");
					}
					else {
						mysql_query("INSERT INTO update_bobotuji VALUES ('".$termBaru."', '".$idBaru."', '".$wBaru."', '', '')");
					}
				}
			}

		}

		public function cosineSimilarity(){
			$query = mysql_query("SELECT update_bobotlatih.term AS termLatih, update_bobotlatih.id_doc AS idLatih, update_bobotlatih.bobot AS bobotLatih,
								update_bobotuji.term AS termUji, update_bobotuji.id_doc AS idUji, update_bobotuji.bobot AS bobotUji 
								FROM update_bobotlatih LEFT JOIN update_bobotuji ON update_bobotuji.term = update_bobotlatih.term");
			while ($row = mysql_fetch_array($query)) {
				$rowTermLatih = $row['termLatih'];
				$rowIDLatih = $row['idLatih'];
				$rowBobotLatih = $row['bobotLatih'];
				$rowTermUji = $row['termUji'];
				$rownIDUji = $row['idUji'];
				$rowBobotUji = $row['bobotUji'];

				// perkalian data W-uji dengan semua bobot W dokumen

			}

			$queryVektorLatih = mysql_query("SELECT * FROM update_bobotlatih");
			while ($latih = mysql_fetch_array($queryVektorLatih)) {
				$termLatih = $latih['term'];
				$idLatih = $latih['id_doc'];
				$bobotLatih = $latih['bobot'];

				// perkalian untuk panjang vektor dari tiap
				$hasilKaliVektor = $bobotLatih * $bobotLatih;
				mysql_query("UPDATE update_bobotlatih SET bobot_vektor = '".$hasilKaliVektor."' WHERE term = '".$termLatih."' AND id_doc = '".$idLatih."'");
			}
		}

		public function naive_bayes() {
			// jumlah kata dalam data latih
			$queryTerm = mysql_query("SELECT tbindex.term AS term, tbindex.id_doc AS id_doc, tbindex.jumlah AS Frekuensi,
									berita_training.kategori AS kategori FROM tbindex 
									JOIN berita_training ON tbindex.id_doc = berita_training.id_berita_training");
			$kosakataLatih = mysql_num_rows($queryTerm); //2513 kata
			while ($data = mysql_fetch_array($queryTerm)) {
				$term = $data['term'];
				$id = $data['id_doc'];
				$frek = $data['Frekuensi'];
				$kat = $data['kategori'];

				$qCekData = mysql_query("SELECT * FROM naive_bayes WHERE term = '".$term."' AND no_preprocess_training = '".$id."'");
				$cekData = mysql_num_rows($qCekData);
				if ($cekData > 0) {
					echo "";
				}
				else {
					mysql_query("INSERT INTO naive_bayes (term, no_preprocess_training, frekuensi, kategori) VALUES
								('".$term."', '".$id."', '".$frek."', '".$kat."')");
				}
			}

			// jumlah seluruh dokumen latih
			$nDok = mysql_query("SELECT DISTINCT no_preprocess_training FROM naive_bayes");
			$jumDoc = mysql_num_rows($nDok); //28 Data

			// jumlah dokumen dengan kategori Politik
			$dokPol = mysql_query("SELECT DISTINCT no_preprocess_training FROM naive_bayes WHERE kategori = 'Politik'");
			$jumPol = mysql_num_rows($dokPol); //5 Data
			$pvjPol = $jumPol / $jumDoc;
			$qJumPol = mysql_query("SELECT * FROM naive_bayes WHERE kategori = 'Politik'");
			$jumKataPol = mysql_num_rows($qJumPol); // 366 kata

			// jumlah dokumen dengan kategori Olahraga
			$dokOlg = mysql_query("SELECT DISTINCT no_preprocess_training FROM naive_bayes WHERE kategori = 'Olahraga'");
			$jumOlg = mysql_num_rows($dokOlg); //5 Data
			$pvjOlg = $jumOlg / $jumDoc;
			$qJumOlg = mysql_query("SELECT * FROM naive_bayes WHERE kategori = 'Olahraga'");
			$jumKataOlg = mysql_num_rows($qJumOlg); // 406 kata

			// jumlah dokumen dengan kategori Pendidikan
			$dokPend = mysql_query("SELECT DISTINCT no_preprocess_training FROM naive_bayes WHERE kategori = 'Pendidikan'");
			$jumPend = mysql_num_rows($dokPend); //5 Data
			$pvjPend = $jumPend / $jumDoc;
			$qJumPend = mysql_query("SELECT * FROM naive_bayes WHERE kategori = 'Pendidikan'");
			$jumKataPend = mysql_num_rows($qJumPend); // 509 kata

			// jumlah dokumen dengan kategori Otomotif
			$dokOto = mysql_query("SELECT DISTINCT no_preprocess_training FROM naive_bayes WHERE kategori = 'Otomotif'");
			$jumOto = mysql_num_rows($dokOto); //5 Data
			$pvjOto = $jumOto / $jumDoc;
			$qJumOto = mysql_query("SELECT * FROM naive_bayes WHERE kategori = 'Otomotif'");
			$jumKataOto = mysql_num_rows($qJumOto); // 525 kata

			// jumlah dokumen dengan kategori Umum
			$dokUmum = mysql_query("SELECT DISTINCT no_preprocess_training FROM naive_bayes WHERE kategori = 'Umum'");
			$jumUmum = mysql_num_rows($dokUmum); //8 Data
			$pvjUmum = $jumUmum / $jumDoc;
			$qJumUmum = mysql_query("SELECT * FROM naive_bayes WHERE kategori = 'Umum'");
			$jumKataUmum = mysql_num_rows($qJumUmum); // 707 kata

			
			$qJumPol = mysql_query("SELECT * FROM naive_bayes WHERE kategori = 'Politik'");
			while ($i = mysql_fetch_array($qJumPol)) {
				$termPol = $i['term'];
				$qPol = mysql_query("SELECT term, no_preprocess_training, SUM(frekuensi) AS frekuensi 
									FROM naive_bayes WHERE kategori = 'Politik' AND term = '".$termPol."'");
				while ( $a = mysql_fetch_array($qPol)) {
					$tPol = $a['term'];
					$idPol = $a['no_preprocess_training'];
					$frekPol = $a['frekuensi'];
					$pwkvjPol = ($frekPol + 1) / ($jumKataPol + $kosakataLatih);
					// echo "$tPol >< $idPol >< $frekPol	=> $pwkvjPol<br>";
					mysql_query("UPDATE naive_bayes SET pwk = '".$pwkvjPol."', pvj = '".$pvjPol."' WHERE term = '".$tPol."' AND kategori = 'Politik'");
				}
			}
				
			$qJumOlg = mysql_query("SELECT * FROM naive_bayes WHERE kategori = 'Olahraga'");
			while ($i = mysql_fetch_array($qJumOlg)) {
				$termOlg = $i['term'];			
				$qOlg = mysql_query("SELECT term, no_preprocess_training, SUM(frekuensi) AS frekuensi 
									FROM naive_bayes WHERE kategori = 'Olahraga' AND term = '".$termOlg."'");
				while ( $a = mysql_fetch_array($qOlg)) {
					$tOlg = $a['term'];
					$idOlg = $a['no_preprocess_training'];
					$frekOlg = $a['frekuensi'];
					$pwkvjOlg = ($frekOlg + 1) / ($jumKataOlg + $kosakataLatih);
					// echo "$tPol >< $idPol >< $frekPol	=> $pwkvjPol<br>";
					mysql_query("UPDATE naive_bayes SET pwk = '".$pwkvjOlg."', pvj = '".$pvjOlg."' WHERE term = '".$tOlg."' AND kategori = 'Olahraga'");
				}
			}
		
			$qJumPend = mysql_query("SELECT * FROM naive_bayes WHERE kategori = 'Pendidikan'");
			while ($i = mysql_fetch_array($qJumPend)) {
				$termPend = $i['term'];
				$qPend = mysql_query("SELECT term, no_preprocess_training, SUM(frekuensi) AS frekuensi 
									FROM naive_bayes WHERE kategori = 'Pendidikan' AND term = '".$termPend."'");
				while ( $a = mysql_fetch_array($qPend)) {
					$tPend = $a['term'];
					$idPend = $a['no_preprocess_training'];
					$frekPend = $a['frekuensi'];
					$pwkvjPend = ($frekPend + 1) / ($jumKataPend + $kosakataLatih);
					// echo "$tPol >< $idPol >< $frekPol	=> $pwkvjPol<br>";
					mysql_query("UPDATE naive_bayes SET pwk = '".$pwkvjPend."', pvj = '".$pvjPend."' WHERE term = '".$tPend."' AND kategori = 'Pendidikan'");
				}
			}
				
			$qJumOto = mysql_query("SELECT * FROM naive_bayes WHERE kategori = 'Otomotif'");
			while ($i = mysql_fetch_array($qJumOto)) {
				$termOto = $i['term'];
				$qOto = mysql_query("SELECT term, no_preprocess_training, SUM(frekuensi) AS frekuensi 
									FROM naive_bayes WHERE kategori = 'Otomotif' AND term = '".$termOto."'");
				while ( $a = mysql_fetch_array($qOto)) {
					$tOto = $a['term'];
					$idOto = $a['no_preprocess_training'];
					$frekOto = $a['frekuensi'];
					$pwkvjOto = ($frekOto + 1) / ($jumKataOto + $kosakataLatih);
					// echo "$tPol >< $idPol >< $frekPol	=> $pwkvjPol<br>";
					mysql_query("UPDATE naive_bayes SET pwk = '".$pwkvjOto."', pvj = '".$pvjOto."' WHERE term = '".$tOto."' AND kategori = 'Otomotif'");
				}
			}
		
			$qJumUmum = mysql_query("SELECT * FROM naive_bayes WHERE kategori = 'Umum'");
			while ($i = mysql_fetch_array($qJumUmum)) {
				$termUmum = $i['term'];
				$qUmum = mysql_query("SELECT term, no_preprocess_training, SUM(frekuensi) AS frekuensi 
									FROM naive_bayes WHERE kategori = 'Umum' AND term = '".$termUmum."'");
				while ( $a = mysql_fetch_array($qUmum)) {
					$tUmum = $a['term'];
					$idUmum = $a['no_preprocess_training'];
					$frekUmum = $a['frekuensi'];
					$pwkvjUmum = ($frekUmum + 1) / ($jumKataUmum + $kosakataLatih);
					// echo "$tPol >< $idPol >< $frekPol	=> $pwkvjPol<br>";
					mysql_query("UPDATE naive_bayes SET pwk = '".$pwkvjUmum."', pvj = '".$pvjUmum."' WHERE term = '".$tUmum."' AND kategori = 'Umum'");
				}
			}


			// insert data uji ke tabel naive_bayes
			$querySelectDataUji = mysql_query("SELECT * FROM tbindex_baru");
			while ($y = mysql_fetch_array($querySelectDataUji)) {
				$term = $y['term'];
				$id = $y['id_doc'];

				$queryCekData = mysql_query("SELECT * FROM nb_uji WHERE term = '".$term."' AND id_doc_uji = '".$id."'");
				$cekIsi = mysql_num_rows($queryCekData);
				if ($cekIsi > 0) {
					echo "";
				}
				else {
					mysql_query("INSERT INTO nb_uji(term, id_doc_uji) SELECT term, id_doc FROM tbindex_baru");
				}
			}
		}
	}

	$ir = new PraprosesBaru();
	$stem = new Stem();
	$select = mysql_query("SELECT * from berita_baru");
	while ($data = mysql_fetch_array($select)) {
		$text = $data['isi_berita'];
		$id = $data['id_berita_baru'];

		$pecah = $ir->casefolding($text);

		foreach ($pecah as $keyCase => $valCase) {
			$pecah[$keyCase] = $valCase;
			foreach ($ir->tokenizing($valCase) as $keyToken => $valToken) {
				$pecah[$keyToken] = $valToken;
				// echo $pecah[$keyToken]."<br>";
				foreach ($ir->filtering($valToken) as $keyFilter => $valFilter) {
					$pecah[$keyFilter] = $valFilter;
					// echo $pecah[$keyFilter]."<br>";
					$hasil_stem = $stem->stemming($pecah[$keyFilter]);

					// // echo $hasil_stem."<br>";
					// //CALL nama_prosedur(parameter);


					if ($hasil_stem != " ") {
						$rescount = mysql_query("SELECT jumlah FROM tbindex_baru WHERE term = '".$hasil_stem."' AND id_doc = '".$id."'");
						$num_row = mysql_num_rows($rescount);

						if ($num_row > 0) {
							$rowCount = mysql_fetch_array($rescount);
							$count = $rowCount['jumlah'];
							$count++;
							mysql_query("UPDATE tbindex_baru SET jumlah = $count WHERE term = '".$hasil_stem."' AND id_doc = '".$id."'");
						}
						else {
							mysql_query("INSERT INTO tbindex_baru (term, id_doc, jumlah) VALUES ('".$hasil_stem."', '".$id."', 1)");
						}
						$ir->hitungBobot();
					}
				}

				// $ir->cosineSimilarity();
			}
		}

		echo "<br>-------------------------------------------------------------------------------<br>";
	}
?>