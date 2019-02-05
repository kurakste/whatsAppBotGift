<?php

$tkb  = (new \Viber\Api\Keyboard())
        ->setButtons(
            [
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
            ]
        );
