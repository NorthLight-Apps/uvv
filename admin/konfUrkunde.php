<?php
include 'hilfsFunktionen.php'; $bAlleKonf=false; $sKonfAlle='';
echo fSeitenKopf('Urkundeneinstellungen setzen','','KUk');

$sMs2=''; $sUpFile='-'; $nPx0=$nPy0=$sVa0=$sAl0=$sSA0=$sSG0=$sSS0=''; $aPosO=array();

if(!defined('FRA_Urkunde')){ //automatisches Setup
 define('FRA_Urkunde','');
 define('FRA_UkDruck','{260.0|20.0|Berlin, {Testdatum}||Arial|14|}');
 define('FRA_UkDatei','Urkunde');
 define('FRA_UkErhalt','B');
 define('FRA_UkFehlUDat','');
 define('FRA_UkFehlTDat','');
 define('FRA_TxUkErhalt','Ihre #Urkunde erhalten Sie #hier.');
 define('FRA_TxUkDrucken','Urkunde drucken');

 $aKonf=array(); $h=opendir(FRAPFAD); while($sF=readdir($h)) if(substr($sF,0,8)=='fraWerte'&&substr($sF,8,1)!='0'&&strpos($sF,'.php')>0) $aKonf[]=(int)substr($sF,8); closedir($h); sort($aKonf); if($aKonf[0]==0) $aKonf[0]=''; $sErfo='';
 foreach($aKonf as $k=>$sKonf){
  $sWerte=str_replace("\r",'',trim(implode('',file(FRAPFAD.'fraWerte'.$sKonf.'.php')))); $bNeu=false;
  if($p=strpos($sWerte,"define('FRA_TlnPersonU'")) if($p=strpos($sWerte,"\n",$p)) {
   $sWerte=substr_replace($sWerte,"\n\n//Urkundeneinstellungen\ndefine('FRA_Urkunde','');\ndefine('FRA_UkDatei','Urkunde');\ndefine('FRA_UkDruck','{260.0|20.0|Bärlin, {Testdatum}||Arial|14|}');\ndefine('FRA_UkErhalt','B');\ndefine('FRA_UkFehlUDat','');\ndefine('FRA_UkFehlTDat','');\ndefine('FRA_TxUkErhalt','Ihre #Urkunde erhalten Sie #hier.');\ndefine('FRA_TxUkDrucken','Urkunde drucken');\n",$p,0); $bNeu=true;
  }
  if($bNeu){ //in fraWerte speichern
   if($f=fopen(FRAPFAD.'fraWerte'.$sKonf.'.php','w')){
    fwrite($f,rtrim(str_replace("\n\n\n","\n\n",str_replace("\r",'',$sWerte)))."\n"); fclose($f); $sErfo.=', '.($sKonf?$sKonf:'0');
   }else $sMeld.='<p class="admFehl">In die Datei fraWerte'.$sKonf.'.php durfte nicht geschrieben werden!</p>';
   if($sErfo) $sMeld='<p class="admErfo">Das Urkunden-Modul wurde in die Konfiguration '.substr($sErfo,2).' eingepflegt.</p>';
  }
 }//foreach
}
$sUpFile=(FRA_Urkunde?FRA_Urkunde:'-');
if(FRA_UkDruck) $aPosO=explode('}{',substr(substr(FRA_UkDruck,0,-1),1));
$fsUkErhalt=FRA_UkErhalt;
$fsUkDatei=FRA_UkDatei;
$fsUkFehlUDat=FRA_UkFehlUDat; $fsUkFehlTDat=FRA_UkFehlTDat;
$fsTxUkErhalt=FRA_TxUkErhalt;

