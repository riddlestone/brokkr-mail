<?php

namespace Riddlestone\Brokkr\Mail;

use Laminas\Mail\Transport\TransportInterface;
use Riddlestone\Brokkr\Mail\Factory\TransportFactory;

return [
    'mail' => [
        'transport' => [
            'type' => 'sendmail',
        ],
    ],
    'service_manager' => [
        'factories' => [
            TransportInterface::class => TransportFactory::class,
        ],
    ],
];
