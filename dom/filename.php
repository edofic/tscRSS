<?php
function getFilename()
{
	$url="left.htm"; ##TODO set the real one

	# create and load the HTML
	include('simple_html_dom.php');
	$html = new simple_html_dom();
	$html->load_file($url);

	$links = $html->find("a");

	$now = time();##mktime(15,0,1,2,3); #for testing
	$rightChoice="";

	foreach($links as $link)
	{
		$time=strtotime($link->plaintext);
		if(($time+16*3600)>=$now) #show today's file until 16.00
			$rightChoice=$link->href;
		else
			break;
	}
	return $rightChoice;
}

echo getFilename();

?>