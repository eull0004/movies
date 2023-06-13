<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;

class Movie
{
    private int $id;
    private int $posterId;
    private string $originalTitle;
    private string $overview;
    private string $releaseDate;
    private int $runtime;
    private string $tagline;
    private string $title;

    /**
     * Get the value of posterId
     */
    public function getPosterId()
    {
        return $this->posterId;
    }

    /**
     * Get the value of originalTitle
     */
    public function getOriginalTitle()
    {
        return $this->originalTitle;
    }

    /**
     * Get the value of overview
     */
    public function getOverview()
    {
        return $this->overview;
    }

    /**
     * Get the value of releaseDate
     */
    public function getReleaseDate()
    {
        return $this->releaseDate;
    }

    /**
     * Get the value of runtime
     */
    public function getRuntime()
    {
        return $this->runtime;
    }

    /**
     * Get the value of tagline
     */
    public function getTagline()
    {
        return $this->tagline;
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *  Get the value of title
     */
    public function getTitle()
    {
        return $this->title;
    }
    public static function findById(int $movieId): Movie
    {
        $movieRequest = MyPdo::getInstance()->prepare(
            <<<'SQL'
			SELECT id, posterId,originalTitle, overview, releaseDate, runtime, tagline, title
			FROM movie
			WHERE id = ?
			SQL
        );
        $movieRequest->execute([$movieId]);
        $movie = $movieRequest->fetchObject(Movie::class);
        if ($movie === false) {
            throw new EntityNotFoundException('Movie not found.');
        }
        return $movie;
    }
}
