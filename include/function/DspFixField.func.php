<?php
/*******************************************************************************************
DATE      : 
AUTHOR    : 
COPYRIGHT : 
*******************************************************************************************/

function DspFixField ($field = '', $num = 10)
{
	if (mb_strlen($field, "UTF-8") > $num)
	{
		$rString = '<a ONMOUSEOVER="return overlib(\''.$field.'\', 300, 120, HAUTO, VAUTO)" onMouseOut="nd();">'.mb_substr($field,0,$num,"UTF-8").'...</a>';
	}
	else
	{
		$rString = $field;
	}
	return $rString;
}
?>