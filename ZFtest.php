<?php
require_once 'Zend.php';
require_once 'Zend/Debug.php';
require_once 'Zend/Http/Client.php';

$client = new Zend_Http_Client('http://baseball.yahoo.co.jp/npb/game/2007041801/');
$response = $client->request();


Zend_Debug::dump($response);

?>