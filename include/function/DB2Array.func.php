<?php
/*
從資料庫中取得資料轉成陣列
arg1 : SQL Object
arg2 : Table Name
arg3 : Column For Key   [ array( key => value ) ]
arg4 : Column For Value [ array( key => value ) ]
arg5 : SQL Statment
*/
function DB2Array($sqlobj, $TableName = '', $KeyCol = '', $ValCol = '', $Statement = '')
{
    $rArray = array();
    if(!is_object($sqlobj)) return $rArray;
    $sqlstr = 'SELECT `'.$KeyCol.'`,`'.$ValCol.'` FROM '.$TableName.' WHERE 1 '.$Statement;
    $sqlobj->RunSQL($sqlstr);
    if(($nrows = $sqlobj->LinkAll()) > 0)
    {
        for($i = 0 ; $i < $nrows ; $i++)
        {
            $row = $sqlobj->GetData1($i);
            $rArray[$row[strtolower($KeyCol)]] = $row[strtolower($ValCol)];
        }
    }
    return $rArray;
}
/*
從陣列array[key] = val 轉成HTML下拉(select)
arg1 : 來源陣列
arg2 : HTML下拉選項的name
arg3 : 預設的值
*/
function Array2Select(&$SrcArray = array(), $SelectName = '', $DefaultVal = '', $EmptyFirst = false, $Event = '')
{
    $rSelect  = '<select name="'.$SelectName.'" id="'.$SelectName.'" '.$Event.'>';
    if($EmptyFirst) $rSelect .= '<option  value=""></option>';
    foreach ($SrcArray as $key => $value)
    {
        ($DefaultVal == $key) ? $selected = 'selected' : $selected = '' ;
        $rSelect .= '<option '.$selected.' value="'.$key.'">'.$value.'</option>';
    }
    $rSelect .= '</select>';
    return $rSelect;
}
/*
從陣列array[key] = val 轉成HTML radio
arg1 : 來源陣列
arg2 : HTML radio選項的name
arg3 : 預設的值
*/
function Array2Radio(&$SrcArray = array(), $RadioName = '', $DefaultVal = '')
{
    $rRadio = '';
    foreach ($SrcArray as $key => $value)
    {
        ($DefaultVal == $key) ? $checked = 'checked' : $checked = '' ;
        $rRadio .= '<input type="radio" name="'.$RadioName.'" '.$checked.' value="'.$key.'">'.$value.' ';
    }
    return $rRadio;
}
/*
從陣列array[key] = val 轉成HTML checkbox
arg1 : 來源陣列
arg2 : HTML radio選項的name
arg3 : 預設的值(array)複選
*/
function Array2CheckBox(&$SrcArray = array(), $CheckBoxName = '', &$DefaultVal = array())
{
    $rCheckBox = '';
    foreach ($SrcArray as $key => $value)
    {
        (in_array($key, $DefaultVal)) ? $checked = 'checked' : $checked = '' ;
        $rCheckBox .= '<input '.$checked.' type="checkbox" name="'.$CheckBoxName.'[]" value="'.$key.'">'.$value.' ';
    }
    return $rCheckBox;
}
?>