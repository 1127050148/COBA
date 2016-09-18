<?php
ini_set('max_execution_time', 300);
class Keywords
{
private $stopwords2 = array("a", "about", "above", "acara", "across", "ada", "adalah", "adanya", "after", "afterwards", "again", "against", "agar", "akan", "akhir", "akhirnya", "akibat", "aku", "all", "almost", "alone", "along", "already", "also", "although", "always", "am", "among", "amongst", "amoungst", "amount", "an", "and", "anda", "another", "antara", "any", "anyhow", "anyone", "anything", "anyway", "anywhere", "apa", "apakah", "apalagi", "are", "around", "as", "asal", "at", "atas", "atau", "awal", "b", "back", "badan", "bagaimana", "bagi", "bagian", "bahkan", "bahwa", "baik", "banyak", "barang", "barat", "baru", "bawah", "be", "beberapa", "became", "because", "become", "becomes", "becoming", "been", "before", "beforehand", "begitu", "behind", "being", "belakang", "below", "belum", "benar", "bentuk", "berada", "berarti", "berat", "berbagai", "berdasarkan", "berjalan", "berlangsung", "bersama", "bertemu", "besar", "beside", "besides", "between", "beyond", "biasa", "biasanya", "bila", "bill", "bisa", "both", "bottom", "bukan", "bulan", "but", "by", "call", "can", "cannot", "cant", "cara", "co", "con", "could", "couldnt", "cry", "cukup", "dalam", "dan", "dapat", "dari", "datang", "de", "dekat", "demikian", "dengan", "depan", "describe", "detail", "di", "dia", "diduga", "digunakan", "dilakukan", "diri", "dirinya", "ditemukan", "do", "done", "down", "dua", "due", "dulu", "during", "each", "eg", "eight", "either", "eleven", "else", "elsewhere", "empat", "empty", "enough", "etc", "even", "ever", "every", "everyone", "everything", "everywhere", "except", "few", "fifteen", "fify", "fill", "find", "fire", "first", "five", "for", "former", "formerly", "forty", "found", "four", "from", "front", "full", "further", "gedung", "get", "give", "go", "had", "hal", "hampir", "hanya", "hari", "harus", "has", "hasil", "hasnt", "have", "he", "hence", "her", "here", "hereafter", "hereby", "herein", "hereupon", "hers", "herself", "hidup", "him", "himself", "hingga", "his", "how", "however", "hubungan", "hundred", "ia", "ie", "if", "ikut", "in", "inc", "indeed", "ingin", "ini", "interest", "into", "is", "it", "its", "itself", "itu", "jadi", "jalan", "jangan", "jauh", "jelas", "jenis", "jika", "juga", "jumat", "jumlah", "juni", "justru", "juta", "kalau", "kali", "kami", "kamis", "karena", "kata", "katanya", "ke", "kebutuhan", "kecil", "kedua", "keep", "kegiatan", "kehidupan", "kejadian", "keluar", "kembali", "kemudian", "kemungkinan", "kepada", "keputusan", "kerja", "kesempatan", "keterangan", "ketiga", "ketika", "khusus", "kini", "kita", "kondisi", "kurang", "lagi", "lain", "lainnya", "lalu", "lama", "langsung", "lanjut", "last", "latter", "latterly", "least", "lebih", "less", "lewat", "lima", "ltd", "luar", "made", "maka", "mampu", "mana", "mantan", "many", "masa", "masalah", "masih", "masing-masing", "masuk", "mau", "maupun", "may", "me", "meanwhile", "melakukan", "melalui", "melihat", "memang", "membantu", "membawa", "memberi", "memberikan", "membuat", "memiliki", "meminta", "mempunyai", "mencapai", "mencari", "mendapat", "mendapatkan", "menerima", "mengaku", "mengalami", "mengambil", "mengatakan", "mengenai", "mengetahui", "menggunakan", "menghadapi", "meningkatkan", "menjadi", "menjalani", "menjelaskan", "menunjukkan", "menurut", "menyatakan", "menyebabkan", "menyebutkan", "merasa", "mereka", "merupakan", "meski", "might", "milik", "mill", "mine", "minggu", "misalnya", "more", "moreover", "most", "mostly", "move", "much", "mulai", "muncul", "mungkin", "must", "my", "myself", "nama", "name", "namely", "namun", "nanti", "neither", "never", "nevertheless", "next", "nine", "no", "nobody", "none", "noone", "nor", "not", "nothing", "now", "nowhere", "of", "off", "often", "oleh", "on", "once", "one", "only", "onto", "or", "orang", "other", "others", "otherwise", "our", "ours", "ourselves", "out", "over", "own", "pada", "padahal", "pagi", "paling", "panjang", "para", "part", "pasti", "pekan", "penggunaan", "penting", "per", "perhaps", "perlu", "pernah", "persen", "pertama", "pihak", "please", "posisi", "program", "proses", "pula", "pun", "punya", "put", "rabu", "rasa", "rather", "re", "ribu", "ruang", "saat", "sabtu", "saja", "salah", "sama", "same", "sampai", "sangat", "satu", "saya", "sebab", "sebagai", "sebagian", "sebanyak", "sebelum", "sebelumnya", "sebenarnya", "sebesar", "sebuah", "secara", "sedang", "sedangkan", "sedikit", "see", "seem", "seemed", "seeming", "seems", "segera", "sehingga", "sejak", "sejumlah", "sekali", "sekarang", "sekitar", "selain", "selalu", "selama", "selasa", "selatan", "seluruh", "semakin", "sementara", "sempat", "semua", "sendiri", "senin", "seorang", "seperti", "sering", "serious", "serta", "sesuai", "setelah", "setiap", "several", "she", "should", "show", "side", "since", "sincere", "six", "sixty", "so", "some", "somehow", "someone", "something", "sometime", "sometimes", "somewhere", "still", "suatu", "such", "sudah", "sumber", "system", "tahu", "tahun", "tak", "take", "tampil", "tanggal", "tanpa", "tapi", "telah", "teman", "tempat", "ten", "tengah", "tentang", "tentu", "terakhir", "terhadap", "terjadi", "terkait", "terlalu", "terlihat", "termasuk", "ternyata", "tersebut", "terus", "terutama", "tetapi", "than", "that", "the", "their", "them", "themselves", "then", "thence", "there", "thereafter", "thereby", "therefore", "therein", "thereupon", "these", "they", "thickv", "thin", "third", "this", "those", "though", "three", "through", "throughout", "thru", "thus", "tidak", "tiga", "tinggal", "tinggi", "tingkat", "to", "together", "too", "top", "toward", "towards", "twelve", "twenty", "two", "ujar", "umum", "un", "under", "until", "untuk", "up", "upaya", "upon", "us", "usai", "utama", "utara", "very", "via", "waktu", "was", "we", "well", "were", "what", "whatever", "when", "whence", "whenever", "where", "whereafter", "whereas", "whereby", "wherein", "whereupon", "wherever", "whether", "which", "while", "whither", "who", "whoever", "whole", "whom", "whose", "why", "wib", "will", "with", "within", "without", "would", "ya", "yaitu", "yakni", "yang", "yet", "you", "your", "yours", "yourself", "yourselves"
   );
 public function getKeywords($string, $nbrwords2 = 5,$kode,$kategorih)
   {
      $words2 = str_word_count($string, 1);
      array_walk($words2, array(
         $this,
         'filter'
      ));
      $words2 = array_diff($words2, $this->stopwords2);
      $wordCount = array_count_values($words2);
      arsort($wordCount);
  
   global $allWords;
    $result = mysql_query( "select id_sw, daftar from stopword" ) or die( "Error in executing mysql query" );
    while ( $row = mysql_fetch_array($result) ) {
        $allWords[$row['keyword']] = $row['id_Sw'];
    }
$jumlah3 = count($wordCount);
foreach ($wordCount as $key3=>$val3) {
 $con = mysql_connect("localhost","root","");
 if ( !isset($allWords[$key3]) ) {
  $keyxx=$this->NAZIEF($key3);
   mysql_query( sprintf( "INSERT INTO stopword ( keyword ) VALUES ( '%s' )",
                mysql_escape_string($keyxx) ) );
     }
    $keyxx=$this->NAZIEF($key3);
 $sql="INSERT INTO link ( keyid,dokid,kategori ) VALUES ( '". $keyxx ."','". $kode ."','". $kategorih ."' );" ;
 mysql_query($sql, $con) ;  }
      $wordCount = array_slice($wordCount, 0, $nbrwords2);
      return array_keys($wordCount);
   }
  
