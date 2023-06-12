<?php

declare(strict_types=1);

namespace Entity;

class Image
{
    private int $id;
    private string $jpeg;

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of jpeg
     */
    public function getJpeg()
    {
        return $this->jpeg;
    }
}