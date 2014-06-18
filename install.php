<?php
#   Copyright by: Balthazar3k
define ( 'main' , TRUE );
define ( 'admin', TRUE );

require_once ('include/includes/config.php');
require_once ('include/includes/loader.php');

db_connect();

$sql = array();

$sql[] = "ALTER TABLE `prefix_modules` CHANGE `url` `url` VARCHAR(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '';";
$sql[] = "ALTER TABLE `prefix_modules` ADD `kat` VARCHAR(50) NOT NULL , ADD `pos` INT(3) NOT NULL;";

$sql[] = "UPDATE `prefix_modules` SET kat='Content', pos='26' WHERE url='gallery';";
$sql[] = "UPDATE `prefix_modules` SET kat='Content', pos='27' WHERE url='news';";
$sql[] = "UPDATE `prefix_modules` SET kat='Content', pos='23' WHERE url='forum';";
$sql[] = "UPDATE `prefix_modules` SET kat='Content', pos='19' WHERE url='archiv-downloads';";
$sql[] = "UPDATE `prefix_modules` SET kat='Content', pos='21' WHERE url='kalender';";
$sql[] = "UPDATE `prefix_modules` SET kat='Content', pos='24' WHERE url='gbook';";

$sql[] = "UPDATE `prefix_modules` SET kat='User', pos='40' WHERE url='groups';";
$sql[] = "UPDATE `prefix_modules` SET kat='User', pos='41' WHERE url='rules';";
$sql[] = "UPDATE `prefix_modules` SET kat='User', pos='39' WHERE url='awards';";

$sql[] = "UPDATE `prefix_modules` SET kat='Clan', pos='12' WHERE url='awaycal';";
$sql[] = "UPDATE `prefix_modules` SET kat='Clan', pos='17' WHERE url='kasse';";
$sql[] = "UPDATE `prefix_modules` SET kat='Clan', pos='14' WHERE url='wars';";
$sql[] = "UPDATE `prefix_modules` SET kat='Module' WHERE kat='';";

$sql[] = "
    INSERT INTO `prefix_modules` (`url`, `name`, `gshow`, `ashow`, `fright`, `kat`, `pos`) VALUES
        ('admin-versionsKontrolle', 'Versionskontrolle', 0, 1, 0, 'Admin', 7),
        ('backup', 'Backup', 0, 1, 0, 'Admin', 3),
        ('allg', 'Konfiguration', 0, 1, 0, 'Admin', 1),
        ('checkconf', 'Server Konfiguration', 0, 1, 0, 'Admin', 4),
        ('newsletter', 'Newsletter', 0, 1, 0, 'Content', 20),
        ('smilies', 'Smilies', 0, 1, 0, 'Admin', 5),
        ('compatibility', 'Kompatibilit&auml;t', 0, 1, 0, 'Admin', 6),
        ('menu', 'Navigation', 0, 1, 0, 'Admin', 2),
        ('contact', 'Kontakt', 0, 1, 0, 'Content', 22),
        ('admin-siteStatistik', 'Seite', 1, 1, 1, 'Statistik', 30),
        ('admin-userOnline', 'Online', 0, 1, 0, 'Statistik', 31),
        ('wars-last', 'Lastwars', 1, 1, 1, 'Clan', 13),
        ('wars-next', 'Nextwars', 0, 1, 0, 'Clan', 15),
        ('history', 'History', 1, 1, 1, 'Clan', 18),
        ('trains', 'Trainzeiten', 0, 1, 1, 'Clan', 16),
        ('user', 'Verwalten', 0, 1, 1, 'User', 36),
        ('grundrechte', 'Grundrechte', 0, 1, 0, 'User', 33),
        ('profilefields', 'Profilefelder', 0, 1, 0, 'User', 34),
        ('user-createNewUser', 'neuen User', 0, 1, 0, 'User', 35),
        ('range', 'Ranks', 0, 1, 0, 'User', 37),
        ('admin-besucherStatistik', 'Besucher', 0, 1, 0, 'Statistik', 32),
        ('picofx', 'Zufallsbild', 0, 1, 1, 'Boxen', 11),
        ('impressum', 'Impressum', 0, 1, 1, 'Content', 25),
        ('modules', 'Module', 0, 1, 0, 'Admin', 8),
        ('puser', 'Unconfirmed User', 0, 1, 0, 'User', 38),
        ('selfbp', 'Eigene Seite/Box', 0, 1, 0, 'Content', 28),
        ('smtpconf', 'SMTP Einstellung', 0, 1, 0, 'Admin', 9),
        ('vote', 'Umfrage', 0, 1, 0, 'Boxen', 10),
        ('vote', 'Umfrage', 0, 1, 0, 'Content', 29);
";

$status = array();
foreach($sql as $s ){
    if( @db_query($s) ){
        $status[] = true;
    } else {
        $status[] = false;
    }
}

if( in_array(false, $status) ){
    wd('admin.php?admin', 'Installation war nicht erfolgreich!', 10);
} else {
    wd('admin.php?admin', 'Installation war erfolgreich!', 0);
}

db_close();
if (false) { //debugging aktivieren
    debug('anzahl sql querys: '.$count_query_xyzXYZ);
    debug('', 1, true);
}
?>