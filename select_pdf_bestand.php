<html
<head>
<meta http-equiv="Content-Language" content="nl">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta http-equiv="refresh">
<title>Select bestand</title>
<style type="text/css">
	body {font-family: Comic sans, sans-serif, Verdana;  }
th {color:white;font-size:10pt;background-color:darkblue;}
td {padding:5pt;background-color:white;clor:darkblue;}
a    {text-decoration:none ;color:blue;font-size:9pt;}
a:hover {color:red;}

</style>
</head>

<body style="background-attachment: fixed">

<div style='background-color:white;'>
<table >
<tr><td style='background-color:white;' rowspan=2 width='280'><img src = '../ontip/images/ontip_logo.png' width='240'></td>
<td STYLE ='font-size: 36pt; background-color:white;color:green ;'>Nieuwsbrieven en handleidingen</TD></tr>
</tr>
</TABLE>
</div>
<hr color='red'/>

<span style='text-align:right;'><a href='index.php'>Terug naar Hoofdmenu</a></span>

<blockquote>

<!---///////                   Bestanden lijst ---------------------------------------------------------------////-->

 <h4 Style='font-family:verdana;font-size:11pt;color:blue;padding-left:45pt;'>Klik op de bestandsnaam om het bestand te openen.</h4>

<div style= 'padding-left:55pt;'> 
<table border="1" cellpadding="0" cellspacing="0" width=90%  style="border-collapse: collapse;background-color:white;padding:5pt;box-shadow: 10px 10px 5px #888888;'"> 
<tr>
	<th style='width:30pt;'>Nr.		</th>
	<th style='width:60pt;'>Soort bestand</th>
	<th>Bestand</th>
		</tr>

<!-----///////----   file browser  ----------------------------------------------////----->

<?php
include('mysqli.php');	

		$dir            = '../ontip/pdf/nieuwsbrieven';
// Maak een gesorteerde lijst op naam
if ($handle = @opendir($dir)) {
    $files = array();
    while (false !== ($files[] = @readdir($handle))); 
    sort($files);
    closedir($handle);
}

$j=1; 

?>
<tr>
	<?php
foreach ($files as $file) {
   	               
        if (strlen($file) > 3 ){    
        	$bestand  = $dir."/".$file;
        	$filesize = 0;   
        	$filesize = filesize($bestand);
        	$last_mod = filectime($bestand);
        	$parts   = explode(".", $file);
        	$ext     = $parts[1];
        	  
 	        if ($ext != '') {  // skip folders
 	        	switch(strtoupper($ext)){
 	           	case "PDF" : $img = '../ontip/images/pdf.gif';break;
 	        	  case "DOC" : $img = '../ontip/images/icon_word.png';break;
 	        	  case "XLS" : $img = '../ontip/images/icon_excel.png';break;
 	        	  default    : $img = '../ontip/images/pdf.gif';break;
 	         } // end switch
 	
          echo "<tr><td  style= 'text-align:right;font-size:10pt;color:blue;'>".$j.".</td>";
          echo "<td><center><img src= '".$img."' width=35 border = 0></center></td>";
          echo "<td style='text-align:left;font-size:10pt;color:black;'><a href= '".$bestand."' target ='_blank' >".$file."</a></td></tr>";
        
          
          $j++;
         }    // end if ext 
 	        
         } // end if strlen
       }// end foreach
 

?>
  </table>
   </div>

</body>
</html>
