<?php

declare(strict_types=1);

namespace Html;
use Html\StringEscaper;

class WebPage
{
    use \Html\StringEscaper;
    private string $head = '';
    private string $title = '';
    private string $body = '';

    /**
     * Constructeur de la classe WebPage. Ce constructeur permet dans un premier temps d’affecter un titre une page Web.
     * Lorsque cette caractéritique n'est pas renseignée lors de l’appel du contructeur, la page Web aura un titre considéré vide.
     * @param string $title
     */
    public function __construct(string $title = '')
    {
        $this->title = $title;
    }

    /**
     * Méthode retournant le contenu head de l'instance concernée.
     * @return string
     */
    public function getHead(): string
    {
        return $this->head;
    }

    /**
     * Méthode retournant le title de l'instance concernée
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Méthode retournant le body de l'instance concernée
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * Méthode permetttant de modifier/créer le titre de la page web
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Méthode permettant d'ajouter le contenu en paramètre au head de l'instance concernée
     * @param string $content
     */
    public function appendToHead(string $content): void
    {
        $this->head = $this->getHead(). $content;
    }

    /**
     * Méthode permettant d'ajouter un contenu css au head de l'instance concernée
     * @param string $css
     */
    public function appendCss(string $css): void
    {
        $this->appendToHead("<style>{$css}</style>");
    }

    /**
     * Méthode ajoutant l'URL d'un script css dans le head de l'instance concernée
     * @param string $url
     * @return void
     */
    public function appendCssUrl(string $url): void
    {
        $this->appendToHead("<link rel='stylesheet' href='{$url}'>");
    }

    /**
     * Méthode ajoutant un contenu JavaScript dans le head de l'instance concernée
     * @param string $js
     * @return void
     */
    public function appendJs(string $js): void
    {
        $this->appendToHead("<script>{$js}</script>");
    }

    /**
     * Méthode permettant d'ajouter l'URL d'un script JavaScript dans le head
     * @param string $url
     * @return void
     */
    public function appendJsUrl(string $url): void
    {
        $this->appendToHead("<script src='{$url}'></script>");
    }

    /**
     * Méthode ajoutant le contenu en paramètre dans le body de l'instance indiquée
     * @param string $content
     * @return void
     */
    public function appendContent(string $content): void
    {
        $this->body = $this->getBody(). $content;
    }

    /**
     * Méthode permettant de produire la page Web complète
     * @return string
     */
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
        {$this->getBody()}
    </body>
    </html>
HTML;
    }

    /**
     * Méthode retournant la date et l'heure de la dernière modification du script principal.
     * @return string
     */
    public static function getLastModification(): string
    {
        return date("F d Y H:i:s.", getlastmod());
    }
}
