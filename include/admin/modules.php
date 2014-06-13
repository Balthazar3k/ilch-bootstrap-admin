<?php 
#   Copyright by: Manuel
#   Support: www.ilch.de


defined ('main') or die ( 'no direct access' );
defined ('admin') or die ( 'only admin access' );

$data = array();
$ignore = array('.', '..', 'modules.php', 'templates');

$design = new design ( 'Admins Area', 'Admins Area', 2 );
$design->header();




$tpl = new tpl ('modules', 1);
$tpl->out(0);

$kat = db_query('SELECT DISTINCT kat FROM prefix_modules ORDER BY kat DESC;');

if( db_num_rows($kat) ){
    while($kategorie = db_fetch_object($kat) ) {
        $tpl->set_ar_out($kategorie, 1);
        
        $res = db_query('SELECT * FROM prefix_modules WHERE kat=\''.$kategorie->kat.'\';');
        while( $module = db_fetch_object($res) ){
            $tpl->set_ar_out($module, 2);
            $ignore[] = $module->url .'.php';
        }
        
        /* Sammeln der Kategorien für das Formular */
        $data['category'] .= $tpl->list_get('category', array($kategorie->kat));
    }
}

/* Unverteilte Module Laden */
foreach( get_files('include/admin/', $ignore) as $k => $v ){
    $data['modules'] .= $tpl->list_get('modules', array(ucfirst($v), $v));
}



$tpl->set_ar_out($data, 3);

?><pre><?php
print_r(get_files('include/admin/', $ignore));
?></pre><?php


$design->footer();

function get_files($path, $ignore = array()){
    $array = array();
    
    $res = scandir($path);
    
    foreach( $res as $k => $v ){
        if( !in_array( $v, $ignore ) ){
            if( is_file( $path.$v ) ){
                $array[] = pathinfo($v, PATHINFO_FILENAME);
            } else {
                $array = array_merge($array, get_files($path.'/'.$v, $ignore) );
            }
        }
    }
    
    return $array;
}
?>