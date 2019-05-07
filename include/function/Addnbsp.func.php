<?php
function Addnbsp($str)
{
    if(empty($str))
    {
        $str = '&nbsp;';
    }
    return $str;
}

function AddChSpace($str)
{
    if(empty($str))
    {
        $str = '　';
    }
    return $str;    
}
?>