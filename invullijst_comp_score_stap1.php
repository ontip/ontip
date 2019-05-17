<?php
// delete cookie speeldatum
setcookie ("speeldatum", $speeldatum, time() -1800);
?> 
<html>
	<Title>PHP Competitie (c) Erik Hendrikx</title>
	<head>
<script src="../ontip/js/utility.js"></script>
<script src="../ontip/js/popup.js"></script>

		<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">                    
		<style type='text/css'><!-- 
BODY {color:black ;font-size: 9pt ; font-family: Comic sans, sans-serif;background-color:white}
TH {color:black ;background-color:white; font-size: 9.0pt ; font-family:Arial, Helvetica, sans-serif; color:darkgreen;Font-Style:Bold;text-align: left; }
TD {color:blue ;background-color:white; font-size: 9.0pt ; font-family:Arial, Helvetica, sans-serif ;padding-left: 11px;}
h1 {color:green ; font-size: 18.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
h2 {color:blue ;font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
h3 {color:green ;background-color:white; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
a {color:green ; font-size: 10.0pt ; font-family:Arial, Helvetica, sans-serif ;text-decoration:none;}
td.menuon { border-color: red;border-width:2px; border-style:solid outset;font-size:14pt;}
td.menuoff { border-color: #FFFFFF;border-width:2px;font-size:14pt;  }

.verticaltext1    {font: 11px Arial;position: absolute;right: 5px;top: 15px;
                  width: 15px;writing-mode: tb-rl;color:green;}
									 
.popup { POSITION: absolute;right:20pt; VISIBILITY: hidden; BACKGROUND-COLOR: blue; LAYER-BACKGROUND-COLOR: blue; 
         width: 460; BORDER-LEFT: 1px solid black; BORDER-TOP: 1px solid black;color:black;
         BORDER-BOTTOM: 3px solid black; BORDER-RIGHT: 3px solid black; PADDING: 3px; z-index: 10 }
-->
</style>

</head>
<body>
 
<?php
include 'mysqli.php'; 

if(!isset($_COOKIE['aangelogd'])){ 
echo '<script type="text/javascript">';
echo 'window.location = "aanlog.php?key=PL"';
echo '</script>';
}

// indien aangeroepen door step 3 dan is cookie gezet
if (isset($_COOKIE['competitie'])){
 $competitie_id  = $_COOKIE['competitie'];
}


// ophalen competitie naam adhv doorgegeven id
$sql        = mysqli_query($con,"SELECT * from comp_soort where Id = '".$competitie_id."'  ")     or die(' Fout in select');  
$result     = mysqli_fetch_array( $sql );
$competitie_naam       = $result['Competitie'];
$soort      = $result['Soort_competitie'];

//echo  "vereniging : ". $vereniging;


$sql        = "SELECT * from comp_data where Vereniging = '".$vereniging."' and Competitie = '".$competitie_naam."'  group by Speeldatum order by Speeldatum";
$datums     = mysqli_query($con,$sql);

// ---------------------------------------------------------------------------------------------------------------------------------------------------
include 'kop.php'; 
?>
<center>
<FORM action='invullijst_comp_score_stap2.php' method='post'>
	<table STYLE ='background-color:white;' width=100% border=0>
		<td widthh=90% ><h3  style='padding:10pt;font size=20pt;color:green;text-align:center;'>Lege lijst score competitie</h3></td>
	<td style='text-align:right;' valign=top><a href='index.php'border = 0><img src='images/home.png' border =0 width=80 alt='Terug naar homepage'></a></td><tr>
	</table>
	
<input type='hidden'   name='vereniging'    value= '<?php echo htmlspecialchars($vereniging); ?>'  />	
<input type='hidden'   name='competitie_id' value= '<?php echo $competitie_id; ?>'  />	
<input type='hidden'   name='soort'         value= '<?php echo $soort; ?>'  />


 <table width=50%>
   <tr>
  	 
  	 <td width='250' STYLE ='font size: 15pt; background-color:white;color:blue;'>Selecteer een speeldatum</td>
     <td><select name='speeldatum' STYLE='font-size:14pt;background-color:white;width:200px;'>
	 	<option value='' selected>Selecteer...</option>
	 	
	     <?php
           
	       	while($row = mysqli_fetch_array( $datums )) {
 	         	echo "<OPTION  value=".$row['Speeldatum'].">";
    	      echo substr($row['Speeldatum'],0,10);
    	      echo "</OPTION>";	
          } /// end while
    ?>
    </SELECT>
    </label>
</td>
<td><input type ='submit' value= 'Klik hier na selecteren'> </center></td>

</tr>
</table>  	 	   	 
</form> 
 </body>
</html>
