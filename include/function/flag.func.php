<?php
/*
取得旗標的是否開啟
arg1 : 旗標變數
arg2 : 旗標位置
*/
function Get_Flag($flag, $seq)
{
    //檢查傳入的參數是否正確//
    if($seq < 1 || ($seq > (getBitCount() - 1 )))
    {
        echo '[ERROR]旗標位置小於1,或者大於系統('.getBitCount().'-1)bits!!';
        return false;
    }
    if(is_string($flag))
    {
        $flag = Bin2Dec($flag);
    }
    //將旗標位置位移至第一位 & mask 1後取值//
    if(($flag >> ($seq - 1)) & 1)
    {
        return true;
    }
    else 
    {
        return false;
    }
}
/*
開啟旗標
arg1 : 旗標變數
arg2 : 旗標位置
*/
function Flag_ON(&$flag, $seq)
{
    //檢查傳入的參數是否正確//
    if($seq < 1 || ($seq > (getBitCount() - 1 )))
    {
        echo '[ERROR]旗標位置小於1,或者大於系統('.getBitCount().'-1)bits!!';
        return false;
    }
    if(is_string($flag))
    {
        $flag = Bin2Dec($flag);
    }
    //檢查該旗標是否開啟//
    if(!Get_Flag($flag, $seq))
    {
        //該旗標關閉//
        $offset = 1 << ($seq - 1);
        $flag += $offset;
    }
    return true;
}
/*
關閉旗標
arg1 : 旗標變數
arg2 : 旗標位置
*/
function Flag_OFF(&$flag, $seq)
{
    //檢查傳入的參數是否正確//
    if($seq < 1 || ($seq > (getBitCount() - 1 )))
    {
        echo '[ERROR]旗標位置小於1,或者大於系統('.getBitCount().'-1)bits!!';
        return false;
    }
    if(is_string($flag))
    {
        $flag = Bin2Dec($flag);
    }
    //檢查該旗標是否開啟//
    if(Get_Flag($flag, $seq))
    {
        $flagLength = strlen(decbin($flag));
        //該旗標關閉//
        $offset = sprintf("%'1".($flagLength-$seq)."s%'1-".($seq)."s","",0);
        $offset = bindec($offset);
        $flag &= $offset;
    }
    return true;
}

//檢查是否為2進位字串//
function CheckBin($binString)
{
    if(ereg("^[0-1]*$", $binString))
    {
        return true;
    }
    else 
    {
        return false;
    }
}

/*
Is PHP running  32-bit or 64-bit?
Sure, we can look at the max int, but  The Weird Number
also tells if we are in 32-bit, 64-bit, or ...
*/
function getBitCount() {
    $how_many_bits = 1;
    $n = 2;
    while( True )
    {
        $how_many_bits += 1;  $n *= 2;  # powers of 2
        # matches its own two's complement?
        if( sprintf("%b", $n) == sprintf("%b", -$n)  )
            return 1 + $how_many_bits;
    }
    return;
}

/*
For converting larger-than-31-bit numbers: 
*/
function Bin2Dec($binstring) { 
    for ($i=0;$i<strlen($binstring);$i++)
    {
       $decvalue += ((int) substr($binstring, strlen($binstring) - $i - 1, 1)) * pow(2, $i);
    }
    return $decvalue;
} 
?>