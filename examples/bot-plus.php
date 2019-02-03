<?php

/**
 * Before you run this example:
 * 1. install monolog/monolog: composer require monolog/monolog
 * 2. copy config.php.dist to config.php: cp config.php.dist config.php
 *
 * @author Novikov Bogdan <hcbogdan@gmail.com>
 */

require_once("../vendor/autoload.php");

use Viber\Bot;
use Viber\Api\Sender;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use function GuzzleHttp\json_decode;

$config = require('./config.php');
$apiKey = $config['apiKey'];

// reply name
$botSender = new Sender([
    'name' => 'Demo bot',
    'avatar' => 'https://developers.viber.com/images/favicon.ico',
]);

// log bot interaction
$log = new Logger('bot');
$log->pushHandler(new StreamHandler('/tmp/bot.log'));

$buttons = [];
for ($i = 0; $i <= 8; $i++) {
    $buttons[] =
        (new \Viber\Api\Keyboard\Button())
            ->setColumns(1)
            ->setActionType('reply')
            ->setActionBody('k' . $i)
            ->setText('k' . $i);
}

try {
    // create bot instance
    $bot = new Bot(['token' => $apiKey]);
    $bot
        // first interaction with bot - return "welcome message"
        ->onConversation(function ($event) use ($bot, $botSender, $log, $buttons) {
            $log->info('onConversation handler');
            return (new \Viber\Api\Message\Text())
                ->setSender($botSender)
                ->setText("Hi, you can see some demo: send 'k1' or 'k2' etc.")
                ->setKeyboard(
                    (new \Viber\Api\Keyboard())
                        ->setButtons($buttons)
                );
        })
        // when user subscribe to PA
        ->onSubscribe(function ($event) use ($bot, $botSender, $log) {
            $log->info('onSubscribe handler');
            $this->getClient()->sendMessage(
                (new \Viber\Api\Message\Text())
                    ->setSender($botSender)
                    ->setText('Thanks for subscription!')
            );
        })
        ->onText('|menu|s', function ($event) use ($bot, $botSender, $log) {
            $log->info('menu method');
            $log->info('tracking data:'.$event->getMessage()->getTrackingData());
            $log->info('message:'.$event->getMessage()->getText());

            $data = json_decode($event->getMessage()->getTrackingData());

            if (!isset($data['counter'])) {
                $data = [];
                $data['counter'] = 0;
            }
            $data['counter'] = ++$data['counter'];
            $log->info('counter!:'.$data['counter']);

            $bot->getClient()->sendMessage(
                (new \Viber\Api\Message\Text())
                    ->setSender($botSender)
                    ->setReceiver($event->getSender()->getId())
                    ->setTrackingData(json_encode(['counter'=>1]))
                    ->setText('Hi from menu')
                    ->setKeyboard(
                        (new \Viber\Api\Keyboard())
                            ->setButtons([
                                (new \Viber\Api\Keyboard\Button())
                                    ->setBgColor('#8074d6')
                                    ->setColumns(3)
                                    ->setTextSize('small')
                                    ->setTextHAlign('right')
                                    ->setActionType('reply')
                                    ->setActionBody('menu-sub-1')
                                    ->setText('subMenu 1'),

                                (new \Viber\Api\Keyboard\Button())
                                    ->setBgColor('#2fa4e7')
                                    ->setColumns(3)
                                    ->setTextHAlign('center')
                                    ->setActionType('reply')
                                    ->setActionBody('menu-sub-2')
                                    ->setText('subMenu 2'),
                                (new \Viber\Api\Keyboard\Button())
                                    ->setBgColor('#2fa4e7')
                                    ->setColumns(6)
                                    ->setTextHAlign('center')
                                    ->setActionType('reply')
                                    ->setActionBody('btn-click')
                                    ->setText('To main menu'),
                            ])
                    )
            );
        })
        ->run();
} catch (Exception $e) {
    $log->warning('Exception: ' . $e->getMessage());
    if ($bot) {
        $log->warning('Actual sign: ' . $bot->getSignHeaderValue());
        $log->warning('Actual body: ' . $bot->getInputBody());
    }
}
