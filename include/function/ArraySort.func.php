<?php
/***********************************************************************************************/
/* 函式名稱：ArraySort($str_,$sort_type)
/* 函式參數：$str_      : 排序之陣列
/*          $sort_type : 排序方式 1:由小到大 2:由大到小
/* 回傳值  ：array(按照value大小排列)
/* 函式功能：陣列排序
/***********************************************************************************************/
function & ArraySort($str_,$sort_type) {
	if (func_num_args() != 2) die("參數錯誤!!");
	//陣列的VALUE陣列//
	$val_[] = array_values($str);
	//陣列的KEY陣列//
	$key_[] = array_keys($str);

	switch($sort_type){
		case '1':
			for ($i = 1; $i < count ($val_); $i++) {
				$index = $val_[$i];
				$kindex = $key_[$i];
				$j = $i;
				while (($j > 0) && ($val_[$j - 1] > $index)) {
					$val_[$j] = $val_[$j - 1];
					$key_[$j] = $key_[$j - 1];
					$j = $j - 1;
				}
				$val_[$j] = $index;
				$key_[$j] = $kindex;
			}
		break;
		case '2':
			for ($i = 1; $i < count ($val_); $i++) {
				$index = $val_[$i];
				$kindex = $key_[$i];
				$j = $i;
				while (($j > 0) && ($val_[$j - 1] < $index)) {
					$val_[$j] = $val_[$j - 1];
					$key_[$j] = $key_[$j - 1];
					$j = $j - 1;
				}
				$val_[$j] = $index;
				$key_[$j] = $kindex;
			}
		break;
	}
	foreach ($val_ as $key => $val) {
		$new_[$key_[$key]] = $val;
	}
	return $new_;
}
?>