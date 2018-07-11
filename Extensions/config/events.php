<?php

namespace Vamshop\Extensions\Config;

return [
    'EventHandlers' => [
        'Vamshop/Extensions.ExtensionsEventHandler' => [
            'options' => [
                'priority' => 5,
            ],
        ],
        'Vamshop/Extensions.HookableComponentEventHandler' => [
            'options' => [
                'priority' => 5,
            ],
        ],
    ],
];
