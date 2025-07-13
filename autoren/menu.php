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
 function Wechsel(Conf){window.location.href='menu.php?conf='+Conf; parent['adm'].location.href='start.php?'+Conf;}
</script>
</head>

<body style="background-color:#F0F7FF;margin-top:8px;margin-left:2px;margin-right:2px;">

<div style="padding-bottom:4px;border:0;border-bottom:1px;border-style:solid;border-color:#999999;">
<a href="http://www.server-scripts.de" target="_new"><img src="_frage.gif" align="left" width="16" height="24" border="0" title="Testfragen-Script"></a>
<b>Version</b><br /><?php include('werte.php'); include($Pfad.'fraVersion.php'); echo '<b>'.substr($fraVersion,0,3),'</b> '.substr($fraVersion,4)?>
</div>
<div class="space">&nbsp;</div>
<p><b>Autorenbereich</b></p>

<?php
 $H=opendir($Pfad); $a=array(); $C=isset($_GET['conf'])?(int)$_GET['conf']:0; $bOK=false;
 while($F=readdir($H)) if(substr($F,0,8)=='fraWerte'&&strpos($F,'.php')!=false) $a[]=(int)substr($F,8);
 closedir($H); clearstatcache(); sort($a); $O='';
 while(list($k,$v)=each($a)) if($v>0) $O.='<option value="'.$v.($v!=$C?'':'" selected="selected').'">Konfiguration '.$v.'</option>';
?>

<form style="margin:8px 4px;"><select name="conf" style="font-size:10px;width:132px;" onchange="Wechsel(this.value)" size="1"><option value="0">Grundkonfiguration</option><?php echo $O?></select></form>
<div class="space">&nbsp;</div>
<?php if(file_exists('konfTest.php')){$bOK=true;?><p><a href="konfTest.php?<?php echo $C?>" target="adm">Testfragenauswahl</a></p><?php }?>
<?php if(file_exists('konfAblauf.php')){$bOK=true;?><p><a href="konfAblauf.php?<?php echo $C?>" target="adm">Ablaufeinstellungen</a></p><?php }?>
<?php if(file_exists('konfBewerten.php')){$bOK=true;?><p><a href="konfBewerten.php?<?php echo $C?>" target="adm">Bewertungsregeln</a></p><?php }?>
<div class="space">&nbsp;</div>
<?php if(file_exists('liste.php')){$bOK=true;?><p><a href="liste.php?<?php echo $C?>" target="adm">Fragenliste</a></p><?php }?>
<?php if(file_exists('suche.php')){$bOK=true;?><p><a href="suche.php?<?php echo $C?>" target="adm">Frage suchen</a></p><?php }?>
<?php if(file_exists('druckSuche.php')){$bOK=true;?><p><a href="druckSuche.php?<?php echo $C?>" target="adm">Fragen drucken</a></p><?php }?>
<?php if(file_exists('eingabe.php')){$bOK=true;?><p><a href="eingabe.php?<?php echo $C?>" target="adm">Frage neu eingeben</a></p><?php }?>
<?php if(file_exists('kategorien.php')){$bOK=true;?><p><a href="kategorien.php?<?php echo $C?>" target="adm">Fragenkategorien</a></p><?php }?>
<div class="space">&nbsp;</div>
<?php if(file_exists('ergebnisListe.php')){$bOK=true;?><p><a href="ergebnisListe.php?<?php echo $C?>" target="adm">Ergebnisliste</a></p><?php }?>
<?php if(file_exists('ergebnisSuche.php')){$bOK=true;?><p><a href="ergebnisSuche.php?<?php echo $C?>" target="adm">Ergebnis suchen</a></p><?php }?>
<div class="space">&nbsp;</div>
<?php if(file_exists('nutzerListe.php')){$bOK=true;?><p><a href="nutzerListe.php?<?php echo $C?>" target="adm">Benutzerübersicht</a></p><?php }?>

<?php if(!$bOK) echo '<p><a href="http://www.server-scripts.de/testfragen/LiesMich.htm#1.1" target="adm">nicht eingerichtet</a>!</p>' ?>
<div class="space">&nbsp;</div>

<div class="space">&nbsp;</div>
<p><a href="<?php echo ADM_Hilfe?>hilfe.html" target="onlinehilfe">Hilfe</a></p>
<hr size="1" noshade style="color:#CCCCCC">
<div align="center" style="font-size:9px;">&copy; <a href="http://www.server-scripts.de/software" target="_blank" style="font-size:9px;text-decoration:none;">J. Hummel</a> &nbsp;</div>
</body>
</html>