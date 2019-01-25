<?php
//// Script voor het afhandelen van de lichtkrant (marquee). de HTML marquee functie wordt niet ondersteund in Chrome.
?>

<SCRIPT>

// Hieronder verander je berichten. je kunt er net zoveel toevoegen als je wilt, gewoon doornummeren
var text=new Array()
text[0]="<?php echo $extra_koptekst;?>"

<?php $link = $prog_url."Inschrijfform.php?toernooi=".$toernooi; ?>

// verander hieronder de url voor ieder bericht
var textlink=new Array()
textlink[0]="<?php echo $link;  ?>"

// verander hier de target voor iedere link
// je kunt kiezen uit "_blank", "_self", "_top", "_parent"
var texttarget=new Array()
texttarget[0]="_blank"


// lettertype
var textfont="Verdana"

// letter kleur
var textfontcoloraa="<?php echo $tekst_kleur; ?>"
var textfontcolorbb="<?php echo $koptekst; ?>"

// kleur bij mouse-over
var textfontcolorrollover="<?php echo $koptekst; ?>"

// tekst grootte
var textfontsize=12

// achtergrondkleur
var textbgcolor="<?php echo $achtergrond_kleur; ?>"

// weergave ( bold of plain )
var textweight="bold"

// italic of normal
var textitalic="normal"

// breedte en hoogte van de scrollerbox afhankelijk van breedte tekst

<?php 
$len       = strlen($extra_koptekst);
echo $len;

$text_width = 780;
?>

// Voorgeloot met daarna poules

var textwidth="<?php echo $text_width; ?>"
var textheight=30

// kleur rand van de scrollerbox
var textbordercolor="<?php echo $koptekst; ?>"

// breedte van de scrollerbox
var textborder=1

// breedte van de transparante zones
var translayerszone=10

// hieronder niets meer veranderen
var textpause=0
var textitalicA=""
var textitalicB=""
var textweightA="<b>"
var textweightB="</b>"
var textdecoration="none"
var textalignonly="center"
var textfontsizeHTML=3
var i_text=0
var textcontent=""
var thisspan=""
var content=""
var contentbg=""
var toggle=1
var timer
var scrollready=true
var tablewidth
var tableheight
var textfontcolortoggle=new Array()
var toggle=1            
var step=6;          
var content
var padding=3
var textcontentheight
var textcontentwidth
var translayerswidth=2
var translayersmax=Math.floor(translayerszone/translayerswidth)
var translayersleftpos=0
var translayersopacity=100
var translayersfactor=100/translayersmax
var translayerswidthall=translayersmax*translayerswidth
var ie=document.all?1:0 
var ns6=document.getElementById&&!document.all?1:0
var ns4=document.layers?1:0
var browserinfos=navigator.userAgent 
var opera=browserinfos.match(/Opera/)  

getcontent()
function getcontent() {
	if (ie || ns6) {	
		tablewidth=textwidth-2*textborder
		tableheight=textheight-2*textborder
		content="<table width="+tablewidth+" height="+tableheight+" cellpadding=3 cellspacing=0 border=0><tr valign=middle><td><nobr>"
		for (i=0;i<text.length;i++) {
			if (toggle==1) {textfontcolortoggle[i]=textfontcoloraa}
			else if (toggle==-1) {textfontcolortoggle[i]=textfontcolorbb}
			toggle*=-1
			content+="<a href=\""+textlink[i]+"\" target=\""+texttarget[i]+"\" style=\"position:relative;font-family:\'"+textfont+"\';font-size:"+textfontsize+"pt;font-weight:"+textweight+";text-decoration:"+textdecoration+";color:"+textfontcolortoggle[i]+";font-style:"+textitalic+";\" onMouseOver=\"this.style.color=\'"+textfontcolorrollover+"\'\" onMouseOut=\"this.style.color=\'"+textfontcolortoggle[i]+"\'\">"
			content+=text[i]
			content+="</a><font color="+textbgcolor+">----------</font>"

		}
		content+="</nobr></td></tr></table>"
	}
	else {	
		tablewidth=textwidth-2*textborder
		tableheight=textheight-2*textborder
		contentbg="<table width="+tablewidth+"  height="+tableheight+"><tr><td><font color="+textbgcolor+">hi</font></td></tr></table>"
		content="<table height="+textheight+" cellpadding=0 cellspacing=0><tr valign=middle><td><nobr>"
		for (i=0;i<text.length;i++) {
			if (toggle==1) {textfontcolortoggle[i]=textfontcoloraa}
			else if (toggle==-1) {textfontcolortoggle[i]=textfontcolorbb}
			toggle*=-1
			content+="<a href=\""+textlink[i]+"\" target=\""+texttarget[i]+"\" style=\"position:relative;font-family:\'"+textfont+"\';font-size:"+textfontsize+"pt;font-weight:"+textweight+";text-decoration:"+textdecoration+";color:"+textfontcolortoggle[i]+";font-style:"+textitalic+";\" >"
			content+=text[i]
			content+="</a><font color="+textbgcolor+">----------</font>"
		}
		content+="</nobr></td></tr></table>"
	}
}

