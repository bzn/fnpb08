<?php
class Image{
    //宣告畫紙//
    private $Paper;
    private $Height;
    private $Width;
    //建構子//
    public function __construct($width, $height)
    {
        $this->SetPaperRange($width, $height);
    }
    /*
    設定畫紙長寬
    */
    public function SetPaperRange($width, $height)
    {
        if(intval($width) > 0 ) $this->Width = $width;
        if(intval($height) > 0 ) $this->Height = $height;
        $this->Paper = imagecreatetruecolor($width,$height);
    }
    /*
    設定顏色
    */
    public function SetColor($mode, $r, $g, $b)
    {
        $color = $this->GetColor($r, $g, $b);
        switch ($mode)
        {
            //背景色 background//
            case 1 :
                imagefill($this->Paper, 0, 0, $color);
                break;
            //外框顏色 border//
            case 2 :
                imagerectangle($this->Paper, 1, 1, $this->Width-1, $this->Height-1, $color);
                break;
        }
    }
    /*
    加入雜訊
    */
    public function AddNoise($mode, $amount = 1)
    {
        switch ($mode)
        {
            //點//
            case 1 :
                for($i = 0 ; $i < $amount ; $i++)
                {
                     $color = $this->GetRandColor();
                     imagesetpixel($this->Paper, rand(1,$this->Width), rand(1,$this->Height), $color);
                }
                break;
            //線//
            case 2 :
                for($i = 0 ; $i < $amount ; $i++)
                {
                    $color = $this->GetRandColor(150);
                    imageline($this->Paper,
                               rand(1,$this->Width),
                               rand(1,$this->Height),
                               rand(1,$this->Width),
                               rand(1,$this->Height),
                               $color
                    );
                }
                break;
        }
    }
    /*
    取得顏色值
    */
    public function GetColor($r, $g, $b)
    {
        $color = imagecolorallocate($this->Paper, $r, $g, $b);
        return $color;
    }
    /*
    取得隨機顏色
    */
    public function GetRandColor($offset = 0)
    {
        $color = imagecolorallocate($this->Paper, rand($offset,255), rand($offset,255), rand($offset,255));
        return $color;
    }
    /*
    增加文字
    */
    public function AddText($text, $size, $x, $y, $r, $g, $b)
    {
        $color = $this->GetColor($r, $g, $b);
        imagestring($this->Paper, $size, $x, $y, $text, $color);
    }
    /*
    輸出
    */
    public function Render($filetype)
    {
        switch ($filetype)
        {
            //JPG//
            case 1 :
                imagejpeg($this->Paper);
                break;
            //GIF//
            case 2 :
                imagegif($this->Paper);
                break;
            //BMP//
            case 3 :
                imagewbmp($this->Paper);
                break;
            //PNG//
            case 3 :
                imagepng($this->Paper);
                break;
        }
    }
}
?>