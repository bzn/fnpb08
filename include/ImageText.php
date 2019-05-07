<?php
header("Content-type:image/jpeg");
require("class/Image.class.php");
$im = new Image(64,26);
//設定背景顏色//
$im->SetColor(1,255,255,255);
//設定框架顏色//
$im->SetColor(2,0,0,0);
//增加雜訊//
$im->AddNoise(1,60);
$im->AddNoise(2,5);
//設定文字//
$text = $_GET['text'];
$im->AddText($text,24,10,5,0,0,0);
//輸出//
$im->Render(1);
?>