if (ns4) {
toggle=1
	document.write('<table cellpadding=0 cellspacing=0 border=0 height='+textheight+' width='+textwidth+'><tr><td>');
	document.write('<ilayer name="marker" bgcolor="'+textbordercolor+'" width='+textwidth+' height='+textheight+'></ilayer>');
	document.write('</td></tr></table>')
		document.write('<layer name="tickerbg" left='+textborder+' top='+textborder+' width='+(textwidth-4*textborder)+' height='+(textheight-2*textborder)+' bgcolor='+textbgcolor+' visibility=hide>'+contentbg+'</layer>')
		document.write('<layer left=-50000 name="ticker"  onMouseOver="setscrollready(0)" onMouseOut="setscrollready(1)">loading</layer>');

}

if (ie || ns6) {
	document.write('<table cellpadding=0 cellspacing=0 border=0 height='+textheight+' width='+textwidth+'><tr><td>');
	document.write('<div id="marker" style="position:relative; width:'+textwidth+'; height:'+textheight+'" ></div>');
	document.write('</td></tr></table>')
	if (ns6) {
		var tablewidth=textwidth-2*textborder
		var tableheight=textheight-2*textborder
	}
	else {
		var tablewidth=textwidth
		var tableheight=textheight
	}
	document.write('<div ID="roof" style="position:absolute;width:'+tablewidth+'px;height:'+tableheight+'px;border-style:solid;border-width:'+textborder+'px;border-color:'+textbordercolor+';background-color:'+textbgcolor+';visibility:hidden;overflow:hidden" onMouseOver="setscrollready(0)" onMouseOut="setscrollready(1)">')
	document.write('<span ID="ticker" style="position:absolute;top:0px;left:0px;visibility:hidden">'+content+'</span>')
	
	if (ie && !opera) {
		for (i=0;i<=translayersmax;i++) {
		document.write('<span ID="trans'+i+'" style="position:absolute;top:0px;left:'+translayersleftpos+'px;width:'+translayerswidth+'px;height:'+tableheight+'px;background-color:'+textbgcolor+';filter:alpha(opacity='+translayersopacity+');overflow:hidden"> </span>')
		translayersleftpos+=translayerswidth
		translayersopacity-=translayersfactor
		}
		translayersleftpos=tablewidth-translayersleftpos
		for (ii=0;ii<=translayersmax;ii++) {
		document.write('<span ID="trans'+ii+'" style="position:absolute;top:0px;left:'+translayersleftpos+'px;width:'+translayerswidth+'px;height:'+tableheight+'px;background-color:'+textbgcolor+';filter:alpha(opacity='+translayersopacity+');overflow:hidden"> </span>')
		translayersleftpos+=translayerswidth
		translayersopacity+=translayersfactor
		}
	}
	
	if (ns6 && !opera) {
		for (i=0;i<=translayersmax-1;i++) {
		document.write('<span ID="transleft'+i+'" style="position:absolute;top:0px;left:'+translayersleftpos+'px;width:'+translayerswidth+'px;height:'+tableheight+'px;background-color:'+textbgcolor+';-moz-opacity:'+translayersopacity/100+';overflow:hidden"> </span>')
		translayersleftpos+=translayerswidth
		translayersopacity-=translayersfactor
		if (translayersopacity<0) {translayersopacity=0.001}
		}
		translayersleftpos=tablewidth-translayersleftpos
		translayersopacity=0.001
		for (i=0;i<=translayersmax-1;i++) {
		document.write('<span ID="transright'+i+'" style="position:absolute;top:0px;left:'+translayersleftpos+'px;width:'+translayerswidth+'px;height:'+tableheight+'px;background-color:'+textbgcolor+';-moz-opacity:'+translayersopacity/100+';"> </span>')
		translayersleftpos+=translayerswidth
		translayersopacity+=translayersfactor
		}
	}
	
	
	document.write('</div>')
	if (ns6) {
		document.write('<span ID="tickersize" style="position:absolute;top:0px;left:-5000px;visibility:hidden">'+content+'</span>')
	}
}