if($_SERVER['REQUEST_METHOD']=='POST'){ //POST
 $sAktion=$_POST['Aktion'];
 $bAlleKonf=(isset($_POST['AlleKonf'])&&$_POST['AlleKonf']=='1'?true:false); $sErfo=''; $bNeu=false; $bUp=false;
 if($sAktion=='Position'){ $aPos=array();
  $fsUkErhalt=(isset($_POST['UkErhaltB'])?$_POST['UkErhaltB']:'').(isset($_POST['UkErhaltA'])?$_POST['UkErhaltA']:'').(isset($_POST['UkErhaltZ'])?$_POST['UkErhaltZ']:'').(isset($_POST['UkErhaltM'])?$_POST['UkErhaltM']:'').(isset($_POST['UkErhaltX'])?$_POST['UkErhaltX']:''); if($fsUkErhalt!=FRA_UkErhalt) $bNeu=true;
  $fsUkDatei=str_replace(' ','_',str_replace('ä','ae',str_replace('ö','oe',str_replace('ü','ue',str_replace('ß','ss',str_replace('Ä','Ae',str_replace('Ö','Oe',str_replace('Ü','Ue',str_replace(':','',str_replace('.','',trim($_POST['UkDatei'])))))))))));
  $fsUkDatei=str_replace('Ã„','Ae',str_replace('Ã¤','ae',str_replace('Ã–','Oe',str_replace('Ã¶','oe',str_replace('Ãœ','Ue',str_replace('Ã¼','ue',str_replace('ÃŸ','ss',$fsUkDatei))))))); if($fsUkDatei!=FRA_UkDatei) $bNeu=true;
  $fsUkFehlUDat=trim($_POST['UkFehlUDat']); if($fsUkFehlUDat!=FRA_UkFehlUDat) $bNeu=true;
  $fsUkFehlTDat=trim($_POST['UkFehlTDat']); if($fsUkFehlTDat!=FRA_UkFehlTDat) $bNeu=true;
  $fsTxUkErhalt=trim($_POST['TxUkErhalt']); if($fsTxUkErhalt!=FRA_TxUkErhalt) $bNeu=true;
  for($i=1;$i<=count($aPosO)+1;$i++){
   $nPx=fGetPos('Px'.$i); $nPy=fGet0Pos('Py'.$i); $sVa=txtVar('Va'.$i); $sAl=strtoupper(substr(txtVar('Al'.$i),0,1)); $sSA=txtVar('SA'.$i); $sSG=(int)txtVar('SG'.$i); $sSS=strtoupper(txtVar('SS'.$i));
   if($sAl!='C'&&$sAl!='R'&&$sAl!='L') $sAl=''; if($sSS!='B'&&$sSS!='I'&&$sSS!='U'&&$sSS!='BI'&&$sSS!='BU'&&$sSS!='BIU') $sSS='';
   if($nPx>0.0&&$nPy>0.0&&$sVa&&$sSA&&$sSG>0){
    $aPos[]=$nPy.'|'.$nPx.'|'.$sVa.'|'.$sAl.'|'.$sSA.'|'.$sSG.'|'.$sSS;
  }}
  $nPx0=fGetPos('Px0'); $nPy0=fGet0Pos('Py0'); $sVa0=trim($_POST['Va0']); $sAl0=strtoupper(substr(trim($_POST['Al0']),0,1)); $sSA0=$_POST['SA0']; $sSG0=(int)$_POST['SG0']; $sSS0=strtoupper(trim($_POST['SS0']));
  if($sAl0!='C'&&$sAl0!='R'&&$sAl0!='L') $sAl0=''; if($sSS0!='B'&&$sSS0!='I'&&$sSS0!='U'&&$sSS0!='BI'&&$sSS0!='BU'&&$sSS0!='BIU') $sSS0='';
  if($nPx0>0.0&&$nPy0>0.0&&$sVa0&&$sSA0&&$sSG0>0){
   $aPos[]=$nPy0.'|'.$nPx0.'|'.$sVa0.'|'.$sAl0.'|'.$sSA0.'|'.$sSG0.'|'.$sSS0;
  }
  sort($aPos); for($i=count($aPos)-1;$i>=0;$i--) if(substr($aPos[$i],0,1)=='0') $aPos[$i]=substr($aPos[$i],1);

  if($aPos!=$aPosO||$bNeu){
   $aPosO=$aPos; $nPx0=$nPy0=$sVa0=$sAl0=$sSA0=$sSG0=$sSS0='';
   foreach($aKonf as $k=>$sKonf) if($bAlleKonf||(int)$sKonf==KONF){
    $sWerte=str_replace("\r",'',trim(implode('',file(FRA_Pfad.'fraWerte'.$sKonf.'.php')))); $bNeu=false;
    if(fSetzFraWert($fsUkErhalt,'UkErhalt',"'")) $bNeu=true;
    if(fSetzFraWert($fsUkDatei,'UkDatei',"'")) $bNeu=true;
    if(fSetzFraWert($fsTxUkErhalt,'TxUkErhalt',"'")) $bNeu=true;
    if(fSetzFraWert($fsUkFehlUDat,'UkFehlUDat',"'")) $bNeu=true;
    if(fSetzFraWert($fsUkFehlTDat,'UkFehlTDat',"'")) $bNeu=true;
    if(fSetzFraWert('{'.trim(implode('}{',$aPos)).'}','UkDruck',"'")) $bNeu=true;
    if($bNeu){ //Speichern
     if(isset($_POST['KonfAlle'])&&$_POST['KonfAlle']=='1'||!$bAlleKonf){
      if($f=fopen(FRA_Pfad.'fraWerte'.$sKonf.'.php','w')){
       fwrite($f,rtrim(str_replace("\n\n\n","\n\n",str_replace("\r",'',$sWerte))).NL); fclose($f); $sErfo.=', '.($sKonf?$sKonf:'0');
      }else $sMeld.='<p class="admFehl">In die Datei <i>fraWerte'.$sKonf.'.php</i> konnte nicht geschrieben werden!</p>';
     }else{$sMeld='<p class="admFehl">Wollen Sie die Änderung wirklich für <i>alle</i> Konfigurationen vornehmen?</p>'; $sKonfAlle='1';}
    }
   }//while
  }
 }elseif($sAktion=='Upload'){
  $sUpNa='bilder/Urkunde'.($bAlleKonf?'':((int)KONF>0?KONF:'')).'.pdf';
  $sUpFile=strtolower(fFraDateiname(basename($_FILES['UpFile']['name']))); $sUpE=strrchr($sUpFile,'.');
  if($sUpE=='.pdf'){
   if(copy($_FILES['UpFile']['tmp_name'],FRA_Pfad.$sUpNa)){
    $sUpFile=$sUpNa; $bUp=true;
   }else $sMs2='<p class="admFehl">'.str_replace('#',$sUpNa,FRA_TxDateiRechte).'</p>';
  }elseif(substr($sUpE,0,1)=='.') $sMs2='<p class="admFehl">Vorlagen mit der Endung <i>'.$sUpE.'</i> sind nicht erlaubt!</p>';

  if($bUp||(isset($_POST['UpLoaded'])&&$_POST['UpLoaded'])) foreach($aKonf as $k=>$sKonf) if($bAlleKonf||(int)$sKonf==KONF){
   $sWerte=str_replace("\r",'',trim(implode('',file(FRA_Pfad.'fraWerte'.$sKonf.'.php')))); $bNeu=false;
   if(fSetzFraWert($sUpNa,'Urkunde',"'")){$bNeu=true; $sUpFile=$sUpNa;}
   if($bNeu){ //Speichern
    if(isset($_POST['KonfAlle'])&&$_POST['KonfAlle']=='1'||!$bAlleKonf){
     if($f=fopen(FRA_Pfad.'fraWerte'.$sKonf.'.php','w')){
      fwrite($f,rtrim(str_replace("\n\n\n","\n\n",str_replace("\r",'',$sWerte))).NL); fclose($f); $sErfo.=', '.($sKonf?$sKonf:'0');
     }else $sMeld.='<p class="admFehl">In die Datei <i>fraWerte'.$sKonf.'.php</i> konnte nicht geschrieben werden!</p>';
    }else{$sMeld='<p class="admFehl">Wollen Sie die Änderung wirklich für <i>alle</i> Konfigurationen vornehmen?</p>'; $sKonfAlle='1';}
   }
  }//while
 }
 if($sErfo) $sMeld.='<p class="admErfo">Die Urkundeneinstellungen wurden'.($sErfo!=', 0'?' in Konfiguration'.substr($sErfo,1):'').' gespeichert.</p>';
 elseif($bUp&&!$sMs2) $sMeld.='<p class="admErfo">Sie Layoutvorlage <i>'.$sUpNa.'</i> wurde hochgeladen.</p>';
 elseif(!$bNeu) $sMeld.='<p class="admMeld">Die Urkundeneinstellungen bleiben unverändert.</p>';
}else{ //GET
 // automatisches Setup durchfuehren - ist oben schon passiert
}

