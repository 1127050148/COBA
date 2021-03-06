<?php
	$conn = mysql_connect("localhost","root","");
	if (!$conn) die ("Koneksi gagal");
	mysql_select_db("db_berita",$conn) or die ("Database tidak ditemukan");

	require 'stem.php';

	class Praproses
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

		public function hitungBobot(){
			//hitung doc data latih
			$sqlJumLatih = mysql_query("SELECT DISTINCT id_doc FROM tbindex");
			$numRowLatih = mysql_num_rows($sqlJumLatih);

			// hitung doc data uji
			$sqljumBaru = mysql_query("SELECT DISTINCT id_doc FROM tbindex_baru");
			$numRowBaru = mysql_num_rows($sqljumBaru);

			// jumlah dokumen update
			$n = $numRowLatih+$numRowBaru; echo $n;


			$resVektor = mysql_query("SELECT tbindex_baru.term AS termBaru, tbindex_baru.jumlah AS jumBaru, tbindex_baru.id_doc AS idBaru, tbindex_baru.bobot AS bobotBaru, 
							tbindex.term AS termLatih, tbindex.jumlah AS jumLatih, tbindex.id_doc AS idLatih, tbindex.bobot AS bobotLatih FROM tbindex_baru 
							RIGHT JOIN tbindex on tbindex_baru.term =  tbindex.term ORDER BY tbindex_baru.term DESC");

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
		}
	}

	$ir = new Praproses();
	$stem = new Stem();
	$select = mysql_query("SELECT * from berita_training");
	while ($data = mysql_fetch_array($select)) {
		$text = $data['isi_berita'];
		$id = $data['id_berita_training'];

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
					// echo $hasil_stem."<br>";

					//CALL nama_prosedur(parameter);

					if ($hasil_stem != " ") {
						$rescount = mysql_query("SELECT jumlah FROM tbindex WHERE term = '".$hasil_stem."' AND id_doc = '".$id."'");
						$num_row = mysql_num_rows($rescount);

						if ($num_row > 0) {
							$rowCount = mysql_fetch_array($rescount);
							$count = $rowCount['jumlah'];
							$count++;
							mysql_query("UPDATE tbindex SET jumlah = $count WHERE term = '".$hasil_stem."' AND id_doc = '".$id."'");
						}
						else {
							mysql_query("INSERT INTO tbindex (term, id_doc, jumlah) VALUES ('".$hasil_stem."', '".$id."', 1)");
						}
						$ir->hitungBobot();
					}
				}
			}
		}

		echo "<br>-------------------------------------------------------------------------------<br>";
	}
?>