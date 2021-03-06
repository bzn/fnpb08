<?php
/*******************************************************************************************
DATE      : 
AUTHOR    : 
COPYRIGHT : 

MYSQL CLASS 
******************************************************************************************/
class SQLObj{
    //BOOL FOR DEBUG MODE//
    private $Debug       = 0;
    //LINK SESSION ID//
    public  $Link_ID     = 0;
    //ARRAY OF DATA//
    private $Data        = array();
    //ARRAY OF DATA//
    private $Data1       = array();
    //NUMBER OF FIELD//
    private $NumFields   = 0;
    //NUMBER OF ROW//
    private $NumRows     = 0;
    //QUERY STRING//
    private $QueryString = '';
    //QUERY RESULT//
    public  $Result;
    //ARRAY OF COLUMN//
    private $Field       = array();
    //DB SETTINGS//
    private $Host        = '';
    private $DataBase    = '';
    private $User        = '';
    private $Password    = '';

    /******************************************************************************
     * DESTRUCTOR
    ******************************************************************************/
    public function __destruct()
    {
        $this->Disconnect();
    }
    
    /******************************************************************************
     * CONNECT TO SQL SERVER
    ******************************************************************************/
    public function connect($D_Host = null, $D_DB = null, $D_User = null, $D_Pass = null)
    {
        //DB settings//
        if(!empty($D_Host)) $this->Host     = $D_Host;
        if(!empty($D_DB))   $this->DataBase = $D_DB;
        if(!empty($D_User)) $this->User     = $D_User;
        if(!empty($D_Pass)) $this->Password = $D_Pass;
        if(0 == $this->Link_ID)
        {
            if($this->Debug)
            {
                print('<br>[Debug Msg] Connect to '.$this->Link_ID.'...<br>');
            }
            //connect to DB server//
            $this->Link_ID = mysql_connect("$this->Host", "$this->User", "$this->Password");
            if($this->Link_ID)
            {
                //select a database//
                $this->SelectDB($this->DataBase);
                //MySQL 5.x or newer use//
                $this->RunSQL("SET NAMES utf8");
            }
            else
            {
                //fail to connect to DB server//
                $this->Halt('<br>[Error] Link-ID == false ( '.$this->Link_ID.' ) SQL Server logon failed...<br>');
            }
            if($this->Debug)
            {
                print('<br>[Debug Msg] Obtained the Link_ID : '.$this->Link_ID.'<br>');
            }
        }
        else
        {
            //MySQL 5.x or newer use//
            $this->RunSQL("SET NAMES utf8");
        }
    }
    
    /******************************************************************************
     * SELECT A DATABASE
    ******************************************************************************/
    public function SelectDB($D_DB = '')
    {
        if(!empty($D_DB))
        {
            if(!(mysql_select_db($D_DB, $this->Link_ID)))
            {
                print('<br>[Error] Select database => '.$D_DB.'<br>');
            }
        }
    }
    
    /******************************************************************************
     * RUN SQL QUERY
    ******************************************************************************/
    public function RunSQL($Query_String)
    {
        $this->FreeResult();
        if(empty($Query_String))
        {
            print('<br>Error : SQL query string is empty!!<br>');
            return FALSE;
        }
        if(0 == $this->Link_ID)
        {
            $this->connect();
        }
        $this->Result = mysql_query($Query_String, $this->Link_ID);
        if(!$this->Result)
        {
            print('<br>[Error] <font color="#FF0000"><b>Query_String : '.$Query_String.'</b></font><br>');
            print('<br>[Error] <font color="#FF0000"><b>'.mysql_error().'</b></font>');
        }
        if($this->Debug)
        {
            print('<br>[Debug Msg] Qeury_String = '.$Query_String.'<br>');
        }
        $this->QueryString = $Query_String;
        return $this->Result;
    }
    
    /******************************************************************************
     * LINK NEXT DATA
    ******************************************************************************/
    public function LinkNext()
    {
        $stat = false;
        //Clear data buffer//
        $this->UnsetData();
        $this->NumRows   = $this->GetNumRows();
        $this->NumFields = $this->GetNumFields();
        if($this->NumRows > 0)
        {
            mysql_data_seek($this->Result, 0);
            mysql_field_seek($this->Result, 0);
            $val = mysql_fetch_array($this->Result, MYSQL_BOTH);
            for($i_field = 0 ; $i_field < $this->NumFields ; $i_field++)
            {
                $colname = mysql_field_name($this->Result, $i_field);
                $this->Data[strtolower($colname)]     = $val[$i_field];
                $this->Data1[0][strtolower($colname)] = $val[$i_field];
                if($this->Debug)
                {
                    print('<b>[Debug Msg] ['.strtoupper($colname).']</b> => ['.$val[$i_field].']<br>');
                }
            }
            $stat = true;
        }
        return $stat;
    }
    
