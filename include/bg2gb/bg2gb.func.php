<?php
function ToGb($buffer)
{
    $obj = new big2gb;
    return $obj->chg_utfcode($buffer,'gb2312');
}

function ToBig5($buffer)
{
    $obj = new big2gb;
    return $obj->chg_utfcode($buffer,'big5');
}
?>