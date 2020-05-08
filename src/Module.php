<?php

namespace Riddlestone\Brokkr\Mail;

class Module
{
    public function getConfig()
    {
        return require __DIR__ . '/../config/module.config.php';
    }
}
