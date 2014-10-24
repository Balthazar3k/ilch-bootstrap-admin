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
<legend>Hilfe Adminbereich</legend>   
<ul class="list-group">
  <li class="list-group-item list-group-item-success">
<h4>Willkommen im Adminbereich</h4>
In den nun folgenden Zeile wird dir die Oberfläche des Adminbereiches erläutert.<br>
Oben rechts im DropDown Menü sind die jeweilgen Bereiche der Seite zu finden.<br>Rechts an der Seite befindet sich das Quickmen&uuml; für einen z&uuml;gigen Zugriff zu weiteren Ansichten. Dort sind, je nach dem gewähltem Bereich, passende Links zu finden, &auml;hnlich dem DropDown Menü.<br>
Hier auf der Startseite gibt es einen Einblick zu einigen Informationen zu der Seite.
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
<legend>Info´s zur Seite</legend>   
<ul class="list-group">
  <li class="list-group-item list-group-item-warning">
<table width="100%"><tr>
    <td>Aktuelles Design</td>
<td class="text-right"><strong><? echo $allgAr['gfx']; ?></strong></td>
</tr></table>
  </li>
</ul>
<ul class="list-group">
  <li class="list-group-item list-group-item-warning">
<table width="100%"><tr>
    <td>Script Version</td>
<td class="text-right"><strong><?php echo 'Ilch '.$scriptVersion.' '.$scriptUpdate.''; ?></strong></td>
</tr></table>
  </li>
</ul>
<ul class="list-group">
  <li class="list-group-item list-group-item-warning">
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
  <li class="list-group-item list-group-item-warning">
<table width="100%"><tr>
    <td>Download Ordner</td>
<td class="text-right"><strong><?php echo nicebytes(dirsize('include/downs/')); ?> gro&szlig;</strong></td>
</tr>
<tr><td colspan="2" class="text-left"><a class="btn btn-default btn-xs" href="admin.php?archiv-downloads">Downloads Verwalten</a></td></tr>
</table>
  </li>
</ul>
<ul class="list-group">
  <li class="list-group-item list-group-item-warning">
<table width="100%"><tr>
    <td>Status Seite</td>
<td class="text-right"><strong><?
  if ($allgAr['wartung'] == 0){
     echo '<p class="text-success">Seite Online</p>';
  }else
    echo '<p class="text-danger">Wartungs Modus</p>';
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
<legend>User</legend>   
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
<td class="text-right"><strong><?
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
<td class="text-right"><strong><?
 $joinus  = @db_result(db_query("SELECT count(name) FROM prefix_usercheck WHERE ak = 4"),0);
  echo ' '.$joinus.' ';
  ?></strong></td>
</tr>
<tr><td colspan="2" class="text-left"><a class="btn btn-default btn-xs" href="admin.php?groups-joinus">Joinus anzeigen</a></td></tr>
</table>
  </li>
</ul>
</div></div>
</div>

