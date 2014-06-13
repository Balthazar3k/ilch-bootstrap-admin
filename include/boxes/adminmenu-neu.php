<?php
/*
 * Code by Balthazar3k $bild = 'include/images/icons/admin/'.$modrow->url.'.png';
 * ALTER TABLE `ic1_modules` ADD `kat` VARCHAR(32) NOT NULL , ADD `recht` INT(1) NOT NULL ;
 * UPDATE `ilchstarndart`.`ic1_modules` SET `kat` = 'Content' WHERE `ic1_modules`.`id` = 1; UPDATE `ilchstarndart`.`ic1_modules` SET `kat` = 'Content' WHERE `ic1_modules`.`id` = 2; UPDATE `ilchstarndart`.`ic1_modules` SET `kat` = 'User' WHERE `ic1_modules`.`id` = 3; UPDATE `ilchstarndart`.`ic1_modules` SET `kat` = 'User' WHERE `ic1_modules`.`id` = 4; UPDATE `ilchstarndart`.`ic1_modules` SET `kat` = 'User' WHERE `ic1_modules`.`id` = 5; UPDATE `ilchstarndart`.`ic1_modules` SET `kat` = 'Content' WHERE `ic1_modules`.`id` = 6; UPDATE `ilchstarndart`.`ic1_modules` SET `kat` = 'Content' WHERE `ic1_modules`.`id` = 7; UPDATE `ilchstarndart`.`ic1_modules` SET `kat` = 'Content' WHERE `ic1_modules`.`id` = 8; UPDATE `ilchstarndart`.`ic1_modules` SET `kat` = 'Clan' WHERE `ic1_modules`.`id` = 9; UPDATE `ilchstarndart`.`ic1_modules` SET `kat` = 'Clan' WHERE `ic1_modules`.`id` = 10; UPDATE `ilchstarndart`.`ic1_modules` SET `kat` = 'Content' WHERE `ic1_modules`.`id` = 11; UPDATE `ilchstarndart`.`ic1_modules` SET `kat` = 'Clan' WHERE `ic1_modules`.`id` = 12;
 * INSERT INTO `ilchstarndart`.`ic1_modules` (`id`, `url`, `name`, `gshow`, `ashow`, `fright`, `kat`, `recht`) VALUES (NULL, 'modules', 'Module Links', '1', '1', '1', 'Konfiguration', '-9');
 */

$tpl = new tpl('navbar.htm', 1);
$tpl->out(0);

$kat = db_query('SELECT DISTINCT kat FROM prefix_modules ORDER BY kat DESC;');

if( db_num_rows($kat) ){
    while($kategorie = db_fetch_object($kat) ) {
        $tpl->set_ar_out($kategorie, 1);
        
        $res = db_query('SELECT * FROM prefix_modules WHERE kat=\''.$kategorie->kat.'\';');
        while( $module = db_fetch_object($res) ){
            $tpl->set_ar_out($module, 2);
        }
        
        $tpl->out(3);
    }
}
$tpl->out(4);
             

?>