//Seitenausgabe
if(!$sMeld) $sMeld='<p class="admMeld">Kontrollieren und ändern Sie die Einstellungen zur Teilnahme-Urkunde.</p>';
echo $sMeld.$sMs2.NL;

$sOptSA='<option value="">--bitte wählen--</option><option value="Arial">Arial</option><option value="Times">Times</option><option value="Courier">Courier</option>'; $sL=''; $n=0;
foreach($aPosO as $s){$a=explode('|',$s);
 $sL.='
  <tr class="admTabl">
   <td style="text-align:center"><input type="text" name="Py'.++$n.'" value="'.fPos($a[0]).'" style="width:3em" /></td>
   <td style="text-align:center"><input type="text" name="Px'.$n.'" value="'.fPos($a[1]).'" style="width:3em" /></td>
   <td><input type="text" name="Va'.$n.'" value="'.$a[2].'" style="width:98%" /></td>
   <td style="text-align:center"><input type="text" name="Al'.$n.'" value="'.$a[3].'" style="width:2em" /></td>
   <td><select name="SA'.$n.'">'.str_replace('value="'.$a[4].'"','value="'.$a[4].'" selected="selected"',$sOptSA).'</select></td>
   <td style="text-align:center"><input type="text" name="SG'.$n.'" value="'.$a[5].'" style="width:2em" /></td>
   <td style="text-align:center"><input type="text" name="SS'.$n.'" value="'.$a[6].'" style="width:2em" /></td>
  </tr>';
}
$sP='<div>'; $i=0;
$a=explode(';',FRA_NutzerFelder);     foreach($a as $s) if(++$i>5) $sP.='{B:'.$s.'} '; $sP.='</div><div style="margin-top:3px;">';
$a=explode(';',FRA_TeilnehmerFelder); foreach($a as $s) $sP.='{T:'.$s.'} '; $sP.='</div>';

