<?php
function SendIM($to = array(), $msg = '')
{
    if(count($to) && !empty($msg))
    {
        //JABBER OBJECT//
        $JABBER = new Jabber; 
        //SERVER SETTINGS//
        $JABBER->server   = "ims.signet.com.tw";
        //$JABBER->server   = "dbm.cargo.com.tw";
        $JABBER->port     = 5222; 
        $JABBER->username = "admin"; 
        $JABBER->password = "admin"; 
        $JABBER->resource = "SIGNET IM"; 
        //CONNECT AND AUTHORIZED//
        $JABBER->Connect() or die("無法連線!!"); 
        $JABBER->SendAuth() or die("認證失敗!!"); 
        //SET PRESENCE//
        $JABBER->SendPresence(NULL, NULL, "online"); 
        //START TRANSPORT//
        //$JABBER->SendPresence(NULL,"msn.dbm.cargo.com.tw",NULL,NULL,"5");
        //$JABBER->CruiseControl(5);
        //SEND MESSAGE//
        foreach($to as $val)
        {
            if(strpos($val, "@") && !strpos($val, "%"))
            {
                $valArray = explode("@",$val);
                $val = $valArray[0].'%'.$valArray[1].'@msn.ims.signet.com.tw';
            }
            $msg .= '

此訊息為系統自動發送，請勿回覆!!
發送於：'.date("Y").' / '.date("m"). ' / '.date("d").'  '.date("h").' : '.date("i");
            
            $JABBER->Subscribe("$val");
            $JABBER->SendMessage("$val", "normal", NULL, array("body" => "$msg"));
        }
        //$JABBER->CruiseControl(5);
        //DISCONNECT//
        $JABBER->Disconnect();
    }
}
?>