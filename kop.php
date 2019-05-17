<?php
// ophalen competitie naam adhv doorgegeven id
$sql        = mysqli_query($con,"SELECT * from comp_soort where Id = '".$competitie_id."'  ")     or die(' Fout in select');  
$result     = mysqli_fetch_array( $sql );
$competitie = $result['Competitie'];
$soort      = $result['Soort_competitie'];
?>
<table STYLE ='background-color:white;' width=98% border=0 class='noprint'>
<tr><td rowspan=3 cellpadding=0><img src = '<?php echo $url_logo?>' width=100></td>

<td STYLE ='font size: 40pt; background-color:white;color:green ;font-family:cursive;'>Boules competitie <?php echo $vereniging ?></TD>
	<td rowspan=3 style='text-align:right;padding:2px;'><img src = 'images/boules.jpg' width=100></td></tr><tr>
	<?php if (isset($competitie)){ ?>
<td STYLE ='font size: 20pt; background-color:white;color:blue ;'> <?php echo $competitie; ?>    </TD></tr>
<?php } else { ?>
<td STYLE ='font size: 20pt; background-color:white;color:blue ;'> onbekend</TD></tr>
<?php }?>

</TABLE>
<hr color='red' class='noprint' />