?>

<table class="admTabl" border="0" cellpadding="2" cellspacing="1">
<tr class="admTabl"><td colspan="2" class="admSpa2">Mit dem Zusatzmodul <i>Urkundenerstellung</i> kann nach dem Test eine gestaltete Teilnehmeurkunde im PDF-Format für den Benutzer bzw. Teilnehmer per E-Mail oder auf dem Bildschirm erzeugt werden.</td></tr>
</table><br />

<form name="fraForm" action="konfUrkunde.php<?php if(KONF>0)echo'?konf='.KONF?>" enctype="multipart/form-data" method="post">
<input type="hidden" name="Aktion" value="Upload" />
<input type="hidden" name="UpLoaded" value="<?php echo ($bUp?'1':'')?>" />
<table class="admTabl" border="0" cellpadding="2" cellspacing="1">
<tr class="admTabl"><td colspan="2" class="admSpa2">Dazu ist eine einseitige PDF-Vorlage als Layoutvorlage hier hochzuladen. Die PDF-Vorlage sollte Lücken bzw. freie Stellen enthalten, in die dann bei der Urkundenerstellung die Teilnehmerdaten eingesetzt werden.</td></tr>
<tr class="admTabl">
 <td class="admSpa1">PDF-Layoutvorlage<?php if($sUpFile>'-'){?><div style="margin-top:4px;text-align:center"><a href="<?php echo $sHttp.FRA_Urkunde ?>" target="_uk" onclick="pdfWin(this.href)"><img src="iconVorschau.gif" width="13" height="13" border="0" title="Vorschau PDF-Vorlage"></a></div><?php }?></td>
 <td><input type="file" name="UpFile" value="" style="width:98%" />
 <div class="admMini" style="margin-top:2px">hochgeladen: <?php echo $sUpFile ?></div></td>
</tr>
</table>
<?php if(MULTIKONF){?>
<p class="admSubmit"><input type="radio" name="AlleKonf" value="0<?php if(!$bAlleKonf)echo'" checked="checked';?>"> nur für diese Konfiguration<?php if(KONF>0) echo '-'.KONF;?> &nbsp; <input type="radio" name="AlleKonf" value="1<?php if($bAlleKonf)echo'" checked="checked';?>"> für alle Konfigurationen<input type="hidden" name="KonfAlle" value="<?php echo $sKonfAlle;?>" /></p>
<?php }?>
<p class="admSubmit"><input class="admSubmit" type="submit" value="Eintragen"></p>
</form><br>

