<?xml version="1.0" encoding="UTF-8" ?>
<rss version="2.0">
<channel>
<title>Suplence</title>
<description>Suplence na TSC Nova Gorica</description>
<?php
function write($class, $lecture, $teacher, $change, $classroom)
{
	echo "<item>\n";
	echo "<title>$class" . ": $lecture -> $teacher </title>\n";
	echo "<description>Pouk bo $lecture" . ". v ucilnici $classroom s prof. $teacher namesto $lecture </description>\n";
	echo "</item>\n";
}


#TODO auto parse URL
$url="data.htm";
if($_GET["url"])
{
	$url = $_GET["url"];
}


# create and load the HTML
include('simple_html_dom.php');
$html = new simple_html_dom();
$html->load_file($url);

#get rows
$table = $html->find("table");

#set buffer
$lastClass = "";

#parse rows
foreach($table[1]->find("tr") as $row)
{
	$cells= $row->find("td");
	#if(ereg("4AZ", $cells[0]))  #sample filtering TODO
	{
		if(strlen($cells[0]->innertext)!=1)
		{
			write($cells[0]->innertext, $cells[1]->innertext, $cells[2]->innertext, $cells[3]->innertext, $cells[4]->innertext);
			$lastClass=$cells[0];
		}
		else
		{
			write($lastClass->innertext, $cells[0]->innertext, $cells[1]->innertext, $cells[2]->innertext, $cells[3]->innertext);
		}
	}
}
?>
</channel>
</rss>