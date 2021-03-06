<?php
#   Copyright by: Manuel
#   Support: www.ilch.de


defined ('main') or die ( 'no direct access' );
defined ('admin') or die ( 'only admin access' );


$design = new design ( 'Admins Area', 'Admins Area', 2 );
$design->header();

# script version
$scriptVersion = 11;
$scriptUpdate = 'P';

# statistik wird bereinigt.
$mon = date('n');
$lastmon = $mon - 1;
$jahr = date('Y');
$lastjahr = $jahr;
if ( $lastmon <= 0 ) { $lastmon = 12; $lastjahr = $jahr - 1; }

db_query("DELETE FROM prefix_stats WHERE NOT ((mon = $mon OR mon = $lastmon) AND (yar = $jahr OR yar = $lastjahr))");
db_query("OPTIMIZE TABLE prefix_stats");


    $um = $menu->get(1);
    switch($um)
    {

        default :
				{
           ?>
<span class="visible-xs-offcanvas"><br><br></span>
<div class="row">

  <div class="col-md-4">
<div class="panel panel-default">
  <div class="panel-body">
<legend><i class="fa fa-life-ring"></i> Hilfe Adminbereich</legend>   
<ul class="list-group">
  <li class="list-group-item list-group-item-success">
<h4>Willkommen im Adminbereich</h4>
In den nun folgenden Zeilen wird die Oberfl�che des Adminbereiches erl�utert.<br>
Oben rechts im DropDown Men� sind die jeweilgen Bereiche der Seite zu finden.<br>Rechts an der Seite befindet sich das Quickmen&uuml; f�r einen z&uuml;gigen Zugriff zu weiteren Ansichten. Dort sind, je nach dem gew�hlten Bereich, passende Links zu finden, &auml;hnlich dem DropDown Men�.<br>
Hier auf der Startseite gibt es einen Einblick zu einigen Informationen der Seite.
<div class="well well-sm">
Sollten Probleme mit dem Ilch CMS auftreten nutze den <a class="text-success" href="http://www.ilch.de/texts.html" target="_blank"><strong>FAQ Bereich</strong></a> auf Ilch.de, sowie die Suche im <a class="text-success" href="http://www.ilch.de/forum.html" target="_blank"><strong>Forum</strong></a> f&uuml;r evtl. schon bestehende Threads zu diesem Thema.
</div>
  </li>
</ul>
</div></div>
</div>
  <div class="col-md-4">
<div class="panel panel-default">
  <div class="panel-body">
<legend><i class="fa fa-info-circle"></i> Info�s zur Seite</legend>   
<ul class="list-group">
  <li class="list-group-item list-group-item-info">
<table width="100%"><tr>
    <td>Aktuelles Design</td>
<td class="text-right"><strong><?php echo $allgAr['gfx']; ?></strong></td>
</tr></table>
  </li>
</ul>
<ul class="list-group">
  <li class="list-group-item list-group-item-info">
<table width="100%"><tr>
    <td>Script Version</td>
<td class="text-right"><strong><?php echo 'Ilch '.$scriptVersion.' '.$scriptUpdate.''; ?></strong></td>
</tr></table>
  </li>
</ul>
<ul class="list-group">
  <li class="list-group-item list-group-item-info">
<table width="100%"><tr>
    <td>Gr&ouml;&szlig;e Datenbank</td>
<td class="text-right"><strong><?php
$result = db_query("SHOW TABLE STATUS");
    $dbsize = 0;
    while($row = mysql_fetch_assoc($result)) {
        $dbsize += $row['Data_length'];
    }echo nicebytes($dbsize);
?></strong></td>
</tr></table>
  </li>
</ul>
<ul class="list-group">
  <li class="list-group-item list-group-item-info">
<table width="100%"><tr>
    <td>Download Ordner</td>
<td class="text-right"><strong><?php echo nicebytes(dirsize('include/downs/')); ?> gro&szlig;</strong></td>
</tr>
<tr><td colspan="2" class="text-left"><a class="btn btn-default btn-xs" href="admin.php?archiv-downloads">Downloads Verwalten</a></td></tr>
</table>
  </li>
</ul>
<ul class="list-group">
  <li class="list-group-item list-group-item-info">
<table width="100%"><tr>
    <td>Status Seite</td>
<td class="text-right"><strong><?php
  if ($allgAr['wartung'] == 0){
     echo '<span class="label label-success">Seite Online</span>';
  }else
    echo '<span class="label label-warning">Wartungs Modus</span>';
?></strong></td>
</tr></table>
  </li>
</ul>
  </div>
</div>
</div>
  <div class="col-md-4">
<div class="panel panel-default">
  <div class="panel-body">
<legend><i class="fa fa-users"></i> User</legend>   
<ul class="list-group">
  <li class="list-group-item list-group-item-warning">
<table width="100%"><tr>
    <td>Benutzer Online</td>
<td class="text-right"><strong><?php echo ' '.ges_online().' ';?></strong></td>
</tr>
<tr><td colspan="2" class="text-left"><a class="btn btn-default btn-xs" href="admin.php?admin-userOnline">Online Liste anzeigen</a></td></tr>
</table>
  </li>
</ul>
<ul class="list-group">
  <li class="list-group-item list-group-item-warning">
<table width="100%"><tr>
    <td>G&auml;ste Online</td>
<td class="text-right"><strong><?php echo ' '.ges_gast_online().' ';?></strong></td>
</tr></table>
  </li>
</ul>
<ul class="list-group">
  <li class="list-group-item list-group-item-warning">
<table width="100%"><tr>
    <td>Offene Registry</td>
<td class="text-right"><strong><?php
  $gesuser  = @db_result(db_query("SELECT count(name) FROM prefix_usercheck WHERE ak = 1"),0);
  echo ' '.$gesuser.' ';
?></strong></td>
</tr>
<tr><td colspan="2" class="text-left"><a class="btn btn-default btn-xs" href="admin.php?puser">Liste anzeigen</a></td></tr>
</table>
  </li>
</ul>
<ul class="list-group">
  <li class="list-group-item list-group-item-warning">
<table width="100%"><tr>
    <td>Offene JoinUs</td>
<td class="text-right"><strong><?php
 $joinus  = @db_result(db_query("SELECT count(name) FROM prefix_usercheck WHERE ak = 4"),0);
  echo ' '.$joinus.' ';
  ?></strong></td>
</tr>
<tr><td colspan="2" class="text-left"><a class="btn btn-default btn-xs" href="admin.php?groups-joinus">Joinus anzeigen</a></td></tr>
</table>
  </li>
</ul>
<legend><h5><strong>neuste Mitglieder</strong></h5></legend>
<?php
  $abf = 'SELECT * FROM prefix_user ORDER BY regist DESC LIMIT 3';
	$erg = db_query($abf);
echo '<div class="list-group">';
  while ($row = db_fetch_object($erg)) {
  $regsek = mktime ( 0,0,0, date('m'), date('d'), date('Y') )  - $row->regist;
  $regday = round($regsek / 86400);
  $user = $row->name;
  echo'
  <a href="?user-1-'.$row->id.'"  class="list-group-item"><strong>'.$user.'</strong><small rel="tooltip" title="angemeldet am '.date('d.m.Y',$row->regist).'" class="pull-right">( '.date('d.m.Y',$row->regist).' )</small></a>';
}
echo '</div>';
?>


</div></div>
</div>

</div>
<div class="row">
  <div class="col-md-4">
<div class="panel panel-default">
  <div class="panel-body">
<legend><i class="fa fa-signal"></i> Statistiken</legend>   
<?php include ('include/boxes/ap_sta.php');?>
</div></div>
</div>
  <div class="col-md-4">
<div class="panel panel-default bg-warning">
  <div class="panel-body bg-warning">
<legend><i class="fa fa-file-text-o"></i> Letzte Eintr&auml;ge</legend>   
<legend class="text-info"><h5><strong>Letzte News</strong></h5></legend>
<?php include ('include/boxes/ap_ne.php');?>
<legend class="text-info"><h5><strong>Letzte Forumeintr&auml;ge</strong></h5></legend>
<?php include ('include/boxes/ap_fo.php');?>
</div></div>
</div>
  <div class="col-md-4">
<div class="panel panel-default">
  <div class="panel-body">
<legend><i class="fa fa-calendar-o"></i> Termine</legend>  
<legend ><h5><strong>Kalender Eintr&auml;ge</strong></h5></legend>
<?php include ('include/boxes/ap_termin.php');?>
<legend ><h5><strong>Next Wars</strong></h5></legend>
<?php include ('include/boxes/ap_next.php');?>
</div></div>
</div>
</div>

           <?php
				   break;
        }

				case 'versionsKontrolle' :
        {

          // ICON Anzeige...
          echo '<legend><h2><i class="fa fa-check-square-o"></i> Versionskontrolle</h2></legend>';


						echo ' <ul class="nav nav-pills nav-stacked" style="max-width: 170px;">
      <li class="active">
        <a href="#">
          <span class="badge pull-right">'.$scriptVersion.'</span>
          Scripte Version
        </a>
      </li>
      <li class="active">
        <a href="#">
          <span class="badge pull-right">'.$scriptUpdate.'</span>
          Update Version
        </a>
      </li>
    </ul><br><br>';
						echo '<div class="alert alert-warning" role="alert"><script language="JavaScript" type="text/javascript" src="http://www.ilch.de/down/ilchClan/update.php?version='.$scriptVersion.'&update='.$scriptUpdate.'"></script></div>';
						#echo '<iframe width="100%" height="60" src="http://www.ilch.de/down/ilchClan/update.php?version='.$scriptVersion.'&update='.$scriptUpdate.'"></iframe>';

						break;
        }

				#####################################

				case 'besucherStatistik' :
				{
            function echo_admin_site_statistik ($title, $col, $smon, $ges, $orderQuery ) {
              $sql = db_query("SELECT COUNT(*) AS wert, $col as schl FROM  `prefix_stats` WHERE mon = ".$smon." GROUP BY schl ORDER BY ".$orderQuery);
              $max = @db_result(db_query("SELECT COUNT(*) as wert, $col as schl FROM prefix_stats WHERE mon = ".$smon." GROUP BY schl ORDER BY wert DESC LIMIT 1"),0,0);
              if ( empty($max) ) { $max = 1; }
              if ( empty($ges) ) { $ges = 1; }
              echo '<tr><th colspan="3" class="text-left warning"><strong>'.$title.'</strong></th></tr>';
              while ( $r = db_fetch_assoc($sql) ) {
                $wert = ( empty($r['wert']) ? 1 : $r['wert'] );
                $weite = ($wert / $max) * 100;
					      $prozent = ($wert * 100) / $ges;
					      $prozent = number_format(round($prozent,2), 2, ',', '');
                $name = $r['schl'];
                if ( strlen ( $name ) >= 50 ) {
                  $name = substr($name,0,50).'';
                }
                echo '<tr><td  class="info"><a style="color:#000;" href="'.$name.'" target="_blank">'.$name.'</a></td>';
                echo '<td style="min-width:65%;"><div class="progress">
  <div class="progress-bar" role="progressbar" aria-valuenow="'.$weite.'"  aria-valuemin="0" aria-valuemax="100" style="width:'.$weite.'%;min-width: 50px;">
    '.$prozent.'%
  </div>
</div></td>';
                echo '<td class="text-right success"><span class="badge">'.$wert.'</span></td></tr>';
              }
            }



            // ICON Anzeige...
            echo '<legend><h2><i class="fa fa-tasks"></i> Besucher Statistik</h2></legend>';

            echo '<div class="btn-group btn-group-sm"><a  class="btn btn-primary" href="admin.php?admin-besucherUebersicht">&Uuml;bersicht</a><a  class="btn btn-info" href="?admin-besucherStatistik-'.$lastmon.'">letzter Monat</a><a  class="btn btn-warning" href="?admin-besucherStatistik-'.$mon.'">dieser Monat</a></div>';
            $smon  = $menu->get(2);
            if ( empty($smon) ) { $smon = $mon; }


            $ges = db_result(db_query("SELECT COUNT(*) FROM prefix_stats WHERE mon = ".$smon),0,0);
            echo '<h5 class="pull-right"><span class="label label-danger">Gesamt diesen Monat : '.$ges.'</span></h5>';
            echo '<table class="table table-condensed">';

            echo_admin_site_statistik ('Besucher nach Tagen', 'day', $smon, $ges, "schl DESC LIMIT 50" );
            echo_admin_site_statistik ('Besucher nach Wochentagen', 'DAYNAME(FROM_UNIXTIME((wtag+3)*86400))', $smon, $ges, "wtag DESC LIMIT 50" );
            echo_admin_site_statistik ('Besucher nach Uhrzeit', 'stunde', $smon, $ges, "schl ASC LIMIT 50");
            echo_admin_site_statistik ('Besucher nach Browsern', 'browser', $smon, $ges, "schl DESC LIMIT 50" );
            echo_admin_site_statistik ('Besucher nach Betriebssytemen', 'os', $smon, $ges, "schl DESC LIMIT 50" );
            echo_admin_site_statistik ('Besucher nach Herkunft', 'ref', $smon, $ges, "wert DESC LIMIT 50" );

				    echo '</table>';


				    break;
				}



				case 'userOnline' :
        {

          ?>
          <legend><h2><i class="fa fa-pie-chart"></i> Online Statistik</h2></legend>
          <table class="table table-striped table-bordered">
          <tr class="warning">
            <th>Username</th>
            <th>Letzte aktivitaet</th>
            <th>IP-Adresse</th>
            <th>Anbieter</th>
          </tr>
          <?php
          echo user_admin_online_liste();
          ?>
          </table>
          <?php

          break;
				}
				case 'besucherUebersicht' :
        {
            function get_max_from_x ($q) {
              $q = db_query($q);
              $m = 0;
              while($r = db_fetch_row($q)) {
                if ($r[0] > $m) { $m = $r[0]; }
              }
              return ($m);
            }

            function echo_admin_site_uebersicht ($schl, $wert, $max, $ges) {
              $wert = ( empty($wert) ? 1 : $wert );
              $weite = ($wert / $max ) * 100;
					    $prozent = ($wert * 100) / $ges;
					    $prozent = number_format(round($prozent,2), 2, ',', '');
              $name = $schl;
              if ( strlen ( $name ) >= 50 ) {
                $name = substr($name,0,50).'<b>...</b>';
              }
              echo '<tr><td>'.$name.'</td><td class="success" min-width="'.$weite.'">';
              echo '<hr width="'.$weite.'" class="pull-left" style="color:#000;border-color:#000;" /></td>';
              echo '<td class="text-right"><span class="label label-info">'.$prozent.'%</span></td>';
              echo '<td class="text-right">'.$wert.'</td></tr>';
            }

          // ICON Anzeige...
          echo '<legend><h2><i class="fa fa-tasks"></i> Besucher Statistik</h2></legend>';


          echo '<div class="btn-group btn-group-sm"><a  class="btn btn-primary" href="admin.php?admin-besucherUebersicht">&Uuml;bersicht</a><a  class="btn btn-info" href="?admin-besucherStatistik-'.$lastmon.'">letzter Monat</a><a  class="btn btn-warning" href="?admin-besucherStatistik-'.$mon.'">dieser Monat</a></div><br><br>';

          echo '<div class="row">';
          echo '<div class="col-md-4"><div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Nach Tagen (letzten 5 Monate)</h3></div><div class="panel-body">';

          echo '<table class="table table-condensed">';
          $max = db_result(db_query("SELECT MAX(`count`) FROM prefix_counter"),0);
          $ges = db_result(db_query("SELECT SUM(`count`) FROM prefix_counter"),0);
          $erg = db_query("SELECT `count` as sum, DATE_FORMAT(`date`, '%d.%m.%Y') as datum FROM prefix_counter ORDER BY `date` DESC");
          while ($r = db_fetch_assoc($erg)) {
            echo_admin_site_uebersicht ($r['datum'], $r['sum'], $max, $ges);
          }
          echo '</table>';

          echo '</div></div></div><div class="col-md-4">
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Nach Monaten</h3></div><div class="panel-body">';

          echo '<table class="table table-condensed">';
          $max = get_max_from_x("SELECT SUM(`count`) FROM prefix_counter GROUP BY MONTH(`date`), YEAR(`date`)");
          $erg = db_query("SELECT SUM(`count`) as sum, MONTH(`date`) as monat, YEAR(`date`) as jahr FROM prefix_counter GROUP BY monat, jahr ORDER BY jahr DESC, monat DESC");
          while ($r = db_fetch_assoc($erg)) {
            echo_admin_site_uebersicht ((strlen($r['monat'])==1?'0':'').$r['monat'].'.'.$r['jahr'], $r['sum'], $max, $ges);
          }
          echo '</table>';

          echo '</div></div></div><div class="col-md-4">
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Nach Jahren</h3></div><div class="panel-body">';

          echo '<table class="table table-condensed">';
          $max = get_max_from_x("SELECT SUM(`count`) FROM prefix_counter GROUP BY YEAR(`date`)");
          $erg = db_query("SELECT SUM(`count`) as sum, YEAR(`date`) as jahr FROM prefix_counter GROUP BY jahr ORDER BY jahr DESC");
          while ($r = db_fetch_assoc($erg)) {
            echo_admin_site_uebersicht ($r['jahr'], $r['sum'], $max, $ges);
          }
          echo '</table>';

          echo '</div></div></div></div>';
          break;

        }
				case 'siteStatistik' :
				{
##########################################
function forum_statistic_show ($sql,$ges) {
  $erg = db_query($sql);
  echo '<table border="0" cellpadding="0" cellspacing="0">';
  while ($r = db_fetch_row($erg)) {
#    str_repeat('|',abs($row['regs'] / 2))
    echo '<tr><td>'.$r[1].'</td><td>'.str_repeat('|',$r[0]).' '.$r[0].'</td></tr>';
  }
  echo '</table>';
}


// ICON Anzeige...
echo '<legend><h2><i class="fa fa-file-text-o"></i> Seiten Statistik</h2></legend>';

echo '<table class="table table-bordered"><tr><td class="warning">';
$heute = mktime(0,0,0,date('m'),date('d'),date('Y'));
$anzheute = db_result(db_query("SELECT COUNT(*) FROM prefix_posts WHERE time >= ".$heute),0,0);
echo 'Gesamt Posts heute: '.$anzheute.'<br><hr>';

# aktivsten user
$sql = "SELECT COUNT(*) as kk , erst as vv FROM prefix_posts WHERE time >= ".$heute." GROUP BY vv ORDER BY kk DESC LIMIT 10";
echo '<b>Aktivsten User heute</b><br>';
forum_statistic_show($sql,$anzheute);

# aktivsten themen
$sql = "SELECT COUNT(*) as kk , name as vv FROM prefix_topics LEFT JOIN prefix_posts ON prefix_posts.tid = prefix_topics.id WHERE time >= ".$heute." GROUP BY vv ORDER BY kk DESC LIMIT 10";
echo '<hr><b>Aktivsten Themen heute</b><br>';
forum_statistic_show($sql,$anzheute);

# aktivsten foren
$sql = "SELECT COUNT(*) as kk , prefix_forums.name as vv FROM prefix_topics LEFT JOIN prefix_forums ON prefix_forums.id = prefix_topics.fid LEFT JOIN prefix_posts ON prefix_posts.tid = prefix_topics.id WHERE time >= ".$heute." GROUP BY vv ORDER BY kk DESC LIMIT 10";
echo '<hr><b>Aktivsten Foren heute</b><br>';
forum_statistic_show($sql,$anzheute);

# neue user heute
$gsh = db_result(db_query("SELECT COUNT(*) FROM prefix_user WHERE regist >= ".$heute),0,0);
$sql = "SELECT COUNT(*) as kk , name as vv FROM prefix_user WHERE regist >= ".$heute." GROUP BY vv ORDER BY kk DESC LIMIT 10";
echo '<hr><b>Neue User heute</b><br />';
forum_statistic_show($sql,$gsh);

echo '</td><td>';
$heute1 = mktime(0,0,0,date('m'),date('d')-1,date('Y'));
$anzheute = db_result(db_query("SELECT COUNT(*) FROM prefix_posts WHERE time >= ".$heute1." AND time <= ".$heute),0,0);
echo 'Gesamt Posts gestern: '.$anzheute.'<br><hr>';

# aktivsten user
$sql = "SELECT COUNT(*) as kk , erst as vv FROM prefix_posts WHERE time >= ".$heute1." AND time <= ".$heute." GROUP BY vv ORDER BY kk DESC LIMIT 10";
echo '<b>Aktivsten User gestern</b><br>';
forum_statistic_show($sql,$anzheute);

# aktivsten themen
$sql = "SELECT COUNT(*) as kk , name as vv FROM prefix_topics LEFT JOIN prefix_posts ON prefix_posts.tid = prefix_topics.id WHERE time >= ".$heute1." AND time <= ".$heute." GROUP BY vv ORDER BY kk DESC LIMIT 10";
echo '<hr><b>Aktivsten Themen gestern</b><br>';
forum_statistic_show($sql,$anzheute);

# aktivsten foren
$sql = "SELECT COUNT(*) as kk , prefix_forums.name as vv FROM prefix_topics LEFT JOIN prefix_forums ON prefix_forums.id = prefix_topics.fid LEFT JOIN prefix_posts ON prefix_posts.tid = prefix_topics.id WHERE time >= ".$heute1." AND time <= ".$heute." GROUP BY vv ORDER BY kk DESC LIMIT 10";
echo '<hr><b>Aktivsten Foren gestern</b><br>';
forum_statistic_show($sql,$anzheute);

# neue user heute
$gsh = db_result(db_query("SELECT COUNT(*) FROM prefix_user WHERE regist >= ".$heute1." AND regist <= ".$heute),0,0);
$sql = "SELECT COUNT(*) as kk , name as vv FROM prefix_user WHERE regist >= ".$heute1." AND regist <= ".$heute." GROUP BY vv ORDER BY kk DESC LIMIT 10";
echo '<hr><b>Neue User gestern</b><br>';
forum_statistic_show($sql,$gsh);
echo '</td></tr></table>';


##########################################
				    break;
				}

		}

$design->footer();
?>