    private function filter(&$val3, $key3)
   {
      $val3 = strtolower($val3);
   }
    private function setStopwords2()
   {
      $this->stopwords2 = array();
   }
  
  
   //algoritma nazief adrian
function cekKamus($kata){
 /** jika menggunakan kamus dari kateglo
$str = file_get_contents('http://kateglo.com/api.php?format=json&phrase='. $kata);
if(empty(json_decode($str, true))) {
 return false;
}else{
 $json = json_decode($str, true);
$a = $json['kateglo']['phrase'];
if(isset($json['kateglo']['root'][0]['root_phrase'])){
 $b = $json['kateglo']['root'][0]['root_phrase'];
if($a===$b){
 return true;
}else{
 return false;
}
 }else{
 return true;
}
}
**/
 $result = mysql_query( "select * from kamus where kata='". $kata ."'" ) or die( "Error in executing mysql query" );
   $row = mysql_fetch_array($result);
   if($row>0){
 return true;  
   }else{
 return false;
   }

}
function cekTotal($kata){
$str = file_get_contents('http://kateglo.com/api.php?format=json&phrase='. $kata);
if(empty(json_decode($str, true))) {
 return $kata;
}else{
 $json = json_decode($str, true); // decode the JSON into an associative array
$a = $json['kateglo']['phrase'];
if(isset($json['kateglo']['root'][0]['root_phrase'])){
 $b = $json['kateglo']['root'][0]['root_phrase'];
return $b;
 }else{
 return $kata;
}
}
}
function Del_Inflection_Suffixes($kata){
$kataAsal = $kata;
if(eregi('([km]u|nya|[kl]ah|pun)$',$kata)){ // Cek Inflection Suffixes
$__kata = eregi_replace('([km]u|nya|[kl]ah|pun)$',"",$kata);
if($this->cekKamus($__kata)){ // Cek Kamus
return $__kata;
}
}
return $kataAsal;
}
// Cek Prefix Disallowed Sufixes (Kombinasi Awalan dan Akhiran yang tidak diizinkan)
function Cek_Prefix_Disallowed_Sufixes($kata){
if(eregi('^(be)[[:alpha:]]+(i)$',$kata)){ // be- dan -i
return true;
}
if(eregi('^(se)[[:alpha:]]+(i|kan)$',$kata)){ // se- dan -i,-kan
return true;
}
return false;
}
// Hapus Derivation Suffixes (“-i”, “-an” atau “-kan”)
function Del_Derivation_Suffixes($kata){
$kataAsal = $kata;
if(eregi('(i|an)$',$kata)){ // Cek Suffixes
$__kata = eregi_replace('(i|an)$',"",$kata);
if($this->cekKamus($__kata)){ // Cek Kamus
return $__kata;
}
}
return $kataAsal;
}
function Del_Derivation_Prefix($kata){
$kataAsal = $kata;
/* —— Tentukan Tipe Awalan ————*/
if(eregi('^(di|[ks]e)',$kata)){ // Jika di-,ke-,se-
$__kata = eregi_replace('^(di|[ks]e)',"",$kata);
if($this->cekKamus($__kata)){
return $__kata; // Jika ada balik
}
$__kata__ = $this->Del_Derivation_Suffixes($__kata);
if($this->cekKamus($__kata__)){
return $__kata__;
}
/*————end “diper-”, ———————————————*/
if(eregi('^(diper)',$kata)){
$__kata = eregi_replace('^(diper)',"",$kata);
if($this->cekKamus($__kata)){
return $__kata; // Jika ada balik
}
}
/*————end “diper-”, ———————————————*/
}
if(eregi('^([tmbp]e)',$kata)){ //Jika awalannya adalah “te-”, “me-”, “be-”, atau “pe-”
$__kata = eregi_replace('^([tmbp]e)',"",$kata);
if($this->cekKamus($__kata)){
return $__kata; // Jika ada balik
}
}
/* — Cek Ada Tidaknya Prefik/Awalan (“di-”, “ke-”, “se-”, “te-”, “be-”, “me-”, atau “pe-”) ——*/
if(eregi('^(di|[kstbmp]e)',$kata) == FALSE){
return $kataAsal;
}
return $kataAsal;
}
function NAZIEF($kata){
$kataAsal = $kata;
/* 1. Cek Kata di Kamus jika Ada SELESAI */
if($this->cekKamus($kata)){ // Cek Kamus
return $kata; // Jika Ada kembalikan
}
/* 2. Buang Infection suffixes (\-lah”, \-kah”, \-ku”, \-mu”, atau \-nya”) */
$kata = $this->Del_Inflection_Suffixes($kata);
/* 3. Buang Derivation suffix (\-i” or \-an”) */
$kata = $this->Del_Derivation_Suffixes($kata);
/* 4. Buang Derivation prefix */
$kata = $this->Del_Derivation_Prefix($kata);
//$kata2=$this->cekTotal($kata);
echo "Kata Asal =".$kataAsal ." --> Stemming ". $kata ." <br>";
return $kata;
}
}
?>