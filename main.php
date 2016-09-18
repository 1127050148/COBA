<?php

include "IR.php";
// document yang sebagai percobaan
$D[0] = "Membuka blog khozaimi asyik";
$D[1] = "Selain asyik blog khozaimi juga banyak yang bisa diperoleh";
$D[2] = "ayuk kita kunjungi blogna khozaimi biar asyik";

$ir = new IR();

echo "<p><b>Corpus:</b></p>";
$ir->show_index($D);

$ir->create_index($D);

echo "<p><b>Inverted Index:</b></p>";
$ir->show_index();

$term = "blog";  //kata asyik yang akan menjadi pusat perhitungan kita
$tf  = $ir->tf($term);
$ndw = $ir->ndw($term);
$idf = $ir->idf($term);
echo "<p>";
echo "Term Frequency of '$term' is $tf<br />";
echo "Number Of Documents with $term is $ndw<br />";
echo "Inverse Document Frequency of $term is $idf";
echo "</p>";

?>