<form name="fraForm" action="konfUrkunde.php<?php if(KONF>0)echo'?konf='.KONF?>" method="post">
<input type="hidden" name="Aktion" value="Position" />
<table class="admTabl" border="0" cellpadding="2" cellspacing="1">
<tr class="admTabl"><td colspan="2" class="admSpa2">Für die Urkundenerstellung sollen die folgenden Vereinbarungen gelten:</td></tr>
<tr class="admTabl">
 <td class="admSpa1">Ausgabe<br />der PDF-Datei</td>
 <td><input type="checkbox" name="UkErhaltB" value="B<?php if(strstr($fsUkErhalt,'B')) echo'" checked="checked'?>"> auf der Bewertungsseite &nbsp; &nbsp;
  <input type="checkbox" name="UkErhaltA" value="A<?php if(strstr($fsUkErhalt,'A')) echo'" checked="checked'?>">auf der Abschlusseite &nbsp; &nbsp;
  <input type="checkbox" name="UkErhaltZ" value="Z<?php if(strstr($fsUkErhalt,'Z')) echo'" checked="checked'?>">im Benutzerzentrum &nbsp; &nbsp;
  <input type="checkbox" name="UkErhaltM" value="M<?php if(strstr($fsUkErhalt,'M')) echo'" checked="checked'?>">per E-Mail<br>
  <input type="checkbox" name="UkErhaltX" value="X<?php if(strstr($fsUkErhalt,'X')) echo'" checked="checked'?>">in der Ergebnisliste im Administratorbereich</td>
</tr>
<tr class="admTabl">
 <td class="admSpa1">Bildschirmmeldung<br>Bewertungsseite<br>oder Abschlusseite</td>
 <td><input type="text" name="TxUkErhalt" value="<?php echo $fsTxUkErhalt?>" style="width:96%" /><div class="admMini" style="margin-top:3px">Muster: Ihre #Urkunde erhalten Sie #hier.<br />Hinweis: Platzhalter # vor einem Wort erzeugt einen Link zur PDF-Datei.</div></td>
</tr>
<tr class="admTabl">
 <td class="admSpa1">Name der erzeugten<br />PDF-Datei</td>
 <td><input type="text" name="UkDatei" value="<?php echo $fsUkDatei?>" style="width:8.2em" /><span class="admMini">.pdf &nbsp; &nbsp; (Dateiname ohne die Dateiendung .pdf)</span></td>
</tr>

<tr class="admTabl">
 <td class="admSpa1">Druckpositionen</td>
 <td><table class="admTabl" border="0" cellpadding="2" cellspacing="1">
  <tr class="admTabl">
   <td style="text-align:center;width:4em">y-Pos</td>
   <td style="text-align:center;width:4em">x-Pos</td>
   <td>Druckinhalt Platzhalter</td>
   <td style="text-align:center;width:5em">Ausrichtung</td>
   <td style="width:11em">Schriftart</td>
   <td style="text-align:center;width:5em">Schriftgröße</td>
   <td style="text-align:center;width:5em">Schriftstil</td>
  </tr><?php echo $sL?>
  <tr class="admTabl">
   <td style="text-align:center"><input type="text" name="Py0" value="<?php echo fPos($nPy0)?>" style="width:3em" /></td>
   <td style="text-align:center"><input type="text" name="Px0" value="<?php echo fPos($nPx0)?>" style="width:3em" /></td>
   <td><input type="text" name="Va0" value="<?php echo $sVa0?>" style="width:98%" /></td>
   <td style="text-align:center"><input type="text" name="Al0" value="<?php echo $sAl0?>" style="width:2em" /></td>
   <td><select name="SA0"><?php echo str_replace('value="'.$sSA0.'"','value="'.$sSA0.'" selected="selected"',$sOptSA)?></select></td>
   <td style="text-align:center"><input type="text" name="SG0" value="<?php echo $sSG0?>" style="width:2em" /></td>
   <td style="text-align:center"><input type="text" name="SS0" value="<?php echo $sSS0?>" style="width:2em" /></td>
  </tr>
 </table>
 </td>
