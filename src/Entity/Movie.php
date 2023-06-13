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
    public function getPosterId(): int
    {
        return $this->posterId;
    }
    public function getOriginalTitle(): string
    {
        return $this->originalTitle;
    }
    public function getOverview(): string
    {
        return $this->overview;
    }
    public function getReleaseDate(): string
    {
        return $this->releaseDate;
    }
    public function getRuntime(): int
    {
        return $this->runtime;
    }
    public function getTagline(): string
    {
        return $this->tagline;
    }
    public function getId(): int
    {
        return $this->id;
    }
    public function getTitle(): string
    {
        return $this->title;
    }
    /**
     * find the movie's using an movie id
     * @param int $movieId
     * @return Movie
     * @throws EntityNotFoundException if movie not found in database
     *
     */
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
