# Riddlestone Brokkr-Mail

A [Laminas](https://github.com/laminas) module to provide service-manager built and configured mail transports

## Installation

Installation of this module uses composer. For composer documentation, please refer to
[getcomposer.org](http://getcomposer.org/).

```sh
composer require riddlestone/brokkr-mail
```

## Usage

This module adds a factory for `Laminas\Mail\Transport\TransportInterface` which creates it from configuration at
`mail.transport`.

For example, to use a shared SMTP transport:

```php
// local.config.php

return [
    'mail' => [
        'transport' => [
            'type' => 'smtp',
            'options' => [
                'name' => 'smtp.example.com',
                'host' => 'smtp.example.com',
                'connection_class' => 'login',
                'connection_config' => [
                    'username' => 'me@example.com',
                    'password' => 'my-p@ssw0rd',
                ],
            ],
        ],
    ],
];
```

```php
// some_factory_or_service.php

use Laminas\Mail\Message;
use Laminas\Mail\Transport\TransportInterface;
use Laminas\ServiceManager\ServiceManager;

/** @var ServiceManager $serviceManager */
/** @var Message $message */

/** @var TransportInterface $transport */
$transport = $serviceManager->get(TransportInterface::class);
$transport->send($message);
```

For more details on the configuration options, see the
[Laminas Mail Docs](https://docs.laminas.dev/laminas-mail/transport/smtp-options/#configuration-options).

## Get Involved

File issues at https://github.com/riddlestone/brokkr-users/issues
