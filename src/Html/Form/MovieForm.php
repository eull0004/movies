<?php

declare(strict_types=1);

namespace Html\Form;

use Entity\Movie;
use Exception\ParameterException;
use Html\StringEscaper;

class MovieForm
{
    use StringEscaper;
    private ?Movie $movie;

    /**
     * @param Movie|null $movie
     */
    public function __construct(?Movie $movie = null)
    {
        $this->movie = $movie;
    }

    /**
     * @return Movie|null
     */
    public function getMovie(): ?Movie
    {
        return $this->movie;
    }

    public function getHtmlForm(string $action): string
    {
        return <<<HTML
                <form action="$action" method="post"  >
                    <input name="id" type="hidden" value="{$this?->movie?->getId()}">
                    <label for="title">
                        Title : 
                        <input type="text" name="title" value="{$this->escapeString($this?->movie?->getTitle())}" required>
                    </label>
                    <label for="originalLanguage">
                        Original Language : 
                        <input type="text" name="originalLanguage" value="{$this->escapeString($this?->movie?->getOriginalLanguage())}" required>
                    </label>
                    <label for="originalTitle">
                        Original Title : 
                        <input type="text" name="originalTitle" value="{$this->escapeString($this?->movie?->getOriginalTitle())}" required>
                    </label>
                    <label for="overview">
                        Overview : 
                        <textarea maxlength="200" name="overview"required>"{$this->escapeString($this?->movie?->getOverview())}"</textarea>
                    </label>
                    <label for="releaseDate">
                        Release Date : 
                        <input type="date" name="releaseDate" value="{$this?->movie?->getReleaseDate()}" required>
                    </label>
                    <label for="runtime">
                        Runtime : 
                        <input type="number" name="runtime" min="0" max="180" step="10" value="{$this?->movie?->getRuntime()}" required>
                    </label>
                    <label for="tagline">
                        Tagline : 
                        <textarea maxlength="100" name="tagline" required>"{$this->escapeString($this?->movie?->getTagline())}"</textarea>
                    </label>
                    <input type="hidden" name="posterId" value="{$this?->movie?->getPosterId()}">
            
                    <input type="submit" value="Valider">
                </form>
        HTML;
    }

    public function setEntityFromQueryString(): void
    {
        $movieId = null;
        if (isset($_POST["id"]) && ctype_digit($_POST["id"])) {
            $movieId = (int) $_POST["id"];
        }

        $posterId = null;
        if (isset($_POST["posterId"]) && ctype_digit($_POST["posterId"])) {
            $posterId = (int) $_POST["posterId"];
        }

        if(!isset($_POST["originalLanguage"]) || empty($this->stripTagsAndTrim($_POST["originalLanguage"]))) {
            throw new ParameterException("original Language is missing");
        }
        $originalLanguage = $this->stripTagsAndTrim($_POST["originalLanguage"]);

        if(!isset($_POST["originalTitle"]) || empty($this->stripTagsAndTrim($_POST["originalTitle"]))) {
            throw new ParameterException("Original Title is missing");
        }
        $originalTitle = $this->stripTagsAndTrim($_POST["originalTitle"]);

        if(!isset($_POST["overview"]) || empty($this->stripTagsAndTrim($_POST["overview"]))) {
            throw new ParameterException("overview is missing");
        }
        $overview = $this->stripTagsAndTrim($_POST["overview"]);

        if(!isset($_POST["releaseDate"]) || empty($this->stripTagsAndTrim($_POST["releaseDate"]))) {
            throw new ParameterException("Release Date is missing");
        }
        $releaseDate = $this->stripTagsAndTrim($_POST["releaseDate"]);

        if(!isset($_POST["runtime"]) || empty($this->stripTagsAndTrim($_POST["runtime"]))) {
            throw new ParameterException("runtime is missing");
        }
        $runtime =(int)$this->stripTagsAndTrim(($_POST["runtime"]));

        if(!isset($_POST["tagline"]) || empty($this->stripTagsAndTrim($_POST["tagline"]))) {
            throw new ParameterException("tagline is missing");
        }
        $tagline = $this->stripTagsAndTrim($_POST["tagline"]);

        if(!isset($_POST["title"]) || empty($this->stripTagsAndTrim($_POST["title"]))) {
            throw new ParameterException("title is missing");
        }
        $title = $this->stripTagsAndTrim($_POST["title"]);

        $this->movie = Movie::create($originalLanguage, $originalTitle, $overview, $releaseDate, $runtime, $tagline, $title, $posterId, $movieId);
    }
}
