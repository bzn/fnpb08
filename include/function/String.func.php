<?php
function RateFormat($rate)
{
    return sprintf("%.3f",$rate);
}

function BillFromat($serno)
{
    return sprintf("%010d",$serno);
}
?>