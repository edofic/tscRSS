<?php
$url="left.htm";


# create and load the HTML
include('simple_html_dom.php');
$html = new simple_html_dom();
$html->load_file($url);

$links = $html->find("a");

foreach($links as $link)
{
echo $link->innertext . "<br>";
}
?>