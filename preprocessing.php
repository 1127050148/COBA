<?php
	$conn = mysql_connect("localhost","root","");
	if (!$conn) die ("Koneksi gagal");
	mysql_select_db("db",$conn) or die ("Database tidak ditemukan");

	include "stemming.php";

	class Preprocessing
	{
		protected $this;
		private $stopwords2 = array("a", "about", "above", "acara", "across", "ada", "adalah", "adanya", "after", "afterwards", "again", "against", "agar", "akan", "akhir", "akhirnya", "akibat", "aku", "all", "almost", "alone", "along", "already", "also", "although", "always", "am", "among", "amongst", "amoungst", "amount", "an", "and", "anda", "another", "antara", "any", "anyhow", "anyone", "anything", "anyway", "anywhere", "apa", "apakah", "apalagi", "are", "around", "as", "asal", "at", "atas", "atau", "awal", "b", "back", "badan", "bagaimana", "bagi", "bagian", "bahkan", "bahwa", "baik", "banyak", "barang", "barat", "baru", "bawah", "be", "beberapa", "became", "because", "become", "becomes", "becoming", "been", "before", "beforehand", "begitu", "behind", "being", "belakang", "below", "belum", "benar", "bentuk", "berada", "berarti", "berat", "berbagai", "berdasarkan", "berjalan", "berlangsung", "bersama", "bertemu", "besar", "beside", "besides", "between", "beyond", "biasa", "biasanya", "bila", "bill", "bisa", "both", "bottom", "bukan", "bulan", "but", "by", "call", "can", "cannot", "cant", "cara", "co", "con", "could", "couldnt", "cry", "cukup", "dalam", "dan", "dapat", "dari", "datang", "de", "dekat", "demikian", "dengan", "depan", "describe", "detail", "di", "dia", "diduga", "digunakan", "dilakukan", "diri", "dirinya", "ditemukan", "do", "done", "down", "dua", "due", "dulu", "during", "each", "eg", "eight", "either", "eleven", "else", "elsewhere", "empat", "empty", "enough", "etc", "even", "ever", "every", "everyone", "everything", "everywhere", "except", "few", "fifteen", "fify", "fill", "find", "fire", "first", "five", "for", "former", "formerly", "forty", "found", "four", "from", "front", "full", "further", "gedung", "get", "give", "go", "had", "hal", "hampir", "hanya", "hari", "harus", "has", "hasil", "hasnt", "have", "he", "hence", "her", "here", "hereafter", "hereby", "herein", "hereupon", "hers", "herself", "hidup", "him", "himself", "hingga", "his", "how", "however", "hubungan", "hundred", "ia", "ie", "if", "ikut", "in", "inc", "indeed", "ingin", "ini", "interest", "into", "is", "it", "its", "itself", "itu", "jadi", "jalan", "jangan", "jauh", "jelas", "jenis", "jika", "juga", "jumat", "jumlah", "juni", "justru", "juta", "kalau", "kali", "kami", "kamis", "karena", "kata", "katanya", "ke", "kebutuhan", "kecil", "kedua", "keep", "kegiatan", "kehidupan", "kejadian", "keluar", "kembali", "kemudian", "kemungkinan", "kepada", "keputusan", "kerja", "kesempatan", "keterangan", "ketiga", "ketika", "khusus", "kini", "kita", "kondisi", "kurang", "lagi", "lain", "lainnya", "lalu", "lama", "langsung", "lanjut", "last", "latter", "latterly", "least", "lebih", "less", "lewat", "lima", "ltd", "luar", "made", "maka", "mampu", "mana", "mantan", "many", "masa", "masalah", "masih", "masing-masing", "masuk", "mau", "maupun", "may", "me", "meanwhile", "melakukan", "melalui", "melihat", "memang", "membantu", "membawa", "memberi", "memberikan", "membuat", "memiliki", "meminta", "mempunyai", "mencapai", "mencari", "mendapat", "mendapatkan", "menerima", "mengaku", "mengalami", "mengambil", "mengatakan", "mengenai", "mengetahui", "menggunakan", "menghadapi", "meningkatkan", "menjadi", "menjalani", "menjelaskan", "menunjukkan", "menurut", "menyatakan", "menyebabkan", "menyebutkan", "merasa", "mereka", "merupakan", "meski", "might", "milik", "mill", "mine", "minggu", "misalnya", "more", "moreover", "most", "mostly", "move", "much", "mulai", "muncul", "mungkin", "must", "my", "myself", "nama", "name", "namely", "namun", "nanti", "neither", "never", "nevertheless", "next", "nine", "no", "nobody", "none", "noone", "nor", "not", "nothing", "now", "nowhere", "of", "off", "often", "oleh", "on", "once", "one", "only", "onto", "or", "orang", "other", "others", "otherwise", "our", "ours", "ourselves", "out", "over", "own", "pada", "padahal", "pagi", "paling", "panjang", "para", "part", "pasti", "pekan", "penggunaan", "penting", "per", "perhaps", "perlu", "pernah", "persen", "pertama", "pihak", "please", "posisi", "program", "proses", "pula", "pun", "punya", "put", "rabu", "rasa", "rather", "re", "ribu", "ruang", "saat", "sabtu", "saja", "salah", "sama", "same", "sampai", "sangat", "satu", "saya", "sebab", "sebagai", "sebagian", "sebanyak", "sebelum", "sebelumnya", "sebenarnya", "sebesar", "sebuah", "secara", "sedang", "sedangkan", "sedikit", "see", "seem", "seemed", "seeming", "seems", "segera", "sehingga", "sejak", "sejumlah", "sekali", "sekarang", "sekitar", "selain", "selalu", "selama", "selasa", "selatan", "seluruh", "semakin", "sementara", "sempat", "semua", "sendiri", "senin", "seorang", "seperti", "sering", "serious", "serta", "sesuai", "setelah", "setiap", "several", "she", "should", "show", "side", "since", "sincere", "six", "sixty", "so", "some", "somehow", "someone", "something", "sometime", "sometimes", "somewhere", "still", "suatu", "such", "sudah", "sumber", "system", "tahu", "tahun", "tak", "take", "tampil", "tanggal", "tanpa", "tapi", "telah", "teman", "tempat", "ten", "tengah", "tentang", "tentu", "terakhir", "terhadap", "terjadi", "terkait", "terlalu", "terlihat", "termasuk", "ternyata", "tersebut", "terus", "terutama", "tetapi", "than", "that", "the", "their", "them", "themselves", "then", "thence", "there", "thereafter", "thereby", "therefore", "therein", "thereupon", "these", "they", "thickv", "thin", "third", "this", "those", "though", "three", "through", "throughout", "thru", "thus", "tidak", "tiga", "tinggal", "tinggi", "tingkat", "to", "together", "too", "top", "toward", "towards", "twelve", "twenty", "two", "ujar", "umum", "un", "under", "until", "untuk", "up", "upaya", "upon", "us", "usai", "utama", "utara", "very", "via", "waktu", "was", "we", "well", "were", "what", "whatever", "when", "whence", "whenever", "where", "whereafter", "whereas", "whereby", "wherein", "whereupon", "wherever", "whether", "which", "while", "whither", "who", "whoever", "whole", "whom", "whose", "why", "wib", "will", "with", "within", "without", "would", "ya", "yaitu", "yakni", "yang", "yet", "you", "your", "yours", "yourself", "yourselves");

		// public function index(){
		// 	// $this->load->model('vpre_baru');
		// 	// $konten=$this->vpre_baru->get_all();
			
		// 	// $text= array(
		// 	// 	'konten'=>$konten
		// 	// 	);
		// 	// $this->load->view('view_berita',$text);
		// }

		public function text()
		{
			$select = mysql_query("SELECT * from berita_baru");
			while ($data = mysql_fetch_array($select)) {
				$text = $data['isi_berita'];
			}
			return $text;
		}

		public function pecah_kalimat($text) //no $text
		{
			$pecah = explode(".",$text);
			return $pecah;
		}

		public function case_folding($text)
		{
			$looping_data = $this->pecah_kalimat($text);
			foreach ($looping_data as $key => $value) 
			{
				$input = preg_replace('@[?:;,."/\'+-=!~#()0-9]+@', " ", strtolower($value));
				$data[] = $input;
			}
			return $data;
		}

		public function tokenizing($text)
		{
			$data = str_word_count($text, 1); 
			$count = count($data);
			// return $data;

			// array_walk($data, array($this, 'filter'));
			$data = array_diff($data, $this->stopwords2);
			$wordCount = array_count_values($data);

			// $jumlahFilter = count($wordCount);

			return array_keys($wordCount);
		}

		private function filter($wordCount)
		{
			$wordCount = strtolower($wordCount);
		}
	}
			
	$awal = microtime(true);
	$ir = new Preprocessing;
	$stem = new Stemming;
	$select = mysql_query("SELECT * from berita_baru");
	while ($data = mysql_fetch_array($select)) {
		$text = $data['isi_berita'];
		$pecah = $ir->case_folding($text);
		foreach ($pecah as $key => $hasil) {
			// echo "$key : $hasil";echo "<br>";
			$word = str_word_count($hasil, 1); 
			$jumlah = count($word);
			// echo $jumlah."<br>";
			
			foreach ($ir->tokenizing($hasil) as $value) {
				// echo $value."<br>";
				
				$hasil_stem = $stem->proses($value);
				echo $hasil_stem."<br>";
			}
			echo "<br><br>";
		}
		echo "<br><br>";
	}

