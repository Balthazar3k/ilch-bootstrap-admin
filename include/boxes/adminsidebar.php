<?php
/*
 * Code by Balthazar3k
 */
$tpl = new tpl('sidebar.htm', 1);
$tpl->out(0);

$module_cat = escape($menu->get(0), 'string');
$category_name = @db_result(db_query('SELECT kat FROM prefix_modules WHERE url LIKE \''.$module_cat.'%\' ORDER BY pos ASC;'),0);
$res = db_query("SELECT * FROM prefix_modules WHERE kat='".$category_name."' ORDER BY pos ASC;");

if( @db_num_rows($res) ){
    while( $k = db_fetch_assoc($res) ){
        $tpl->set_ar_out($k, 1);
    }
}
$tpl->out(2);
?>