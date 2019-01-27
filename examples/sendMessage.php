<?php
require_once '../vendor/autoload.php';
require_once '../helpers/vd.php';

use Viber\Client;
use Viber\Api\Message\Text;
use Viber\Api\Sender;

$reciver = $_GET ['reciver'];
$msg = $_GET ['msg'];
$name = $_GET['name']; 

$config = require('./config.php');

$apiKey = $config['apiKey']; // from PA "Edit Details" page

$botSender = new Sender([
    'name' => $name,
    'avatar' => 'https://whatsism.com/uploads/posts/2018-05/thumbs/1525351974_kung_fu_panda.jpg',
]);

$message = (new \Viber\Api\Message\Text())
    ->setSender($botSender)
    ->setReceiver($reciver)
    ->setText($msg);

try {
    echo "sending request...";
    $client = new Client(['token' => $apiKey]);
    $client->sendMessage($message);

} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
}
