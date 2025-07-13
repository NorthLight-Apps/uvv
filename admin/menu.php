<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Menü</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
<meta http-equiv="expires" content="0">
<style type="text/css">
 p,div,td,a,select {font-family:Verdana,Arial,Helvetica;font-size:11px;}
 p {margin-top:3px;margin-bottom:5px;padding-left:4px;}
 a,a:link,a:active,a:visited {color:#000033;text-decoration:underline;} a:hover {color:#CC3333;}
 div.space{font-size:3px;line-height:3px;}
</style>
<script type="text/javascript">
 function Wechsel(Conf){window.location.href='menu.php?conf='+Conf; parent['adm'].location.href='konfTest.php?'+Conf;}
</script>
</head>

<body style="background-color:#F0F7FF;margin-top:8px;margin-left:2px;margin-right:2px;">

<div style="padding-bottom:4px;border:0;border-bottom:1px;border-style:solid;border-color:#999999;">
<a href="http://www.server-scripts.de" target="_new"><img src="_frage.gif" align="left" width="16" height="24" border="0" title="Testfragen-Script"></a>
<b>Version</b><br /><?php include('werte.php'); include($Pfad.'fraVersion.php'); echo '<b>'.substr($fraVersion,0,3),'</b> '.substr($fraVersion,4)?>
</div>

<?php
 $H=opendir($Pfad); $a=array(); $C=(isset($_GET['conf'])?(int)$_GET['conf']:0);
 while($F=readdir($H)) if(substr($F,0,8)=='fraWerte'&&strpos($F,'.php')!=false) $a[]=(int)substr($F,8);
 closedir($H); clearstatcache(); sort($a); $O='';
 while(list($k,$v)=each($a)) if($v>0) $O.='<option value="'.$v.($v!=$C?'':'" selected="selected').'">Konfiguration '.$v.'</option>';
?>

<p style="padding:2px 2px;"><a href="konfSetup.php?<?php echo $C?>" target="adm">Setup/Update</a></p>
<form style="margin:8px 4px;"><select name="conf" style="font-size:10px;width:132px;" onchange="Wechsel(this.value)" size="1"><option value="0">Grundkonfiguration</option><?php echo $O?></select></form>
<p><a href="konfKonf.php?<?php echo $C?>" target="adm">Konfigurationen</a></p>
<div class="space">&nbsp;</div>
<p><a href="konfDaten.php?<?php echo $C?>" target="adm">Datenbasis</a></p>
<div class="space">&nbsp;</div>
<p><a href="konfWerte.php?<?php echo $C?>" target="adm">Allgemeines</a></p>
<p><a href="konfLayout.php?<?php echo $C?>" target="adm">Layouteinstellungen</a></p>
<p><a href="konfFarben.php?<?php echo $C?>" target="adm">Farbeinstellungen</a></p>
<p><a href="konfTeilnehmer.php?<?php echo $C?>" target="adm">Teilnehmerfunktionen</a></p>
<p><a href="konfNutzer.php?<?php echo $C?>" target="adm">Benutzerfunktionen</a></p>
<p><a href="konfAdmin.php" target="adm">Administration</a></p>
<div class="space">&nbsp;</div>
<p><a href="konfTest.php?<?php echo $C?>" target="adm">Testfragenauswahl</a></p>
<p><a href="konfAblauf.php?<?php echo $C?>" target="adm">Ablaufeinstellungen</a></p>
<p><a href="konfBewerten.php?<?php echo $C?>" target="adm">Bewertungsregeln</a></p>
<div class="space">&nbsp;</div>
<p><a href="liste.php?<?php echo $C?>" target="adm">Fragenliste</a></p>
<p><a href="suche.php?<?php echo $C?>" target="adm">Frage suchen</a></p>
<p><a href="druckSuche.php?<?php echo $C?>" target="adm">Fragen drucken</a></p>
<p><a href="eingabe.php?<?php echo $C?>" target="adm">Frage neu eingeben</a></p>
<p><a href="kategorien.php?<?php echo $C?>" target="adm">Fragenkategorien</a></p>
<p><a href="export.php?<?php echo $C?>" target="adm">Fragenexport</a></p>
<p><a href="import.php?<?php echo $C?>" target="adm">Fragenimport</a></p>
<div class="space">&nbsp;</div>
<p><a href="ergebnisListe.php?<?php echo $C?>" target="adm">Ergebnisliste</a></p>
<p><a href="ergebnisSuche.php?<?php echo $C?>" target="adm">Ergebnis suchen</a></p>
<div class="space">&nbsp;</div>
<p><a href="nutzerListe.php?<?php echo $C?>" target="adm">Benutzerliste</a></p>
<div class="space">&nbsp;</div>
<p><a href="importVer2x.php?<?php echo $C?>" target="adm">Import Version 2.x</a></p>
<div class="space">&nbsp;</div>
<p><a href="<?php echo ADM_Hilfe?>hilfe.html" target="onlinehilfe">Hilfe</a></p>
<p><a href="info.php" style="color:#999999;" target="adm">PHP-Info</a></p>
<hr size="1" noshade style="color:#CCCCCC">
<div align="center" style="font-size:9px;">&copy; <a href="http://www.server-scripts.de/software" target="_blank" style="font-size:9px;text-decoration:none;">J. Hummel</a> &nbsp;</div>
</body>
</html>