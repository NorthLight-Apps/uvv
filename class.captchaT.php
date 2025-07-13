<?php
class Captcha{
/*--(c) J. Hummel------------------------------------------------------------
 ->Generate()                          erzeugt die Daten
 ->Test(Answer,Public,Question)        prueft die Schluessel
 ->Delete()                            loescht Schluessel und Eintrag
 ->Question                            enthaelt die Frage
 ->PublicKey                           enthaelt den PublicKey
 ->PrivateKey                          enthaelt den PrivatenKey
 ->Path
 ->KeyFile              captcha.csv    Name der Schluesseldatei
 ---------------------------------------------------------------------------*/
 var $Question='';
 var $PrivateKey='';
 var $PublicKey='';
 var $Salt='08-15';
 var $Path='';
 var $KeyFile='';
 var $Type='T';

 function __construct($sPath='./captcha/',$sKeyfile='captcha.csv'){ //Konstruktor
  $this->Path=$sPath;
  $this->KeyFile=$sPath.$sKeyfile;
  if(defined('CAPTCHA_SALT')) $this->Salt=CAPTCHA_SALT;
 }

 function Generate(){ //Captcha erzeugen und Texte liefern
  $sAnswer=$this->GetData(); //setzt $Question
  $sPublic=md5($this->Salt.'*'.strtolower($sAnswer)); $this->PublicKey=$sPublic;
  $aC=@file($this->KeyFile); $sCsv=''; $nTime=time(); $sRefTime=strval($nTime-3600);
  if(is_array($aC)&&($nCnt=count($aC))) for($i=0;$i<$nCnt;$i++){
   $sLn=rtrim($aC[$i]); if(substr($sLn,0,10)>$sRefTime) $sCsv.=$sLn."\n"; else @unlink($this->Path.substr($sLn,11,8).'.jpg');
  }
  if($f=fopen($this->KeyFile,'w')){
   fwrite($f,$sCsv.$nTime.';'.$sPublic."\n"); fclose($f); $sResult='OK';
  }else $sResult.='_KeyFile';
  return $sResult;
 }

 function Test($sAnswer,$sPublic,$sQuestion){ //Antwort pruefen
  $bResult=false;
  $this->Question=str_replace('"','&quot;',$sQuestion);
  $this->PrivateKey=$sAnswer; $this->PublicKey=$sPublic;
  if(strlen($sAnswer)&&$sPublic==md5($this->Salt.'*'.strtolower($sAnswer))){ //richtig
   if(($aC=@file($this->KeyFile))&&is_array($aC)&&($nCnt=count($aC))){
    for($i=0;$i<$nCnt;$i++) if(rtrim(substr($aC[$i],11))==$sPublic){$bResult=true; break;}
   }
  }
  return $bResult;
 }

 function Delete(){ //Captcha loeschen
  $bResult=false;
  $sAnswer=$this->PrivateKey; $sPublic=$this->PublicKey;
  if(strlen($sAnswer)&&$sPublic==md5($this->Salt.'*'.strtolower($sAnswer))){ //richtig
   $sCsv=''; $sRefTime=strval(time()-900);
   if(($aC=@file($this->KeyFile))&&is_array($aC)&&($nCnt=count($aC))){
    for($i=0;$i<$nCnt;$i++){
     $sLn=rtrim($aC[$i]);
     if(substr($sLn,11)==$sPublic){$this->PrivateKey=''; $bResult=true;}
     else{if(substr($sLn,0,10)>$sRefTime) $sCsv.=$sLn."\n"; else @unlink($this->Path.substr($Ln,11,8).'.jpg');}
    }
    if($f=fopen($this->KeyFile,'w')){fwrite($f,$sCsv); fclose($f);}
   }
  }
  return $bResult;
 }

