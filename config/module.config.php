<?php

namespace Riddlestone\Brokkr\Mail;

use Laminas\Mail\Transport\TransportInterface;

return [
    'mail' => [
        'transport' => [
            'type' => 'sendmail',
        ],
    ],
    'service_manager' => [
        'factories' => [
            MessageFactory::class => Factory\MessageFactoryFactory::class,
            TransportInterface::class => Factory\TransportFactory::class,
        ],
    ],
];
