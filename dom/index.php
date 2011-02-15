<?xml version="1.0" encoding="UTF-8" ?>
<rss version="2.0">
<channel>
<title>Suplence</title>
<description>Suplence na TSC Nova Gorica</description>
<?php
function rssDate($timestamp=null)
    {
        /*** set the timestamp ***/
        $timestamp = ($timestamp==null) ? time() : $timestamp;

        /*** Mon, 02 Jul 2009 11:36:45 +0000 ***/
        return date(DATE_RSS, $timestamp);
    }
	
function write($class, $lecture, $teacher, $change, $classroom)
{
	echo "<item>\n";
	echo "<title>$class" . ": $lecture -> $change </title>\n";
	echo "<description>Pouk bo $lecture" . ". v ucilnici $classroom namesto $teacher </description>\n";
	echo "<guid>" . md5($class . $lecture . $teacher . $change . $classroom) . "</guid>" ;
	echo "<pubDate>" . rssDate() . "</pubDate>";
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
	if(strlen($cells[0]->innertext)!=1)
	{
		$class=$cells[0]->innertext;
		$lecture=$cells[1]->innertext;
		$teacher=$cells[2]->innertext;
		$change=$cells[3]->innertext;
		$classroom=$cells[4]->innertext;
	}
	else
	{
		$lecture=$cells[0]->innertext;
		$teacher=$cells[1]->innertext;
		$change=$cells[2]->innertext;
		$classroom=$cells[3]->innertext;
	}
	if(eregi($_GET["q"], $class))  #TODO filtering?
	{
		write($class, $lecture, $teacher, $change, $classroom);	
	}
}
?>
</channel>
</rss>