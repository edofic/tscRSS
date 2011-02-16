<?php 
   $mtime = microtime(); 
   $mtime = explode(" ",$mtime); 
   $mtime = $mtime[1] + $mtime[0]; 
   $starttime = $mtime; 
;?> 
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
	#TODO structure for RSS
	echo $class . "; " .  $lecture . "; " .  $teacher . "; " .  $change . "; " .  $classroom ."<br>";
}

#######
#START"
#######

include('simple_html_dom.php');

#get current filename
$url="http://asc.tsc.si/ngsupl/subst_left.htm"; ##TODO set the real one
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
$html->clear();

$url="http://asc.tsc.si/ngsupl/" . $rightChoice;
# create and load the HTML
$html = new simple_html_dom();
$html->load_file($url);

#get rows
$table = $html->find("table");

#set buffer
$class="";

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
<?php 
   $mtime = microtime(); 
   $mtime = explode(" ",$mtime); 
   $mtime = $mtime[1] + $mtime[0]; 
   $endtime = $mtime; 
   $totaltime = ($endtime - $starttime); 
   echo "This page was created in ".$totaltime." seconds"; 
;?>