</tr>
<tr class="admTabl">
 <td class="admSpa1">Erklärung<br />zu Druckpositionen</td>
 <td>
  - x-Position und y-Position in Millimetern von der linken oberen Blattecke gemessen<br>
  - mögliche Ausrichtungen: <b>C</b> für mittig oder <b>R</b> für rechts oder leer lassen bzw. <b>L</b> für links<br>
  - mögliche Schriftstile: <b>B</b> für fett oder <b>I</b> für kursiv oder <b>U</b> für unterstrichen oder <b>BI</b>, <b>BU</b>, <b>BIU</b> oder leer lassen
 </td>
</tr>
<tr class="admTabl">
 <td class="admSpa1">mögliche Platzhalter</td>
 <td><?php echo $sP?><div style="margin-top:3px">
  {Testfolgenname} {Antwortzeit} {Fragenanzahl} {Versuche} {Auslassungen}<br />
  {Richtige} {Falsche} {Punkte} {PunkteMoeglich} {ProzentPunkte} {ProzentRichtig} {Verbalwertung}<br />
  {Testdatum} {Testzeit} {Druckdatum} {Druckzeit}</div>
  <div class="admMini" style="margin-top:4px"><u>Erklärung</u>: B: steht für <i>Benutzer</i>, &nbsp; T: steht für <i>Teilnehmer</i></div>
  <div class="admMini"><u>Hinweis</u>: Damit die Platzhalter funktionieren müssen sie unter <a href="konfBewertung.php<?php if(KONF>0)echo'?konf='.KONF?>">Bewertungsreglen</a> in der <i>Ergebnisliste Administrator</i> aktiviert sein.</i></div>
  <div class="admMini"><u>Hinweis</u>: Alle Druckinhalte werden <i>einzeilig</i> gedruckt mit maximal <i>120 mm</i> Druckbreite.</div>
 </td>
</tr>
<tr class="admTabl">
 <td class="admSpa1">fehlende Daten</td>
 <td>
  <div><span style="width:30.4em;display:inline-block">fehlende Benutzer- oder Teilnehmerdaten ersetzen durch:   </span> <input type="text" name="UkFehlUDat" value="<?php echo $fsUkFehlUDat?>" style="width:3em" /> <span class="admMini">Empfehlung: leer lassen oder -- oder ??</span></div>
  <div><span style="width:30.4em;display:inline-block">fehlende Testergebnisdaten in Platzhaltern ersetzen durch:</span> <input type="text" name="UkFehlTDat" value="<?php echo $fsUkFehlTDat?>" style="width:3em" /> <span class="admMini">Empfehlung: leer lassen oder -- oder ??</span></div>
 </td>
</tr>
</table>
<?php if(MULTIKONF){?>
<p class="admSubmit"><input type="radio" name="AlleKonf" value="0<?php if(!$bAlleKonf)echo'" checked="checked';?>"> nur für diese Konfiguration<?php if(KONF>0) echo '-'.KONF;?> &nbsp; <input type="radio" name="AlleKonf" value="1<?php if($bAlleKonf)echo'" checked="checked';?>"> für alle Konfigurationen<input type="hidden" name="KonfAlle" value="<?php echo $sKonfAlle;?>" /></p>
<?php }?>
<p class="admSubmit"><input class="admSubmit" type="submit" value="Eintragen"></p>
</form>

<script language="JavaScript" type="text/javascript">
 function pdfWin(href){vWin=window.open(href,"_uk","width=600,height=830,left=10,top=5,menubar=yes,statusbar=no,toolbar=no,scrollbars=yes,resizable=yes");vWin.focus(); return true;}
</script>

<?php
echo fSeitenFuss();

function fGet0Pos($v){
 if($s=(isset($_POST[$v])?trim(str_replace(',','.',$_POST[$v])):'')) $s=sprintf('%05.1f',min($s,268.5)); return $s;
}
function fGetPos($v){
 if($s=(isset($_POST[$v])?trim(str_replace(',','.',$_POST[$v])):'')) $s=sprintf('%0.1f',$s); return $s;
}
function fPos($n){
 if($n>0.0) return str_replace('.',',',$n); else return '';
}
function fFraDateiname($s){
 $s=str_replace('Ä','Ae',str_replace('Ö','Oe',str_replace('Ü','Ue',str_replace('ß','ss',$s))));
 return str_replace('ä','ae',str_replace('ö','oe',str_replace('ü','ue',str_replace(' ','_',$s))));
}
?>