<html>
	<Title>PHP Competitie (c) Erik Hendrikx</title>
	<head>
<script src="../ontip/js/utility.js"></script>
<script src="../ontip/js/popup.js"></script>

		<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">                    
		<style type='text/css' media="print" ><!-- 
BODY {color:black ;font-size: 9pt ; font-family: Comic sans, sans-serif;background-color:white}
TH {color:black ;background-color:white; font-size: 9.0pt ; font-family:Arial, Helvetica, sans-serif; color:darkgreen;Font-Style:Bold;text-align: left; }
TD {color:blue ; font-family:Arial, Helvetica, sans-serif ;padding-left: 11px;}
h1 {color:green ; font-size: 18.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
h2 {color:blue ;font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
h3 {color:green ;background-color:white; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
a {color:green ; font-size: 10.0pt ; font-family:Arial, Helvetica, sans-serif ;text-decoration:none;}
td.menuon { border-color: red;border-width:2px; border-style:solid outset;font-size:14pt;}
td.menuoff { border-color: #FFFFFF;border-width:2px;font-size:14pt;  }

.noprint {display:none;}   

.verticaltext1    {font: 11px Arial;position: absolute;right: 5px;top: 15px;
                  width: 15px;writing-mode: tb-rl;color:green;}
									 
.popup { POSITION: absolute;right:20pt; VISIBILITY: hidden; BACKGROUND-COLOR: blue; LAYER-BACKGROUND-COLOR: blue; 
         width: 460; BORDER-LEFT: 1px solid black; BORDER-TOP: 1px solid black;color:black;
         BORDER-BOTTOM: 3px solid black; BORDER-RIGHT: 3px solid black; PADDING: 3px; z-index: 10 }
-->
</style>

<script type="text/javascript">
function CopyToClipboard()
{
   CopiedTxt = document.selection.createRange();
   CopiedTxt.execCommand("Copy");
}
</script>
</head>

 <body>
 	
</head>

<body>
 
<?php
include 'mysqli.php'; 

//// Omrekenen datum
/* Set locale to Dutch */
setlocale(LC_ALL, 'nl_NL');

if (isset($_POST['speeldatum'])){
$speeldatum = $_POST['speeldatum'];
}
else {
// indien aangeroepen door step 3 dan is cookie gezet
 $speelronde  = $_COOKIE['speelronde'];
}


// indien aangeroepen door step 3 dan is cookie gezet
if (isset($_COOKIE['competitie'])){
 $competitie_id  = $_COOKIE['competitie'];
}
 
// ophalen competitie naam adhv doorgegeven id
$sql        = mysqli_query($con,"SELECT * from comp_soort where Id = '".$competitie_id."'  ")     or die(' Fout in select soort');  
$result     = mysqli_fetch_array( $sql );
$competitie_naam       = $result['Competitie'];
$soort      = $result['Soort_competitie'];

// ---------------------------------------------------------------------------------------------------------------------------------------------------
include 'kop.php'; 
?>
<center>

<?php
$jaar  = substr($speeldatum, 0,4);
$maand = substr($speeldatum, 5,2);
$dag   = substr($speeldatum,8,2);

?>
<TABLE width=100%  borde=0 class='noprint'>
	<tr>
		<td width=90%><h3  style='font size=20pt;color:green;text-align:center;'>Invullijst speeldag</h3></td>
	  <td valign="top" style='text-align:right;'><INPUT type= 'button' alt='Print deze pagina' value = 'Print'  onClick='window.print()'></td>
    <td style='text-align:right;' valign=top><a href='index.php'border = 0><img src='images/home.png' border =0 width=80 alt='Terug naar homepage'></a></td>
</tr>
</table>


<table width=1500  border =2 id='MyTable1'>

<tr>
		<th colspan=2 style='font size=20pt;color:black;text-align:center;font-weight:bold;'><?php echo strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) )?></th>
<?php
// ophalen rondes van die dag. nu alleen tbv koptekst
	 	  $sql1        = "SELECT * from comp_data where Vereniging = '".$vereniging."' and Competitie = '".$competitie_naam."' and Speeldatum = '".$speeldatum."' order by Speelronde";
	 	  $datums      = mysqli_query($con,$sql1);  	 

     while($row1 = mysqli_fetch_array( $datums )) { 
        
        echo "<th colspan = 3  style='font-size:14pt;border-right: solid 2px blue;background-color:green;color:white;'><center>Ronde ".$row1['Speelronde']."</center></th>";
        
      } // end while 
      ?>
      </tr>
      <tr><th>Team</th><th >Namen</th>
      <?php
      
      // ophalen rondes van die dag. nu alleen tbv koptekst2
	 	  $sql1        = "SELECT * from comp_data where Vereniging = '".$vereniging."' and Competitie = '".$competitie_naam."' and Speeldatum = '".$speeldatum."' ";
	 	  $datums      = mysqli_query($con,$sql1);  	 

     while($row1 = mysqli_fetch_array( $datums )) { 
        
        echo "<th>Voor</th><th>Tegen</th><th style='border-right: solid 2px blue;padding-right:2pt;'>Tegen<br>stander</th>";
      } // end while 
      ?> 
       </tr>
      
   
			<?php
			/// detailregels
			$sql        = "SELECT Distinct Team from comp_spelers where Vereniging = '".$vereniging."' and Competitie = '".$competitie_naam."' order by Team";
      $teams      = mysqli_query($con,$sql);  	 	   	 
  	 	  
  	 	  while($row = mysqli_fetch_array( $teams )) {  	 
  	 	 // echo $row['Team'];
  	 	   
  	 	  // samenstellen teams 	 	  
  	 	  $sql2        = "SELECT * from comp_spelers where Vereniging = '".$vereniging."' and Competitie = '".$competitie_naam."' and Team = '".$row['Team']."' ";
  	 	  $spelers     = mysqli_query($con,$sql2);  	 
  	
  	 	  $i           = $row['Team'];
  	 	  $team_namen     = '';
  	 	  
  	 	  while($row2 = mysqli_fetch_array( $spelers )) {  	 
  	 	  
  	 	  	$team_namen .= $row2['Naam']. " - ";
  	 	   }
  	 	   $len = strlen($team_namen);
  	 	   $team_namen  = substr($team_namen,0,$len-2);	


        echo "<tr><td STYLE ='font-size: 18pt; background-color:white;color:red ;'>".$row['Team']."</td>";
        echo "<td STYLE ='font-size: 18pt; background-color:white;color:blue ;'>".$team_namen."</td>";


/////////////////////////// ophalen rondes van die dag. nu tbv detailregels
	 	  $sql1        = "SELECT * from comp_data where Vereniging = '".$vereniging."' and Competitie = '".$competitie_naam."' and Speeldatum = '".$speeldatum."'  order by Speelronde";
	 	  $datums      = mysqli_query($con,$sql1);  	 

     while($row1 = mysqli_fetch_array( $datums )) { 

        $speelronde  = $row1['Speelronde'];
  	 	   
  	 	  	 	  
  	 	  // ophalen tegenstander uit comp_spel_schema
  	 	  $sql4        = "SELECT Tegenstander from comp_spel_schema where Competitie = '".$competitie_naam."' and Speelronde = ".$speelronde." and Team = '".$row['Team']."' ";    
        $out         = mysqli_query($con,$sql4);  	 
        $result      = mysqli_fetch_array( $out );
        $tegenstander = $result['Tegenstander'];
  	 	   
  	 	   if ($tegenstander == 'BAR' or $tegenstander == '') {
  	 	   	  echo "<td STYLE ='font size: 28pt; background-color:white;width:35pt;'>xxx</td>";
  	 	      echo "<td STYLE ='font size: 28pt; background-color:white;width:35pt;'>xxx</td>";
  	 	    } else {
  	 	      echo "<td STYLE ='font size: 28pt; background-color:white;width:35pt;'>__</td>";
  	 	      echo "<td STYLE ='font size: 28pt; background-color:white;width:35pt;'>__</td>";
  	 	   }   
  	 	   
  	 	   
          echo "<td STYLE ='font size: 21pt; background-color:white;color:green ;border-right: solid 2px blue;padding-right:2pt;text-align:center;'>".$tegenstander."</td>";
        
        
  	    
  	  } // end while speeldatum
  	    echo "</tr>";
  	    
  	 	} /// end while
  	?>
 </tr>    
  </table>  
 </body>
</html>
