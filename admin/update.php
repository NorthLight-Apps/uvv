<?php
//Update: wird innerhalb von konfSetup.php aufgerufen

$aKonf=array(); $h=opendir(FRAPFAD); while($sF=readdir($h)) if(substr($sF,0,8)=='fraStyle'&&substr($sF,8,1)!='0'&&strpos($sF,'.css')>0) $aKonf[]=(int)substr($sF,8); closedir($h); sort($aKonf); if($aKonf[0]==0) $aKonf[0]='';
foreach($aKonf as $k=>$sKonf){ // ueber alle Style-Dateien
 $sCSS=str_replace("\r",'',trim(implode('',file(FRAPFAD.'fraStyle'.$sKonf.'.css')))); $bNeu=false;

 if(!strpos($sCSS,'div.fraScha{')){ //SchalterBox 07.08.09
  if($p=strpos($sCSS,'ul.fraText')){
   $sCSS=substr_replace($sCSS,"div.fraScha{ /*Zeile für den Formular-Schalter*/\n padding-top:1px; padding-bottom:5px;\n text-align:center;\n}\n\n",$p,0); $bNeu=true;
  }
 }
 if(!strpos($sCSS,'div.fraOffn{')){ //AnmerkungsBox 07.08.09
  if($p=strpos($sCSS,'table.fraAnmk{')){ $q=strpos($sCSS,'}',$p+1);
   $sCSS=substr_replace($sCSS,"div.fraOffn{\n width:500px;margin-top:16px; margin-bottom:5px;\n font-size:1.0em; font-weight:normal;\n border-color:#CCCCEE; border-width:2px; border-style:dotted;\n background-color:#FFFFFF;\n}",$p,$q-$p+1); $bNeu=true;
  }
 }

 if(!strpos($sCSS,'table.fraMenu{')){include_once 'upd091105.php'; $sCSS=fUpdNutzerFormulare($sCSS); $bNeu=true;}

 if(!strpos($sCSS,'input.fraASch{')){ //SofortBeantwortenSchalter 24.08.14
  if($p=strpos($sCSS,'input.fraScha{')){$p=strpos($sCSS,'}',$p+1); $p=strpos($sCSS,"\n",$p);
   $sCSS=substr_replace($sCSS,"\ninput.fraASch{ /*SofortBeantwortenSchalter*/\n width:100%; min-height:2.2em;\n font-size:0.95em;\n text-align:left;\n color: ; background-color: ;\n}",$p,0); $bNeu=true;
  }
 }
 if(!strpos($sCSS,'table.fraStat{')){ //Statistikseite 25.08.14
  if($p=strpos($sCSS,'table.fraBwrt{')) if($q=strpos($sCSS,'td.fraBwrt{',$p)) if($q=strpos($sCSS,'}',$q)){
   $sC=str_replace('Bewertungstabelle','Bestenliste',str_replace('fraBwrt','fraStat',substr($sCSS,$p,$q-$p+1)));
   $sCSS=substr_replace($sCSS,"\n\n/* = Tabelle der Bestenliste/Statistik = */\n".$sC,$q+1,0); $bNeu=true;
  }
 }
 if(!strpos($sCSS,'div.fraNorm{')){ //DIV-Container normalisieren 11.10.14
  if($p=strpos($sCSS,'div.fraCapH{')) if($p=strpos($sCSS,'}',$p)){
   $sCSS=substr_replace($sCSS," color:#555555;\n}\n\n/* Normalisierung, falls div-Containern fremdformatiert sind  */\n\ndiv.fraNorm{\n font-size:1.0em; font-weight:normal;\n border-style:none; border-width:0;\n margin:0; padding:0;\n color:#000000;\n",$p,0); $bNeu=true;
  }
  if($p=strpos($sCSS,'td.fraDru{')) if($p=strpos($sCSS,'}',$p)){
   $sCSS=substr_replace($sCSS,"}\ndiv.fraDru{\n font-size:1.0em; font-weight:normal;\n border-style:none; border-width:0;\n margin:0; padding:0;\n color:#000000;\n",$p,0); $bNeu=true;
  }
 }
 if(!strpos($sCSS,'td.capCell{')){ //neue Captchas 21.12.14
  if($p=strpos($sCSS,'div.fraDru')) if($p=strpos($sCSS,'}',$p+1)){
   $sCSS=substr_replace($sCSS,"\n\n/* = Captcha-Styles = */\ntd.capCell{ /* Zweitklasse der Zellen in der Captcha-Zeile */\n vertical-align:top;\n padding-top:3px;\n}\ninput.capAnsw{ /* Zweitklasse des Eingabefelds fuer Captcha-Antwort*/\n width:10em;\n}\ninput.capQuest{ /* Zweitklasse des Ausgabefelds der Captcha-Frage */\n background-color:transparent;\n min-width:25em;\n width:99%;\n border:0;\n}\nspan.capImg{ /* Platzhalter fuer das Captcha-Bild */\n}\nimg.capImg{ /* Captcha-Bild */\n margin:1px;\n vertical-align:middle;\n}\nbutton.capReload{ /* Schalter zum Erneuern des Captchas */\n height:22px; width:22px;\n background:transparent url(reload.gif) center no-repeat;\n border:0; padding:0; margin:0;\n font-size:8px; color:transparent;\n}",$p+1,0); $bNeu=true;
  }
 }
 if(!strpos($sCSS,'td.fraMenu form{')){ //Menubutton 14.07.15
  if($p=strpos($sCSS,"\na.fraMenu")){
   $sCSS=substr_replace($sCSS,"td.fraMenu form{margin:0}\n",$p+1,0); $bNeu=true;
  }
 }
 if(!strpos($sCSS,'td.fra15Bs')){ //Menubutton 20.12.15
  if($p=strpos($sCSS,'input.fraLogi')) if($p=strpos($sCSS,'}',$p+1)){
   $sCSS=substr_replace($sCSS,"}\n\ntd.fra15Bs{width:9em;",$p,0); $bNeu=true;
  }
 }
 if(!strpos($sCSS,'div.fraBlock p')){ //Textabsatz wegen CKEdit 14.08.22
  if($p=strpos($sCSS,'div.fraBlock')) if($p=strpos($sCSS,'}',$p+1)){
   $sCSS=substr_replace($sCSS,"}\ndiv.fraBlock p{\n margin:0px;\n",$p,0); $bNeu=true;
  }
 }

 if($bNeu){ //CSS speichern
  if($f=fopen(FRAPFAD.'fraStyle'.$sKonf.'.css','w')){
   fwrite($f,rtrim(str_replace("\n\n\n","\n\n",str_replace("\r",'',$sCSS)))."\n"); fclose($f);
   $sMeld='<p class="admErfo">Die Datei <i>fraStyle'.$sKonf.'.css</i> wurde aktualisiert.</p>'.$sMeld;
  }else $sMeld='<p class="admFehl">In die Datei fraStyle'.$sKonf.'.css durfte nicht geschrieben werden!</p>'.$sMeld;
 }
} // foreach $aKonf

