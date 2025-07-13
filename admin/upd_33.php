<?php
if(!function_exists('fGetWert33Wert')){
 function fGetWert33Wert($sW,$sV){
  $r=false;
  if($p=strpos($sW,$sV)) if($p=strpos($sW,',',$p)){
   $r=substr($sW,$p+1,99); $r=trim(str_replace("'",'',substr($r,0,strpos($r,')'))));
  }
  return $r;
}}

 if($p=strpos($sWerte,"'FRA_Www','http")){// http(s):// entfernen
  $p+=11; $q=strpos($sWerte,'://',$p)-$p+3;
  if($q<9) $sWerte=substr_replace($sWerte,'',$p,$q);
 }
 if(!strpos($sWerte,'//Schluessel:')) if($p=strpos($sWerte,"define('FRA_Schluessel'")) if($p=strpos($sWerte,"\n",$p+1)){
  $sWerte=substr_replace($sWerte,' //Schluessel: '.FRA_Schluessel,$p,0); $bNeu=true;
 }
 if($p=strpos($sWerte,"define('FRA_MailTo'")){
  $sWerte=substr_replace($sWerte,'Empfaenger',$p+12,6); $bNeu=true;
 }
 if($p=strpos($sWerte,"define('FRA_MailFrom'")){
  $sWerte=substr_replace($sWerte,'Sender',$p+12,8); $bNeu=true;
 }
 if($p=strpos($sWerte,"define('FRA_Nutzerverwaltung'")){ $p+=30;
  if(substr($sWerte,$p,4)=='true') $sWerte=substr_replace($sWerte,"'vorher'",$p,4);
  elseif(substr($sWerte,$p,5)=='false') $sWerte=substr_replace($sWerte,"''",$p,5);
 }
 if(!strpos($sWerte,'FRA_WarnMeldungen')) if($p=strpos($sWerte,"define('FRA_Www'")){
  $sWerte=substr_replace($sWerte,"define('FRA_WarnMeldungen',false);\n",$p,0); $bNeu=true;
 }
 if(!strpos($sWerte,'FRA_ZeichnsNorm')) if($p=strpos($sWerte,"define('FRA_Datumsformat'")){
  $sWerte=substr_replace($sWerte,"define('FRA_ZeichnsNorm',0);\n",$p,0); $bNeu=true;
 }
 if(!strpos($sWerte,'FRA_TimeZoneSet')) if($p=strpos($sWerte,"define('FRA_Datumsformat'")){
  $sWerte=substr_replace($sWerte,"define('FRA_TimeZoneSet','Europe/Berlin');\n",$p,0);
 }
 if(!strpos($sWerte,'ADF_MitLogin')){ //Admin-Abschnitt umschreiben
  if($p=strpos($sWerte,"define('FRA_Schluessel'")) if($p=strpos($sWerte,"\n",$p)){
   @include_once './werte.php';
   if(defined('ADM_Hoehe')){
    if(defined('ADM_Druck'.$sKonf)) $sDr=constant('ADM_Druck'.$sKonf); elseif(defined('ADM_Druck')) $sDr=ADM_Druck; else $sDr='1;0;0;1;1;1;1;0;1;1';
    $sWerte=substr_replace($sWerte,"\ndefine('ADF_AntwortZahl',".ADM_AntwortZahl.");\ndefine('ADF_ListenLaenge',".ADM_ListenLaenge.");\ndefine('ADF_Rueckwaerts',".(ADM_Rueckwaerts?'true':'false').");\ndefine('ADF_ErgebnisLaenge',".ADM_ErgebnisLaenge.");\ndefine('ADF_ErgebnisRueckw',".(ADM_ErgebnisRueckw?'true':'false').");\ndefine('ADF_NutzerLaenge',".ADM_NutzerLaenge.");\ndefine('ADF_NutzerRueckw',".(ADM_NutzerRueckw?'true':'false').");\ndefine('ADF_NutzerBetreff','".ADM_NutzerBetreff."');\ndefine('ADF_NutzerKontakt','".ADM_NutzerKontakt."');\ndefine('ADF_DruckSuch','');\ndefine('ADF_DruckFeld','".$sDr."');",$p,0);
   }
   $sWerte=substr_replace($sWerte,"\n\n// Administration\ndefine('ADF_MitLogin',false);\ndefine('ADF_Admin','admin');\ndefine('ADF_Passwort','');\ndefine('ADF_AuthLogin',false);\ndefine('ADF_Author','author');\ndefine('ADF_AuthPass','');\ndefine('ADF_SessionsAgent',true);\ndefine('ADF_SessionsIPAddr',true);\ndefine('ADF_Hilfe','https://www.server-scripts.de/testfragen/');\ndefine('ADF_Breite',1000);",$p,0);
  }
 }
 if(!strpos($sWerte,'ADF_FragenFeldHoehe')) if($p=strpos($sWerte,"define('ADF_ListenLaenge'")){
  $sWerte=substr_replace($sWerte,"define('ADF_FragenFeldHoehe',5);\ndefine('ADF_AntwortFeldHoehe',2);\ndefine('ADF_AnmerkFeldHoehe',3);\n",$p,0); $bNeu=true;
 }
 if(!strpos($sWerte,'FRA_PunkteTeilen')) if($p=strpos($sWerte,"define('FRA_Offenlegen'")){//01.04.13 Punkte teilen
  $sWerte=substr_replace($sWerte,"define('FRA_PunkteTeilen',true);\n",$p,0);
 }
 if(!strpos($sWerte,'FRA_MischKategorie')) if($p=strpos($sWerte,"define('FRA_ZeitLimit'")){//07.04.13 Kategorien mischen
  $sWerte=substr_replace($sWerte,"define('FRA_MischKategorie',true);\n",$p,0);
 }
 if(!strpos($sWerte,'FRA_ProSeite')) if($p=strpos($sWerte,"define('FRA_RadioButton'")){//09.05.13 Fragen pro Seite
  $sWerte=substr_replace($sWerte,"define('FRA_ProSeite',1);\n",$p,0);
 }
 if(!strpos($sWerte,'FRA_BldAlleNr')){//09.05.13 Auswertung nur Falsche
  if($p=strpos($sWerte,"define('FRA_BldErgebnis'"))
   $sWerte=substr_replace($sWerte,"define('FRA_BldAlleNr',true);\n",$p,0);
  if($p=strpos($sWerte,"define('FRA_AdmErgebnis'"))
   $sWerte=substr_replace($sWerte,"define('FRA_AdmAlleNr',true);\n",$p,0);
  if($p=strpos($sWerte,"define('FRA_TlnErgebnis'"))
   $sWerte=substr_replace($sWerte,"define('FRA_TlnAlleNr',true);\n",$p,0);
 }
 if(!strpos($sWerte,'FRA_BldKatErgebnis')){//09.05.13 Auswertung pro Kategorie
  if($p=strpos($sWerte,"define('FRA_BldAnzahlU'"))
   $sWerte=substr_replace($sWerte,"define('FRA_BldKatErgebnis',false);\ndefine('FRA_BldKatPunkte',false);\ndefine('FRA_BldKatSumme',true);\n",$p,0);
  if($p=strpos($sWerte,"define('FRA_AdmAnzahlU'"))
   $sWerte=substr_replace($sWerte,"define('FRA_AdmKatErgebnis',false);\ndefine('FRA_AdmKatPunkte',false);\ndefine('FRA_AdmKatSumme',true);\n",$p,0);
  if($p=strpos($sWerte,"define('FRA_TlnAnzahlU'"))
   $sWerte=substr_replace($sWerte,"define('FRA_TlnKatErgebnis',false);\ndefine('FRA_TlnKatPunkte',false);\ndefine('FRA_TlnKatSumme',true);\n",$p,0);
  if($p=strpos($sWerte,"define('FRA_VerbalPunkte'"))
   $sWerte=substr_replace($sWerte,"define('FRA_DatKatErgebnis',false);\ndefine('FRA_DatKatPunkte',false);\ndefine('FRA_DatKatSumme',true);\n",$p,0);
  if($p=strpos($sWerte,"define('FRA_ZntAuslassen'")) if($p=strpos($sWerte,"\n",$p+1))
   $sWerte=substr_replace($sWerte,"\ndefine('FRA_ZntKatErgebnis',false);\ndefine('FRA_ZntKatPunkte',false);\ndefine('FRA_ZntKatSumme',true);",$p,0);
 }
 if(!strpos($sWerte,'FRA_LoesungsSeite')) if($p=strpos($sWerte,"define('FRA_BldAnzahlO'")){//09.05.13 LoesungsSeite
  $sWerte=substr_replace($sWerte,"define('FRA_LoesungsSeite',false);\ndefine('FRA_LoesungsFalsche',true);\ndefine('FRA_LoesungsAnmk',false);\n",$p,0);
 }
 if(!strpos($sWerte,'FRA_TxZeigeRichtig')) if($p=strpos($sWerte,"define('FRA_TxRestZeit'")){//28.07.13 LoesungsSeitenTexte
  $sWerte=substr_replace($sWerte,"define('FRA_TxZeigeRichtig','korrekt beantwortet');\ndefine('FRA_TxZeigeUnnuetz','unzutreffend gewählt');\ndefine('FRA_TxZeigeFehlt','hätte gewählt sein müssen');\ndefine('FRA_TxZeigeLeer','nicht zutreffend');\ndefine('FRA_TxZeigeWertung','#P von #G Punkten');\n",$p,0);
 }
 if(!strpos($sWerte,'ADF_AnmerkZahl')) if($p=strpos($sWerte,"define('ADF_FragenFeldHoehe'")){//11.05.13 Anmerkungszahl
  $sWerte=substr_replace($sWerte,"define('ADF_AnmerkZahl',1);\n",$p,0);
 }
 if(!strpos($sWerte,'ADF_StripSlashes')) if($p=strpos($sWerte,"define('ADF_ListenLaenge'")){//11.05.13 StripSlashes
  $sWerte=substr_replace($sWerte,"define('ADF_StripSlashes',false);\n",$p,0);
 }
 if($p=strpos($sWerte,"define('FRA_TestDatei'")){//15.05.13 Begriff auf FolgeName aendern
  $sWerte=substr_replace($sWerte,"FolgeName",$p+12,9);
 }
 if($p=strpos($sWerte,"define('FRA_SpontanFolge'")){//15.05.13 Begriff auf FolgeSpontan aendern
  $sWerte=substr_replace($sWerte,"FolgeSpontan",$p+12,12);
 }
 //Platzhalter in Texten erneuern
 if(($p=strpos($sWerte,"FRA_TxBeginn'"))&&($q=strpos($sWerte,');',$p))&&(strpos($sWerte,"\n",$p)>$q)){
  if(!strpos(substr($sWerte,$p,$q-$p),'#Z'))
   $sWerte=substr_replace($sWerte,"FRA_TxBeginn',".'"'.str_replace('#','#Z',FRA_TxBeginn).'"',$p,$q-$p);
 }
 if(($p=strpos($sWerte,"FRA_TxNormal'"))&&($q=strpos($sWerte,');',$p))&&(strpos($sWerte,"\n",$p)>$q)){
  if(!strpos(substr($sWerte,$p,$q-$p),'#N'))
   $sWerte=substr_replace($sWerte,"FRA_TxNormal',".'"'.str_replace('#','#N',FRA_TxNormal).'"',$p,$q-$p);
 }
 if(($p=strpos($sWerte,"FRA_TxHandle'"))&&($q=strpos($sWerte,');',$p))&&(strpos($sWerte,"\n",$p)>$q)){
  if(!strpos(substr($sWerte,$p,$q-$p),'#N'))
   $sWerte=substr_replace($sWerte,"FRA_TxHandle',".'"'.str_replace('#','#N',FRA_TxHandle).'"',$p,$q-$p);
 }
 if(($p=strpos($sWerte,"FRA_TxAnsEnde'"))&&($q=strpos($sWerte,');',$p))&&(strpos($sWerte,"\n",$p)>$q)){
  if(!strpos(substr($sWerte,$p,$q-$p),'#N'))
   $sWerte=substr_replace($sWerte,"FRA_TxAnsEnde',".'"'.str_replace('#','#N',FRA_TxAnsEnde).'"',$p,$q-$p);
 }
 if(($p=strpos($sWerte,"FRA_TxNochMal'"))&&($q=strpos($sWerte,');',$p))&&(strpos($sWerte,"\n",$p)>$q)){
  if(!strpos(substr($sWerte,$p,$q-$p),'#N'))
   $sWerte=substr_replace($sWerte,"FRA_TxNochMal',".'"'.str_replace('#','#N',FRA_TxNochMal).'"',$p,$q-$p);
 }
 if(($p=strpos($sWerte,"FRA_TxHalb'"))&&($q=strpos($sWerte,');',$p))&&(strpos($sWerte,"\n",$p)>$q)){
  if(!strpos(substr($sWerte,$p,$q-$p),'#N'))
   $sWerte=substr_replace($sWerte,"FRA_TxHalb',".'"'.str_replace('#','#N',FRA_TxHalb).'"',$p,$q-$p);
 }
 if(($p=strpos($sWerte,"FRA_TxStimmt'"))&&($q=strpos($sWerte,');',$p))&&(strpos($sWerte,"\n",$p)>$q)){
  if(!strpos(substr($sWerte,$p,$q-$p),'#N'))
   $sWerte=substr_replace($sWerte,"FRA_TxStimmt',".'"'.str_replace('#','#N',FRA_TxStimmt).'"',$p,$q-$p);
 }
 if(($p=strpos($sWerte,"FRA_TxAnders'"))&&($q=strpos($sWerte,');',$p))&&(strpos($sWerte,"\n",$p)>$q)){
  if(!strpos(substr($sWerte,$p,$q-$p),'#N'))
   $sWerte=substr_replace($sWerte,"FRA_TxAnders',".'"'.str_replace('#','#N',FRA_TxAnders).'"',$p,$q-$p);
 }
 if(($p=strpos($sWerte,"FRA_TxLernen'"))&&($q=strpos($sWerte,');',$p))&&(strpos($sWerte,"\n",$p)>$q)){
  if(!strpos(substr($sWerte,$p,$q-$p),'#N'))
   $sWerte=substr_replace($sWerte,"FRA_TxLernen',".'"'.str_replace('#','#N',FRA_TxLernen).'"',$p,$q-$p);
 }
 if(($p=strpos($sWerte,"FRA_TxLernOk'"))&&($q=strpos($sWerte,');',$p))&&(strpos($sWerte,"\n",$p)>$q)){
  if(!strpos(substr($sWerte,$p,$q-$p),'#Z'))
   $sWerte=substr_replace($sWerte,"FRA_TxLernOk',".'"'.str_replace('#','#Z',FRA_TxLernOk).'"',$p,$q-$p);
 }
 if(($p=strpos($sWerte,"FRA_TxAllesFertig'"))&&($q=strpos($sWerte,');',$p))&&(strpos($sWerte,"\n",$p)>$q)){
  if(!strpos(substr($sWerte,$p,$q-$p),'#Z'))
   $sWerte=substr_replace($sWerte,"FRA_TxAllesFertig',".'"'.str_replace('#','#Z',FRA_TxAllesFertig).'"',$p,$q-$p);
 }
 if(($p=strpos($sWerte,"FRA_TxNichtGefunden'"))&&($q=strpos($sWerte,');',$p))&&(strpos($sWerte,"\n",$p)>$q)){
  if(!strpos(substr($sWerte,$p,$q-$p),'#N'))
   $sWerte=substr_replace($sWerte,"FRA_TxNichtGefunden',".'"'.str_replace('#','#N',FRA_TxNichtGefunden).'"',$p,$q-$p);
 }
 if(($p=strpos($sWerte,"FRA_TxZeitLimit'"))&&($q=strpos($sWerte,');',$p))&&(strpos($sWerte,"\n",$p)>$q)){
  if(!strpos(substr($sWerte,$p,$q-$p),'#Z'))
   $sWerte=substr_replace($sWerte,"FRA_TxZeitLimit',".'"'.str_replace('#','#Z',FRA_TxZeitLimit).'"',$p,$q-$p);
 }
 if(($p=strpos($sWerte,"FRA_TxBewertungHier'"))&&($q=strpos($sWerte,');',$p))&&(strpos($sWerte,"\n",$p)>$q)){
  if(!strpos(substr($sWerte,$p,$q-$p),'#Z'))
   $sWerte=substr_replace($sWerte,"FRA_TxBewertungHier',".'"'.str_replace('#','#Z',FRA_TxBewertungHier).'"',$p,$q-$p);
 }
 $DivW=450;
 if(!strpos($sWerte,'FRA_LayoutBildText')) if($p=strpos($sWerte,"define('FRA_Rahmen'")){//31.07.13 CSS-Layoutaenderung
  $sS=str_replace("\n\n\n","\n\n",str_replace("\r",'',trim(implode('',file(FRAPFAD.'fraStyle.css')))));
  if($o=strpos($sS,'div.fraText')) if($q=strpos($sS,'width',$o)) if($q<strpos($sS,'}',$o)) if($o=strpos($sS,':',$q)) $DivW=(int)substr($sS,$o+1,10);
  $sWerte=substr_replace($sWerte,"define('FRA_LayoutBildText',true);\ndefine('FRA_DivTextWidth',".$DivW.");\ndefine('FRA_ResponsiveLayout',false);\ndefine('FRA_LayoutReservePixel',10);\n",$p,0);
  if(!defined('FRA_DivWT')) define('FRA_DivWT',$DivW);
  $sFraLayout=fGetWert33Wert($sWerte,"FRA_Layout'");
  if($sFraLayout){ //Layoutnumerierung geaendert
   if($sFraLayout==1) $sS='2'; elseif($sFraLayout==2) $sS='3'; elseif($sFraLayout==3) $sS='1'; else $sS='0';
   if($p=strpos($sWerte,"define('FRA_Layout'")) $sWerte=substr_replace($sWerte,"define('FRA_LayoutTyp',".$sS,$p,21);
  }
 }
 if(!strpos($sWerte,'FRA_TxZeigeLoesung')) if($p=strpos($sWerte,"define('FRA_TxNichtGefunden'")){//13.08.13
  $sWerte=substr_replace($sWerte,"define('FRA_TxZeigeLoesung','Lösung zur Frage-Nr. #N');\n",$p,0);
 }
 if(!strpos($sWerte,'FRA_TxSendeFehl')) if($p=strpos($sWerte,"define('FRA_TxNutzerDatBtr'")){//13.08.13
  $sWerte=substr_replace($sWerte,"define('FRA_TxSendeFehl','Die Nachricht konnte soeben nicht versandt werden!');\n",$p,0);
 }
 if(!strpos($sWerte,'FRA_SchalterSuchen')) if($p=strpos($sWerte,"define('FRA_FertigHtml'")){//11.05.13 Schalter Zurueck/Vor
  $sWerte=substr_replace($sWerte,"define('FRA_SchalterSuchen','Frage suchen');\ndefine('FRA_SchalterTxGeheZu','');\ndefine('FRA_SchalterZurueck','zurück blättern');\ndefine('FRA_SchalterTxZurueck','');\ndefine('FRA_Schalter2Zeilen',false);\n",$p,0);
 }
 if(!strpos($sWerte,'FRA_Nutzerfreigabe')) if($p=strpos($sWerte,"define('FRA_NutzerNeuErlaubt'")){//17.08.13 automatische Nutzerfreigabe
  $sWerte=substr_replace($sWerte,"define('FRA_Nutzerfreigabe',false);\n",$p,0);
 }
 if(!strpos($sWerte,'FRA_Drucken')) if($p=strpos($sWerte,"define('FRA_BildH'")) if($p=strpos($sWerte,"\n",$p+1)){//18.08.13 Drucken
  $sWerte=substr_replace($sWerte,"\n//Druckeinstellungen\ndefine('FRA_Drucken','');\ndefine('FRA_DruckSpalten','1;0;1;0;1;0;1;0;0'); // Nr;Kat;Fra;Loe;Pkt;Bld;Aw;B1;B2\ndefine('FRA_DruckSuchSpalten',3);\ndefine('FRA_DruckSuche','1;0;1;0;0;0;1;0;0');\ndefine('FRA_DruckGast',false);\n",$p+1,0);
  if($p=strpos($sWerte,"define('FRA_TxDatum'")) $sWerte=substr_replace($sWerte,"define('FRA_TxBis','bis');\ndefine('FRA_TxWie','wie');\ndefine('FRA_TxOderWie','oder wie');\ndefine('FRA_TxIstOderAb','ist oder ab');\ndefine('FRA_TxAberNichtWie','aber nicht wie');\n",$p,0);
  if($p=strpos($sWerte,"define('FRA_TxRichtig'")) $sWerte=substr_replace($sWerte,"define('FRA_TxBild','Bild');\ndefine('FRA_TxBemerkung','Anmerkung');\n",$p,0);
  if($p=strpos($sWerte,"define('FRA_TxZeigeRichtig'")) $sWerte=substr_replace($sWerte,"define('FRA_TxDrucken','Stellen Sie Ihre Druckliste zusammen!');\ndefine('FRA_TxDruckFilter','Auswahl der zu druckenden Fragen anhand folgender Filterbedingungen:');\ndefine('FRA_TxDruckSpalten','In der Druckliste sollen folgende Spalten erscheinen:');\n",$p,0);
 }
 if(!strpos($sWerte,'FRA_DruckRueckw')) if($p=strpos($sWerte,"define('FRA_DruckGast'")){//23.08.13 Rueckwaertsdruck
  $sWerte=substr_replace($sWerte,"define('FRA_DruckRueckw',false);\n",$p,0);
 }
 if(!strpos($sWerte,'FRA_NutzerTests')) if($p=strpos($sWerte,"define('FRA_NachLoginWohin'")){//15.09.13 Nutzertests
  if($p=strpos($sWerte,"\n",$p+1)) $sWerte=substr_replace($sWerte,"\ndefine('FRA_NutzerTests',false);",$p,0);
 }
 if(!strpos($sWerte,'FRA_Zuweisung')) if($p=strpos($sWerte,"define('FRA_SQL'")){//20.09.13 Zuweisungstabellen
  $sWerte=substr_replace($sWerte,"define('FRA_Zuweisung','zuweisungen.txt');\n",$p,0);
  if($p=strpos($sWerte,"define('FRA_Schluessel'")){
   $sWerte=substr_replace($sWerte,"define('FRA_SqlTabZ','fra_zuweisungen');\n",$p,0);
  }
  if($p=strpos($sWerte,"('FRA_SQL',false)")){
   if($f=fopen(fGetWert33Wert($sWerte,"FRA_Pfad'").fGetWert33Wert($sWerte,"FRA_Daten'").'zuweisungen.txt','w')){
    fwrite($f,'Benutzer;zugewiesene_Tests'.NL); fclose($f);
   }else if(!strpos($sMeld,'zuweisungen.txt')) $sMeld.='<p class="admFehl">Die neue Datei <i>'.FRA_Daten.'zuweisungen.txt</i> durfte nicht angelegt werden.</p>'; ;
  }
 }
 if($p=strpos($sWerte,"('FRA_SQL',false)")){//05.10.13 Kopfzeile in Folgen
  $sTab=fGetWert33Wert($sWerte,"FRA_Pfad'").fGetWert33Wert($sWerte,"FRA_Daten'").fGetWert33Wert($sWerte,"FRA_Folgen'"); $a=@file($sTab);
  if(is_array($a)&&!strpos($a[0],'Fragen;ProSeite')){
   if($f=fopen($sTab,'w')){
    fwrite($f,rtrim('Folge;Fragen;ProSeite'.NL.implode('',$a)).NL); fclose($f);
 }}}
 if(!strpos($sWerte,'FRA_TxNutzerFrist')) if($p=strpos($sWerte,"define('FRA_TxNutzerRegel'")){//03.10.13 Nutzerfrist
  $sWerte=substr_replace($sWerte,"define('FRA_TxNutzerFrist','gültig bis');\ndefine('FRA_TxNutzerAblauf','abgelaufen');\n",$p,0);
 }
 if(!strpos($sWerte,'FRA_NutzerFrist')) if($p=strpos($sWerte,"define('FRA_Nutzerfreigabe'")){//03.10.13 Nutzerfrist
  $sWerte=substr_replace($sWerte,"define('FRA_NutzerFrist',0);\n",$p,0);
 }
 if(!strpos($sWerte,'FRA_DruckBildW')) if($p=strpos($sWerte,"define('FRA_DruckGast'")){//08.10.13 Druckbildbreite
  $sWerte=substr_replace($sWerte,"define('FRA_DruckBildW',100);\n",$p,0);
 }

 if($p=strpos($sWerte,"('FRA_SQL',true)")){
  if($p=strpos($sWerte,"('FRA_SqlHost',")){$q=strpos($sWerte,"\n",$p); $s=substr($sWerte,$p,$q-($p+3)); $sSqlHost=substr($s,strpos($s,",'")+2);}
  if($p=strpos($sWerte,"('FRA_SqlUser',")){$q=strpos($sWerte,"\n",$p); $s=substr($sWerte,$p,$q-($p+3)); $sSqlUser=substr($s,strpos($s,",'")+2);}
  if($p=strpos($sWerte,"('FRA_SqlPass',")){$q=strpos($sWerte,"\n",$p); $s=substr($sWerte,$p,$q-($p+3)); $sSqlPass=substr($s,strpos($s,",'")+2);}
  if($p=strpos($sWerte,"('FRA_SqlDaBa',")){$q=strpos($sWerte,"\n",$p); $s=substr($sWerte,$p,$q-($p+3)); $sSqlDaBa=substr($s,strpos($s,",'")+2);}
  if($p=strpos($sWerte,"('FRA_SqlTabF',")){$q=strpos($sWerte,"\n",$p); $s=substr($sWerte,$p,$q-($p+3)); $sSqlTabF=substr($s,strpos($s,",'")+2);}
  if($p=strpos($sWerte,"('FRA_SqlTabT',")){$q=strpos($sWerte,"\n",$p); $s=substr($sWerte,$p,$q-($p+3)); $sSqlTabT=substr($s,strpos($s,",'")+2);}

  $DbO=@new mysqli($sSqlHost,$sSqlUser,$sSqlPass,$sSqlDaBa);
  if(!mysqli_connect_errno()){
    $DbO->query('ALTER TABLE '.$sSqlTabF.' ADD COLUMN `Anmerkung2` TEXT NOT NULL AFTER `Anmerkung`');
    $DbO->query('ALTER TABLE '.$sSqlTabT.' ADD COLUMN `ProSeite` VARCHAR(8) NOT NULL DEFAULT "" AFTER `Fragen`');
    $DbO->query('UPDATE IGNORE '.$sSqlTabT.' SET ProSeite="1" WHERE Folge>" "');
    $DbO->query('CREATE TABLE `fra_zuweisungen` (Nummer INT NOT NULL auto_increment, Tests TEXT NOT NULL, PRIMARY KEY (Nummer)) COMMENT="FrageScript-Testzuweisungen"');
    $DbO->close(); $DbO=NULL;
  }
 }

 $bUpd33=true;

