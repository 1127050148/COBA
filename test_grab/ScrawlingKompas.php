<?php

define("DOC_ID", 0);
define("TERM_POSITION", 1);

class ScrawlingKompas {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	// public function index()
	// {
	// 	// $this->load->view('vclassification');
	// }

	public $num_docs = 0;
	public $corpus_terms = array();
	public $explode, $jum, $ex, $x;

	function readHTML($url)
	{
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

	function striptag($text)
	{
		$text = strip_tags($text);
		return $text;
	}

	function token($text)
	{
		$num_docs = 0;
		$term = array();

		$this->$num_docs = count($text)

		$explode=explode(" ", $text);
		$jum = count($explode);
		for ($i=0; $i<$jum ; $i++) { 
		$ex = $explode[$i];
		$x = preg_replace("/[^A-Za-z0-9 ]/", " ", $ex);
		$term = strtolower($x);

		$this->corpus_terms[$term]=array();
	}

	// function index_token($text)
	// {
	// 	$this->$num_docs = count($dok);
	// 	for ($j=0; $j < $this->num_docs; $j++) { 
	// 		$pecah = array();
		
	// 		$pecah=explode("", $dok[$j]);
	// 		$jum = count($pecah);
	// 		for ($i=0; $i<$jum ; $i++) { 
	// 			$term=strtolower($pecah[$i]);
	// 			$x = preg_replace("/[^A-Za-z0-9 ]/", " ", $term);

	// 			$this->corpus_terms[$x][]=array($j, $i);
	// 		}
	// 	}
	// }

	function show_index()
	{
		ksort($this->corpus_terms);
		foreach ($$this->corpus_terms as $term => $doc_locations) {
			echo "<b>$term</b>";
			foreach ($doc_locations as $doc_location) {
				echo "{".$doc_location[DOC_ID].",".$doc_location[TERM_POSITION]."}";
				echo "<br />";
			}
		}
	}

	function tf($term)
	{
		$term = strtolower($term);
		return count($this->corpus_terms[$term]);
	}

	function ndw($term)
	{
		$term = strtolower($term);
		$doc_locations = $this->corpus_terms[$term];
		$num_locations = count($doc_location);
		$doc_with_term = array();
		for($doc_location = 0;$doc_location<$num_location;$doc_location++)
		{
			$doc_with_term[$i]++;
			return count($doc_with_term);
		}
	}

	function idf($doc_with_term)
	{
		return log($this->num_docs) / $this->ndw($term);
	}
}
// $isi_paragraf = $hasil;

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */