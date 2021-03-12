<?php
//搜尋程式

function beck_iscore_search($queryarray, $andor, $limit, $offset, $userid)
{
    global $xoopsDB;
    if (get_magic_quotes_gpc()) {
        foreach ($queryarray as $k => $v) {
            $arr[$k] = addslashes($v);
        }
        $queryarray = $arr;
    }
    $sql = "SELECT `sn`,`stu_name`,`update_time`, `uid` FROM " . $xoopsDB->prefix("yy_student") . " WHERE 1";
    if ($userid != 0) {
        $sql .= " AND uid=" . $userid . " ";
    }
    if (is_array($queryarray) && $count = count($queryarray)) {
        $sql .= " AND ((`stu_name` LIKE '%{$queryarray[0]}%'  OR `family_profile` LIKE '%{$queryarray[0]}%' )";
        for ($i = 1; $i < $count; $i++) {
            $sql .= " $andor ";
            $sql .= "(`stu_name` LIKE '%{$queryarray[$i]}%' OR  `family_profile` LIKE '%{$queryarray[$i]}%' )";
        }
        $sql .= ") ";
    }
    $sql .= "ORDER BY  `create_time` DESC";
    $result = $xoopsDB->query($sql, $limit, $offset);
    $ret    = array();
    $i      = 0;
    while ($myrow = $xoopsDB->fetchArray($result)) {
        $ret[$i]['image'] = "images/icons/on.png";
        $ret[$i]['link']  = "index.php?sn=" . $myrow['sn'];
        $ret[$i]['title'] = $myrow['stu_name'];
        $ret[$i]['time']  = strtotime($myrow['create_time']);
        $ret[$i]['uid']   = $myrow['uid'];
        $i++;
    }
    return $ret;
}
