<?php
return  
    (new \Viber\Api\Keyboard())
        ->setButtons([
            (new \Viber\Api\Keyboard\Button())
                ->setBgColor('#8074d6')
                ->setColumns(3)
                ->setTextSize('small')
                ->setTextHAlign('center')
                ->setActionType('reply')
                ->setActionBody('usecases')
                ->setText('Варианты использования'),

            (new \Viber\Api\Keyboard\Button())
                ->setBgColor('#2fa4e7')
                ->setColumns(3)
                ->setTextHAlign('center')
                ->setActionType('reply')
                ->setActionBody('benifits')
                ->setText('Выгоды'),

            (new \Viber\Api\Keyboard\Button())
                ->setBgColor('#555555')
                ->setTextSize('large')
                ->setTextHAlign('center')
                ->setActionType('reply')
                ->setActionBody('btn-click')
                ->setText('Сколько это может стоить?'),
        ]);