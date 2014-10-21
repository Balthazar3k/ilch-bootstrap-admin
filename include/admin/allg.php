<?php

#   Copyright by: Manuel
#   Support: www.ilch.de
defined('main') or die('no direct access');
defined('admin') or die('only admin access');

$design = new design('Admins Area', 'Admins Area', 2);
$design->header();

if (!is_admin()) {
    echo 'Dieser Bereich ist nicht fuer dich...';
    $design->footer();
    exit();
}

# hilfsfunktionen

function get_links_array() {
    $ar = array();
    $handle = opendir('include/contents');
    while ($ver = readdir($handle)) {
        if ($ver != "." AND $ver != ".." AND !is_dir('include/contents/' . $ver)) {
            $n = explode('.', $ver);
            $ar[$n[0]] = $ver;
        }
    }
    closedir($handle);
    $handle = opendir('include/contents/selfbp/selfp');
    while ($ver = readdir($handle)) {
        if ($ver == "." OR $ver == ".." OR is_dir('include/contents/selfbp/selfp/' . $ver)) {
            continue;
        }
        $n = explode('.', $ver);
        if (file_exists('include/contents/' . $ver) OR file_exists('include/contents/' . $n[0] . '.php')) {
            $n[0] = 'self-' . $n[0];
        }
        $ar[$n[0]] = 'self_' . $ver;
    }
    closedir($handle);
    asort($ar);
    return ($ar);
}

# funktionen fuer listen

function admin_allg_gfx($ak) {
    $gfx = '';
    $o = opendir('include/designs');
    while ($ver = readdir($o)) {
        if ($ver != "." AND $ver != ".." AND is_dir('include/designs/' . $ver)) {

            if ($ver == $ak) {
                $sel = ' selected';
            } else {
                $sel = '';
            }
            $gfx .= '<option' . $sel . '>' . $ver . '</option>';
        }
    }
    closedir($o);
    return ( $gfx );
}

function admin_allg_smodul($ak) {
    $ordner = array();
    $handle = opendir('include/contents');
    while ($ver = readdir($handle)) {
        if ($ver == '.' OR $ver == '..' OR is_dir('include/contents/' . $ver)) {
            continue;
        }
        $lver = explode('.', $ver);
        $ordner[] = $lver[0];
    }
    $smodul = '';
    $ordner = get_links_array();
    foreach ($ordner as $a => $x) {
        if ($a == $ak) {
            $sel = ' selected';
        } else {
            $sel = '';
        }
        $smodul .= '<option' . $sel . ' value="' . $a . '">' . ucfirst($a) . '</option>';
    }
    return ( $smodul );
}

function admin_allg_wars_last_komms($ak) {
    $ar = array(0 => 'nein', -1 => 'ab User', -3 => 'ab Trial', -4 => 'ab Member');
    $l = '';
    foreach ($ar as $k => $v) {
        if ($k == $ak) {
            $sel = ' selected';
        } else {
            $sel = '';
        }
        $l .= '<option' . $sel . ' value="' . $k . '">' . $v . '</option>';
    }
    return ($l);
}

function get_category() {
    $list = array();
    $res = db_query("SELECT DISTINCT kat FROM prefix_config ORDER BY kat ASC, pos ASC;");
    while ($row = db_fetch_assoc($res)) {
        $list[] = str_replace(' Optionen', '', $row['kat']);
    }

    return $list;
}

$csrfCheck = chk_antispam('admin_allg', true);

if (empty($_POST['submit']) || !$csrfCheck) {
    $gfx = admin_allg_gfx($allgAr['gfx']);
    $smodul = admin_allg_smodul($allgAr['smodul']);
    $wars_last_komms = admin_allg_wars_last_komms($allgAr['wars_last_komms']);
      
    $category = get_category();
    $tpl = new tpl('allg.htm', 1);
    foreach ($category as $k => $v) {
        $list_category .= $tpl->list_get('category', array($v, $v));
    }
    $tpl->set('category', $list_category);
    $tpl->out(0);

    foreach ($category as $k => $v) {
        $tpl->set_out('category', $v, 1);

        $res = db_query("SELECT * FROM prefix_config WHERE kat LIKE '" . $v . "%' ORDER BY pos ASC;");
        while ($row = db_fetch_assoc($res)) {
            if ($row['typ'] == 'input') {
                $row['field_type'] = '<input class="form-control" size="50" type="text" name="' . $row['schl'] . '" value="' . $row['wert'] . '">';
            } elseif ($row['typ'] == 'r2') {
                $checkedj = '';
                $checkedn = '';
                if ($allgAr[$row['schl']] == 1) {
                    $checkedj = 'checked';
                    $checkedn = '';
                    $activej = 'active';
                    $activen = '';
                } else {
                    $checkedn = 'checked';
                    $checkedj = '';
                    $activej = '';
                    $activen = 'active';
                }
                $row['field_type'] = '<div class="btn-group" data-toggle="buttons">';
                $row['field_type'] .= '<label class="btn btn-default '.$activej.'"><input type="radio" name="' . $row['schl'] . '" value="1" ' . $checkedj . ' >ja</label>';
                $row['field_type'] .= '<label class="btn btn-default '.$activen.'"><input type="radio" name="' . $row['schl'] . '" value="0" ' . $checkedn . ' > nein</label>';
                $row['field_type'] .= '</div>';
            } elseif ($row['typ'] == 's') {
                $vname = $row['schl'];
                $row['field_type'] = '<select class="form-control" name="' . $row['schl'] . '">' . $$vname . '</select>';
            } elseif ($row['typ'] == 'textarea') {
                $row['field_type'] = '<textarea class="form-control" cols="55" rows="3" name="' . $row['schl'] . '">' . $row['wert'] . '</textarea>';
            } elseif ($row['typ'] == 'grecht') {
                $grl = dblistee($allgAr[$row['schl']], "SELECT id,name FROM prefix_grundrechte ORDER BY id ASC");
                $row['field_type'] = '<select class="form-control" name="' . $row['schl'] . '">' . $grl . '</select>';
            } elseif ($row['typ'] == 'grecht2') {
                $grl = dblistee($allgAr[$row['schl']], "SELECT id,name FROM prefix_grundrechte WHERE id >= -2 ORDER BY id ASC");
                $row['field_type'] = '<select class="form-control" name="' . $row['schl'] . '">' . $grl . '</select>';
            } elseif ($row['typ'] == 'password') {
                $row['field_type'] = '<input class="form-control" size="50" type="password" name="' . $row['schl'] . '" value="***" />';
            }
            $tpl->set_ar_out($row, 2);
        }
        $tpl->set_out('antispam', get_antispam('admin_allg', 0, true), 3);
    }

    $tpl->out(4);
} elseif ($csrfCheck) {
    $abf = 'SELECT * FROM `prefix_config` ORDER BY kat';
    $erg = db_query($abf);
    while ($row = db_fetch_assoc($erg)) {
        if ($row['typ'] == 'password' AND $_POST[$row['schl']] == '***') {
            continue;
        } elseif ($row['typ'] == 'password') {
            require_once('include/includes/class/AzDGCrypt.class.inc.php');
            $cr64 = new AzDGCrypt(DBDATE . DBUSER . DBPREF);
            $_POST[$row['schl']] = $cr64->crypt($_POST[$row['schl']]);
        }
        db_query('UPDATE `prefix_config` SET wert = "' . escape($_POST[$row['schl']], 'textarea') . '" WHERE schl = "' . $row['schl'] . '"');
    }
    wd('admin.php?allg', 'Erfolgreich ge&auml;ndert', 2);
}

//-----------------------------------------------------------|
$design->footer();
?>