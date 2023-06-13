<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;

class Movie
{
    private ?int $id;
    private ?int $posterId;
    private string $originalLanguage;
    private string $originalTitle;
    private string $overview;
    private string $releaseDate;
    private int $runtime;
    private string $tagline;
    private string $title;

    private function __construct()
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
    * @param int|null $id
    * @return Movie
    */
    private function setId(?int $id): Movie
    {
        $this->id = $id;
        return $this;
    }

    public function getPosterId(): ?int
    {
        return $this->posterId;
    }
    /**
    * @param int|null $posterId
    *@return Movie
    */
    public function setPosterId(?int $posterId): Movie
    {
        $this->posterId = $posterId;
        return $this;
    }

    public function getOriginalLanguage(): string
    {
        return $this->originalLanguage;
    }

    /**
    * @param string $originalLanguage
    * @return Movie
    */
    public function setOriginalLanguage(string $originalLanguage): Movie
    {
        $this->originalLanguage = $originalLanguage;
        return $this;
    }
    public function getOriginalTitle(): string
    {
        return $this->originalTitle;
    }
    /**
    * @param string $originalTitle
    * @return Movie
    */
    public function setOriginalTitle(string $originalTitle): Movie
    {
        $this->originalTitle = $originalTitle;
        return $this;
    }

    public function getOverview(): string
    {
        return $this->overview;
    }
    /**
    * @param string $overview
    *@return Movie
    */
    public function setOverview(string $overview): Movie
    {
        $this->overview = $overview;
        return $this;
    }

    public function getReleaseDate(): string
    {
        return $this->releaseDate;
    }
    /**
    * @param string $releaseDate
    * @return Movie
    */
    public function setReleaseDate(string $releaseDate): Movie
    {
        $this->releaseDate = $releaseDate;
        return $this;
    }

    public function getRuntime(): int
    {
        return $this->runtime;
    }
    /**
    * @param int $runtime
    * @return Movie
    */
    public function setRuntime(int $runtime): Movie
    {
        $this->runtime = $runtime;
        return $this;
    }

    public function getTagline(): string
    {
        return $this->tagline;
    }
    /**
    * @param string $tagline
    * @return Movie
    */
    public function setTagline(string $tagline): Movie
    {
        $this->tagline = $tagline;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    /**
    * @param string $title
    * @return Movie
    */
    public function setTitle(string $title): Movie
    {
        $this->title = $title;
        return $this;
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

    /**
     * delete movie using an id
    * @return $this
     */
    public function delete(): Movie
    {
        $delete = MyPdo::getInstance()->prepare(
            <<<'SQL'
                    DELETE
                    FROM movie
                    WHERE id = ?
        SQL
        );
        $delete->bindValue(1, $this->id);
        $delete->execute();

        $this->id = null;
        return $this;
    }

    protected function update(): Movie
    {
        $update = MyPdo::getInstance()->prepare(
            <<<'SQL'
                    UPDATE movie
                    SET title = :title
                    AND originalLanguage = :oLang
                    AND originalTitle = :oTitle
                    AND overview = :overwiew
                    AND releaseDate = :releaseDate
                    AND runtime = :runtime
                    AND tagline = :tagline
                    WHERE id = :id
        SQL
        );
        $update->bindValue(':title', $this->title);
        $update->bindValue(':oLang', $this->originalLanguage);
        $update->bindValue(':oTitle', $this->originalTitle);
        $update->bindValue(':overview', $this->overview);
        $update->bindValue(':releaseDate', $this->releaseDate);
        $update->bindValue(':runtime', $this->runtime);
        $update->bindValue(':tagline', $this->tagline);
        $update->bindValue(':id', $this->id);
        $update->execute();

        return $this;
    }

    public static function create(string $originalTitle, string $originalLanguage, string $overview, string $releaseDate, int $runtime, string $tagline, string $title, ?int $posterId = null, ?int $id = null): Movie
    {
        $movie = new Movie();
        $movie->setOriginalTitle($originalTitle)->setOriginalLanguage($originalLanguage)->setOverview($overview)->setReleaseDate($releaseDate)->setRuntime($runtime)->setTagline($tagline)->setPosterId($posterId)->setId($id)->setTitle($title);
        return $movie;
    }

    protected function insert(): Movie
    {
        $insert = MyPdo::getInstance()->prepare(
            <<<'SQL'
                    INSERT INTO movie (originalLanguage,originalTitle,overview,releaseDate,runtime,tagline,title,id)
                    VALUES (:originalLanguage, :originalTitle, :overview, :releaseDate, :runtime, :tagline, :title, :id)
        SQL
        );
        $insert->bindValue(':originalLanguage', $this->originalLanguage);
        $insert->bindValue(':originalTitle', $this->originalTitle);
        $insert->bindValue(':overview', $this->overview);
        $insert->bindValue(':releaseDate', $this->releaseDate);
        $insert->bindValue(':runtime', $this->runtime);
        $insert->bindValue(':tagline', $this->tagline);
        $insert->bindValue(':title', $this->title);
        $insert->bindValue(':id', $this->id);
        $insert->execute();
        $this->setId((int)MyPdo::getInstance()->lastInsertId());
        return $this;
    }

    public function save(): Movie
    {
        if ($this->id === null) {
            $this->insert();
        } else {
            $this->update();
        }
        return $this;
    }
}
