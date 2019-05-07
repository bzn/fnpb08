<?php
/*******************************************************************************************
DATE      : 
AUTHOR    : 
COPYRIGHT : 

MYSQLI CLASS 
******************************************************************************************/
class SQLObji{
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
    public  $QueryString = '';
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
            /*
            $this->Link_ID = mysqli_init();
            mysqli_real_connect($this->Link_ID,"$this->Host", "$this->User", "$this->Password", "$this->DataBase");
            */
            $this->Link_ID = mysqli_connect("$this->Host", "$this->User", "$this->Password");
            //CHECK CONNECT ERROR//
            if (mysqli_connect_errno()) {
                printf("Connect failed: %s\n", mysqli_connect_error());
                exit();
            }
            else
            {
                //select a database//
                $this->SelectDB($this->DataBase);
                //MySQL 5.x or newer use//
                $this->RunSQL("SET NAMES utf8");
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
            if(!(mysqli_select_db( $this->Link_ID, $D_DB)))
            {
                print('<br>[<font color="red">Error</fonr>] Select database => '.$D_DB);
                print('<br>[<font color="red">Error</fonr>]'.mysqli_error($this->Link_ID));
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
        if(!$this->Link_ID)
        {
            $this->connect();
        }
        $this->Result = mysqli_query($this->Link_ID, $Query_String);
        if(!$this->Result)
        {
            print('<br>[<font color="red">Error</font>] Query_String : '.$Query_String);
            print('<br>[<font color="red">Error</font>] '.mysqli_error());
        }
        if($this->Debug)
        {
            print('<br>[<font color="blue">Debug Msg</font>] Qeury_String : '.$Query_String.'<br>');
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
        //FREE SQL RESULT//
        $this->FreeResult();
        //CLEAR DATA BUFFER//
        $this->UnsetData();
        //GET COUNT OF ROWS & FIELDS//
        $this->NumRows   = $this->GetNumRows();
        if($this->NumRows > 0)
        {
            //DATA SEEK//
            mysqli_data_seek($this->Result, 0);
            mysqli_field_seek($this->Result, 0);
            //FETCH ARAAY//
            $val = mysqli_fetch_array($this->Result, MYSQLI_BOTH);
            //FETCH FIELD//
            $fieldArray = mysqli_fetch_fields($this->Result);
            foreach ($fieldArray as $field)
            {
                $this->Data[strtolower($field->name)]     = $val[$field->name];
                $this->Data1[0][strtolower($field->name)] = $val[$field->name];
                //$this->Data1[0][strtoupper($field->name)] = $val[$field->name];
                if($this->Debug)
                {
                    print('<br>[<font color="blue">Debug Msg</font>] ['.$field->name.'] => ['.$val[$field->name].']');
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
        //FREE SQL RESULT//
        $this->FreeResult();
        //CLEAR DATA BUFFER//
        $this->UnsetData();
        //GET COUNT OF ROWS & FIELDS//
        $this->NumFields = $this->GetNumFields();
        $this->NumRows   = $this->GetNumRows();
        if($this->NumRows > 0)
        {
            //DATA SEEK//
            mysqli_data_seek($this->Result, 0);
            mysqli_field_seek($this->Result, 0);
            for($i_row = 0 ; $i_row < $this->NumRows ; $i_row++)
            {
                $val = mysqli_fetch_array($this->Result, MYSQLI_ASSOC);
                //FETCH FIELD//
                $fieldArray = mysqli_fetch_fields($this->Result);
                foreach ($fieldArray as $field)
                {
                    $this->Data[strtolower($field->name)][$i_row]  = $val[$field->name];
                    $this->Data1[$i_row][strtolower($field->name)] = $val[$field->name];
                    //$this->Data1[$i_row][strtoupper($field->name)] = $val[$field->name];
                    if($this->Debug)
                    {
                        print('<br>[<font color="blue">Debug Msg</font>] ['.$field->name.'] => ['.$val[$field->name].']');
                    }
                }
            }
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
        //FREE SQL RESULT//
        $this->FreeResult();
        //RUN SQL BY PAGE//
        $this->RunSQL($this->QueryString.' LIMIT '.$start.','.$rows_per_page.' ');
        //GET COUNT OF ROWS & FIELDS//
        $this->NumFields = $this->GetNumFields();
        $this->NumRows   = $this->GetNumRows();
        if($this->NumRows > 0)
        {
            //DATA SEEK//
            mysqli_data_seek($this->Result, 0);
            mysqli_field_seek($this->Result, 0);
            for($i_row = 0 ; $i_row < $this->NumRows ; $i_row++)
            {
                $val = mysqli_fetch_array($this->Result, MYSQLI_BOTH);
                //FETCH FIELD//
                $fieldArray = mysqli_fetch_fields($this->Result);
                foreach ($fieldArray as $field)
                {
                    $this->Data[strtolower($field->name)][$i_row]  = $val[$field->name];
                    $this->Data1[$i_row][strtolower($field->name)] = $val[$field->name];
                    //$this->Data1[$i_row][strtoupper($field->name)] = $val[$field->name];
                    if($this->Debug)
                    {
                        print('<br>[<font color="blue">Debug Msg</font>] ['.$field->name.'] => ['.$val[$field->name].']');
                    }
                }
            }
            //FREE SQL RESULT//
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
            $num_row = mysqli_num_rows($this->Result);
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
        if(is_resource($this->Result))
        {
            $num_field = mysqli_num_fields($this->Result);
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
            mysqli_close($this->Link_ID);
        }
    }
    
    /******************************************************************************
     * FREE RESULT
    ******************************************************************************/
    public function FreeResult()
    {
        if(is_resource($this->Result))
        {
            mysqli_free_result($this->Result);
        }
    }
    
    /******************************************************************************
     * SET CONNECT WITH A LINK SESSION ID
    ******************************************************************************/
    public function SetConnection($link_id)
    {
        if(is_resource($link_id))
        {
            $this->Link_ID = $link_id;
        }
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
        return $this->Data1[strtolower($current_row)];
    }
}
?>