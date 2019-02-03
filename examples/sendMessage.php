<?php
require_once '../vendor/autoload.php';
require_once '../helpers/vd.php';
require_once '../helpers/fileCheckers.php';

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

$btns = require('./btns.php');

if (checkForFile()) {
    $message = packFileMessage();
    $message
        ->setSender($botSender)
        ->setReceiver($reciver);
} else {
    $message = (new \Viber\Api\Message\Text())
        ->setSender($botSender)
        ->setReceiver($reciver)
        ->setText($msg)
        ->setKeyboard(
            (new \Viber\Api\Keyboard())
                ->setButtons($btns)
            );
}

try {
    echo "sending request...";
    $client = new Client(['token' => $apiKey]);
    $client->sendMessage($message);
    echo 'done...';
    //var_dump($btns);

} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
}
