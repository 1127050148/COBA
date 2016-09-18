<?php
	include "ScrawlingKompas.php";

	$ir = new ScrawlingKompas();
	$num_docs = 0;
	$corpus_terms = array();
	
	$kodeHTML = $ir->readHTML('http://localhost/COBA/parkir.php');
	$pecah = explode('<div class="kcm-read-text">', $kodeHTML);
	$pecahLagi = explode('<table class="grey">', $pecah[1]);
	$dok = $ir->striptag($pecahLagi[0]); //striptag oke
	$jum = count($dok);
	// echo($dok); echo "<br />";

	$token = $ir->index_token($dok);

	for ($i=0; $i < $jum; $i++) { 
		$term = $dok[$i];
		$tf = $ir->tf($term);
	$ndw = $ir->ndw($term);
	$idf = $ir->idf($term);
	}

	echo $tf;
	echo $ndw;
	echo $idf;


?>