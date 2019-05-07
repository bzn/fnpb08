<?php
/*******************************************************************************************
DATE      : 2006/06/12
AUTHOR    : ahdai(alan@signet.com.tw)
COPYRIGHT : 新台旅行社(www.signet.com.tw)
*******************************************************************************************/
class MySmarty extends Smarty{
    public function __construct($setting = array())
    {
        $this->template_dir = $setting['template_dir'];
        $this->compile_dir  = $setting['compile_dir'];
    }
}
?>