 function GetData(){
  // Tiere
  $q[]='Hund;Welches Haustier bellt?';
  $q[]='Hund;Welches Haustier gehorcht treu seinem Herrn?';
  $q[]='Hund;H�ufigstes Haustier neben der Katze ist der:';
  $q[]='Katze;Welches Haustier macht miau?';
  $q[]='Katze;Vor welchem Haustier sollte die Maus fl�chten?';
  $q[]='Katze;Welches Tier jagt im Haus die M�use?';
  $q[]='Katze;Wer jagt die M�use in Scheune und Garten?';
  $q[]='Katze;H�ufigstes Haustier neben dem Hund ist die:';
  $q[]='Kater;Die m�nnliche Katze ist ein:';
  $q[]='Schwein;Welches Tier grunzt?';
  $q[]='Ferkel;Neu geborene Hausschweine nennt man:';
  $q[]='Kuh;Welches Tier macht muh?';
  $q[]='Kuh;Von welchem Tier kommt die Milch?';
  $q[]='Pferd;Welches Tier wiehert?';
  $q[]='Pferd;Auf welchem Tier reitet der Reiter?';
  $q[]='Pferd;Welches Tier zieht die Kutsche?';
  $q[]='Pferd;Welches Tier l�uft auf der Galopprennbahn?';
  $q[]='Ziege;Welches Tier meckert?';
  $q[]='Schaf;Welches Tier gibt die Wolle?';
  $q[]='Huhn;Welches Tier legt die Eier?';
  $q[]='Hahn;Welcher Vogel kr�ht am Morgen?';
  $q[]='Ente;Welcher Vogel au�er der Gans schnattert?';
  $q[]='Vogel;Welches Tier fliegt und zwitschert?';
  $q[]='Vogel;Welches Tier hat Fl�gel und Federn?';
  $q[]='Vogel;Welches Tier hat Federn und Fl�gel?';
  $q[]='Biene;Welches Insekt liefert den Honig?';
  $q[]='Hase;Welches langohrige Tier hoppelt �ber das Feld?';
  $q[]='Hase;Im M�rchen gibt es den Wettlauf zwischen Igel und:';
  $q[]='Igel;Im M�rchen gibt es den Wettlauf zwischen Hase und:';
  $q[]='Igel;Welches heimische S�ugetier hat Stacheln?';
  $q[]='Hirsch;Welches Tier im Wald tr�gt ein Geweih?';
  $q[]='Fisch;Welches Tier zieht der Angler an Land?';
  $q[]='Fisch;Welches Tier h�ngt an der Angel?';
  $q[]='Frosch;Wer quakt im Teich?';
  $q[]='Giraffe;Welches Tier hat den l�ngsten Hals?';
  $q[]='Elefant;Welches Tier hat einen R�ssel?';
  $q[]='Elefant;Welches Tier hat lange wei�e Sto�z�hne?';
  $q[]='L�we;Wer gilt als K�nig unter den Tieren Afrikas?';
  $q[]='Nashorn;Welches Tier hat ein Horn auf der Nase?';
  $q[]='Krokodil;Welche gro�e Echse lebt im Nil?';
  $q[]='Pinguin;Welcher Vogel tr�gt einen Frack?';
  // Farben
  $q[]='gelb;Welche Farbe hat die Sonne?';
  $q[]='gelb;Welche Farbe hat ein reifes Weizenfeld?';
  $q[]='rot;Welche Farbe hat das Blut?';
  $q[]='rot;In welcher Farbe bl�ht der Klatschmohn?';
  $q[]='rot;Welche Farbe haben reife Erdbeeren?';
  $q[]='gr�n;Welche Farbe hat frisches Gras?';
  $q[]='gr�n;Welche Farbe haben die Bl�tter am Baum?';
  $q[]='gr�n;Welche Farbe hat Spinat?';
  $q[]='blau;In welcher Farbe strahlt ein wolkenloser Himmel?';
  $q[]='braun;Welche Farbe hat Kakao?';
  $q[]='braun;Welche Farbe hat gew�hnliche Schokolade?';
  $q[]='schwarz;Welche Farbe hat Kohle?';
  $q[]='schwarz;Welche Farbe hat der Ru�?';
  $q[]='schwarz;Welche Farbe haben Autoreifen �blicherweise?';
  // Maerchen
  $q[]='Hase;Im M�rchen gibt es den Wettlauf zwischen Igel und:';
  $q[]='Igel;Im M�rchen gibt es den Wettlauf zwischen Hase und:';
  $q[]='Wolf;Welches Tier ist b�se zu Rotk�ppchen?';
  $q[]='Wolf;Wer frisst im M�rchen die 7 Gei�lein?';
  $q[]='Rosenrot;Wie hei�t die Schwester von Schneewei�chen?';
  $q[]='B�r;Welches gro�e Tier wohnt bei Schneewei�chen und Rosenrot?';
  $q[]='Gretel;Wie hei�t im M�rchen die Schwester von H�nsel?';
  $q[]='Gretel;Wer schiebt im M�rchen die Hexe in den Ofen?';
  $q[]='Hexe;Wer h�lt H�nsel und Gretel gefangen?';
  $q[]='Hexe;Wer f�ttert im M�rchen den H�nsel fett?';
  $q[]='Hexe;Wen schiebt Gretel in den Backofen?';
  $q[]='Hexe;Welche M�rchenfigur wohnt im Knusperh�uschen?';
  $q[]='Holle;Die Goldmarie bekommt Ihren Lohn von Frau:';
  $q[]='Holle;Die Pechmarie bekommt Ihr Pech von Frau:';
  $q[]='Holle;Wie hei�t die Frau, die Schnee aus den Betten sch�ttelt?';
  $q[]='Brunnen;Wohinein fallen die Spule und Goldmarie?';
  $q[]='Prinz;Wer weckt Dornr�schen aus dem Schlaf?';
  $q[]='K�nigin;Welche b�se Frau will Schneewittchen vergiften?';
  $q[]='K�nigin;Wer neben Schneewittchen ist die Sch�nste im Land?';
  $q[]='J�ger;Wer mu� Schneewittchen in den Wald bringen?';
  $q[]='J�ger;Wer soll Schneewittchen im Auftrag t�ten?';
  $q[]='Schneewittchen;Wer wohnt bei den 7 Zwergen?';
  $q[]='Schneewittchen;Wer wird von der K�nigin mit einem Kamm vergiftet?';
  $q[]='Schneewittchen;Wen vergiftet die K�nigin mit einem Apfel?';

  $a=explode(';',$q[rand(0,count($q)-1)],2);
  $this->Question=str_replace('"','&quot;',$a[1]);
  return $a[0];
 }
}
?>