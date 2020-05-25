<?php

namespace Riddlestone\Brokkr\Mail\Test\Integration;

use Riddlestone\Brokkr\Mail\MessageFactory;

class MessageFactoryTest extends AbstractApplicationTestCase
{
    public function testCreate()
    {
        /** @var MessageFactory $messageFactory */
        $messageFactory = $this->app->getServiceManager()->get(MessageFactory::class);
        $message = $messageFactory->create('html', 'text', ['title' => 'Title', 'paragraph' => 'Lorem ipsum']);
        $parts = $message->getBody()->getParts();
        $this->assertCount(2, $parts);
        $this->assertEquals("Title\n\nLorem ipsum", $parts[0]->getRawContent());
        $this->assertEquals("<h1>Title</h1>\n<p>Lorem ipsum</p>\n", $parts[1]->getRawContent());
    }

    public function testCreateWithoutText()
    {
        /** @var MessageFactory $messageFactory */
        $messageFactory = $this->app->getServiceManager()->get(MessageFactory::class);
        $message = $messageFactory->create('html', null, ['title' => 'Title', 'paragraph' => 'Lorem ipsum']);
        $parts = $message->getBody()->getParts();
        $this->assertCount(2, $parts);
        $this->assertEquals("Title\n\nLorem ipsum", $parts[0]->getRawContent());
        $this->assertEquals("<h1>Title</h1>\n<p>Lorem ipsum</p>\n", $parts[1]->getRawContent());
    }
}
