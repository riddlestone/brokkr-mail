<?php

namespace Riddlestone\Brokkr\Mail\Test\Unit;

use Laminas\View\Model\ViewModel;
use Laminas\View\View;
use PHPUnit\Framework\TestCase;
use Riddlestone\Brokkr\Mail\MessageFactory;

class MessageFactoryTest extends TestCase
{
    public function testCreateWithoutTextTemplate()
    {
        $template = 'email/template';
        $variables = ['v1' => 'First variable', 'v2' => 'Second'];

        $view = $this->createMock(View::class);
        $view->method('render')->willReturnCallback(
            function (ViewModel $viewModel) use ($template, $variables) {
                $this->assertEquals($template, $viewModel->getTemplate());
                $this->assertEquals($variables, $viewModel->getVariables());
                return '<h1>Title Here</h1><p>And the paragraph</p>';
            }
        );
        $messageFactory = new MessageFactory($view);
        $message = $messageFactory->create($template, null, $variables);

        $parts = $message->getBody()->getParts();
        $this->assertEquals("Title Here\n\nAnd the paragraph", $parts[0]->getRawContent());
        $this->assertEquals("<h1>Title Here</h1><p>And the paragraph</p>", $parts[1]->getRawContent());
    }

    public function testCreateWithTextTemplate()
    {
        $htmlTemplate = 'email/html';
        $textTemplate = 'email/text';
        $variables = ['v1' => 'First variable', 'v2' => 'Second'];

        $view = $this->createMock(View::class);
        $view->method('render')->willReturnCallback(
            function (ViewModel $viewModel) use ($htmlTemplate, $textTemplate, $variables) {
                $this->assertEquals($variables, $viewModel->getVariables());
                switch ($viewModel->getTemplate()) {
                    case $htmlTemplate:
                        return '<h1>Title Here</h1><p>And the paragraph</p>';
                    case $textTemplate:
                        return "Title Here\n\nAnd the paragraph";
                    default:
                        $this->fail('Unexpected template file');
                }
                return false;
            }
        );
        $messageFactory = new MessageFactory($view);
        $message = $messageFactory->create($htmlTemplate, $textTemplate, $variables);

        $parts = $message->getBody()->getParts();
        $this->assertEquals("Title Here\n\nAnd the paragraph", $parts[0]->getRawContent());
        $this->assertEquals("<h1>Title Here</h1><p>And the paragraph</p>", $parts[1]->getRawContent());
    }
}