function doscroll(){
	if (scrollready) {
		if(ns4){
			document.ticker.left+=-step;
			if (document.ticker.left<document.marker.pageX+1*textborder) {
				document.ticker.clip.left+=step;
			}
		
			document.ticker.clip.right+=step;
			if(document.ticker.left<-textcontentwidth+document.marker.pageX) {
				document.ticker.left=textwidth+document.marker.pageX-1*textborder;
				document.ticker.clip.left=0
				document.ticker.clip.right=0
			}
		}
		if (ie) {
			document.all.ticker.style.posLeft+=-step
			if (document.all.ticker.style.posLeft<-textcontentwidth) {
				document.all.ticker.style.posLeft=textwidth
			}
		}
		if (ns6) {
		document.getElementById('ticker').style.left=parseInt(document.getElementById('ticker').style.left)-step
			if (parseInt(document.getElementById('ticker').style.left)<-textcontentwidth) {
				document.getElementById('ticker').style.left=textwidth
			}
		}
		timer=setTimeout("doscroll()",50)
	}
	else {
		clearTimeout(timer)
	}
}

function DL_GetElementLeft(eElement) {
    var nLeftPos = eElement.offsetLeft;          
    var eParElement = eElement.offsetParent;     
    while (eParElement != null) {                                            
        nLeftPos += eParElement.offsetLeft;      
        eParElement = eParElement.offsetParent;  
    }
    return nLeftPos;                            
}

function DL_GetElementTop(eElement) {
    var nTopPos = eElement.offsetTop;            
    var eParElement = eElement.offsetParent;     
    while (eParElement != null) {                                            
        nTopPos += eParElement.offsetTop;        
        eParElement = eParElement.offsetParent;  
    }
    return nTopPos;                              
}

function initscroller(){
	if (ns4) {
		getcontent()
		var thisspan=eval("document.ticker")
		thisspan.document.clear()
		thisspan.document.write(content)
		thisspan.document.close()
		textcontentwidth=thisspan.clip.right
		document.tickerbg.left=document.marker.pageX+1*textborder
		document.tickerbg.top=document.marker.pageY+1*textborder
		thisspan.left=document.marker.pageX-1*textborder+textwidth
		thisspan.top=document.marker.pageY
		thisspan.clip.width=textcontentwidth;
		thisspan.clip.height=textheight;
		thisspan.clip.left=0
		thisspan.clip.right=0
		document.tickerbg.visibility="show";
		thisspan.visibility="show";
	}
	if (ie) {
		textcontentwidth=document.all.ticker.clientWidth
		document.all.roof.style.posLeft=DL_GetElementLeft(document.all.marker);
		document.all.roof.style.posTop=DL_GetElementTop(document.all.marker);
		document.all.ticker.style.posLeft=textwidth
		document.all.ticker.style.clip='rect(0px, '+textcontentwidth+'px, '+(textheight)+'px, 0px)';
		document.all.roof.style.visibility="visible";
		document.all.ticker.style.visibility="visible";
	}
	if (ns6) {
		textcontentwidth=document.getElementById('tickersize').offsetWidth
		document.getElementById('roof').style.left=DL_GetElementLeft(document.getElementById('marker'));
		document.getElementById('roof').style.top=DL_GetElementTop(document.getElementById('marker'));
		document.getElementById('ticker').style.left=textwidth
		document.getElementById('ticker').clip='rect(0px, '+textcontentwidth+'px, '+(textheight)+'px, 0px)';
		document.getElementById('roof').style.visibility="visible";
		document.getElementById('ticker').style.visibility="visible";
	}
	doscroll()
}

function setscrollready(whatanswer) {
	if (whatanswer==1) {
		scrollready=true
		checkscroll()
	}
	else {
		scrollready=false
	}
}

function checkscroll() {
	clearTimeout(timer)
	if (scrollready) {
		doscroll()
	}
}
function reopenpage() {
	history.go(0)
}
window.onresize=reopenpage
window.onload=initscroller
</script>