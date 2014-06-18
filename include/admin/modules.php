<?php 
#   Copyright by: Balthazar3k


defined ('main') or die ( 'no direct access' );
defined ('admin') or die ( 'only admin access' );

$data = array();
$ignore = array('.', '..', 'templates', 'installmodules.php');

switch($menu->get(1)){
    case 'save':
        $res = array_map("mysql_real_escape_string", $_POST);
        //var_dump(db::update($res)); exit();
        
        $module_id = escape($menu->get(2), 'integer');
        if( $module_id != 0 ) {
            db_query("
                UPDATE `prefix_modules` SET ".db::update($res)." WHERE id='".$module_id."';
            ");
        } else {
            db_query("
                INSERT INTO `prefix_modules` ".db::insert($res).";
            ");
        }
        
        wd('admin.php?modules', 'Erfolgreich', 0);
        exit();
    break;
    case 'delete':
        db_query("DELETE FROM prefix_modules WHERE id='".escape($menu->get(2), 'integer')."';");
        wd('admin.php?modules', 'Erfolgreich', 0);
    break;
    case 'edit':
        $data = db_fetch_assoc(db_query("SELECT * FROM prefix_modules WHERE id='".escape($menu->get(2), 'integer')."';"));
    break;
    case 'sort':
        $res = array_map("mysql_real_escape_string", $_POST['sort']);
        foreach( $res as $pos => $id ){
            db_query("UPDATE prefix_modules SET pos='".($pos+1)."' WHERE id='".$id."'");
        }
        exit();
    break;
    default:
        $data = array(
            'id' => '0',
            'name' => '',
            'url' => '',
            'gshow' => '0',
            'ashow' => '0',
            'fright' => '0',
            'kat' => ''
        );
    break;
}

$design = new design ( 'Admins Area', 'Admins Area', 2 );
$design->header();

$tpl = new tpl ('modules', 1);
$tpl->out(0);

$kat = db_query('SELECT DISTINCT kat FROM prefix_modules ORDER BY pos ASC;');

if( db_num_rows($kat) ){
    while( $k = db_fetch_assoc($kat) ){
        $tpl->set_ar_out($k, 1);

        $modulesResult = db_query("SELECT * FROM prefix_modules WHERE kat='".$k['kat']."' ORDER BY pos ASC;");
        
        while ( $module = db_fetch_assoc($modulesResult)){
            $tpl->set_ar_out($module, 2);
            
                /* Module die bereits in der Datenbank sind, müssen
                * nicht mehr beim Hinzufügen angezeigt werden,
                * somit alle Module in der ignor sammeln, damit die
                * restlichen Module angezeigt werden, die noch
                * nicht als Menü angezeigt werden.
                * Wird für die get_files() gebraucht!
                */
               $ignore[] = $module['url'] .'.php';  
        }
            
            
             
        $data['category'] .= $tpl->list_get('category', array($k['kat']));
    }
}

/* Unverteilte Module ins Formular laden */
foreach( get_files('include/admin/', $ignore) as $k => $v ){
    $data['modules'] .= $tpl->list_get('modules', array($v));
}

$tpl->set_ar_out($data, 3);
$design->footer();

/*
 * Anzeige zu ende, folgender Code sind Functionen
 */

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

class db
{
    public static function select($data)
    {
        return implode(', ', self::getSelect($data));      
    }
    
    public static function update($data)
    {
        return implode(', ', self::getFields($data));           
    }
    
    public static function insert($data)
    {
        $sql .= ' ('. implode(', ', self::getFieldKeys($data)).')';
        $sql .= ' VALUES( '. implode(', ', self::getFieldValues($data)).')';
        return $sql;
                
    }
      
    public static function getSelect($attributes)
    {
        if( is_array($attributes) && count($attributes) > 0 ){
            $attr = array();
            foreach( $attributes as $key => $value){
                $attr[] = '`'.$value.'`';
            }
            return $attr;
        }
    }
    
    public static function getFields($attributes)
    {
        if( is_array($attributes) && count($attributes) > 0 ){
            $attr = array();
            foreach( $attributes as $key => $value){
                $attr[] = '`'.$key.'`="'.$value.'"';
            }
            return $attr;
        }
    }
    
    public static function getFieldKeys($attributes)
    {
        if( is_array($attributes) && count($attributes) > 0 ){
            $attr = array();
            foreach( $attributes as $key => $value){
                $attr[] = '`'.$key.'`';
            }
            return $attr;
        }
    }
    
    public static function getFieldValues($attributes)
    {
        if( is_array($attributes) && count($attributes) > 0 ){
            $attr = array();
            foreach( $attributes as $value){
                $attr[] = '"'.$value.'"';
            }
            return $attr;
        }
    }
    
    public static function getOrder($attributes)
    {
        if( is_array($attributes) && count($attributes) > 0 ){
            $attr = array();
            foreach( $attributes as $key => $value){
                $attr[] = '`'.$key.'` '.$value.'';
            }
            return $attr;
        }
    }
}

?>