<?php
/*******************************************************************************************
DATE      : 
AUTHOR    : 
COPYRIGHT : 
*******************************************************************************************/
class text{
    public $contenet_text = '';
    public function printtext()
    {
        print($this->contenet_text);
    }
    public function settext($text = '')
    {
        $this->contenet_text = $text;
    }
}

class html{
    public $title      = '';
    public $meta       = '';
    public $css        = '';
    public $javascript = '';
    public function html()
    {
        $this->title      = new text();
        $this->meta       = new text();
        $this->css        = new text();
        $this->javascript = new text();
    }
    
    public function settext($title = '', $meta = '', $css = '', $javascript = '')
    {
        $this->title->settext($title);
        $this->meta->settext($meta);
        $this->css->settext($css);
        $this->javascript->settext($javascript);
    }
}
?>