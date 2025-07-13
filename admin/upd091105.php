<?php
//Ergebniskonvertierung wegen Testfolgenamen im Benutzerzentrum
function fUpdErgFlgNa($sW){
 if(substr($sW,strpos($sW,"FRA_SQL'")+9,4)!='true'){//TextDatenbank
  $sTab=fGetWerteWert($sW,"FRA_Pfad'").fGetWerteWert($sW,"FRA_Daten'").fGetWerteWert($sW,"FRA_Ergebnis'"); $aE=@file($sTab);
  if(is_array($aE)&&($nZl=count($aE))){
   if(!strpos($aE[0],';Testfolge;')){
    $aE[0]='Eintrag;Datum;Dauer;Anzahl;Richtige;Falsche;Punkte;Versuche;Auslassungen;Bewertung;Antwortkette;Verlaufskette;Testfolge;Benutzer'."\n";
    for($i=1;$i<$nZl;$i++){
     $sZl=rtrim($aE[$i]); $p=0; for($j=0;$j<12;$j++) $p=strpos($sZl,';',$p+1); $aE[$i]=substr_replace($sZl,';',$p,0)."\n";
    }
    if($f=fopen($sTab,'w')){
     fwrite($f,rtrim(implode('',$aE))."\n"); fclose($f);
    }else $sMeld.='<p class="fraFehl">Ergebniskonvertierung in Datei '.fGetWerteWert($sW,"FRA_Ergebnis'").' nicht möglich!</p>';
   }
  }else $sMeld.='<p class="fraFehl">Ergebniskonvertierung in Datei '.fGetWerteWert($sW,"FRA_Ergebnis'").' gescheitert!</p>';
 }else{//SQL
  $DbO=@new mysqli(fGetWerteWert($sW,"FRA_SqlHost'"),fGetWerteWert($sW,"FRA_SqlUser'"),fGetWerteWert($sW,"FRA_SqlPass'"),fGetWerteWert($sW,"FRA_SqlDaBa'"));
  if(!mysqli_connect_errno()){
    $sTab=fGetWerteWert($sW,"FRA_SqlTabE'");
    if(!$rR=$DbO->query('SELECT Testfolge FROM '.$sTab.' LIMIT 0,1')){//Feld nicht vorhanden
     if(!$DbO->query('ALTER TABLE '.$sTab.' ADD Testfolge VARCHAR(50) NOT NULL DEFAULT "" AFTER Verlaufskette'))
      $sMeld.='<p class="fraFehl">Ergebniskonvertierung in SQL-Tabelle '.$sTab.' gescheitert!</p>';
     $DbO->query('ALTER TABLE '.$sTab.' CHANGE Fragen Bewertung TEXT NOT NULL');
    }else $rR->close();
   }else $sMeld.='<p class="fraFehl">Ergebniskonvertierung in SQL-Datenbank '.fGetWerteWert($sW,"FRA_SqlDaBa'").' nicht möglich!</p>';
   $DbO->close();
  }else $sMeld.='<p class="fraFehl">Ergebniskonvertierung in SQL-Verbindung '.fGetWerteWert($sW,"FRA_SqlHost'").' gescheitert!</p>';
 }
}
function fGetWerteWert($sW,$sV){
 $r=false;
 if($p=strpos($sW,$sV)) if($p=strpos($sW,',',$p)){
  $r=substr($sW,$p+1,99); $r=trim(str_replace("'",'',substr($r,0,strpos($r,')'))));
 }
 return $r;
}

//CSS-Erweiterung
function fUpdNutzerFormulare($sCSS){
 $sNeu=str_replace("\r",'',"\n\n".'/* = Formular Benutzerzentrum = */
table.fraMenu{ /* Menütabelle */
 width:; margin-bottom:10px;
 font-size:1.0em; font-weight:normal;
 border-color:#AAAAE0; border-style:dotted; border-width:2px; border-collapse:collapse;
 background-color:#F7F7F0;
 table-layout:auto;
}
td.fraMenu{
 font-size:1.0em; font-weight:normal;
 color:#000000; background-color:#F7F7F7;
 border-color:#CCCCCC; border-width:2px; border-style:dotted;
 padding:6px; vertical-align:middle;
}
td.fraMnuL{
 width:24px; height:;
 /* background-image:url(schalter.gif); Das Hintergrundbild wird später vom PHP-Script eingesetzt wegen der Veränderlichkeit des Pfades bei includierten Aufrufen. */
 background-repeat:no-repeat; background-position:12px;
 border-color:#CCCCCC; border-width:2px; border-style:dotted; border-right-style:none; border-right-style:hidden;
}
td.fraMnuM{
 width:48px; height:;
 text-align:center; color:#666666;
 /* background-image:url(schalter.gif); Das Hintergrundbild wird später vom PHP-Script eingesetzt wegen der Veränderlichkeit des Pfades bei includierten Aufrufen. */
 background-repeat:no-repeat; background-position:-8px;
 border-color:#CCCCCC; border-width:2px; border-style:dotted; border-left-style:none; border-right-style:none; border-left-style:hidden; border-right-style:hidden;
}
td.fraMnuR{
 width:24px; height:;
 /* background-image:url(schalter.gif); Das Hintergrundbild wird später vom PHP-Script eingesetzt wegen der Veränderlichkeit des Pfades bei includierten Aufrufen. */
 background-repeat:no-repeat; background-position:-116px;
 border-color:#CCCCCC; border-width:2px; border-style:dotted; border-left-style:none; border-left-style:hidden;
}
a.fraMenu,a.fraMenu:link,a.fraMenu:active,a.fraMenu:visited{ /*Links im Menüschalter*/
 color:#111177; text-decoration:none;
 font-size:0.95em; font-weight:normal;
}
a.fraMenu:hover{
 color:#00BB11; text-decoration:none;
}
');
 if($p=strpos($sCSS,'input.fraLogi')) if($p=strpos($sCSS,'}',$p+1)) if($p=strpos($sCSS,"\n",$p+1)){
  $sCSS=substr_replace($sCSS,$sNeu,$p,0); $bNeu=true;
 }
 return $sCSS;
}
?>