// ---fertig------------------------------------------------------------------

if(!function_exists('fCSSUp33')){
 function fCSSUp33($DivW){
  $r=false; if(defined('FRA_DivWT')) $DivW=FRA_DivWT; $nBildW=FRA_BildW; if(FRA_Layout==0||FRA_Layout==3) $nBildW=0;
  $sS=str_replace("\n\n\n","\n\n",str_replace("\r",'',trim(implode('',file(FRAPFAD.'fraStyle.css')))));

  if($q=strpos($sS,'div.fraOffn')) if($p=strpos($sS,'width',$q)) if($e=strpos($sS,'}',$q)) if($p<$e){
   if($q=strpos($sS,';',$p)) if($q<$e){
    $sS=substr_replace($sS,'',$p,$q+1-$p); while(substr($sS,$p,1)==' ') $sS=substr_replace($sS,'',$p,1);
   }
  }

  if($q=strpos($sS,'td.fraLogi')) if($p=strpos($sS,'vertical-align',$q)) if($e=strpos($sS,'}',$q)) if($p<$e){
   $sS=substr_replace($sS,'text-align:left; ',$p,0);
  }
  if($q=strpos($sS,'td.fraMenu')) if($p=strpos($sS,'vertical-align',$q)) if($e=strpos($sS,'}',$q)) if($p<$e){
   $sS=substr_replace($sS,'text-align:left; ',$p,0);
  }
  if($q=strpos($sS,'td.fraBwrt')) if($p=strpos($sS,'vertical-align',$q)) if($e=strpos($sS,'}',$q)) if($p<$e){
   $sS=substr_replace($sS,'text-align:left; ',$p,0);
  }

  if(!strpos($sS,'div.fraTxtR')) if($p=strpos($sS,'div.fraText')){ // TxtR und TxtF
   $sS=substr_replace($sS,',div.fraTxtR,div.fraTxtF',$p+11,0);

   if($p=strpos($sS,'}',++$p)){
    $sNeu='
div.fraTxtR{ /*Umrahmung richtiger Antwortblock*/
 border-color:#119911;
}
div.fraTxtF{ /*Umrahmung falscher Antwortblock*/
 border-color:#AA1111;
}';
    $sS=substr_replace($sS,$sNeu,$p+1,0);
   }
  }

  if($p=strpos($sS,'table.fraGsmt')) if($q=strpos($sS,'td.fraScha',$p+1)) if($e=strpos($sS,'}',$q+1)){ //responsive Layout
   $sNeu='/* = seit Version 3.3 geloescht = */

/* = pro Frage gestalten wegen mehr als einer Frage pro Seite = */
div.fraBlock{
 width:'.($DivW+(FRA_Layout==0||FRA_Layout==3?0:$nBildW)+10).'px; overflow:hidden;
 margin:0px; padding:0px; margin-bottom:8px;
 border-color:#CCCCEE; border-width:2px; border-style:dotted;
}
div.fraText,div.fraTxtR,div.fraTxtF{ /*Textblock eventuell floaten*/
 float:'.(FRA_Layout==0||FRA_Layout==3?'none':(FRA_Layout==1?'right':'left')).'; overflow:hidden;
}
div.fraBild{ /*Bildblock eventuell floaten*/
 width:'.FRA_BildW.'px;
 float:'.(FRA_Layout==0||FRA_Layout==3?'none':(FRA_Layout==1?'left':'right')).'; overflow:hidden;
 border-style:none; border-width:0px;
}
div.fraClrB{
 clear:both; margin:0; padding:0; height:0;
}

/* = ---responsive Design fuer schmale Geraete--------------------- = */
@media screen and (max-width:100px) { /* einspaltig mit voller Breite */

 div.fraBlock,div.fraText,div.fraTxtR,div.fraTxtF{width:auto;}
 div.fraText,div.fraTxtR,div.fraTxtF,div.fraBild{float:none;}

}
/* = ---/responsive Design ---------------------------------------- = */
';
   $sS=substr_replace($sS,$sNeu."\n\n",$p,$e+1-$p);
  }

  if(!strpos($sS,'table.fraDrck')) if($p=strpos($sS,'td.fraBwrt')) if($p=strpos($sS,'}',$p+1)){
   $sNeu='}

/* = Formular zur Parametrierung der Druckliste = */
table.fraDrck{ /* Druckparameterformular */
 width:; margin-top:15px; margin-bottom:15px;
 font-size:1.0em; font-weight:normal;
 border-color:#AAAAEE; border-width:2px; border-style:dotted; border-collapse:collapse;
 background-color:#FFFFFF;
 table-layout:auto;
}
td.fraDrck{
 font-size:1.0em; font-weight:normal;
 color:#000000; background-color:#FFFFFF;
 border-color:#CCCCCC; border-width:2px; border-style:dotted;
 padding:4px; text-align:left; vertical-align:middle;
}
input.fraDrck{ /* Eingabefelder im Formular */
 width:150px;
 font-size:0.95em;
 color:#000011; background-color:#FFFFFF;
}

/* = ausgegebene Druckliste = */
table.fraDru{ /* Drucktabelle */
 width:; margin-top:15px; margin-bottom:15px;
 font-size:1.0em; font-weight:normal;
 border-color:#BBBBBB; border-width:1px; border-style:solid; border-collapse:collapse;
 background-color:#FFFFFF;
 table-layout:auto;
}
tr.fraDru{ /* Zeile in der Drucktabelle */
}
td.fraDru{ /* Zelle in der Drucktabelle */
 font-size:1.0em; font-weight:normal;
 color:#000000; background-color:#FFFFFF;
 border-color:#BBBBBB; border-width:1px; border-style:solid;
 padding:3px; text-align:left; vertical-align:top;
';
   $sS=substr_replace($sS,$sNeu,$p,0);
  }

  if($f=fopen(FRAPFAD.'fraStyle.css','w')){
   fwrite($f,rtrim(str_replace("\n\n\n","\n\n",str_replace("\r",'',$sS)))."\n"); fclose($f); $r=true;
  }
  return $r;
 }
}
?>