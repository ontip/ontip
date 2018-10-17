<html>
<title>PHP Toernooi Inschrijvingen</title>
<head>
	<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">                    
<style type='text/css'><!-- 
BODY {color:black ;font-size: 9pt ; font-family: Comic sans, sans-serif;background-color:white}
TH {color:black ;background-color:white; font-size: 9.0pt ; font-family:Arial, Helvetica, sans-serif; color:darkgreen;Font-Style:Bold;text-align: left; }
h1 {color:orange ; font-size: 18.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
h2 {color:blue ;background-color:white; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
h3 {color:red ; font-size: 16.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
table,textarea,td {font-family:courier new;font-size: 9pt ; }
.verticaltext1    {font: 11px Arial;position: absolute;right: 5px;bottom: 35px;
                  width: 15px;writing-mode: tb-rl;color:black;}
// -->
table {border-collapse: collapse;}
.textareaCode {font-family:courier new; font-size: 9pt ;}
</style>
<script type="text/javascript">

function SelectRange (element_id) {
var d=document;
if(d.getElementById ) {
var elem = d.getElementById(element_id);
if(elem) {
if(d.createRange) {
var rng = d.createRange();
if(rng.selectNodeContents) {
rng.selectNodeContents(elem);
if(window.getSelection) {
var sel=window.getSelection();
if(sel.removeAllRanges) sel.removeAllRanges();
if(sel.addRange) sel.addRange(rng);
}
}
} else if(d.body && d.body.createTextRange) {
var rng = d.body.createTextRange();
rng.moveToElementText(elem);
rng.select();
}
}
}
}
</script>
<script type="text/javascript">
function CopyToClipboard()
{
   CopiedTxt = document.selection.createRange();
   CopiedTxt.execCommand("Copy");
}
</script>

</head>
<body>

<h3>Hulpmiddel voor tickertape</h3>

In de tickettape worden de komende 15 OnTip toernooien getoond. De toernooi namen bevatten ook een link naar het overeenkomstige inschrijfformulier.<br>
<br>
<b>
Klik op de Select  knop.
Alles wat zich binnen het rode vlak bevind wordt geslecteerd.Druk daarna op CTRL-C. <i>Plak daarna de gekopieerde tekst in je HTML pagina.</i><br></font></b>


		<textarea class="code_input" id="textareaCode" wrap="logical" rows="9" cols="90" SCROLLING=NO style="border: red solid 1px;padding:0pt;width:550pt;">
	     <iframe SRC ='http://www.boulamis.nl/boulamis_toernooi/ticker_toernooien_ontip.php?
	       width=250
	       &textcolor=yellow
	       &mouseovercolor=white
	       &backgroundcolor=red
	       &limit=10' 
	       WIDTH=500 SCROLLING=NO HEIGHT=45  
	       SEAMLESS>
	       </iframe>
</textarea>
<br>
<!--  Knoppen voor verwerking   ----->
<center>

<form name="test2">
<input type="button" onClick="CopyToClipboard(SelectRange('textareaCode'))" value="Select" />
</form>
</center>
<h3>Uitleg </h3>
Het programma 'ticker_toernooien_ontip.php wordt met een viertal parameters gestart:<br>
<ul>
	<li> width=250               geeft de breedte van de tickertape aan
	<li> textcolor=kleur         geeft de tekst kleur van de ticker aan.
	<li> mousovercolor=kleur     geeft de kleur aan die de tekst krijgt als je er met de muis overheen gaat. De tekst stop dan.
	<li> backgroundcolor=kleur   geeft de achtergrond kleur van de ticker aan. (LET op de ' achter de kleur!! Deze geeft het einde van de parameters weer)
	<li> limit=10                geeft het maximum aantal toernooien aan die in de ticker staan.

 </ul>

WIDTH=500 is de breedte van het iframe<br>
SCROLLING=NO betekent dat er geen scroll balken verschijnen<br>
HEIGHT=45 is de hoogte van het iframe<br>
SEAMLESS geeft aan dat het iframe zonder randen verschijnt op de HTML pagina.<br>



</body>
</html>

