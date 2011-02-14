<?php
//TODO get url
//$html = file_get_contents("http://localhost/rss/data.htm");
$html = file_get_html("http://localhost/rss/data.htm");
foreach($html->find('a') as $element) 
       echo $element->href . '<br>';

?>