<?php #measuring run time
   $mtime = microtime(); 
   $mtime = explode(" ",$mtime); 
   $mtime = $mtime[1] + $mtime[0]; 
   $starttime = $mtime; 
;?> 

<?php
function write($class, $lecture, $teacher, $change, $classroom)
{
	#TODO structure for RSS
	echo $class . "; " .  $lecture . "; " .  $teacher . "; " .  $change . "; " .  $classroom ."<br>";
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
$html = file_get_html($url);

#get rows
$table = $html->find("table");

#set buffer
$lastClass = "";

#parse rows
foreach($table[1]->find("tr") as $row)
{
	$cells= $row->find("td");
	#if(ereg("1AZ", $cells[0]))  #sample filtering TODO
	{
		if(strlen($cells[0]->innertext)!=1)
		{
			write($cells[0], $cells[1], $cells[2], $cells[3], $cells[4]);
			$lastClass=$cells[0];
		}
		else
		{
			write($lastClass, $cells[0], $cells[1], $cells[2], $cells[3]);
		}
	}
}
?>

<?php  #output run time
   $mtime = microtime(); 
   $mtime = explode(" ",$mtime); 
   $mtime = $mtime[1] + $mtime[0]; 
   $endtime = $mtime; 
   $totaltime = ($endtime - $starttime); 
   echo "This page was created in ".$totaltime." seconds"; 
;?>