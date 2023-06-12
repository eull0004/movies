<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;

class Avatar extends Image
{
    public static function findById(int $avatarId): Avatar
    {
        $avatarRequest = MyPdo::getInstance()->prepare(
            <<<'SQL'
			SELECT id, jpeg 
			FROM image
			WHERE id = ?
			SQL
        );
        $avatarRequest->execute([$avatarId]);
        $avatar = $avatarRequest->fetchObject(avatar::class);
        if (!$avatar) {
            throw new EntityNotFoundException('Avatar not found');
        }
        return $avatar;
    }
}
