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

try {
    // create bot instance
    $bot = new Bot(['token' => $apiKey]);
    $bot
        // first interaction with bot - return "welcome message"
        ->onConversation(function ($event) use ($bot, $botSender, $log) {
            $log->info('onConversation handler');
            return (new \Viber\Api\Message\Text())
                ->setSender($botSender)
                ->setText("Hi, you can see some demo: send 'k1' or 'k2' etc.");
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
        ->onText('|начать|s', function ($event) use ($bot, $botSender, $log) {
            $log->info('onStart' . $event->getMessage()->getText());
            $str = $event->getMessage()->getTrackingData();
            $log->info('Tracking data:'.$str);
            $bot->getClient()->sendMessage(
                (new \Viber\Api\Message\Text())
                    ->setTrackingData($str)
                    ->setSender($botSender)
                    ->setReceiver($event->getSender()->getId())
                    ->setText('Здравсвуйте! Мы занимаемся разработкой чат-ботов.'.
                    'У нас можно узнать о том, как вы можите использовать технологии в своем бизнесе'
                    .'Пожалуйста воспользуйтесь меню.')
            );
        })
        ->onText('|заказать|s', function ($event) use ($bot, $botSender, $log) {
            $log->info('onGetOrder' . $event->getMessage()->getText());
            $str = $event->getMessage()->getTrackingData();
            $log->info('Tracking data:'.$str);
            $bot->getClient()->sendMessage(
                (new \Viber\Api\Message\Text())
                    ->setTrackingData($str)
                    ->setSender($botSender)
                    ->setReceiver($event->getSender()->getId())
                    ->setText('заказываем...')
            );
        })
        ->onText('|menu|s', function ($event) use ($bot, $botSender, $log) {
            $kbrd = require_once(__DIR__.'/keyboards/mainMenu.php');
            $log->info('menu method:');
            $bot->getClient()->sendMessage(
                (new \Viber\Api\Message\Text())
                    ->setSender($botSender)
                    ->setReceiver($event->getSender()->getId())
                    ->setText('Hi from menu')
                    ->setKeyboard($kbrd)
            );
        })
        ->onText('|usecases|s', function ($event) use ($bot, $botSender, $log) {
            $kbrd = require_once(__DIR__.'/keyboards/mainMenu.php');
            $str = require_once(__DIR__.'/messages/vars.php');
            $log->info('usecases method:');
            $bot->getClient()->sendMessage(
                (new \Viber\Api\Message\Text())
                    ->setSender($botSender)
                    ->setReceiver($event->getSender()->getId())
                    ->setText('str')
                    ->setKeyboard($kbrd)
            );
        })
        ->onText('|clear|s', function ($event) use ($bot, $botSender, $log) {
            $log->info('onClear' . $event->getMessage()->getText());
            $str = $event->getMessage()->getTrackingData();
            $log->info('Tracking data:'.$str);
            $str = '';
            // .* - match any symbols
            $bot->getClient()->sendMessage(
                (new \Viber\Api\Message\Text())
                    ->setTrackingData($str)
                    ->setSender($botSender)
                    ->setReceiver($event->getSender()->getId())
                    ->setText('Yes, MyCap')
            );
        })
        ->onText('|.*|s', function ($event) use ($bot, $botSender, $log) {
            $log->info('onText ' . $event->getMessage()->getText());
            $str = $event->getMessage()->getTrackingData();
            $log->info('Tracking data:'.$str);
            // .* - match any symbols
            $bot->getClient()->sendMessage(
                (new \Viber\Api\Message\Text())
                    ->setTrackingData($str)
                    ->setSender($botSender)
                    ->setReceiver($event->getSender()->getId())
                    ->setText('HI!')
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
