<?php

namespace Riddlestone\Brokkr\Mail;

use Laminas\Mail\Message;
use Laminas\Mime\Message as MimeMessage;
use Laminas\Mime\Mime;
use Laminas\Mime\Part;
use Laminas\View\Model\ViewModel;
use Laminas\View\View;

class MessageFactory
{
    /**
     * @var View
     */
    protected $view;

    // region Magic Methods

    public function __construct(View $view)
    {
        $this->view = $view;
    }

    // endregion Magic Methods

    /**
     * @return View
     */
    public function getView(): View
    {
        return $this->view;
    }

    public function create(string $htmlTemplate, ?string $textTemplate = null, array $params = []): Message
    {
        $viewModel = new ViewModel($params);
        $viewModel->setOption('has_parent', true);

        $viewModel->setTemplate($htmlTemplate);
        $html = $this->getView()->render($viewModel);

        $htmlPart = $this->createMimePart($html, Mime::TYPE_HTML);

        $text = $textTemplate && $viewModel->setTemplate($textTemplate)
            ? $this->getView()->render($viewModel)
            : $this->htmlToText($html);

        $textPart = $this->createMimePart($text, Mime::TYPE_TEXT);

        $mimeMessage = new MimeMessage();
        $mimeMessage->setParts([$textPart, $htmlPart]);

        $message = new Message();
        $message->setBody($mimeMessage);
        $contentTypeHeader = $message->getHeaders()->get('Content-Type');
        $contentTypeHeader->setType('multipart/alternative');

        return $message;
    }

    /**
     * @param string $content
     * @param string $type
     * @return Part
     */
    protected function createMimePart(string $content, string $type): Part
    {
        $html = new Part($content);
        $html->setType($type);
        $html->setCharset('utf-8');
        $html->setEncoding(Mime::ENCODING_QUOTEDPRINTABLE);
        return $html;
    }

    /**
     * @param string $html
     * @return string
     */
    protected function htmlToText(string $html)
    {
        $html = preg_replace(
            '#(<br(\\s[^>]*)/?>)\\s*#m',
            '$1' . "\n",
            $html
        );
        $html = preg_replace(
            '#(</(p|h[1-6])>)\\s*(<(p|h[1-6])(\s[^>]*)?>)?\\s*#m',
            '$1' . "\n\n" . '$3',
            $html
        );
        return trim(strip_tags($html), "\n");
    }
}
