<?php
# create and load the HTML
include('simple_html_dom.php');
$html = new simple_html_dom();
$html = file_get_html("http://localhost/RSS/dom/quasi.html");

$table = $html->find("table");
$rows = $table[1]->find("tr");
#$cells= $rows[1]->find("td");

//echo $cells[0];

foreach($rows as $row)
{
	$cells = $row->find("td");
	foreach($cells as $cell)
	{
		echo $cell;
		echo "; ";
	}
	#echo count($cells);
	echo "<br>";
}



# get an element representing the second paragraph
#$element = $html->find("p");

# modify it
#$element[1]->innertext .= " and we're here to stay.";

# output it!
# echo $html->save();
?>