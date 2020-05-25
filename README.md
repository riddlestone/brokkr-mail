# Riddlestone Brokkr-Mail

A [Laminas](https://github.com/laminas) module to provide service-manager built and configured mail transports

## Installation

Installation of this module uses composer. For composer documentation, please refer to
[getcomposer.org](http://getcomposer.org/).

```sh
composer require riddlestone/brokkr-mail
```

## Usage

### Building a Message

This module adds a factory for generating messages with content created using Laminas View.

```php
// local.config.php

return [
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../views',
        ],
    ],
];
``` 

```php
// some_factory_or_service.php

use Laminas\ServiceManager\ServiceManager;
use Riddlestone\Brokkr\Mail\MessageFactory;

/** @var ServiceManager $serviceManager */

$messageFactory = $serviceManager->get(MessageFactory::class);
$message = $messageFactory(
    'mail/my-html-template',
    'mail/my-text-template',
    [
        'view_variable_1' => 'Some value',
        'view_variable_2' => 'Some other value',
    ],
);
```

Once created, you will need to set the subject, and other header fields (such as To, From, etc.).

The created message will have two alternate mime-parts: text and HTML. If the text template is omitted, the text will be
created from the HTML content.

### Building a Transport

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

File issues at https://github.com/riddlestone/brokkr-mail/issues