$aKonf=array(); $h=opendir(FRAPFAD); while($sF=readdir($h)) if(substr($sF,0,8)=='fraWerte'&&substr($sF,8,1)!='0'&&strpos($sF,'.php')>0) $aKonf[]=(int)substr($sF,8); closedir($h); sort($aKonf); if($aKonf[0]==0) $aKonf[0]='';
foreach($aKonf as $k=>$sKonf){
 $sWerte=str_replace("\r",'',trim(implode('',file(FRAPFAD.'fraWerte'.$sKonf.'.php')))); $bNeu=false;

 if(!strpos($sWerte,'FRA_MaxSessionZeit')){//Benutzerzentrum 06.09.09-05.11.09
  if($p=strpos($sWerte,"define('FRA_Captcha'")){
   $sWerte=substr_replace($sWerte,"define('FRA_MaxSessionZeit',90);\n",$p,0); $bNeu=true;
  }
 }
 if(!strpos($sWerte,'FRA_SofortFrageNachReg')){
  if($p=strpos($sWerte,"define('FRA_TeilnehmerFelder'")){
   $sWerte=substr_replace($sWerte,"define('FRA_SofortFrageNachReg',false);\n",$p,0); $bNeu=true;
  }
 }
 if(!strpos($sWerte,'FRA_NachLoginWohin')){
  if($p=strpos($sWerte,"define('FRA_SofortFrageBeiLogin'")){
   $q=strpos($sWerte,"\n",$p+1); $q=strpos($sWerte,"\n",$q+1);
   $sWerte=substr_replace($sWerte,"define('FRA_NachLoginWohin','Fragen');\n",$p,$q-$p); $bNeu=true;
  }
 }
 if($p=strpos($sWerte,"define('FRA_TestFolge'")) if($p=strpos($sWerte,"FRA_TestFolge'",$p)){
  $sWerte=substr_replace($sWerte,'SpontanFolge',$p+4,9); $bNeu=true;
 }
 if(!strpos($sWerte,'NutzerStandardtest')){
  if($p=strpos($sWerte,"define('FRA_NachLoginWohin'")) if($p=strpos($sWerte,"\n",++$p)){
   $sWerte=substr_replace($sWerte,"\n\n//Benutzerzentrum\ndefine('FRA_NutzerStandardtest',true);\ndefine('FRA_NutzerAlleFolgen',false);\ndefine('FRA_NutzerSpontaneFolge',false);\ndefine('FRA_NutzerErgebnis',true);\ndefine('FRA_NutzerAendern',true);\ndefine('FRA_ZntErgebnisRueckw',true);\ndefine('FRA_ZntAntwort',true);\ndefine('FRA_ZntLoesung',true);\ndefine('FRA_ZntAnzahlO',true);\ndefine('FRA_ZntZeitO',true);\ndefine('FRA_ZntRichtigeO',true);\ndefine('FRA_ZntFalscheO',true);\ndefine('FRA_ZntPunkteO',true);\ndefine('FRA_ZntVersucheO',false);\ndefine('FRA_ZntAuslassenO',false);\ndefine('FRA_ZntFrageNr',true);\ndefine('FRA_ZntErgebnis',true);\ndefine('FRA_ZntPunkte',true);\ndefine('FRA_ZntVersuche',false);\ndefine('FRA_ZntAuslassen',false);\n",$p,0); $bNeu=true;
  }
 }
 if(!strpos($sWerte,'FRA_TxFuer')){
  if($p=strpos($sWerte,"define('FRA_TxOder'")){
   $sWerte=substr_replace($sWerte,"define('FRA_TxFuer','für');\n",$p,0); $bNeu=true;
  }
 }
 if(!strpos($sWerte,'FRA_TxDatum')){
  if($p=strpos($sWerte,"define('FRA_TxZeit'")){
   $sWerte=substr_replace($sWerte,"define('FRA_TxDatum','Datum/Zeit');\n",$p,0); $bNeu=true;
  }
 }
 if(!strpos($sWerte,"FRA_TxAntwort'")){
  if($p=strpos($sWerte,"define('FRA_TxPunkte'")){
   $sWerte=substr_replace($sWerte,"define('FRA_TxAntwort','Antwort');\ndefine('FRA_TxLoesung','Lösung');\ndefine('FRA_TxErgebnis','Ergebnis');\n",$p,0); $bNeu=true;
  }
 }
 $bUpd091105=false;
 if(!strpos($sWerte,'FRA_TxBenutzerzentrum')){
  if($p=strpos($sWerte,"define('FRA_TxSessionUngueltig'")) if($p=strpos($sWerte,"\n",++$p)){
   $sWerte=substr_replace($sWerte,"\n\n//Benutzerzentrum\ndefine('FRA_TxBenutzerzentrum','Benutzerzentrum');\ndefine('FRA_TxAbmelden','Sitzung beenden');\ndefine('FRA_TxTestNr','Test-#:');\ndefine('FRA_TxTestName','Testname');\ndefine('FRA_TxStandardTest','Standardtest');\ndefine('FRA_TxSpontanFolge','Spontanfolge');\ndefine('FRA_TxErgebnisListe','Ergebnisliste');\ndefine('FRA_TxNutzerAendern','Benutzerdaten ändern');\ndefine('FRA_TxErgebnisDetails','Details anzeigen');\n",$p,0); $bNeu=true; $bUpd091105=true;
  }
 }
 if(!strpos($sWerte,"FRA_TxNutzerUnveraendert'")){
  if($p=strpos($sWerte,"define('FRA_TxNutzerGeaendert'")){
   $sWerte=substr_replace($sWerte,"define('FRA_TxNutzerUnveraendert',\"Die Benutzerdaten bleiben unverändert!\");\n",$p,0); $bNeu=true;
  }
 }
 if(!strpos($sWerte,'FRA_ZeitLimit')){
  if($p=strpos($sWerte,"define('FRA_Rueckwaerts'")){
   $sWerte=substr_replace($sWerte,"define('FRA_ZeitLimit',0);\n",$p,0); $bNeu=true;
  }
 }
 if(!strpos($sWerte,'FRA_TxZeitLimit')){
  if($p=strpos($sWerte,"define('FRA_TxBewertungHier'")){
   $sWerte=substr_replace($sWerte,"define('FRA_TxZeitLimit',\"Die Bearbeitungszeit ist abgelaufen. Hier Ihr Ergebnis.\");\n",$p,0); $bNeu=true;
  }
 }
 if(!strpos($sWerte,'FRA_NummernTyp')){//12.03.10
  if($p=strpos($sWerte,"define('FRA_ZeigeKategorie'")){
   $sWerte=substr_replace($sWerte,"define('FRA_NummernTyp',0);\n",$p,0); $bNeu=true;
  }
 }
 if(!strpos($sWerte,'FRA_BldTestName')){//18.10.11
  if($p=strpos($sWerte,"define('FRA_BldPunkte'")){
   $sWerte=substr_replace($sWerte,"define('FRA_BldTestName',true);\n",$p,0); $bNeu=true;
  }
  if($p=strpos($sWerte,"define('FRA_AdmPunkte'")){
   $sWerte=substr_replace($sWerte,"define('FRA_AdmTestName',true);\n",$p,0); $bNeu=true;
  }
  if($p=strpos($sWerte,"define('FRA_TlnPunkte'")){
   $sWerte=substr_replace($sWerte,"define('FRA_TlnTestName',true);\n",$p,0); $bNeu=true;
  }
 }
 if(!strpos($sWerte,'FRA_ZufallsAntwort')){//12.02.12 Zufallsantworten
  if($p=strpos($sWerte,"define('FRA_PruefeAnzahl'")){
   $sWerte=substr_replace($sWerte,"define('FRA_ZufallsAntwort',false);\n",$p,0); $bNeu=true;
  }
 }
 if(!strpos($sWerte,'FRA_RestZeit')){//12.02.12 Restzeit
  if($p=strpos($sWerte,"define('FRA_Rueckwaerts'")){
   $sWerte=substr_replace($sWerte,"define('FRA_RestZeit',false);\n",$p,0); $bNeu=true;
  }
  if($p=strpos($sWerte,"define('FRA_TxNeuStart'")){
   $sWerte=substr_replace($sWerte,"define('FRA_TxRestZeit','Restzeit');\n",$p,0); $bNeu=true;
  }
 }
 if(!strpos($sWerte,'FRA_TxZwischenwertung')){//12.02.12 Zwischenbewertung
  if($p=strpos($sWerte,"define('FRA_TxHandle'")){
   $sWerte=substr_replace($sWerte,"define('FRA_TxZwischenwertung',\"\");\n",$p,0); $bNeu=true;
  }
 }
 if(!strpos($sWerte,'FRA_ZntVerbalO')){//12.02.12 verbale Bewertung
  if($p=strpos($sWerte,"define('FRA_ZntVersucheO'")){
   $sWerte=substr_replace($sWerte,"define('FRA_ZntVerbalO',false);\n",$p,0); $bNeu=true;
  }
  if($p=strpos($sWerte,"define('FRA_DatVersucheO'")){
   $sWerte=substr_replace($sWerte,"define('FRA_DatVerbalO',false);\n",$p,0); $bNeu=true;
  }
  if($p=strpos($sWerte,"define('FRA_BldVersucheO'")){
   $sWerte=substr_replace($sWerte,"define('FRA_BldVerbalO',false);\n",$p,0); $bNeu=true;
  }
  if($p=strpos($sWerte,"define('FRA_BldVersucheU'")){
   $sWerte=substr_replace($sWerte,"define('FRA_BldVerbalU',false);\n",$p,0); $bNeu=true;
  }
  if($p=strpos($sWerte,"define('FRA_AdmVersucheO'")){
   $sWerte=substr_replace($sWerte,"define('FRA_AdmVerbalO',false);\n",$p,0); $bNeu=true;
  }
  if($p=strpos($sWerte,"define('FRA_AdmVersucheU'")){
   $sWerte=substr_replace($sWerte,"define('FRA_AdmVerbalU',false);\n",$p,0); $bNeu=true;
  }
  if($p=strpos($sWerte,"define('FRA_TlnVersucheO'")){
   $sWerte=substr_replace($sWerte,"define('FRA_TlnVerbalO',false);\n",$p,0); $bNeu=true;
  }
  if($p=strpos($sWerte,"define('FRA_TlnVersucheU'")){
   $sWerte=substr_replace($sWerte,"define('FRA_TlnVerbalU',false);\n",$p,0); $bNeu=true;
  }
 }
 if(!strpos($sWerte,'FRA_VerbalTx0')){//12.02.12 verbale Bewertung
  if($p=strpos($sWerte,"define('FRA_DatVerlauf'")) if($p=strpos($sWerte,"\n",$p+1)){
   $sWerte=substr_replace($sWerte,"\ndefine('FRA_VerbalAb1',50);\ndefine('FRA_VerbalTx1',\"bestanden\");\ndefine('FRA_VerbalAb2',0);\ndefine('FRA_VerbalTx2',\"\");\ndefine('FRA_VerbalAb3',0);\ndefine('FRA_VerbalTx3',\"\");\ndefine('FRA_VerbalAb4',0);\ndefine('FRA_VerbalTx4',\"\");\ndefine('FRA_VerbalAb5',0);\ndefine('FRA_VerbalTx5',\"\");\ndefine('FRA_VerbalAb6',0);\ndefine('FRA_VerbalTx6',\"\");\ndefine('FRA_VerbalTx0',\"nicht bestanden\");",$p,0); $bNeu=true;
  }
 }
 if(!strpos($sWerte,'FRA_Smtp')){ //SMTP 17.02.12
  if($p=strpos($sWerte,"define('FRA_EnvelopeSender'")){
   $sWerte=substr_replace($sWerte,"define('FRA_Smtp',false);\ndefine('FRA_SmtpHost','localhost');\ndefine('FRA_SmtpPort',25);\ndefine('FRA_SmtpAuth',false);\ndefine('FRA_SmtpUser','');\ndefine('FRA_SmtpPass','');\n",$p,0); $bNeu=true;
  }
 }
 if(!strpos($sWerte,'FRA_VerbalPunkte')){
  if($p=strpos($sWerte,"define('FRA_VerbalAb1'")){
   $sWerte=substr_replace($sWerte,"define('FRA_VerbalPunkte',true);\n",$p,0); $bNeu=true;
  }
 }
 if($p=strpos($sWerte,"define('FRA_TeilWertung'")){ //Typaenderung FRA_TeilWertung 12.10.12
  if($p=strpos($sWerte,',',$p+1)){
   if(substr($sWerte,$p,6)==',false') $sWerte=substr_replace($sWerte,',0',$p,6);
   elseif(substr($sWerte,$p,5)==',true') $sWerte=substr_replace($sWerte,',1',$p,5);
  }
 }
 if(!strpos($sWerte,'FRA_TxBB_H')){//02.02.13 Hoch-Tiefgestellt
  if($p=strpos($sWerte,"define('FRA_TxBB_C'")){
   $sWerte=substr_replace($sWerte,"define('FRA_TxBB_H','hochgestellter Text: [sup]Text[/sup]');\ndefine('FRA_TxBB_D','tiefgestellter Text: [sub]Text[/sub]');\n",$p,0); $bNeu=true;
  }
 }
 if(($p=strpos($sWerte,"'FRA_Version'"))&&substr($sWerte,$p+15,3)<'3.3'){ //Update Version 3.3 25.02.13
  if(file_exists('upd_33.php')){
   $bUpd33=false; include 'upd_33.php';
   if($bUpd33) $bNeu=true; else $sMeld.='<p class="admFehl">Die Version_3.3 konnte nicht in die Konfiguration '.$sKonf.' eingespielt werden.</p>';
  }else if(!strpos($sMeld,'upd_33')) $sMeld.='<p class="admFehl">Die Datei <i>upd_33.php</i> wurde nicht gefunden.</p>';
 }
 if(!strpos($sWerte,'FRA_OffenNurFalsche')){ //Offenlegen nur Falsche 02.11.13
  if($p=strpos($sWerte,"define('FRA_Offenlegen'")) if($p=strpos($sWerte,"\n",$p+1)){
   $sWerte=substr_replace($sWerte,"\ndefine('FRA_OffenNurFalsche',true);",$p,0); $bNeu=true;
 }}
 if(!strpos($sWerte,'FRA_SqlCharSet')){ //MySQL-Charset 01.02.14
  if($p=strpos($sWerte,"define('FRA_Datumsformat'")){
   $sWerte=substr_replace($sWerte,"define('FRA_SqlCharSet','');\n",$p,0); $bNeu=true;
 }}
 if(!strpos($sWerte,'FRA_BldKatFehlErgb')){//Fehler pro Kategorie separat 12.04.14
  if($p=strpos($sWerte,"define('FRA_BldKatPunkte'"))
   $sWerte=substr_replace($sWerte,"define('FRA_BldKatFehlErgb',false);\n",$p,0);
  if($p=strpos($sWerte,"define('FRA_AdmKatPunkte'"))
   $sWerte=substr_replace($sWerte,"define('FRA_AdmKatFehlErgb',false);\n",$p,0);
  if($p=strpos($sWerte,"define('FRA_TlnKatPunkte'"))
   $sWerte=substr_replace($sWerte,"define('FRA_TlnKatFehlErgb',false);\n",$p,0);
  if($p=strpos($sWerte,"define('FRA_DatKatPunkte'"))
   $sWerte=substr_replace($sWerte,"define('FRA_DatKatFehlErgb',true);\n",$p,0);
  if($p=strpos($sWerte,"define('FRA_ZntKatPunkte'"))
   $sWerte=substr_replace($sWerte,"define('FRA_ZntKatFehlErgb',false);\n",$p,0);
 }
 if(!strpos($sWerte,'FRA_UploadDir')){ //UpLoadDir 12.04.14
  if($p=strpos($sWerte,"define('FRA_Fragen'")){
   $sWerte=substr_replace($sWerte,"define('FRA_UploadDir','".FRA_Bilder."');\n",$p,0); $bNeu=true;
 }}
 if($p=strpos($sWerte,"NachLoginWohin','Fragen'")){ //NachLoginWohin=Fragen 21.08.14
  $sWerte=substr_replace($sWerte,'FragenA',$p+17,6); $bNeu=true;
 }
 if(!strpos($sWerte,'FRA_NutzerLoesung')){ // 22.08.14 Nutzerzentrum Loesungsseite
  if($p=strpos($sWerte,"define('FRA_NutzerAendern'")){
   $sWerte=substr_replace($sWerte,"define('FRA_NutzerLoesung',false);\ndefine('FRA_NutzerLsgAlle',true);\n",$p,0); $bNeu=true;
  }
  if($p=strpos($sWerte,"define('FRA_TxErgebnisDetails'")){
   $sWerte=substr_replace($sWerte,"define('FRA_TxErgebnisLoesung','Lösungsseite anzeigen');\n",$p,0); $bNeu=true;
  }
 }
 if(!strpos($sWerte,'FRA_SofortBeiKlick')){ //SofortBeantworten 24.08.14
  if($p=strpos($sWerte,"FRA_RadioButton")) if($p=strpos($sWerte,"\n",$p)){
   $sWerte=substr_replace($sWerte,"\ndefine('FRA_SofortBeiKlick',0);",$p,0); $bNeu=true;
 }}
 if(!strpos($sWerte,'FRA_NutzerStatistik')){ //Bestenliste 27.08.14
  if($p=strpos($sWerte,'FRA_TlnPersonU')) if($p=strpos($sWerte,"\n",$p+1)){
   $sWerte=substr_replace($sWerte,"\n\n// Statistik/Bestenliste\ndefine('FRA_Statistik',true);\ndefine('FRA_StatOffen',true);\ndefine('FRA_StatFelder','1,2,0,0,0,0,4,0,0,0,0,0,0,3');\ndefine('FRA_StatNFelder','1,2,0,0,0,0,4,0,0,0,0,0,0,3');\ndefine('FRA_StatCssStil',',,,,,,font-weight:bold;,,,,,,,');\ndefine('FRA_StatTlnFld','1,1');\ndefine('FRA_StatNtzFld','0,0,0,0,0,1,1');\ndefine('FRA_StatTlnTrn',', ');\ndefine('FRA_StatNtzTrn',', ');\ndefine('FRA_StatSortier1',6);\ndefine('FRA_StatSortier2',2);\ndefine('FRA_StatSortAbsteig',true);\ndefine('FRA_StatDatumZeit',true);\ndefine('FRA_StatKommaStellen',1);\ndefine('FRA_StatListenZeilen',20);\n",$p,0); $bNeu=true;
  }
  if($p=strpos($sWerte,'FRA_TxErgebnisDetails'))  if($p=strpos($sWerte,"\n",$p+1)){
   $sWerte=substr_replace($sWerte,"\ndefine('FRA_TxStatistik',\"Die bisher besten Resultate lauten:\");\ndefine('FRA_TxKeinTlnNam','Gast');\ndefine('FRA_TxKeinNtzNam','unbekannt');",$p,0); $bNeu=true;
  }
  if($p=strpos($sWerte,"define('FRA_NutzerAendern'")){
   $sWerte=substr_replace($sWerte,"define('FRA_NutzerStatistik',true);\n",$p,0); $bNeu=true;
  }
  if($p=strpos($sWerte,"define('FRA_TxNutzerAendern'")){
   $sWerte=substr_replace($sWerte,"define('FRA_TxNutzerStatName','Bestenliste');\n",$p,0); $bNeu=true;
  }
 }
 if(!strpos($sWerte,"define('FRA_RegistWenn'")){ //bedingte Registrierung 27.08.14
  if($p=strpos($sWerte,"define('FRA_SofortFrageNachReg'")){
   $sWerte=substr_replace($sWerte,"define('FRA_RegistWenn','');\ndefine('FRA_RegistGrenze',60);\n",$p,0); $bNeu=true;
 }}
 if(!strpos($sWerte,"define('FRA_TxRegistNicht'")){
  if($p=strpos($sWerte,'FRA_TxVorNachErfassen')) if($p=strpos($sWerte,"\n",$p)){
   $sWerte=substr_replace($sWerte,"\ndefine('FRA_TxRegistNicht','Sie haben weniger als das Limit erreicht.\n Der Versuch wird nicht gewertet.');",$p,0); $bNeu=true;
 }}
 if(!strpos($sWerte,"define('FRA_LoginWenn'")){ //bedingte Registrierung 27.08.14
  if($p=strpos($sWerte,"define('FRA_Nutzerzwang'")){
   $sWerte=substr_replace($sWerte,"define('FRA_LoginWenn','');\ndefine('FRA_LoginGrenze',50);\n",$p,0); $bNeu=true;
 }}
 if(!strpos($sWerte,"define('FRA_TxLoginNicht'")){
  if($p=strpos($sWerte,'FRA_TxNutzerLogin')) if($p=strpos($sWerte,"\n",$p)){
   $sWerte=substr_replace($sWerte,"\ndefine('FRA_TxLoginNicht','Sie haben weniger als das Limit erreicht.\n Der Versuch wird nicht eingetragen.');",$p,0); $bNeu=true;
 }}
 if(!strpos($sWerte,"define('FRA_DruckSchablone'")){ //bedingte Registrierung 11.10.14
  if($p=strpos($sWerte,"define('FRA_DruckSpalten'")){
   $sWerte=substr_replace($sWerte,"define('FRA_DruckSchablone','fraSeite.htm');\n",$p,0); $bNeu=true;
 }}
 if(!strpos($sWerte,"define('FRA_CaptchaTyp'")){ //neue Captchas 14.12.14
  if($p=strpos($sWerte,"define('FRA_CaptchaPfad'")){
   $sWerte=substr_replace($sWerte,"define('CAPTCHA_SALT','".chr(rand(65,90)).substr(time(),-5)."');\ndefine('FRA_CaptchaTyp','G');\ndefine('FRA_CaptchaGrafisch',true);\ndefine('FRA_CaptchaNumerisch',false);\ndefine('FRA_CaptchaTextlich',false);\n",$p,0); $bNeu=true;
 }}
 if(!strpos($sWerte,"define('FRA_TxCaptchaNeu'")){
  if($p=strpos($sWerte,"define('FRA_TxCaptchaHilfe'")){
   $sWerte=substr_replace($sWerte,"define('FRA_TxCaptchaNeu','neues #Captcha anfordern');\ndefine('FRA_TxZahlenCaptcha','Zahlen-');\ndefine('FRA_TxTextCaptcha','Text-');\ndefine('FRA_TxGrafikCaptcha','Grafik-');\n",$p,0); $bNeu=true;
 }}
 if(!strpos($sWerte,"define('FRA_TeilnehmerSperre'")){ //Folgen anbieten 20.01.15
  if($p=strpos($sWerte,"define('FRA_SofortFrageNachReg'")){
   $s=((substr($sWerte,$p+32,4)=='true')?'Fragen':'Daten'); $q=strpos($sWerte,"\n",$p+1);
   $sWerte=substr_replace($sWerte,"define('FRA_TeilnehmerSperre',false);\ndefine('FRA_NachRegisterWohin','".$s."');\ndefine('FRA_TeilnehmerMitCode',false);\n",$p,$q-$p+1); $bNeu=true;
  }
  if($p=strpos($sWerte,"define('FRA_NutzerFelder'")){
   $sWerte=substr_replace($sWerte,"define('FRA_NutzerSperre',false);\ndefine('FRA_NutzerMitCode',false);\n",$p,0); $bNeu=true;
  }
  if($p=strpos($sWerte,"('FRA_SQL',false)")){ //Textdatei ergaenzen
   if($p=strpos($sWerte,"('FRA_Pfad',")){$q=strpos($sWerte,"\n",$p); $s=substr($sWerte,$p,$q-($p+3)); $sUpPfad=substr($s,strpos($s,",'")+2);}
   if($p=strpos($sWerte,"('FRA_Daten',")){$q=strpos($sWerte,"\n",$p); $s=substr($sWerte,$p,$q-($p+3)); $sUpDaten=substr($s,strpos($s,",'")+2);}
   if($p=strpos($sWerte,"('FRA_Folgen',")){$q=strpos($sWerte,"\n",$p); $s=substr($sWerte,$p,$q-($p+3)); $sUpFolgen=substr($s,strpos($s,",'")+2);}
   $aFlg=@file($sUpPfad.$sUpDaten.$sUpFolgen); $t='Folge;Fragen;ProSeite;GAktiv;BAktiv;Code;VorAuswertung;NachAuswertung'."\n"; $nFlg=count($aFlg);
   for($p=1;$p<$nFlg;$p++){
    $a=explode(';',rtrim($aFlg[$p]));
    if(isset($a[1])&&$a[1]>' ') $t.=$a[0].';'.$a[1].';'.(isset($a[2])?$a[2]:'').';0;1;'.rand(1000,9999)."\n";
   }
   if($f=fopen($sUpPfad.$sUpDaten.$sUpFolgen,'w')){fwrite($f,$t); fclose($f);}
  }
  if($p=strpos($sWerte,"('FRA_SQL',true)")){ //SQL-Datei ergaenzen
   if($p=strpos($sWerte,"('FRA_SqlHost',")){$q=strpos($sWerte,"\n",$p); $s=substr($sWerte,$p,$q-($p+3)); $sSqlHost=substr($s,strpos($s,",'")+2);}
   if($p=strpos($sWerte,"('FRA_SqlUser',")){$q=strpos($sWerte,"\n",$p); $s=substr($sWerte,$p,$q-($p+3)); $sSqlUser=substr($s,strpos($s,",'")+2);}
   if($p=strpos($sWerte,"('FRA_SqlPass',")){$q=strpos($sWerte,"\n",$p); $s=substr($sWerte,$p,$q-($p+3)); $sSqlPass=substr($s,strpos($s,",'")+2);}
   if($p=strpos($sWerte,"('FRA_SqlDaBa',")){$q=strpos($sWerte,"\n",$p); $s=substr($sWerte,$p,$q-($p+3)); $sSqlDaBa=substr($s,strpos($s,",'")+2);}
   if($p=strpos($sWerte,"('FRA_SqlTabF',")){$q=strpos($sWerte,"\n",$p); $s=substr($sWerte,$p,$q-($p+3)); $sSqlTabF=substr($s,strpos($s,",'")+2);}
   if($p=strpos($sWerte,"('FRA_SqlTabT',")){$q=strpos($sWerte,"\n",$p); $s=substr($sWerte,$p,$q-($p+3)); $sSqlTabT=substr($s,strpos($s,",'")+2);}
   $DbO=@new mysqli($sSqlHost,$sSqlUser,$sSqlPass,$sSqlDaBa);
   if(!mysqli_connect_errno()){
    $DbO->query('ALTER TABLE '.$sSqlTabT.' ADD COLUMN `GAktiv` CHAR(1) NOT NULL DEFAULT "" AFTER `ProSeite`, ADD COLUMN `BAktiv` CHAR(1) NOT NULL DEFAULT "" AFTER `GAktiv`, ADD COLUMN `Code` INT(4) NOT NULL DEFAULT "0" AFTER `BAktiv`');
    $DbO->query('UPDATE IGNORE '.$sSqlTabT.' SET GAktiv="0",BAktiv="1",Code="3927" WHERE Folge>" "');
    $DbO->close(); $DbO=NULL;
 }}}
 if(!strpos($sWerte,"define('FRA_TxNutzerSperre'")){ //Tests sperren 25.01.15
  if($p=strpos($sWerte,"define('FRA_TxVorVorErfassen'")){
   $sWerte=substr_replace($sWerte,"define('FRA_TxTeilnehmerSperre','Der Zugang für Teilnehmer ist momentan gesperrt.');\n",$p,0); $bNeu=true;
  }
  if($p=strpos($sWerte,"define('FRA_TxLoginNicht'")){
   $sWerte=substr_replace($sWerte,"define('FRA_TxNutzerSperre','Der Zugang für Benutzer ist momentan gesperrt');\n",$p,0); $bNeu=true;
 }}
 if(!strpos($sWerte,"define('FRA_TeilnehmerAlleFolgen'")){ //Testauswahlzentrum 28.01.15
  if($p=strpos($sWerte,"define('FRA_TeilnehmerFelder'")){
   $sWerte=substr_replace($sWerte,"define('FRA_TeilnehmerStandardtest',false);\ndefine('FRA_TeilnehmerSpontaneFolge',false);\ndefine('FRA_TeilnehmerAlleFolgen',true);\ndefine('FRA_TeilnehmerDrucken',false);\ndefine('FRA_TeilnehmerKennfeld',1);\n",$p,0); $bNeu=true;
  }
  if($p=strpos($sWerte,"define('FRA_TxAbmelden'")){
   $sWerte=substr_replace($sWerte,"define('FRA_TxTeilnehmerzentrum','Testauswahl');\n",$p,0); $bNeu=true;
 }}
 if(!strpos($sWerte,"define('FRA_ZeigeNamen'")){ //Nutzernamen zeigen 01.02.15
  if($p=strpos($sWerte,"define('FRA_ZeigeAntwZahl'")){
   $sWerte=substr_replace($sWerte,"define('FRA_ZeigeNamen','');\n",$p,0); $bNeu=true;
 }}
 if(!strpos($sWerte,"define('FRA_DatVerbalL'")){ //verbale Wertung in Adminliste 08.11.15
  if($p=strpos($sWerte,"define('FRA_DatVersucheO'")){
   $sWerte=substr_replace($sWerte,"define('FRA_DatVerbalL',false);\n",$p,0); $bNeu=true;
 }}
 if(!strpos($sWerte,"define('FRA_TxZeigeAdmPkte'")){ //verbale Wertung in Adminliste 08.11.15
  if($p=strpos($sWerte,"define('FRA_DatVerbalO'")){
   $sWerte=substr_replace($sWerte,"define('FRA_TxZeigeAdmPkte','');\n",$p,0); $bNeu=true;
 }}
 if(!strpos($sWerte,"define('FRA_DruckZufallsAw'")){ //zufaellige Antwortreihenfolge drucken
  if($p=strpos($sWerte,"define('FRA_DruckBildW'")){
   $sWerte=substr_replace($sWerte,"define('FRA_DruckZufallsAw',false);\n",$p,0); $bNeu=true;
 }}
 if(!strpos($sWerte,"define('FRA_TxDruckGanzeListe'")){ //DrucklistenUeberschriften
  if($p=strpos($sWerte,"define('FRA_TxDruckFilter'")){
   $sWerte=substr_replace($sWerte,"define('FRA_TxDruckGanzeListe','Gesamt-Fragenliste');\ndefine('FRA_TxDruckFilterListe','Auszug aus der Fragenliste');\n",$p,0); $bNeu=true;
 }}
 if(!strpos($sWerte,"define('FRA_TxDruckNrOriginal'")){ //DruckNummern 20.03.16
  if($p=strpos($sWerte,"define('FRA_TxZeigeRichtig'")){
   $sWerte=substr_replace($sWerte,"define('FRA_TxDruckNrOriginal','Original-Nummer');\ndefine('FRA_TxDruckNrCronolog','chronologisch');\n",$p,0); $bNeu=true;
 }}
 if(!strpos($sWerte,"define('FRA_BldVorAw'")){ //21.05.16 Vor- und Nachtext bei Folgen-Auswertung
  if($p=strpos($sWerte,"define('FRA_BldAnzahlO'")){
   $sWerte=substr_replace($sWerte,"define('FRA_BldVorAw',false);\ndefine('FRA_BldNachAw',false);\ndefine('FRA_TlnVorAw',false);\ndefine('FRA_TlnNachAw',false);\n",$p,0); $bNeu=true;
  }
  if($p=strpos($sWerte,"('FRA_SQL',true)")){ //SQL ergaenzen
   if($p=strpos($sWerte,"('FRA_SqlTabT',")){$q=strpos($sWerte,"\n",$p); $s=substr($sWerte,$p,$q-($p+3)); $sSqlTabT=substr($s,strpos($s,",'")+2);}
   if($p=strpos($sWerte,"('FRA_SqlHost',")){$q=strpos($sWerte,"\n",$p); $s=substr($sWerte,$p,$q-($p+3)); $sSqlHost=substr($s,strpos($s,",'")+2);}
   if($p=strpos($sWerte,"('FRA_SqlUser',")){$q=strpos($sWerte,"\n",$p); $s=substr($sWerte,$p,$q-($p+3)); $sSqlUser=substr($s,strpos($s,",'")+2);}
   if($p=strpos($sWerte,"('FRA_SqlPass',")){$q=strpos($sWerte,"\n",$p); $s=substr($sWerte,$p,$q-($p+3)); $sSqlPass=substr($s,strpos($s,",'")+2);}
   if($p=strpos($sWerte,"('FRA_SqlDaBa',")){$q=strpos($sWerte,"\n",$p); $s=substr($sWerte,$p,$q-($p+3)); $sSqlDaBa=substr($s,strpos($s,",'")+2);}
   $DbO=@new mysqli($sSqlHost,$sSqlUser,$sSqlPass,$sSqlDaBa);
   if(!mysqli_connect_errno()){
    $DbO->query('ALTER TABLE '.$sSqlTabT.' ADD COLUMN `NachAw` TEXT NOT NULL AFTER `CODE`, ADD COLUMN `VorAw` TEXT NOT NULL AFTER `Code`');
    $DbO->close(); $DbO=NULL;
 }}}
 if(!strpos($sWerte,"define('FRA_DatPersonL'")){ //Personendaten in Admin-Ergebnisliste 30.04.17
  if($p=strpos($sWerte,"define('FRA_DatFrageNr'")){
   $sWerte=substr_replace($sWerte,"define('FRA_DatPersonL',true);\ndefine('FRA_DatPersonD',false);\ndefine('FRA_DatPersonN','');\ndefine('FRA_DatPersonT','');\n",$p,0); $bNeu=true;
 }}
 if(!strpos($sWerte,"define('FRA_DSELink'")){ // 05.05.18 Datenschutzerklaerung
  if($p=strpos($sWerte,"define('FRA_Captcha'")){
   $sWerte=substr_replace($sWerte,"define('FRA_DSELink','datenschutz.html');\ndefine('FRA_DSETarget','_blank');\ndefine('FRA_DSEPopUp',false);\ndefine('FRA_DSEPopupW',900);\ndefine('FRA_DSEPopupH',600);\ndefine('FRA_DSEPopupX',5);\ndefine('FRA_DSEPopupY',5);\n",$p,0); $bNeu=true;
  }
  if($p=strpos($sWerte,"define('FRA_TxSessionZeit'")){
   $sWerte=substr_replace($sWerte,"define('FRA_TxDSE1',\"Ich habe die [L]Datenschutzerklärung[/L] gelesen und stimme ihr zu.\");\ndefine('FRA_TxDSE2',\"Ich bin mit der Verarbeitung und Speicherung meiner persönlichen Daten im Rahmen der Datenschutzerklärung einverstanden.\");\n",$p,0); $bNeu=true;
  }
  if($p=strpos($sWerte,"define('FRA_NachLoginWohin'")){
   $sWerte=substr_replace($sWerte,"define('FRA_NutzerDSE1',false);\ndefine('FRA_NutzerDSE2',false);\n",$p,0); $bNeu=true;
  }
  if($p=strpos($sWerte,"define('FRA_TeilnehmerStandardtest'")){
   $sWerte=substr_replace($sWerte,"define('FRA_TeilnehmerDSE1',false);\ndefine('FRA_TeilnehmerDSE2',false);\n",$p,0); $bNeu=true;
  }
 }
 if(!strpos($sWerte,"define('SMTP_No_TLS'")){ // 30.05.18 SMTP_No_TLS
  if($p=strpos($sWerte,"define('FRA_SmtpAuth'")){
   $sWerte=substr_replace($sWerte,"if(!defined('SMTP_No_TLS')) define('SMTP_No_TLS',true);\n",$p,0); $bNeu=true;
 }}
 if(!strpos($sWerte,"define('FRA_OhneAntwort'")){ // 20.01.19 Fragen ohne Antwort
  if($p=strpos($sWerte,"define('FRA_BildKB'")){
   $sWerte=substr_replace($sWerte,"define('FRA_OhneAntwort',false);\n",$p,0); $bNeu=true;
 }}
 if(!strpos($sWerte,"define('FRA_StatSrt2Absteig'")){ // 08.02.19 Sortierung2 Bestenliste
  if($p=strpos($sWerte,"define('FRA_StatDatumZeit'")){
   $sWerte=substr_replace($sWerte,"define('FRA_StatSrt2Absteig',true);\n",$p,0); $bNeu=true;
 }}
 if(!strpos($sWerte,"define('FRA_TxAktivCodeNoetig'")){ // 27.07.19 Aktivcodetext
  if($p=strpos($sWerte,"define('FRA_TxKeinTlnNam'")){
   $sWerte=substr_replace($sWerte,"define('FRA_TxAktivCodeNoetig','Geben Sie den korrekten Aktiv-Code an!');\n",$p,0); $bNeu=true;
 }}
 if(!strpos($sWerte,"define('FRA_TxErgDruckKopf'")){ // 15.10.19 Ergebnisdruck
  if($p=strpos($sWerte,"define('FRA_VerbalPunkte'")){
   $sWerte=substr_replace($sWerte,"define('FRA_ErgDruckTempl',true);\ndefine('FRA_TxErgDruckKopf',\"Ergebnis Nr. #N von Teilnehmer #T am #D\");\ndefine('FRA_TxErgDruckFuss',\"Gesamt #P von #G Punkten, #W Prozent\");\n",$p,0); $bNeu=true;
  }
  if($p=strpos($sWerte,"define('FRA_TxErgebnisDetails'")){
   $sWerte=substr_replace($sWerte,"define('FRA_TxErgebnisDrucken','Lösungsseiten drucken');\n",$p,0); $bNeu=true;
  }
 }
 if(!strpos($sWerte,"define('FRA_HilfeBemerkung'")){ // 25.03.20 Hilfebermerkung und Lernmodusbemerkung
  if($p=strpos($sWerte,"define('FRA_ZeigeNamen'")){
   $sWerte=substr_replace($sWerte,"define('FRA_HilfeBemerkung',false);\ndefine('FRA_LernBemerkung',0);\n",$p,0); $bNeu=true;
 }}
 if(!strpos($sWerte,'FRA_CSSDatei')){ //spezielle CSS-Datei 09.05.21
  if($p=strpos($sWerte,"define('FRA_LayoutTyp'")){
   $sWerte=substr_replace($sWerte,"define('FRA_CSSDatei','fraStyle.css');\n",$p,0); $bNeu=true;
 }}
 if(!strpos($sWerte,"define('FRA_TxBB_V'")){ // 09.07.22 Videos und Audios
  if($p=strpos($sWerte,"define('FRA_TxBB_O'")){
   $sWerte=substr_replace($sWerte,"define('FRA_TxBB_V','Video: [video]pfad/datei.mp4[/video] oder [video Breite Höhe]https://www.domain.de/pfad/datei.ogg[/video]');\ndefine('FRA_TxBB_Y','Youtube: [youtube Breite Höhe]https://www.youtube.com/embed/ID-Code[/youtube]');\ndefine('FRA_TxBB_A','Audio: [audio]pfad/datei.mp3[/audio] oder [audio]https://www.domain.de/pfad/datei.mp3[/audio]');\n",$p,0); $bNeu=true;
 }}
 if(!strpos($sWerte,"define('ADF_CKEditor'")){ // 10.08.22 CKEditor
  if($p=strpos($sWerte,"define('ADF_AntwortZahl'")){
   $sWerte=substr_replace($sWerte,"define('ADF_CKEditor',false);\n",$p,0); $bNeu=true;
 }}
 // 03.09.23 Setup offline-Test per 'offline.php'

 //Abschluss
 if(fSetzFraWert($fraVersion,'Version',"'")) $bNeu=true;
 if($bNeu){ //in fraWerte speichern
  if($f=fopen(FRAPFAD.'fraWerte'.$sKonf.'.php','w')){
   fwrite($f,rtrim(str_replace("\n\n\n","\n\n",str_replace("\r",'',$sWerte)))."\n"); fclose($f); $sErfo.=', '.($sKonf?$sKonf:'0');
   if($bUpd091105){include_once 'upd091105.php'; fUpdErgFlgNa($sWerte);}
  }else $sMeld.='<p class="admFehl">In die Datei fraWerte'.$sKonf.'.php durfte nicht geschrieben werden!</p>';
 }
}//foreach aKonf

if(isset($bUpd33)&&$bUpd33){
 if(fCSSUp33($DivW)) $sMeld.='<p class="admErfo">Die Datei <i>fraStyle.css</i> wurde aktualisiert (3.3).</p>';
 else $sMeld.='<p class="admFehl">In die Datei fraStyle.css durfte nicht geschrieben werden (3.3)!</p>';
 $bUpd33=false;
}
?>