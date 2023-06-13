<?php

declare(strict_types=1);

namespace Html;

class AppWebPage extends WebPage
{
    public function __construct(string $title = '')
    {
        parent::__construct($title);
        $this->appendCssUrl("/css/style.css");
    }

    public function toHtml(): string
    {
        return <<<HTML
    <!doctype html>
    <html lang="fr">
    <head>
        <meta name ="viewport">
        <meta charset="utf-8">
        {$this->getHead()}
        <title>{$this->getTitle()}</title>
    </head>
    <body>
        <section class="header">
            <h1>{$this->getTitle()}</h1>
        </section>
        <section class="content">
            {$this->getBody()}
        </section>
        <section class="footer">
            <div>{$this->getLastModification()}</div>
        </section>
    </body>
    </html>
HTML;
    }
}
