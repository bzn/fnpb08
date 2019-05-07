<?php
class Combo{
    //INPUT NAME//
    private $InputName;
    //INPUT SIZE//
    private $InputSize      = 12;
    //INPUT MAXLENGTH//
    private $InputMaxLength = 12;
    //INPUT STYLE//
    private $InputStyleStr;
    //BUTTON TYPE 1: TEXT 2: IMG//
    private $BtnType        = 1;
    //BUTTON IMG TEXT//
    private $BtnText        = '▼';
    //BUTTON CLASS//
    private $BtnClassName   = 'class_btn';
    //BUTTON IMG SRC//
    private $BtnImgSrc;
    //BUTTON STYLE//
    private $BtnStyleStr;
    //DIV NAME//
    private $DivName;
    /*
    CONSTRUCTOR
    @PARAM1 INPUT NAME & ID
    @PARAM2 DIV NAME & ID
    */
    public function __construct($input_name = 'ComboInput', $div_name = 'ComboDiv')
    {
        static $ObjCount;
        $ObjCount++;
        if($input_name === 'ComboInput') $this->InputName = $input_name . $ObjCount;
        else                             $this->InputName = $input_name;
        if($div_name === 'ComboDiv')     $this->DivName   = $div_name . $ObjCount;
        else                             $this->DivName   = $div_name;
    }
    /*
    SET INPUT ATTRIBUTES
    @PARAM1 INPUT SIZE
    @PARAM2 INPUT MAXLENGTH
    @PARAM3 INPUT STYLE
    */
    public function SetInputAttr($size = 12, $maxlength = 12, $style = '')
    {
        if($size != 12)      $this->InputSize      = $size;
        if($maxlength != 12) $this->InputMaxLength = $maxlength;
        if($style)           $this->InputStyleStr  = $style;
    }
    /*
    SET BUTTON ATTRIBUTES
    @PARAM1 BUTTON TYPE 1:TEXT 2:IMG
    @PARAM2 TYPE 1 => TEXT , TYPE 2 => IMAGE SRC
    */
    public function SetBtnAttr($type = 1, $set = '▼', $style = '')
    {
        $this->BtnType     = $type;
        $this->BtnStyleStr = $style;
        switch ($type)
        {
            case 1 :
                $this->BtnText     = $set;
                break;
            case 2 :
                $this->BtnImgSrc = $set;
                break;
        }
    }
    /*
    */
    public function GetComboString($list = array(), $default = '')
    {
        //INPUT//
        $html  = '<input type="text" 
                    value="'.$default.'" 
                    id="'.$this->InputName.'" 
                    name="'.$this->InputName.'" 
                    size="'.$this->InputSize.'" 
                    maxlength="'.$this->InputMaxLength.'" 
                    style="'.$this->InputStyleStr.'">';
        //BUTTON//
        switch ($this->BtnType)
        {
            case 1 :
                $html .= '<input type="button" value="'.$this->BtnText.'" style="'.$this->BtnStyleStr.'" class="class_btn" 
                            onclick="SwitchComboList(\''.$this->DivName.'\',\''.$this->InputName.'\');">';
                break;
            case 2 :
                $html .= '<img src="'.$this->BtnImgSrc.'" style="'.$this->BtnStyleStr.'" 
                            onclick="SwitchComboList(\''.$this->DivName.'\',\''.$this->InputName.'\');">';
                break;
        }
        //SELECT LIST//
        $html .= '<div id="'.$this->DivName.'" 
                   style="display    : none;
                          overflow   : auto;
                          position   : absolute;
                          top        : 0px;
                          left       : 0px;
                          width      : 90px;
                          height     : 100px;
                          border     : 1px solid #C0C0C0;
                          background : #FFFFFF;">';
        foreach ($list as $key => $val)
        {
            $html .= '<div 
                        onmouseover="this.style.backgroundColor=\'#0000FF\';this.style.color=\'#FFFFFF\';" 
                        onmouseout="this.style.backgroundColor=\'#FFFFFF\';this.style.color=\'#000000\';" 
                        onclick="GetListVal(\''.$val.'\',\''.$this->InputName.'\',\''.$this->DivName.'\');" 
                        style="width:100%;font:11px;">
                      '.$val.'
                      </div>';
        }
        $html .= '</div>';
        return $html;
    }
}
?>