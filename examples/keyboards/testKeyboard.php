<?php
return  
    (new \Viber\Api\Keyboard())
        ->setButtons([
            (new \Viber\Api\Keyboard\Button())
                ->setBgColor('#8074d6')
                ->setTextSize('small')
                ->setTextHAlign('right')
                ->setActionType('reply')
                ->setActionBody('btn-click')
                ->setText('Button 1'),

            (new \Viber\Api\Keyboard\Button())
                ->setBgColor('#2fa4e7')
                ->setTextHAlign('center')
                ->setActionType('reply')
                ->setActionBody('btn-click')
                ->setText('Button 2'),

            (new \Viber\Api\Keyboard\Button())
                ->setBgColor('#555555')
                ->setTextSize('large')
                ->setTextHAlign('left')
                ->setActionType('reply')
                ->setActionBody('btn-click')
                ->setText('Button 3'),
        ]);