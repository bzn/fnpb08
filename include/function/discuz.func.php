<?php
function get_threads_by_fid($sqlobj, $fid, $cnt = 5)
{
    $r_array = array();
    if(!$sqlobj || $fid < 1) return $r_array;
    $sqlstr = 'SELECT `tid`,`subject`,`dateline`,`lastpost`,`author` FROM `mumutoys_npbdiscuz`.`cdb_threads` 
               WHERE 1 AND `fid`='.$fid.' 
               ORDER BY `lastpost` DESC,`tid` DESC 
               LIMIT 0,'.$cnt;
    $sqlobj->RunSQL($sqlstr);
    if($nrows = $sqlobj->LinkAll())
    {
        for($i = 0 ; $i < $nrows ; $i++)
        {
            $row = $sqlobj->GetData1($i);
            $r_array[$i]['subject']  = $row['subject'];
            $r_array[$i]['link']     = 'http://npb.ohdada.com/discuz/viewthread.php?tid='.$row['tid'];
            $r_array[$i]['lastpost'] = date("Y-m-d", $row['lastpost']);
            $r_array[$i]['author']   = $row['author'];
        }
    }
    return $r_array;
}
?>