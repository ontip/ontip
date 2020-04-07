<?php
?>
<html>
	<head>
		<style>
		body { margin: 0;
		 width: 100%; 
    height: 100%;

}
Iframe
{
padding:0;
margin: 0cm;
		 width: 100%; 
    height: 100%;
    overflow:hidden;
}

</style>
</head>
			
<script type="text/javascript">
function init() {
var toernooi= window.location.search.substring(9);
var url = "https://www.petanqueinschrijven.com/boulamis/Inschrijfform.php?toernooi	" + toernooi;
document.getElementById("myframe").src = url;
}
</script>
<body onLoad="init()">
<iframe id="myframe" height="100%" scrolling="auto" frameborder="0"   src=""></iframe>
</body>
</html>
<?php?>
