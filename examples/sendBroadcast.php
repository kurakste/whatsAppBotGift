<?php
require_once '../vendor/autoload.php';
require_once '../helpers/vd.php';

use Viber\Client;
use Viber\Api\Bmessage\Text;
use Viber\Api\Sender;

$broadcast = ['Pb3NHeJ54AqxpiqhnmFKKg', 'SrzcHSfkHwNiypzY2pNe2A=='];
$msg = 'Hello! It\'s a broadcast message';
$name = 'Admin'; 

$config = require('./config.php');

$apiKey = $config['apiKey']; // from PA "Edit Details" page

$botSender = new Sender([
    'name' => $name,
    'avatar' => 'https://whatsism.com/uploads/posts/2018-05/thumbs/1525351974_kung_fu_panda.jpg',
]);

$bmessage = (new \Viber\Api\Bmessage\Text())
    ->setSender($botSender)
    ->setBroadcastList($broadcast)
    ->setText($msg);

//vd($bmessage);

try {
    echo "sending request...";
    $client = new Client(['token' => $apiKey]);
    $client->sendBroadcast($bmessage);

} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
}
