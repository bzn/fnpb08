<?php
/*********************************************************************************************
DATE      : 
AUTHOR    : 
COPYRIGHT : 
*********************************************************************************************/
function TreeArrayToString($ArrayTreeNodeGrp = array(), $upno = 0, $ArrayTreeNodeGrm)
{
    if(count($ArrayTreeNodeGrp[$upno]) > 0)
    {
        if($upno > 0) $js = ',';
        //是否有下個群組(節點)的旗標//
        $isNextGrp = false;
        foreach ( $ArrayTreeNodeGrp[$upno] as $key => $value )
        {
            //如果有下個群組(節點)的話就加逗號(,) , 跑第一次先把旗標ON//
            if($isNextGrp) $js .= ','; else $isNextGrp = true;
            //群組目錄//
            if($value['name'] != 'null')  $value['name']  = '\''.$value['name'].'\'';
            if($value['url'] != 'null')   $value['url']   = '\''.$value['url'].'\'';
            if($value['frame'] != 'null') $value['frame'] = '\''.$value['frame'].'\'';
            $js .= '['.$value['name'].','.$value['url'].','.$value['frame'].'';
            //往下找是否有在該群組(節點)內的群組(節點)//
            $js .= TreeArrayToString($ArrayTreeNodeGrp, $key, $ArrayTreeNodeGrm);
            //目錄(程式)//
            if(count($ArrayTreeNodeGrm[$key]) > 0)
            {
                $js .= ',';
                //是否有下個目錄(程式)的旗標//
                $isNextGrm = false;
                foreach($ArrayTreeNodeGrm[$key] as $value1)
                {
                    //如果有下個目錄(程式)的話就加逗號(,) , 跑第一次先把旗標ON//
                    if($isNextGrm) $js .= ','; else $isNextGrm = true;
                    if(empty($value1['url']))   $value1['url']   = '../system/board/index.php';
                    if(empty($value1['frame'])) $value1['frame'] = 'mainFrame';
                    $js .= '[\''.$value1['name'].'\',\''.$value1['url'].'\',\''.$value1['frame'].'\']';
                }
            }
            $js .= ']';
        }
        //根群組(節點)的目錄(程式)//
        if($upno == 0)
        {
            if(count($ArrayTreeNodeGrm[0]) > 0)
            {
                $js .= ',';
                foreach($ArrayTreeNodeGrm[0] as $value1)
                {
                    $js .= '[\''.$value1['name'].'\',\''.$value1['url'].'\',\''.$value1['frame'].'\'],';
                }
            }          
        }
    }
    return $js;
}
?>