<?php
include 'hilfsFunktionen.php';
echo fSeitenKopf('Fragenliste','
<script language="JavaScript" type="text/javascript">
 function SelAll(bStat,sName){
  for(var i=0;i<self.document.flist.length;++i)
   if(self.document.flist.elements[i].type=="checkbox"&&self.document.flist.elements[i].name.substring(0,3)==(sName)) self.document.flist.elements[i].checked=bStat;
 }
</script>
<link rel="stylesheet" type="text/css" href="http'.(!isset($_SERVER['SERVER_PORT'])||$_SERVER['SERVER_PORT']!='443'?'':'s').'://'.FRA_Www.'fraStyle.css">','FFl');

$DDl=''; $bCh=false; $nDel=''; //Listenaktionen
if($_SERVER['REQUEST_METHOD']=='POST'){
 foreach($_POST as $k=>$xx) if(substr($k,0,3)=='del'&&strpos($k,'x')>0) $nDel=(int)substr($k,3); reset($_POST);
 if($nDel>0){ //loeschen
  if($nDel==(isset($_POST['ddl'])?$_POST['ddl']:'')){
   if(!FRA_SQL){ //Textdaten
    $aD=file(FRA_Pfad.FRA_Daten.FRA_Fragen); $nCnt=count($aD); $sDel=$nDel.';'; $l=strlen($sDel);
    for($i=1;$i<$nCnt;$i++) if(substr($aD[$i],0,$l)==$sDel){
     $aR=explode(';',$aD[$i],9); $aD[$i]=''; $sBld=$aR[7]; $s=rtrim(str_replace("\r",'',implode('',$aD)));
     if($f=fopen(FRA_Pfad.FRA_Daten.FRA_Fragen,'w')){ //speichern
      fwrite($f,$s.NL); fclose($f); $sMeld='<p class="admErfo">Die bisherige Frage '.$nDel.' wurde gel�scht!</p>';
      if($sBld) if(strpos($s,';'.$sBld.';')==false) @unlink(FRA_Pfad.FRA_Bilder.$sBld);
     }else $sMeld='<p class="admFehl">'.str_replace('#',FRA_Daten.FRA_Fragen,FRA_TxDateiRechte).'</p>';
     break;
    }
   }elseif($DbO){ //beiSQL
    if($rR=$DbO->query('SELECT Nummer,Bild FROM '.FRA_SqlTabF.' WHERE Nummer='.$nDel)){
     $aR=$rR->fetch_row(); $rR->close(); $sBld=$aR[1];
     if($DbO->query('DELETE FROM '.FRA_SqlTabF.' WHERE Nummer='.$nDel)&&$DbO->affected_rows>0){
      $sMeld='<p class="admErfo">Die bisherige Frage '.$nDel.' wurde gel�scht!</p>';
      if($sBld) if($rR=$DbO->query('SELECT Nummer,Bild FROM '.FRA_SqlTabF.' WHERE Bild="'.$sBld.'"')){
       if($rR->num_rows==0) @unlink(FRA_Pfad.FRA_Bilder.$sBld); $rR->close();
      }
     }else $sMeld='<p class="admFehl">'.FRA_TxSqlAendr.'</p>';
    }else $sMeld='<p class="admFehl">'.FRA_TxSqlFrage.'</p>';
   }
  }else{$DDl=$nDel; $sMeld='<p class="admFehl">Die Frage Nummer '.$nDel.' wirklich l�schen?</p>';}
 }else{ //aktiv/verst
  if(!FRA_SQL){ //Textdaten
   $aD=file(FRA_Pfad.FRA_Daten.FRA_Fragen); $nCnt=count($aD);
   $aD[0]='Nummer;aktiv;versteckt;Kategorie;Frage;Loesung;Punkte;Bild;Antwort1;Antwort2;Antwort3;Antwort4;Antwort5;Antwort6;Antwort7;Antwort8;Antwort9;Anmerkung;Anmerkung2'.NL;
   for($i=1;$i<$nCnt;$i++){
    $sLn=rtrim($aD[$i]); $p=strpos($sLn,';'); $k=(int)substr($sLn,0,$p);
    if(isset($_POST['num'.$k])&&$_POST['num'.$k]){
     $v=sprintf('%0d;%0d',(isset($_POST['akt'.$k])?$_POST['akt'.$k]:0),(isset($_POST['vrs'.$k])?$_POST['vrs'.$k]:0));
     if(substr($sLn,++$p,3)!=$v){$sLn=$k.';'.$v.substr($sLn,$p+3); $aD[$i]=$sLn.NL; $bCh=true;}
    }//elseif($bCh) break;
   }
   if($bCh){
    if($f=fopen(FRA_Pfad.FRA_Daten.FRA_Fragen,'w')){//speichern
     fwrite($f,rtrim(str_replace("\r",'',implode('',$aD))).NL); fclose($f);
     $sMeld='<p class="admErfo">Die Frage wurden aktiviert/deaktiviert bzw. versteckt!</p>';
    }else $sMeld='<p class="admFehl">'.str_replace('#',FRA_Daten.FRA_Fragen,FRA_TxDateiRechte).'</p>';
   }else $sMeld='<p class="admMeld">Die Fragen bleiben unver�ndert.</p>';
  }elseif($DbO){ //beiSQL
   if($rR=$DbO->query('SELECT Nummer,aktiv,versteckt FROM '.FRA_SqlTabF.' ORDER BY Nummer')){
    $aD=array(); while($aR=$rR->fetch_row()) $aD[$aR[0]]=$aR[1].';'.$aR[2]; $rR->close(); $bCh=false;
    foreach($aD as $k=>$s) if(isset($_POST['num'.$k])&&$_POST['num'.$k]){
     $v=sprintf('%0d;%0d',(isset($_POST['akt'.$k])?$_POST['akt'.$k]:0),(isset($_POST['vrs'.$k])?$_POST['vrs'.$k]:0));
     if($v!=$s) if($DbO->query('UPDATE IGNORE '.FRA_SqlTabF.' SET aktiv="'.substr($v,0,1).'", versteckt="'.substr($v,2,1).'" WHERE Nummer='.$k)) $bCh=true;
    }elseif($bCh) break;
    if($bCh) $sMeld='<p class="admErfo">Die Frage wurden aktiviert/deaktiviert bzw. versteckt!</p>';
    else $sMeld='<p class="admMeld">Die Fragen bleiben unver�ndert.</p>';
   }else $sMeld='<p class="admFehl">'.FRA_TxSqlFrage.'</p>';
  }
 }
}//POST

$aQ=array(); $sQ=''; //Suchparameter
if($FNr=(isset($_POST['fnr'])?$_POST['fnr']:'').(isset($_GET['fnr'])?$_GET['fnr']:'')){$a1Filt[0]=$FNr; $sQ.='&amp;fnr='.$FNr; $aQ['fnr1']=$FNr;}
$Onl=(isset($_POST['onl'])?$_POST['onl']:'').(isset($_GET['onl'])?$_GET['onl']:'').(isset($_POST['onl1'])?$_POST['onl1']:'').(isset($_GET['onl1'])?$_GET['onl1']:'').(isset($_POST['onl2'])?$_POST['onl2']:'').(isset($_GET['onl2'])?$_GET['onl2']:'');
$Vst=(isset($_POST['vst'])?$_POST['vst']:'').(isset($_GET['vst'])?$_GET['vst']:'').(isset($_POST['vst1'])?$_POST['vst1']:'').(isset($_GET['vst1'])?$_GET['vst1']:'').(isset($_POST['vst2'])?$_POST['vst2']:'').(isset($_GET['vst2'])?$_GET['vst2']:'');
if(strlen($Onl)!=1) $Onl=''; else {$a1Filt[1]=$Onl; $sQ.='&amp;onl='.$Onl; $aQ['onl1']=$Onl;}
if(strlen($Vst)!=1) $Vst=''; else {$a1Filt[2]=$Vst; $sQ.='&amp;vst='.$Vst; $aQ['vst1']=$Vst;}
$s=(isset($_POST['kat1'])?$_POST['kat1']:'').(isset($_GET['kat1'])?$_GET['kat1']:''); if(strlen($s)){$a1Filt[3]=$s; $sQ.='&amp;kat1='.rawurlencode($s); $aQ['kat1']=$s;}
$s=(isset($_POST['kat2'])?$_POST['kat2']:'').(isset($_GET['kat2'])?$_GET['kat2']:''); if(strlen($s)){$a2Filt[3]=$s; $sQ.='&amp;kat2='.rawurlencode($s); $aQ['kat2']=$s;}
$s=(isset($_POST['kat3'])?$_POST['kat3']:'').(isset($_GET['kat3'])?$_GET['kat3']:''); if(strlen($s)){$a3Filt[3]=$s; $sQ.='&amp;kat3='.rawurlencode($s); $aQ['kat3']=$s;}
$s=(isset($_POST['frg1'])?$_POST['frg1']:'').(isset($_GET['frg1'])?$_GET['frg1']:''); if(strlen($s)){$a1Filt[4]=$s; $sQ.='&amp;frg1='.rawurlencode($s); $aQ['frg1']=$s;}
$s=(isset($_POST['frg2'])?$_POST['frg2']:'').(isset($_GET['frg2'])?$_GET['frg2']:''); if(strlen($s)){$a2Filt[4]=$s; $sQ.='&amp;frg2='.rawurlencode($s); $aQ['frg2']=$s;}
$s=(isset($_POST['frg3'])?$_POST['frg3']:'').(isset($_GET['frg3'])?$_GET['frg3']:''); if(strlen($s)){$a3Filt[4]=$s; $sQ.='&amp;frg3='.rawurlencode($s); $aQ['frg3']=$s;}
$s=(isset($_POST['bem1'])?$_POST['bem1']:'').(isset($_GET['bem1'])?$_GET['bem1']:''); if(strlen($s)){$a1Filt[17]=$s;$sQ.='&amp;bem1='.rawurlencode($s); $aQ['bem1']=$s;}
$s=(isset($_POST['bem2'])?$_POST['bem2']:'').(isset($_GET['bem2'])?$_GET['bem2']:''); if(strlen($s)){$a2Filt[17]=$s;$sQ.='&amp;bem2='.rawurlencode($s); $aQ['bem2']=$s;}
$s=(isset($_POST['bem3'])?$_POST['bem3']:'').(isset($_GET['bem3'])?$_GET['bem3']:''); if(strlen($s)){$a3Filt[17]=$s;$sQ.='&amp;bem3='.rawurlencode($s); $aQ['bem3']=$s;}
$s=(isset($_POST['b2m1'])?$_POST['b2m1']:'').(isset($_GET['b2m1'])?$_GET['b2m1']:''); if(strlen($s)){$a1Filt[18]=$s;$sQ.='&amp;b2m1='.rawurlencode($s); $aQ['b2m1']=$s;}
$s=(isset($_POST['b2m2'])?$_POST['b2m2']:'').(isset($_GET['b2m2'])?$_GET['b2m2']:''); if(strlen($s)){$a2Filt[18]=$s;$sQ.='&amp;b2m2='.rawurlencode($s); $aQ['b2m2']=$s;}
$s=(isset($_POST['b2m3'])?$_POST['b2m3']:'').(isset($_GET['b2m3'])?$_GET['b2m3']:''); if(strlen($s)){$a3Filt[18]=$s;$sQ.='&amp;b2m3='.rawurlencode($s); $aQ['b2m3']=$s;}

$aD=array(); $aTmp=array(); $aIdx=array(); //Daten holen
if(!FRA_SQL){ //Textdaten
 if($aD=@file(FRA_Pfad.FRA_Daten.FRA_Fragen)) $nCnt=count($aD); else $nCnt=0;
 for($i=1;$i<$nCnt;$i++){ //ueber alle Datensaetze
  $a=explode(';',rtrim($aD[$i])); $sNr=(int)$a[0]; $b=true;
  if(isset($a1Filt)&&is_array($a1Filt)){reset($a1Filt); //Suchfiltern 1,2
   foreach($a1Filt as $j=>$v) if($b&&$j>2){
    if($w=(isset($a2Filt[$j])?$a2Filt[$j]:'')){if(stristr((isset($a[$j])?str_replace('`,',';',$a[$j]):''),$w)) $b2=true; else $b2=false;} else $b2=false;
    if(!(stristr((isset($a[$j])?str_replace('`,',';',$a[$j]):''),$v)||$b2)) $b=false;
   }else if($a[$j]!=$v) $b=false;
  }
  if($b&&isset($a3Filt)&&is_array($a3Filt)){ //Suchfiltern 3
   reset($a3Filt); foreach($a3Filt as $j=>$v) if(stristr((isset($a[$j])?str_replace('`,',';',$a[$j]):''),$v)){$b=false; break;}
  }
  if($b){ //Datensatz g�ltig
   $aTmp[$sNr]=array($sNr); $aTmp[$sNr][1]=$a[1]; $aTmp[$sNr][2]=$a[2]; $aTmp[$sNr][3]=str_replace('`,',';',$a[3]); //Nr,akt,vst,Kat
   $aTmp[$sNr][4]=str_replace('\n ',NL,str_replace('`,',';',$a[4])); $aTmp[$sNr][5]=$a[6]; $aTmp[$sNr][6]=$a[7]; //Fra,Pkt,Bld
   if(!FRA_PunkteTeilen){$nTP=0; for($j=8;$j<17;$j++){$t=trim($a[$j]); $nTP+=(($p=strpos($t,'|#'))?(int)substr($t,$p+2):0);} $aTmp[$sNr][7]=$nTP;}
   $aIdx[$sNr]=sprintf('%0'.FRA_NummerStellen.'d',$i);
  }
 }$aD=array();

}elseif($DbO){ //SQL-Daten
 $s='';
 if(isset($a1Filt)&&is_array($a1Filt)) foreach($a1Filt as $j=>$v){ //Suchfiltern 1-2
  if($j>2){
   $sF=($j==4?'Frage':($j==3?'Kategorie':($j!=18?'Anmerkung':'Anmerkung2')));
   $s.=' AND('.$sF.' LIKE "%'.$v.'%"'; if($w=(isset($a2Filt[$j])?$a2Filt[$j]:'')) $s.=' OR '.$sF.' LIKE "%'.$w.'%"'; $s.=')';
  }else $s.=' AND '.($j==0?'Nummer':($j==1?'aktiv':'versteckt')).'="'.$v.'"';
 }
 if(isset($a3Filt)&&is_array($a3Filt)) foreach($a3Filt as $j=>$v){ //Suchfiltern 3
  $s.=' AND NOT('.($j==4?'Frage':($j==3?'Kategorie':($j!=18?'Anmerkung':'Anmerkung2'))).' LIKE "%'.$v.'%")';
 }
 if($rR=$DbO->query('SELECT Nummer,aktiv,versteckt,Kategorie,Frage,Punkte,Bild'.(FRA_PunkteTeilen?'':',Antwort1,Antwort2,Antwort3,Antwort4,Antwort5,Antwort6,Antwort7,Antwort8,Antwort9').' FROM '.FRA_SqlTabF.($s?' WHERE '.substr($s,4):'').' ORDER BY Nummer')){
  $i=0;
  while($a=$rR->fetch_row()){
   $sNr=(int)$a[0]; $aTmp[$sNr]=array($sNr); $aTmp[$sNr][1]=$a[1]; $aTmp[$sNr][2]=$a[2]; $aTmp[$sNr][3]=$a[3]; //Nr,akt,vst,Kat
   $aTmp[$sNr][4]=str_replace("\r",'',$a[4]); $aTmp[$sNr][5]=$a[5]; $aTmp[$sNr][6]=$a[6]; //Fra,Pkt,Bld
   if(!FRA_PunkteTeilen){$nTP=0; for($j=7;$j<16;$j++){$t=trim($a[$j]); $nTP+=(($p=strpos($t,'|#'))?(int)substr($t,$p+2):0);} $aTmp[$sNr][7]=$nTP;}
   $aIdx[$sNr]=sprintf('%0'.FRA_NummerStellen.'d',++$i);
  }$rR->close();
 }else $sMeld='<p class="admFehl">'.FRA_TxSqlFrage.'</p>';
}

if(!$nStart=(int)((isset($_GET['start'])?$_GET['start']:'').(isset($_POST['start'])?$_POST['start']:''))) $nStart=1; $nStop=$nStart+ADF_ListenLaenge;
if(ADF_Rueckwaerts) arsort($aIdx);
reset($aIdx); $k=0; foreach($aIdx as $i=>$xx) if(++$k<$nStop&&$k>=$nStart) $aD[]=$aTmp[$i];
if(!$sMeld){if(!$sQ) $sMeld='<p class="admMeld">Gesamt-Fragenliste</p>'; else $sMeld='<p class="admMeld">Abfrageergebnis</p>';}
$sQ=(KONF>0?'konf='.KONF.$sQ:substr($sQ,5));
?>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
 <tr>
  <td><?php echo $sMeld;?></td>
  <td align="right">[ <a href="suche.php<?php if($sQ) echo '?'.$sQ?>">Suche</a> ]</td>
 </tr>
</table>
<?php
 $sNavigator=fFraNavigator($nStart,count($aIdx),ADF_ListenLaenge,$sQ); echo $sNavigator;
 if($nStart>1) $sQ.=($sQ?'&amp;':'').'start='.$nStart; $aQ['start']=$nStart; $sAmp=($sQ?'&amp;':'');
 $bAendern=file_exists('aendern.php'); $bKopieren=file_exists('kopieren.php'); $bLoeschen=file_exists('loeschen.php');
?>

<form name="flist" action="liste.php<?php if(KONF>0)echo'?konf='.KONF?>" method="post">
<table class="admTabl" style="width:100%" border="0" cellpadding="2" cellspacing="1">
 <tr class="admTabl">
  <?php if($bLoeschen){?><td width="12">&nbsp;</td><?php }?>
  <td align="center" width="1%"><b>Nr</b></td>
  <?php if($bAendern){?><td width="12">&nbsp;</td><?php }?>
  <?php if($bKopieren){?><td width="12">&nbsp;</td><?php }?>
  <td width="13">&nbsp;</td>
  <td width="15" align="center" title="aktiviert"><b>A</b></td>
  <td align="center" width="15" title="versteckt"><b>V</b></td>
  <?php if(FRA_Kategorien>''){?><td><b>Kategorie</b></td><?php }?>
  <td><b>Frage</b></td>
  <td align="center" width="1%"><b>Punkte</b></td>
  <?php if(FRA_LayoutTyp>0){?><td><b>Bild</b></td><?php }?>
 </tr>
<?php
foreach($aD as $a){ //Datenzeilen ausgeben
 $sNr=$a[0];
 echo ' <tr class="admTabl">'.NL;
 if($bLoeschen) echo '  <td style="vertical-align:top;text-align:center"><input type="image" name="del'.$sNr.'" src="iconLoeschen.gif" width="12" height="13" border="0" title="Frage '.$sNr.' l�schen"><input type="hidden" name="num'.$sNr.'" value="*"/></td>'.NL;
 echo '  <td style="vertical-align:top;text-align:center" width="1%">'.sprintf('%'.FRA_NummerStellen.'d',$sNr).'</td>'.NL;
 if($bAendern) echo '  <td style="vertical-align:top;text-align:center"><a href="aendern.php?'.$sQ.$sAmp.'nr='.$sNr.'"><img src="iconAendern.gif" width="12" height="13" border="0" title="bearbeiten"></a></td>'.NL;
 if($bKopieren)echo '  <td style="vertical-align:top;text-align:center"><a href="kopieren.php?'.$sQ.$sAmp.'nr='.$sNr.'"><img src="iconKopie.gif" width="12" height="13" border="0" title="kopieren"></a></td>'.NL;
 echo '  <td style="vertical-align:top;text-align:center"><a href="vorschau.php?'.$sQ.$sAmp.'nr='.$sNr.'"><img src="iconVorschau.gif" width="13" height="13" border="0" title="Vorschau"></a></td>'.NL;
 echo '  <td style="vertical-align:top;text-align:center"><input class="admCheck" type="checkbox" name="akt'.$sNr.'" value="1"'.($a[1]?' checked="checked"':'').' title="'.($a[1]?'':'de').'aktiviert"></td>'.NL;
 echo '  <td style="vertical-align:top;text-align:center"><input class="admCheck" type="checkbox" name="vrs'.$sNr.'" value="1"'.($a[2]?' checked="checked"':'').' title="'.($a[2]?'':'nicht ').'versteckt"></td>'.NL;
 if(FRA_Kategorien>'') echo '  <td style="vertical-align:top">'.($a[3]?$a[3]:'').'</td>'.NL;
 echo '  <td>'.fFraBB($a[4]).'</td>'.NL.'  <td style="vertical-align:top;text-align:center">'.$a[5].(FRA_PunkteTeilen?'':'('.$a[7].')').'</td>'.NL;
 if(FRA_LayoutTyp>0) echo '  <td style="vertical-align:top;text-align:left">'.($a[6]?$a[6]:'&nbsp;').'</td>'.NL;
 echo ' </tr>'.NL;
}
?>
 <tr class="admTabl">
  <td colspan="<?php echo (($bLoeschen?1:0)+($bAendern&&$bKopieren?'4':($bAendern||$bKopieren?'3':'2')))?>" align="right">alle</td>
  <td align="center"><input class="admCheck" type="checkbox" name="allO" onclick="SelAll(this.checked,'akt')" title="alle aktivieren/deaktivieren"></td>
  <td align="center"><input class="admCheck" type="checkbox" name="allV" onclick="SelAll(this.checked,'vrs')" title="alle verstecken/hervorholen"></td>
  <td align="center" style="padding-right:110px" colspan="<?php echo 2+(FRA_LayoutTyp>0?1:0)+(FRA_Kategorien>''?1:0)?>"><input type="submit" class="admSubmit" style="width:16em" value="aktivieren/deaktivieren"></td>
 </tr>
</table>
<input type="hidden" name="ddl" value="<?php echo $DDl?>" /><?php foreach($aQ as $k=>$v) echo NL.'<input type="hidden" name="'.$k.'" value="'.$v.'" />'?>
</form>
<?php echo $sNavigator?>
<p style="text-align:center;">[ <a href="liste.php<?php if($sQ) echo '?'.$sQ?>">aktualisieren</a> ]</p>

<?php
echo fSeitenFuss();

function fFraNavigator($nStart,$nCount,$nListenLaenge,$sQry){
 $nPgs=ceil($nCount/$nListenLaenge); $nPag=ceil($nStart/$nListenLaenge); if($sQry) $sQry.='&amp;';
 $s ='<td style="width:16px;text-align:center;"><a href="liste.php?'.$sQry.'start=1" title="Anfang">|&lt;</a></td>';
 $nAnf=$nPag-4; if($nAnf<=0) $nAnf=1; $nEnd=$nAnf+9; if($nEnd>$nPgs){$nEnd=$nPgs; $nAnf=$nEnd-9; if($nAnf<=0) $nAnf=1;}
 for($i=$nAnf;$i<=$nEnd;$i++){
  if($i!=$nPag) $nPg=$i; else $nPg='<b>'.$i.'</b>';
  $s.=NL.'  <td style="width:18px;text-align:center;"><a href="liste.php?'.$sQry.'start='.(($i-1)*$nListenLaenge+1).'" title="Seite-'.$i.'">'.$nPg.'</a></td>';
 }
 $s.=NL.'  <td style="width:16px;text-align:center;"><a href="liste.php?'.$sQry.'start='.(max($nPgs-1,0)*$nListenLaenge+1).'" title="Ende">&gt;|</a></td>';
 $X =NL.'<table style="width:100%;margin-top:3px;margin-bottom:3px;" border="0" cellpadding="0" cellspacing="0">';
 $X.=NL.' <tr>';
 $X.=NL.'  <td>Seite '.$nPag.'/'.$nPgs.'</td>';
 $X.=NL.'  '.$s;
 $X.=NL.' </tr>'.NL.'</table>'.NL;
 return $X;
}

//BB-Code zu HTML wandeln
function fFraBB($s){
 $v=str_replace("\n",'<br />',str_replace("\n ",'<br />',str_replace("\r",'',$s))); $p=strpos($v,'[');
 while(!($p===false)){
  $Tg=substr($v,$p,9);
  if(substr($Tg,0,3)=='[b]') $v=substr_replace($v,'<b>',$p,3); elseif(substr($Tg,0,4)=='[/b]') $v=substr_replace($v,'</b>',$p,4);
  elseif(substr($Tg,0,3)=='[i]') $v=substr_replace($v,'<i>',$p,3); elseif(substr($Tg,0,4)=='[/i]') $v=substr_replace($v,'</i>',$p,4);
  elseif(substr($Tg,0,3)=='[u]') $v=substr_replace($v,'<u>',$p,3); elseif(substr($Tg,0,4)=='[/u]') $v=substr_replace($v,'</u>',$p,4);
  elseif(substr($Tg,0,7)=='[color='){$o=substr($v,$p+7,9); $o=substr($o,0,strpos($o,']')); $v=substr_replace($v,'<span style="color:'.$o.'">',$p,8+strlen($o));} elseif(substr($Tg,0,8)=='[/color]') $v=substr_replace($v,'</span>',$p,8);
  elseif(substr($Tg,0,6)=='[size='){$o=substr($v,$p+6,4); $o=substr($o,0,strpos($o,']')); $v=substr_replace($v,'<span style="font-size:'.(10+($o)).'0%">',$p,7+strlen($o));} elseif(substr($Tg,0,7)=='[/size]') $v=substr_replace($v,'</span>',$p,7);
  elseif(substr($Tg,0,8)=='[center]'){$v=substr_replace($v,'<p class="fraText" style="text-align:center">',$p,8); if(substr($v,$p-6,6)=='<br />') $v=substr_replace($v,'',$p-6,6);} elseif(substr($Tg,0,9)=='[/center]'){$v=substr_replace($v,'</p>',$p,9); if(substr($v,$p+4,6)=='<br />') $v=substr_replace($v,'',$p+4,6);}
  elseif(substr($Tg,0,7)=='[right]'){$v=substr_replace($v,'<p class="fraText" style="text-align:right">',$p,7); if(substr($v,$p-6,6)=='<br />') $v=substr_replace($v,'',$p-6,6);} elseif(substr($Tg,0,8)=='[/right]'){$v=substr_replace($v,'</p>',$p,8); if(substr($v,$p+4,6)=='<br />') $v=substr_replace($v,'',$p+4,6);}
  elseif(substr($Tg,0,5)=='[sup]') $v=substr_replace($v,'<sup>',$p,5); elseif(substr($Tg,0,6)=='[/sup]') $v=substr_replace($v,'</sup>',$p,6);
  elseif(substr($Tg,0,5)=='[sub]') $v=substr_replace($v,'<sub>',$p,5); elseif(substr($Tg,0,6)=='[/sub]') $v=substr_replace($v,'</sub>',$p,6);
  elseif(substr($Tg,0,5)=='[url]'){
   $o=$p+5; if(!$l=min(strpos($v,'[',$o),strpos($v,' ',$o))) $l=strpos($v,'[',$o);
   if(substr($v,$l,1)==' ') $v=substr_replace($v,'">',$l,1); else $v=substr_replace($v,'">'.substr($v,$o,$l-$o),$l,0);
   $v=substr_replace($v,'<a class="fraText" target="_blank" href="'.(substr($v,$o,4)!='http'?'http'.'://':''),$p,5);
  }elseif(substr($Tg,0,6)=='[/url]') $v=substr_replace($v,'</a>',$p,6);
  elseif(substr($Tg,0,5)=='[list'){
   if(substr($Tg,5,2)=='=o'){$q='o';$l=2;}else{$q='u';$l=0;}
   $v=substr_replace($v,'<'.$q.'l class="fraText"><li class="fraText">',$p,6+$l);
   $e=strpos($v,'[/list]',$p+5); $v=substr_replace($v,'</li></'.$q.'l>',$e,7+(substr($v,$e+7,6)=='<br />'?6:0));
   $l=strpos($v,'<br />',$p);
   while($l<$e&&$l>0){$v=substr_replace($v,'</li><li class="fraText">',$l,6); $e+=19; $l=strpos($v,'<br />',$l);}
  }
  $p=strpos($v,'[',$p+1);
 }return $v;
}
?>