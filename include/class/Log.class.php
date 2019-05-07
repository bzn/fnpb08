<?php
/*********************************************************************************************
DATE      : 
AUTHOR    : 
COPYRIGHT : 
REQUIRE   :

*********************************************************************************************/
class Log{
    //SQL OBJECT//
    private $SQLObj;
    //TABLE NAME//
    private $TableName;
    //DATABASE NAME//
    private $DatabaseName;
    //LOG IN USER ID//
    private $LoginUserId;
    /*
    CONSTRUCTOR
    ARG1 : SQL DB LINK ID
    ARG2 : LOG DB NAME
    ARG3 : LOG IN USER ID
    */
    public function __construct($SQLObj, $DB_NAME , $USER_ID)
    {
        $this->SQLObj       = $SQLObj;
        $this->DatabaseName = $DB_NAME;
        $this->LoginUserId  = $USER_ID;
        $this->TableName    = $this->getTableName();
        $this->CreateLogTable();
    }
    /*
    取得寫入的table名稱(依照西元年月YYYYMM命名)
    */
    private function getTableName()
    {
        $tableName = 'log'.date("Y").date("m");
        return $tableName;
    }
    /*
    建立LOG TABLE
    */
    private function CreateLogTable()
    {
        if($this->SQLObj)
        {
            $sqlstr = '
            CREATE TABLE IF NOT EXISTS `'.$this->DatabaseName.'`.`'.$this->TableName.'` (
            `serno` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            `loginid` INT( 10 ) NOT NULL ,
            `logtime` DATETIME NOT NULL ,
            `dirname` CHAR( 50 ) NOT NULL,
            `command` TEXT NOT NULL 
            ) ENGINE = MYISAM ;
            ';
            $this->SQLObj->RunSQL($sqlstr);
        }
        else 
        {
        	echo '[<font color="red">ERROR</font>]$this->SQLObj is not a object.';
        }
    }
    /*
    將log資料寫入資料庫
    */
    public function save($dirname = '', $command = '')
    {
        if($this->SQLObj && strlen($command) > 0)
        {
            $sqlstr = '
            INSERT INTO `'.$this->DatabaseName.'`.`'.$this->TableName.'`(loginid, logtime, dirname, command) 
            VALUES(\''.$this->LoginUserId.'\',NOW(),\''.$dirname.'\',\''.$command.'\')';
            $this->SQLObj->RunSQL($sqlstr);
        }
        else 
        {
        	echo '[<font color="red">ERROR</font>]$this->SQLObj is not a object.';
        }
    }
}
?>