// $kalimat = "Idul Fitri adalah hal yang dinanti-nantikan oleh umat muslim setiap tahunnya. Tak perduli jarak, 
// 	waktu, hingga uang, akan dikorbankan agar bisa menghabiskan lebaran untuk mudik berkumpul dengan keluarga. 
// 	Termasuk rela berjam-jam terperangkap macet. Hal ini seperti yang dirasakan oleh Firman Abielfida, 
// 	pemudik dari Purwakarta yang hendak menuju kampung halamannya di Semarang. Berangkat bersama sang adik sejak pukul 15.00 WIB, Sabtu (2/7/2015), 
// 	hingga saat ini Firman masih jauh dari tujuan dan terjebak macet di wilayah Brebes. Saya sekarang di wilayah Bangsri. 
// 	Lalu lintas Brebes-Tegal nyaris parkir, ujar Firman saat berbincang dengan detikcom, Minggu (3/7/2016). Perjalanan Firman pada awalnya cukup lancar. 
// 	Ia keluar dari Tol Palimanan saat magrib dan terus melanjutkan hingga Kanci. Sampai di daerah Bulakamba, 
// 	bapak dua anak ini lalu beristirahat untuk makan. Setelah istirahat sebentar dan hendak melanjutkan perjalanan, Firman terjebak macet parah. 
// 	Bulakamba menuju Bangsri sebenarnya hanya berjarak lebih kurang 10 km tetapi dari jam 20.05 WIB sampai dengan saat ini situasi masih sama dan stagnan, 
// 	kata dia. Beruntung Firman sudah terlebih dahulu memulangkan istri dan anak-anaknya ke kampung halaman mereka. 
// 	Ia tidak ingin buah hatinya yang masih kecil-kecil harus merasakan beratnya perjuangan mudik lewat jalur darat. Karena situasinya kayak gini, 
// 	kasihan kalau ikut saya. Udah seminggu lalu istri dan anak-anak saya pulangin duluan naik kereta. Kalau saya bawa mobil karena di sana bisa dipakai juga, 
// 	tutur Firman. Meski harus berpeluh setiap tahun menghadapi kemacetan arus mudik, Firman tak menyerah. 
// 	Tetap saja perjuangan itu ia lakoni demi berkumpul bersama keluarga, terutama agar bisa menghadap orangtua. Mau ke rumah orangtua. 
// 	Alhamdulillah orangtua saya masih lengkap. Nggak apa-apa macet-macetan, setahun sekali. Yang paling penting bisa lebaran sama orangtua dan istri anak, 
// 	sebutnya. Pengalaman mudik tahun ini menurut Firman adalah yang paling parah dari empat tahun pengalaman mudiknya. 
// 	Itu bisa terlihat dari bagaimana jarak Bulukamba-Bangsri yang hanya 10 km perlu ditempuhnya selama lebih dari 10 jam. 
// 	Dan ia masih harus menghadapi kemacetan entah hingga pukul berapa dan tak bisa memprediksi kapan akan sampai Semarang. 
// 	Paling parah kayaknya tahun ini. Tahun kemarin saya 36 jam baru sampai, sekarang nggak tahu deh. Bisa-bisa besok baru sampai kayaknya, 
// 	apalagi Pekalongan katanya juga macet, ucap Firman. Menurutnya, saat ini 4 lajur baik sisi kiri dan kanan Pantura sudah terpakai semua oleh para pemudik 
// 	yang hendak menuju timur. Itu dikatakan Firman menambah kekacauan. Rombongan pemudik motor mulai berdatangan dari jam 03.00 WIB. 
// 	Ini nggak jalan sama sekali. Sebelum 4 lajur kepakai semua, masih jalan sedikit. Sekarang nggak sama sekali, terangnya. Walau terjebak kemacetan cukup parah, 
// 	tampaknya ia bersama sang adik tetap semangat mudik ke kampung halaman. Ya dijalani aja, tutup Firman sambil tergelak.";

?>