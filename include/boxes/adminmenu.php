<?php
/*
 * Code by Balthazar3k $bild = 'include/images/icons/admin/'.$modrow->url.'.png';
 */

$tpl = new tpl('navbar.htm', 1);
$tpl->out(0);

$kat = db_query('SELECT DISTINCT kat FROM prefix_modules ORDER BY pos ASC;');
if( @db_num_rows($kat) ){
    while( $k = db_fetch_assoc($kat) ){
        $tpl->set_ar_out($k, 1);
        $modulesResult = db_query("SELECT * FROM prefix_modules WHERE kat='".$k['kat']."' ORDER BY pos ASC;");
        while ( $module = db_fetch_object($modulesResult)){
            $tpl->set_ar_out($module, 2);
        }
        $tpl->out(3);
    }
}
$tpl->out(4);
?>