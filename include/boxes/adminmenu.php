<?php
#   Copyright by Manuel
#   Support www.ilch.de


defined ('main') or die ( 'no direct access' );

if (is_coadmin()) {
  ?><script language="JavaScript" type="text/javascript">
<!--

  function createNewUser() {
    var Fenster = window.open ('admin.php?user-createNewUser', 'createNewUser', 'status=yes,scrollbars=yes,height=200,width=350,left=300,top=50');
    Fenster.focus();
  }
//-->
</script><?php
}


if ( is_coadmin() ) {


echo '<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cogs"></i> Admin <b class="caret"></b></a><ul class="dropdown-menu">';
      if (is_admin()) { 
echo '<li><a href="admin.php?allg">Konfiguration</a></li>';
       }
      if ($allgAr['mail_smtp']) { 
echo '<li><a href="admin.php?smtpconf">SMTP Konfiguration</a></li>';
      } 
echo '<li><a href="admin.php?menu">Navigation</a></li>';
       if (is_admin()) { 
echo '<li><a href="admin.php?backup">Backup</a></li>';
       } 
echo '<li><a href="admin.php?compatibility">Kompatibilität</a></li>
       <li><a href="admin.php?smilies">Smilies</a></li>
       <li><a href="admin.php?newsletter">Newsletter</a></li>
       <li><a href="admin.php?admin-versionsKontrolle">Versions Kontrolle</a></li>
       <li><a href="admin.php?checkconf">Server Konfiguration</a></li>
       <li class="divider"></li><li>
       <li><a href="admin.php?admin-besucherStatistik">Statistik-Besucher</a></li>
       <li><a href="admin.php?admin-siteStatistik">Statistik-Seite</a></li>
       <li><a href="admin.php?admin-userOnline">Wer ist Online</a></li>';
echo '</ul></li>';
echo '<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-users"></i> User <b class="caret"></b></a><ul class="dropdown-menu">';

echo '<li><a href="admin.php?user">Verwalten</a></li>';

echo '</ul></li>';
echo '<li><a rel="tooltip" title="Eigene Boxen und Seiten erstellen" data-placement="bottom" href="admin.php?selfbp"><i class="fa fa-plus-square"></i> Eigene Box/Page</a></li>';

echo '<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-flag-o"></i> Clanbox <b class="caret"></b></a><ul class="dropdown-menu">';
echo '</ul></li>';

echo '<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-file-o"></i> Content <b class="caret"></b></a><ul class="dropdown-menu">';
echo '</ul></li>';

echo '<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cubes"></i> Module <b class="caret"></b></a><ul class="dropdown-menu">';
echo '</ul></li></ul>';

}

echo '<ul class="nav navbar-nav">
<li><a rel="tooltip" title="Startseite Adminbereich" data-placement="bottom" href="admin.php?admin"><i class="fa fa-undo"></i></a></li>
<li class="active"><a rel="tooltip" title="Startseite Frontend" data-placement="bottom" href="./"><i class="fa fa-home"></i> Seite</a></li>
      </ul>';


?>
