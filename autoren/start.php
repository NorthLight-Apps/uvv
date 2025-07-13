<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
<meta http-equiv="expires" content="0">
<title>Testfragen-Script</title>
<link rel="stylesheet" type="text/css" href="styles.css">
<script type="text/javascript">
 function hlpWin(){hWin=window.open("about:blank","hilfe","width=995,height=570,left=5,top=5,menubar=yes,statusbar=no,toolbar=no,scrollbars=yes,resizable=yes");hWin.focus();}
</script>
</head>

<body>
<div class="admin" style="width:<?php include('werte.php'); echo ADM_Breite.'px;height:'.ADM_Hoehe?>px;">
<h1><img src="_frage.gif" width="16" height="24" border="0" align="bottom" alt=""> Testfragen-Script: Autorenbereich
<a href="<?php echo ADM_Hilfe ?>LiesMich.htm#1.1" target="hilfe" onclick="hlpWin()"><img src="hilfe.gif" width="13" height="13" border="0" title="Hilfe"></a> <?php echo ADM_ABLAUF?></h1>

<?php
$nT='??'; $nV='??';
if(file_exists('liste.php')||file_exists('suche.php')||file_exists('druckSuche.php')||file_exists('eingabe.php')||file_exists('kategorien.php')||file_exists('ergebnisListe.php')||file_exists('ergebnisSuche.php')||file_exists('nutzerListe.php')||file_exists('konfTest.php')||file_exists('konfAblauf.php')||file_exists('konfBewerten.php')){
 if(file_exists($Pfad.'fraWerte'.ADM_KONF.'.php')){
  $bOK=true; $C=(ADM_KONF==''?'':'?'.ADM_KONF);
  if(!FRA_SQL){ //Textdaten
   $aD=@file(FRA_Pfad.FRA_Daten.FRA_Fragen); $nF=max(count($aD)-1,0);
  }else{ //SQL
   if($DbC=@mysql_connect(FRA_SqlHost,FRA_SqlUser,FRA_SqlPass)){
    if(@mysql_select_db(FRA_SqlDaBa,$DbC)){
     if($rR=mysql_query('SELECT COUNT(Nummer) FROM '.FRA_SqlTabF)){
      $a=mysql_fetch_row($rR); mysql_free_result($rR); $nF=$a[0];
     }else echo '<p class="fraFehl">'.FRA_TxSqlFrage.'</p>';
    }else echo '<p class="fraFehl">'.FRA_TxSqlDaBnk.'</p>'; mysql_close($DbC);
   }else echo '<p class="fraFehl">'.FRA_TxSqlVrbdg.'</p>';
  }//SQL
 }else echo '<p class="fraFehl">Setup-Fehler: Die Datei <i>fraWerte'.ADM_KONF.'.php</i> im Programmverzeichnis kann nicht gelesen werden!</p>';
}else{
 echo '<p class="fraFehl" style="margin-top:32px;">Der Autorenbereich wurde vom Administrator noch nicht eingerichtet!</p>'; $bOK=false;
}
?>

<table class="fraTabl" border="0" cellpadding="8" cellspacing="1" style="margin-top:32px;">
<?php if(file_exists('liste.php')){?>
<tr class="fraTabl">
 <td width="12"><a href="liste.php<?php echo $C?>" title="bearbeiten"><img src="iconAendern.gif" width="12" height="13" border="0" alt="bearbeiten"></a></td>
 <td>Fragen bearbeiten (<?php echo $nF?> Fragen in der <?php echo (defined('FRA_SQL')?(FRA_SQL?'MySQL-':'Text-'):'')?>Datenbasis)</td>
</tr>
<?php } if(file_exists('eingabe.php')){?>
<tr class="fraTabl">
 <td width="12"><a href="eingabe.php<?php echo $C?>" title="eingeben"><img src="iconAendern.gif" width="12" height="13" border="0" alt="eingeben"></a></td>
 <td>neue Frage eingeben</td>
</tr>
<?php } if(file_exists('kategorien.php')){?>
<tr class="fraTabl">
 <td width="12"><a href="kategorien.php<?php echo $C?>" title="eingeben"><img src="iconAendern.gif" width="12" height="13" border="0" alt="eingeben"></a></td>
 <td>Kategorien bearbeiten</td>
</tr>
<?php } if(file_exists('konfTest.php')){?>
<tr class="fraTabl">
 <td width="12"><a href="konfTest.php<?php echo $C?>" title="konfigurieren"><img src="iconAendern.gif" width="12" height="13" border="0" alt="konfigurieren"></a></td>
 <td>Testfragenauswahl</td>
</tr>
<?php } if(file_exists('konfAblauf.php')){?>
<tr class="fraTabl">
 <td width="12"><a href="konfAblauf.php<?php echo $C?>" title="konfigurierenn"><img src="iconAendern.gif" width="12" height="13" border="0" alt="konfigurieren"></a></td>
 <td>Ablaufeinstellungen</td>
</tr>
<?php } if(file_exists('konfBewerten.php')){?>
<tr class="fraTabl">
 <td width="12"><a href="konfBewerten.php<?php echo $C?>" title="konfigurieren"><img src="iconAendern.gif" width="12" height="13" border="0" alt="konfigurieren"></a></td>
 <td>Bewertungsregeln</td>
</tr>
<?php } if(file_exists('ergebnisListe.php')){?>
<tr class="fraTabl">
 <td width="12"><a href="ergebnisListe.php<?php echo $C?>" title="konfigurieren"><img src="iconAendern.gif" width="12" height="13" border="0" alt="konfigurieren"></a></td>
 <td>Ergebnisliste</td>
</tr>
<?php } if(file_exists('nutzerListe.php')){?>
<tr class="fraTabl">
 <td width="12"><a href="nutzerListe.php<?php echo $C?>" title="bearbeiten"><img src="iconAendern.gif" width="12" height="13" border="0" alt="bearbeiten"></a></td>
 <td>Benutzer bearbeiten</td>
</tr>
<?php } if(!$bOK){?>
<tr class="fraTabl">
 <td width="13"><a href="http://www.server-scripts.de/testfragen/LiesMich.htm#1.1" title="Hilfe"><img src="hilfe.gif" width="13" height="13" border="0" title="Hilfe"></a></td>
 <td>siehe Anleitung <a href="http://www.server-scripts.de/testfragen/LiesMich.htm#1.1">LiesMich.htm</a></td>
</tr>
<?php }?>
</table>

<p style="margin-top:16px;"><?php echo date('d.m.Y, H:i:s')?></p>
</div>
</body>
</html>