</div>
<div class="row">
  <div class="col-md-4">Box4</div>
  <div class="col-md-4">Box5</div>
  <div class="col-md-4">Box6</div>
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
              echo '<tr><th align="left" colspan="4">'.$title.'</th></tr>';
              while ( $r = db_fetch_assoc($sql) ) {
                $wert = ( empty($r['wert']) ? 1 : $r['wert'] );
                $weite = ($wert / $max) * 200;
					      $prozent = ($wert * 100) / $ges;
					      $prozent = number_format(round($prozent,2), 2, ',', '');
                $name = $r['schl'];
                if ( strlen ( $name ) >= 50 ) {
                  $name = substr($name,0,50).'<b>...</b>';
                }
                echo '<tr class="active"><td width="150" title="'.$r['schl'].'">'.$name.'</td><td width="250">';
                echo '<hr width="'.$weite.'" align="left" style="color:#2f2f2f"/></td>';
                echo '<td width="50" align="right">'.$prozent.'%</td>';
                echo '<td  width="50" align="right">'.$wert.'</td></tr>';
              }
            }

            // ICON Anzeige...
            echo '<legend><h2><i class="fa fa-tasks"></i> Besucher Statistik</h2></legend>';

            echo '<div class="btn-group btn-group-sm"><a  class="btn btn-primary" href="admin.php?admin-besucherUebersicht">&Uuml;bersicht</a><a  class="btn btn-primary" href="?admin-besucherStatistik-'.$lastmon.'">letzter Monat</a><a  class="btn btn-primary" href="?admin-besucherStatistik-'.$mon.'">dieser Monat</a></div>';
            $smon  = $menu->get(2);
            if ( empty($smon) ) { $smon = $mon; }


            $ges = db_result(db_query("SELECT COUNT(*) FROM prefix_stats WHERE mon = ".$smon),0,0);
            echo '<br><br><b>Gesamt diesen Monat: '.$ges.'</b>';
            echo '<table class="table">';

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
              echo '<tr class="norm"><td width="150" title="'.$schl.'">'.$name.'</td><td width="250">';
              echo '<hr width="'.$weite.'" align="left" /></td>';
              echo '<td width="50" align="right">'.$prozent.'%</td>';
              echo '<td  width="50" align="right">'.$wert.'</td></tr>';
            }

          // ICON Anzeige...
          echo '<table cellpadding="0" cellspacing="0" border="0"><tr><td><img src="include/images/icons/admin/stats_visitor.png" /></td><td width="30"></td><td valign="bottom"><h1>Besucher Statistik</h1></td></tr></table>';


          echo '<a href="admin.php?admin-besucherUebersicht">&Uuml;bersicht</a>&nbsp;<b>|</b>&nbsp;<a href="?admin-besucherStatistik-'.$lastmon.'" title="'.$lastmon.'. '.$lastjahr.'">letzter Monat</a>&nbsp;<b>|</b>&nbsp;<a href="?admin-besucherStatistik-'.$mon.'" title="'.$mon.'. '.$jahr.'">dieser Monat</a>';

          echo '<br /><br /><table cellpadding="0" border="0" cellspacing="0" width="100%">';
          echo '<tr><td valign="top" width="33%"><b>Nach Tagen (letzten 5 Monate):</b><br />';

          echo '<table cellpadding="0" border="0" cellspacing="0" width="90%">';
          $max = db_result(db_query("SELECT MAX(`count`) FROM prefix_counter"),0);
          $ges = db_result(db_query("SELECT SUM(`count`) FROM prefix_counter"),0);
          $erg = db_query("SELECT `count` as sum, DATE_FORMAT(`date`, '%d.%m.%Y') as datum FROM prefix_counter ORDER BY `date` DESC");
          while ($r = db_fetch_assoc($erg)) {
            echo_admin_site_uebersicht ($r['datum'], $r['sum'], $max, $ges);
          }
          echo '</table>';

          echo '</td><td valign="top" width="33%"><b>Nach Monaten:</b><br />';

          echo '<table cellpadding="0" border="0" cellspacing="0" width="90%">';
          $max = get_max_from_x("SELECT SUM(`count`) FROM prefix_counter GROUP BY MONTH(`date`), YEAR(`date`)");
          $erg = db_query("SELECT SUM(`count`) as sum, MONTH(`date`) as monat, YEAR(`date`) as jahr FROM prefix_counter GROUP BY monat, jahr ORDER BY jahr DESC, monat DESC");
          while ($r = db_fetch_assoc($erg)) {
            echo_admin_site_uebersicht ((strlen($r['monat'])==1?'0':'').$r['monat'].'.'.$r['jahr'], $r['sum'], $max, $ges);
          }
          echo '</table>';

          echo '</td><td valign="top" width="33%"><b>Nach Jahren:</b><br />';

          echo '<table cellpadding="0" border="0" cellspacing="0" width="90%">';
          $max = get_max_from_x("SELECT SUM(`count`) FROM prefix_counter GROUP BY YEAR(`date`)");
          $erg = db_query("SELECT SUM(`count`) as sum, YEAR(`date`) as jahr FROM prefix_counter GROUP BY jahr ORDER BY jahr DESC");
          while ($r = db_fetch_assoc($erg)) {
            echo_admin_site_uebersicht ($r['jahr'], $r['sum'], $max, $ges);
          }
          echo '</table>';

          echo '</td></tr></table>';
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
