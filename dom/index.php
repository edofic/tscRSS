<?php
function write($class, $lecture, $teacher, $change, $classroom)
{
	echo $class . "; " .  $lecture . "; " .  $teacher . "; " .  $change . "; " .  $classroom ."<br>";
}

#TODO get url
$url="http://localhost/rss/dom/data.htm";

# create and load the HTML
include('simple_html_dom.php');
$html = new simple_html_dom();
$html = file_get_html($url);

#get rows
$table = $html->find("table");
#$rows = $table[1]->find("tr");

#parse rows
foreach($table[1]->find("tr") as $row)
{
	$cells= $row->find("td");
	#if(ereg("1AZ", $cells[0]))
	{
		write($cells[0], $cells[1], $cells[2], $cells[3], $cells[4]);
	}
}

?>