<?php
    // Tokenization Function
    function tokenization($text){
        // Removing punctuation in the text.
        $text = preg_replace("/[?!.,()*]|[-]|'/"," ", $text);
 
        // Convert text to lower case
        $text = strtolower(trim($text));
 
        // Tokenization
        $word = explode(" ",$text);
        $tok = $word;
 
        for($i=0;$i<=(count($tok)-1);$i++){
            for($j=0;$j<=(count($tok)-1);$j++){
                if ($word[$i] == $tok[$j]){
                    $freq[$word[$i]]+=1;
                    array_splice($word,$i,1);
                }
            }
        }
 
        // Sort the results of tokenization based on the largest frequency
        arsort($freq);
 
        // Returns the result of Tokenization
        return $freq;
 
    }
 
    $news = "Information retrieval (IR) is the area of study concerned with searching for documents, for information within documents, and for metadata about documents, as well as that of searching relational databases and the World Wide Web. There is overlap in the usage of the terms data retrieval, document retrieval, information retrieval, and text retrieval, but each also has its own body of literature, theory, praxis, and technologies. IR is interdisciplinary, based on computer science, mathematics, library science, information science, information architecture, cognitive psychology, linguistics, and statistics.";
 
    $result = tokenization($news);
 
    // The result in table
    echo "<table border='1'><tbody><tr><th width='20%'>Result</th><th>News</th></tr><tr><td><ol>";
    foreach($result as $key => $val) {
        echo "<li>$key = $val</li>";
    }
    echo "</ol></td><td align='justify' valign='top'>$news</td></tr></tbody></table>";
?>