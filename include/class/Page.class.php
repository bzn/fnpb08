<?php
/*******************************************************************************************
DATE      : 
AUTHOR    : 
COPYRIGHT : 
*******************************************************************************************/
class Page{
    //start row//
    var $RowStart       = 0;
    //end row//
    var $RowEnd         = 0;
    //total rows//
    var $TotalRows      = 0;
    //total pages//
    var $TotalPages     = 0;
    //current_page//
    var $CurrentPage    = 0;
    //rows per page//
    var $RowsPerPage    = 0;
    //go page link string(連結換頁選單)//
    var $PageLinkStr    = '';
    //ten page link string(10頁快速連結)//
    var $PageTenLinkStr = '';
    //go page select string(下拉式換頁選單)//
    var $PageSelectStr  = '';
    /*
    CONSTRUCTOR
    par1 : SQL Result;
    par2 : 一頁要顯示幾列;
    */
    public function __construct($total_rows, $rows_per_page = 20)
    {
        if(($this->TotalRows = $total_rows) > 0)
        {
            $this->RowsPerPage = $rows_per_page;
            $this->TotalPages  = ceil($this->TotalRows / $rows_per_page);
        }
    }
    /*
    GoPage (到指定頁數的頁面)
    par1 : 欲前往的頁數
    */
    public function GoPage($page = 1)
    {
        if($this->TotalRows > 0)
        {
            if($page == 0 || empty($page)) $page = 1;
            elseif($page > $this->TotalPages) $page = $this->TotalPages;
            $this->CurrentPage = $page;
            $this->RowStart = ($this->CurrentPage - 1) * $this->RowsPerPage;
            if($this->CurrentPage == $this->TotalPages)
            {
                $this->RowEnd = $this->TotalRows;
            }
            elseif ($this->CurrentPage < $this->TotalPages)
            {
                $this->RowEnd = $this->CurrentPage * $this->RowsPerPage;
            }
        }
    }
    /*
    genPageHtml(產生三個html的換頁字串PageLinkStr,PageTenLinkStr,PageSelectStr)
    par1 : 1 => Link
           2 => AJAX
           3 => Submit
    par2 : Link URL後面所需要代的參數
    par3 : AJAX 的呼叫函式名稱(mode:2必須)
    */
    public function genPageHtml($mode = 1, $par = '', $javafunc = '')
    {
        if($this->TotalRows > 0)
        {
            $this->PageLinkStr    = '';
            $this->PageTenLinkStr = '';
            $this->PageSelectStr  = '';
            //一次顯示十頁//
            $begpage = ((ceil($this->CurrentPage / 10) - 1) * 10 + 1);
            $endpage = ((ceil($this->CurrentPage / 10) - 1) * 10 + 10);
            if($this->TotalPages < $endpage)
            {
                $endpage = $this->TotalPages;
            }
            switch ($mode)
            {
                //LINK URL 模式//
                case 1 :
                    //下拉式換頁選單//
                    $this->PageSelectStr .= '第';
                    $this->PageSelectStr .= '<select class="class_select" name="page" size="1" onchange="submit();">';
                    for($i = 1 ; $i <= $this->TotalPages ; $i++)
                    {
                        ($i == $this->CurrentPage) ? $select = 'selected' : $select ='' ;
                        $this->PageSelectStr .= '<option '.$select.' value="'.$i.'">'.$i.'</option>';
                    }
                    $this->PageSelectStr .= '</select> / '.$this->TotalPages.'頁';
                    //連結換頁選單(第一頁,上一頁,下一頁,最後頁)//
                    if($this->CurrentPage > 1)
                    {
                        $parstr = 'page=1&'.$par;
                        $parstr = base64_encode($parstr);
                        //$this->PageLinkStr .= '<input class="button4w" type="button" value="第一頁" onClick="location.href="'.$PHP_SELF.'?'.$parstr.';"> ';
                        $parstr = 'page='.($this->current_page - 1).'&'.$par;
                        $parstr = base64_encode($parstr);
                        $this->PageLinkStr .= '<input class="button4w" type="button" value="上一頁" onClick="location.href="'.$PHP_SELF.'?'.$parstr.';"> ';
                    }
                    if($this->CurrentPage < $this->TotalPages)
                    {
                        $parstr = 'page='.($this->CurrentPage + 1).'&'.$par;
                        $parstr = base64_encode($parstr);
                        $this->PageLinkStr .= '<input class="button4w" type="button" value="下一頁" onClick="location.href="'.$PHP_SELF.'?'.$parstr.';"> ';
                        $parstr = 'page='.($this->TotalPages).'&'.$par;
                        $parstr = base64_encode($parstr);
                        //$this->PageLinkStr .= '<input class="button4w" type="button" value="最後頁" onClick="location.href="'.$PHP_SELF.'?'.$parstr.';"> ';
                    }
                    //每次顯示10個快速換頁連結//
                    $this->PageTenLinkStr .= ' [ ';
                    for($i = $begpage ; $i <= $endpage ; $i++ )
                    {
                        if($i == $this->CurrentPage)
                        {
                            $this->PageTenLinkStr .= '<font class="eb11" color="#CE0000">'.$i.' </font>';
                        }
                        else
                        {
                            $parstr = 'page='.$i.'&'.$par;
                            $parstr = base64_encode($parstr);
                            $this->PageTenLinkStr .= '<a href="'.$PHP_SELF.'?'.$parstr.'"><font class="e11">'.$i.'</font> </a>';
                        }
                    }
                    $this->PageTenLinkStr .= ' ] ';
                    break;
                //AJAX模式//
                case 2 :
                    //下拉式換頁選單//
                    $this->PageSelectStr .= '第';
                    $this->PageSelectStr .= '<select class="class_select" name="page" size="1" onchange="'.$javafunc.'(this.value);">';
                    for($i = 1 ; $i <= $this->TotalPages ; $i++)
                    {
                        ($i == $this->CurrentPage) ? $select = 'selected' : $select ='' ;
                        $this->PageSelectStr .= '<option '.$select.' value="'.$i.'">'.$i.'</option>';
                    }
                    $this->PageSelectStr .= '</select> / '.$this->TotalPages.'頁';
                    //連結換頁選單(第一頁,上一頁,下一頁,最後頁)//
                    if($this->CurrentPage > 1)
                    {
                        //$this->PageLinkStr .= '<input class="button4w" type="button" value="第一頁" onClick="'.$javafunc.'(1)"> ';
                        $this->PageLinkStr .= '<input class="button4w" type="button" value="上一頁" onClick="'.$javafunc.'('.($this->CurrentPage - 1).')"> ';
                    }
                    if($this->CurrentPage < $this->TotalPages)
                    {
                        $this->PageLinkStr .= '<input class="button4w" type="button" value="下一頁" onClick="'.$javafunc.'('.($this->CurrentPage + 1).')"> ';
                        //$this->PageLinkStr .= '<input class="button4w" type="button" value="最後頁" onClick="'.$javafunc.'('.$this->TotalPages.')"> ';
                    }
                    //每次顯示10個快速換頁連結//
                    $this->PageTenLinkStr .= ' [ ';
                    for($i = $begpage ; $i <= $endpage ; $i++ )
                    {
                        if($i == $this->CurrentPage)
                        {
                            $this->PageTenLinkStr .= '<font class="eb11" color="#CE0000">'.$i.' </font>';
                        }
                        else
                        {
                            $this->PageTenLinkStr .= '<a onclick="'.$javafunc.'('.$i.')" onmouseover="style.cursor=\'hand\'"><font class="e11">'.$i.'</font> </a>';
                        }
                    }
                    $this->PageTenLinkStr .= ' ] ';
                    break;
                //Submit//
                case 3:
                    //下拉式換頁選單//
                    $this->PageSelectStr .= '第';
                    $this->PageSelectStr .= '<select class="class_select" name="page" size="1" onchange="submit();">';
                    for($i = 1 ; $i <= $this->TotalPages ; $i++)
                    {
                        ($i == $this->CurrentPage) ? $select = 'selected' : $select ='' ;
                        $this->PageSelectStr .= '<option '.$select.' value="'.$i.'">'.$i.'</option>';
                    }
                    $this->PageSelectStr .= '</select> / '.$this->TotalPages.'頁';
                    //連結換頁選單(上一頁,下一頁)//
                    if($this->CurrentPage > 1)
                    {
                        $this->PageLinkStr .= '<input class="class_btn" type="button" value="第一頁" onClick="FisrtPage(this.form);">　';
                        $this->PageLinkStr .= '<input class="class_btn" type="button" value="上一頁" onClick="PrevPage(this.form);">　';
                    }
                    if($this->CurrentPage < $this->TotalPages)
                    {
                        $this->PageLinkStr .= '<input class="class_btn" type="button" value="下一頁" onClick="NextPage(this.form,'.$this->TotalPages.');">　';
                        $this->PageLinkStr .= '<input class="class_btn" type="button" value="最後頁" onClick="LastPage(this.form,'.$this->TotalPages.');">　';
                    }
                    break;
            }
        }
    }
}
?>