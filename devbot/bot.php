<?php

/**
 * Before you run this example:
 * 1. install monolog/monolog: composer require monolog/monolog
 * 2. copy config.php.dist to config.php: cp config.php.dist config.php
 *
 * @author Novikov Bogdan <hcbogdan@gmail.com>
 */

require_once '../vendor/autoload.php';

use Viber\Bot;
use Viber\Api\Sender;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Viber\Blogica\Ruler;

$config = require('./config.php');
$apiKey = $config['apiKey'];

// reply name
$botSender = new Sender([
    'name' => 'My pozdravim',
    'avatar' => 'https://developers.viber.com/img/favicon.ico',
]);

// log bot interaction
$log = new Logger('bot');
$log->pushHandler(new StreamHandler('/tmp/bot1.log'));


try {
    // create bot instance
    $bot = new Bot(['token' => $apiKey]);
    $bot
        ->onConversation(function ($event) use ($bot, $botSender, $log) {
            $log->info('onConversation ' . var_export($event, true));
            // this event fires if user open chat, you can return "welcome message"
            // to user, but you can't send more messages!
            return (new \Viber\Api\Message\Text())
                ->setSender($botSender)
                ->setText('Can i help you?');
        })
        ->onText('|whois .*|si', function ($event) use ($bot, $botSender, $log) {
            $log->info('onText whois ' . var_export($event, true));
            // match by template, for example "whois Bogdaan"

            $bot->getClient()->sendMessage(
                (new \Viber\Api\Message\Text())
                    ->setSender($botSender)
                    ->setReceiver($event->getSender()->getId())
                    ->setText('I do not know )')
            );
        })
        ->onText('|.*|s', function ($event) use ($bot, $botSender, $log) {
            $log->info('onText '.$event->getSender()->getId());
            // .* - match any symbols
            $bot->getClient()->sendMessage(
                (new \Viber\Api\Message\Text())
                    ->setSender($botSender)
                    ->setReceiver($event->getSender()->getId())
                    ->setText('HI!')
            );
        })
        ->onPicture(function ($event) use ($bot, $botSender, $log) {
            $log->info('onPicture ' . var_export($event, true));
            $bot->getClient()->sendMessage(
                (new \Viber\Api\Message\Text())
                    ->setSender($botSender)
                    ->setReceiver($event->getSender()->getId())
                    ->setText('Nice picture ;-)')
            );
        })
        
        ->onLocation(function ($event) use ($bot, $botSender, $log) {
            // $log->info('onLocation ' . var_export($event, true));
            // $log->info('my ' . var_export($event->getMessage()->getLocation()['lat'], true));
            // $log->info('my ' . var_export($event->getMessage()->getLocation()['lon'], true));
            $lat = $event->getMessage()->getLocation()['lat'];
            $lon = $event->getMessage()->getLocation()['lon'];
            $ruler = new Ruler;
            $dist = $ruler->calculateTheDistance($lat, $lon, 48.852220, 2.356677);
            $dist = round($dist/1000, 0);

            $bot->getClient()->sendMessage(
                (new \Viber\Api\Message\Text())
                    ->setSender($botSender)
                    ->setReceiver($event->getSender()->getId())
                    ->setText("Привет! Тебе до парижа еще {$dist} km фигачить. Давай, крути педали)")

            );
        })

        ->on(function ($event) {
            return true; // match all
        }, function ($event) use ($log) {
            $log->info('Other event: ' . var_export($event, true));
        })
        ->run();
} catch (Exception $e) {
    $log->warning('Exception: '.$e->getMessage());
    if ($bot) {
        $log->warning('Actual sign: ' . $bot->getSignHeaderValue());
        $log->warning('Actual body: ' . $bot->getInputBody());
    }
}
