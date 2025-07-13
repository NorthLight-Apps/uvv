<?php
/* Administrationseinstellungen */

$Pfad='../';
/* -------------------------------------------------------------
 das ist die relative Pfadangabe,
 die vom Autoren-Ordner aus auf das Programmverzeichnis testfragen
 verweist mit einem / am Ende
 Die Angabe ist zu ändern, wenn der Autoren-Ordner NICHT wie üblich
 direkt unterhalb von testfragen als testfragen/admin liegt.
 Beispiel: $Pfad='../';
---------------------------------------------------------------- */

define('ADM_Breite',800);
define('ADM_Hoehe',750);

define('ADM_AntwortZahl',6);
define('ADM_ListenLaenge',25);
define('ADM_Rueckwaerts',false);

define('ADM_Hilfe','http://www.server-scripts.de/testfragen/');

define('ADM_ErgebnisLaenge',10); //Listenlänge
define('ADM_ErgebnisRueckw',true);

define('ADM_NutzerLaenge',15); //Listenlänge
define('ADM_NutzerRueckw',false);
define('ADM_NutzerBetreff',"Ihr Testergebnis");
define('ADM_NutzerKontakt','Sehr geehrte Damen und Herren,\n \n Sie haben im Testfragen-Script.....');

define('ADM_Druck','1;0;0;1;1;1;1;0;1;1');
define('NL',"\n");
define('ADM_KONF',($k=(int)$_SERVER['QUERY_STRING'])?$k:''); unset($k);
if(phpversion()>='5.1.0') date_default_timezone_set('Europe/Berlin');
if(file_exists($Pfad.'fraWerte'.ADM_KONF.'.php')){
 define('ADM_ABLAUF','<span style="color:#888;">('.(ADM_KONF==''?'Grundkonfiguration':'Konfiguration-'.ADM_KONF).')</span>');
 include($Pfad.'fraWerte'.ADM_KONF.'.php');
}else define('ADM_ABLAUF','- <span style="color:#903;">ohne Konfiguration!!</span>');
?>