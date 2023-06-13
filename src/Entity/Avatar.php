<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;

class Avatar extends Image
{
    /**
     * find the avatar's using an avatar id
     * @param int $avatarId
     * @return Avatar
     * @throws EntityNotFoundException if avatar not found in database
     *
     */
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
        $avatar = $avatarRequest->fetchObject(Avatar::class);
        if (!$avatar) {
            throw new EntityNotFoundException('Avatar not found');
        }
        return $avatar;
    }
}
