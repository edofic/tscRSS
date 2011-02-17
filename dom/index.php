<?php

function rssDate($timestamp=null)
   {
       $timestamp = ($timestamp==null) ? time() : $timestamp;

       return date(DATE_RSS, $timestamp);
   }

function write($class, $lecture, $teacher, $change, $classroom)
{
       echo "<item>\n";
       echo "<title>$class" . ": $lecture -> $change </title>\n";
       echo "<description>Pouk bo $lecture" . ". v ucilnici $classroom namesto $teacher </description>\n";
       echo "<guid>" . md5($class . $lecture . $teacher . $change . $classroom) . "</guid>" ;
       #echo "<pubDate>" . rssDate() . "</pubDate>";
       echo "</item>\n";
}


#######
#START"
#######

echo '<?xml version="1.0" encoding="UTF-8" ?>
<rss version="2.0">
<channel>
<title>Suplence</title>
<description>Suplence na TSC Nova Gorica</description>';

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

if($rightChoice!="")
{
$url="http://asc.tsc.si/ngsupl/" . $rightChoice;
# create and load the HTML
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
               $lecture=$cells[1]->innertext; $teacher=$cells[2]->innertext;
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

       if(eregi($_GET["q"], $class) || ($_GET["q"]==""))  #TODO filtering?
       {
               write($class, $lecture, $teacher, $change, $classroom);
       }
}
}
echo "</channel>
</rss>";
?>