<?php

declare(strict_types=1);

namespace Entity;

class Image
{
    protected int $id;
    protected string $jpeg;

    public function getId(): int
    {
        return $this->id;
    }
    public function getJpeg(): string
    {
        return $this->jpeg;
    }
}
