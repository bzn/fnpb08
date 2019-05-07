<?php
function GetRandText($length = 1)
{
    $text = '';
    for($i = 0 ; $i < $length ; $i++)
    {
        $set = rand() % 1 ;
        switch ($set)
        {
            //文字型態(大寫)//
            case 0 :
                $ascii = rand(65,90);
                break;
            //數字型態//
            case 1 :
                $ascii = rand(49,57);
                break;
            //文字型態(小寫)//
            case 2 :
                $ascii = rand(97,122);
                break;
        }
        $text .= chr($ascii);
    }
    return $text;
}
?>