    /******************************************************************************
     * LINK ALL DATA
    ******************************************************************************/
    public function LinkAll()
    {

        //Clear data buffer//
        $this->UnsetData();
        $this->NumFields = $this->GetNumFields();
        $this->NumRows   = $this->GetNumRows();
        if($this->NumRows > 0)
        {
            mysql_data_seek($this->Result, 0);
            mysql_field_seek($this->Result, 0);
            for($i_row = 0 ; $i_row < $this->NumRows ; $i_row++)
            {
                $val = mysql_fetch_array($this->Result, MYSQL_BOTH);
                for($i_field = 0 ; $i_field < $this->NumFields ; $i_field++)
                {
                    $colname = mysql_field_name($this->Result, $i_field);
                    $this->Data[strtolower($colname)][$i_row]  = $val[$i_field];
                    $this->Data1[$i_row][strtolower($colname)] = $val[$i_field];
                    if($this->Debug)
                    {
                        print('<b>[Debug Msg] ['.strtoupper($colname).']</b> => ['.$val[$i_field].']<br>');
                    }
                }
            }
            //FREE SQL RESULT//
            $this->FreeResult();
        }
        return $this->NumRows;
    }
    
    /******************************************************************************
     * LINK BY PAGE
    ******************************************************************************/
    function LinkPage($start, $rows_per_page)
    {
        //CLEAR DATA BUFFER//
        $this->UnsetData();
        //RUN SQL BY PAGE//
        $this->QueryString .= ' LIMIT '.$start.','.$rows_per_page.' ';
        $this->RunSQL($this->QueryString);
        //GET DATA//
        $this->NumFields = $this->GetNumFields();
        $this->NumRows   = $this->GetNumRows();
        if($this->NumRows > 0)
        {
            mysql_data_seek($this->Result, 0);
            for($i_row = 0 ; $i_row < $this->NumRows ; $i_row++)
            {
                $val = mysql_fetch_array($this->Result, MYSQL_BOTH);
                for($i_field = 0 ; $i_field < $this->NumFields ; $i_field++)
                {
                    $colname = mysql_field_name($this->Result, $i_field);
                    $this->Data[strtolower($colname)][$i_row]  = $val[$i_field];
                    $this->Data1[$i_row][strtolower($colname)] = $val[$i_field];
                    if($this->Debug)
                    {
                        print('<b>[Debug Msg] ['.strtoupper($colname).']</b> => ['.$val[$i_field].']<br>');
                    }
                }
            }
            //Free SQL result//
            $this->FreeResult();
        }
        return $this->NumRows;
    }
    
    /******************************************************************************
     * NUMBER OF ROWS
    ******************************************************************************/    
    public function GetNumRows()
    {
        if($this->Result)
        {
            $num_row = mysql_num_rows($this->Result);
        }
        else 
        {
            $num_row = 0;
        }
        return $num_row;
    }
    
    /******************************************************************************
     * NUMBER OF FIELDS
    ******************************************************************************/    
    public function GetNumFields()
    {
        if($this->Result)
        {
            $num_field = mysql_num_fields($this->Result);
        }
        else 
        {
            $num_field = 0;
        }
        return $num_field;
    }
    
    /******************************************************************************
     * DISCONNECT FROM DATABASE
    ******************************************************************************/
    public function Disconnect()
    {
        if(is_resource($this->Link_ID))
        {
            mysql_close($this->Link_ID);
        }
    }
    
    /******************************************************************************
     * FREE RESULT
    ******************************************************************************/
    public function FreeResult()
    {
        if(is_resource($this->Result))
        {
            mysql_free_result($this->Result);
        }
    }
    
    /******************************************************************************
     * SET CONNECT WITH A LINK SESSION ID
    ******************************************************************************/
    public function SetConnection($link_id)
    {
        $this->Link_ID = $link_id;
    }
    
    /******************************************************************************
     * LINK HALT
    ******************************************************************************/
    public function Halt($msg)
    {
        die('<br>Session halted...!!<br>'.mysql_error());
    }
    
    /******************************************************************************
     * CLEAR DATA BUFFER
    ******************************************************************************/
    public function UnsetData()
    {
        unset($this->Data);
        unset($this->Data1);
    }
    
    /******************************************************************************
     * GET DATA WITH COLUM NAME
    ******************************************************************************/
    public function GetData($colname)
    {
        return $this->Data[strtolower($colname)];
    }
    
    /******************************************************************************
     * GET DATA WITH FETCH_ARRAY
    ******************************************************************************/
    public function GetData1($current_row)
    {
        return $this->Data1[$current_row];
    }

    /******************************************************************************
     * SHOW ALL TABLES
    ******************************************************************************/
    public function ShowTables()
    {
        $this->Result = mysql_list_tables($this->DataBase);
        if($this->Result)
        {
            while($val = mysql_fetch_array($this->Result))
            {
                print('[ '.$val[0].' ]<br>');
            }
            //Free SQL result//
            $this->FreeResult();
        }
    }
    
    /******************************************************************************
     * SHOW PROCESS
    ******************************************************************************/
    public function ShowProcess()
    {
        if($this->Link_ID)
        {
            $this->Result = mysql_list_processes($this->Link_ID);
            while($row = mysql_fetch_assoc($this->Result))
            {
                print('[Id] => '.$row['Id'].' [Host] => '.$row['Host'].'<br>');
            }
            //Free SQL result//
            $this->FreeResult();
        }
    }
}
?>