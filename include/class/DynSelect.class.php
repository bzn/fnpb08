<?php
/*********************************************************************************************
DATE      : 
AUTHOR    : 
COPYRIGHT : 
REQUIRE   : prototype.js,
            dojo.js
*********************************************************************************************/
class DynSelect{
    private $SQLObj;
    //Master Select Id//
    private $mSelectId;
    //Master Select Data//
    private $mDataArray = array();
    //Slave Select Id//
    private $sSelectId;
    //Slave Select Data//
    private $sDataArray = array();
    /*
    CONSTRUCTOR
    arg1 : SQL Connect Obj
    arg2 : Master Select Id
    arg3 : Slave Select Id
    */
    public function __construct($sqlobj, $mId = '', $sId = '')
    {
        $this->SQLObj    = $sqlobj;
        $this->mSelectId = $mId;
        $this->sSelectId = $sId;
    }
    /*
    取得Master Select 的資料
    arg1 : 資料表名稱(department 或 SYSTEM.department)
    arg2 : Master Select的值(value)
    arg3 : Master Select的text(text)
    */
    public function MasterDataFromDB($TableName = '', $KeyColName = '', $ValueColName = '', $Statement = '')
    {
        $sqlstr = 'SELECT '.$KeyColName.','.$ValueColName.' FROM '.$TableName.' WHERE 1 '.$Statement;
        $this->SQLObj->RunSQL($sqlstr);
        if(($nrows = $this->SQLObj->LinkAll()) > 0)
        {
            for($i = 0 ; $i < $nrows ; $i++)
            {
                $row = $this->SQLObj->GetData1($i);
                $key = trim($row[$KeyColName]);
                $val = trim($row[$ValueColName]);
                $this->mDataArray[$key] = $val;
            }
        }
    }
    /*
    取得Slave Select 的資料
    arg1 : 資料表名稱(department 或 SYSTEM.department)
    arg2 : 與Master Select關聯的key欄位
    arg3 : Slave Select的值(value)
    arg4 : Slave Select的text(text)
    */
    public function SlaveDataFromDB($TableName = '', $mKeyColName = '', $sKeyColName = '', $sValueColName = '', $Statement = '')
    {
        $sqlstr = 'SELECT '.$mKeyColName.','.$sKeyColName.','.$sValueColName.' FROM '.$TableName.' WHERE 1 '.$Statement;
        $this->SQLObj->RunSQL($sqlstr);
        if(($nrows = $this->SQLObj->LinkAll()) > 0)
        {
            for($i = 0 ; $i < $nrows ; $i++)
            {
                $row = $this->SQLObj->GetData1($i);
                $mkey = trim($row[$mKeyColName]);
                $skey = trim($row[$sKeyColName]);
                $sval = trim($row[$sValueColName]);
                $this->sDataArray[$mkey][$skey] = $sval;
            }
        }
    }
    /*
    取得JS字串
    arg1 : Master Select 預設選定的值
    arg2 : Master Select 初始預設的Text
    arg3 : Slave Select 預設選定的值
    arg4 : Slave Select 初始預設的Text
    arg5 : Slave Selec 如果沒有選項時顯示的Text
    加上$this->mSelectId來達到多個動態下拉選單
    */
    public function getJString($mDefaultValue = '', $mDefaultText = '', $sDefaultValue = '', $sDefaultText = '', $sNullText = '')
    {
        //將Master,Slave陣列的資料串成JS的陣列字串//
        $js = '
        dojo.addOnLoad(setMaster_'.$this->mSelectId.');
        var mSelect_'.$this->mSelectId.'      = $(\''.$this->mSelectId.'\');
        mSelect_'.$this->mSelectId.'.onchange = setSlave_'.$this->mSelectId.';
        var sSelect_'.$this->mSelectId.'      = $(\''.$this->sSelectId.'\');
        var sKey_'.$this->mSelectId.' = new Array();
        var sVal_'.$this->mSelectId.' = new Array();
        ';
        if(count($this->mDataArray) > 0)
        {
            $i = 0;
            //Master資料To JS Array(加上雙引號丟入暫存陣列方便implode)//
            foreach($this->mDataArray as $key => $val)
            {
                $tmpArray['mKey'][$i] = '"'.$key.'"';
                $tmpArray['mVal'][$i] = '"'.$val.'"';
                if(count($this->sDataArray[$key]) > 0)
                {
                    $tmpArray['sKey']   = array();
                    $tmpArray['sVal']   = array();
                    //Slave資料To JS Array(加上雙引號丟入暫存陣列方便implode)//
                    foreach ($this->sDataArray[$key] as $key1 => $val1)
                    {
                        $tmpArray['sKey'][] = '"'.$key1.'"';
                        $tmpArray['sVal'][] = '"'.$val1.'"';
                    }
                    //Slave資料To JS Array//
                    $tmpString = implode(",", $tmpArray['sKey']);
                    $js .= '
                    sKey_'.$this->mSelectId.'['.$i.'] = new Array('.$tmpString.');
                    ';
                    $tmpString = implode(",", $tmpArray['sVal']);
                    $js .= '
                    sVal_'.$this->mSelectId.'['.$i.'] = new Array('.$tmpString.');
                    ';
                }
                $i++;
            }
            //Master資料To JS Array//
            $tmpString = implode(",", $tmpArray['mKey']);
            $js .= '
            var mKey_'.$this->mSelectId.' = new Array('.$tmpString.');
            ';
            $tmpString = implode(",", $tmpArray['mVal']);
            $js .= '
            var mVal_'.$this->mSelectId.' = new Array('.$tmpString.');
            ';
        }
        //設定Master下拉選項(選項從陣列1開始,0為預設顯示文字)//
        $js .= '
        function setMaster_'.$this->mSelectId.'()
        {
            var mLength = mKey_'.$this->mSelectId.'.length;
            mSelect_'.$this->mSelectId.'.options[0] = new Option("'.$mDefaultText.'", "");
            for(var i = 1 ; i <= mLength ; i++)
            {
                if(mKey_'.$this->mSelectId.'[i-1] == \''.$mDefaultValue.'\')
                {
                    mSelect_'.$this->mSelectId.'.options[i] = new Option(mVal_'.$this->mSelectId.'[i-1], mKey_'.$this->mSelectId.'[i-1], true, true);
                }
                else
                {
                    mSelect_'.$this->mSelectId.'.options[i] = new Option(mVal_'.$this->mSelectId.'[i-1], mKey_'.$this->mSelectId.'[i-1]);
                }
            }
            setSlave_'.$this->mSelectId.'();
        }';
        //設定Slave下拉選項(選項從陣列1開始,0為預設顯示文字)//
        $js .= '
        function setSlave_'.$this->mSelectId.'()
        {
            clearSlave_'.$this->mSelectId.'();
            if(mSelect_'.$this->mSelectId.'.selectedIndex > 0)
            {
                var sKeyList = sKey_'.$this->mSelectId.'[mSelect_'.$this->mSelectId.'.selectedIndex-1];
                var sValList = sVal_'.$this->mSelectId.'[mSelect_'.$this->mSelectId.'.selectedIndex-1];
                if(sKeyList)
                {
                    var sLength  = sKeyList.length;
                    sSelect_'.$this->mSelectId.'.options[0] = new Option("'.$sDefaultText.'", "");
                    for(var i = 1 ; i <= sLength ; i++)
                    {
                        if(sKeyList[i-1] == \''.$sDefaultValue.'\')
                        {
                            sSelect_'.$this->mSelectId.'.options[i] = new Option(sValList[i-1], sKeyList[i-1], true, true);
                        }
                        else
                        {
                            sSelect_'.$this->mSelectId.'.options[i] = new Option(sValList[i-1], sKeyList[i-1]);
                        }
                    }
                }
                else
                {
                    sSelect_'.$this->mSelectId.'.options[0] = new Option("'.$sNullText.'", "");
                }
            }
            else
            {
                sSelect_'.$this->mSelectId.'.options[0] = new Option("'.$sNullText.'", "");
            }
        }';
        //清除Slave的下拉選項//
        $js .= '
        function clearSlave_'.$this->mSelectId.'()
        {
            var sLength = sSelect_'.$this->mSelectId.'.options.length;
            for(var i = sLength - 1 ; i >= 0 ; i--)
            {
                sSelect_'.$this->mSelectId.'.options[i] = null;
            }
        }
        ';
        return $js;
    }
}
?>