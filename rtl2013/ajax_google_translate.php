<?php

include('includes/ajax_top.php');

include('includes/classes/google_translates.php');

if (($_GET['text'])&& ($_GET['language_pair'])){
	
	$text = $_GET['text'];
	$language_pair = $_GET['language_pair'];

	//echo $text." ".$language_pair."<br>";
	
	$g = new Google_API_translator();
	$g->setOpts(array("text" => $text, "language_pair" => $language_pair));
	$g->translate();
	echo $g->out;

}


include('includes/ajax_bottom.php');



?>