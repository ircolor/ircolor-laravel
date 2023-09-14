<?php

namespace App\Services\Auth\Infrastructure\OneTimePassword\Repositories;

use App\Repositories\Base\BaseRepository;
use App\Services\Auth\Contracts\AuthIdentifierInterface;
use App\Services\Auth\Infrastructure\OneTimePassword\Repositories\Contracts\OneTimePasswordRepositoryInterface;
use App\Services\Auth\Model\Contracts\OneTimePasswordEntityInterface;
use App\Services\Auth\Model\OneTimePasswordEntity;
use App\Services\Auth\Traits\HasKeyPrefix;
use Illuminate\Redis\Connections\Connection;

class OneTimePasswordRepository extends BaseRepository implements OneTimePasswordRepositoryInterface
{
    use HasKeyPrefix;

    public function __construct(private readonly Connection $connection)
    {
        self::$prefix = 'otp';
    }

    public function createOneTimePasswordWithIdentifier(OneTimePasswordEntityInterface $entity): bool
    {
        $this->connection->hMSet($key = self::getKey($entity->getKey()), $entity->toArray());
        return $this->connection->expire($key, $entity->getValidInterval()->totalSeconds * 2);
    }

    public function getOneTimePasswordWithIdentifierAndToken(AuthIdentifierInterface $identifier, string $token): ?OneTimePasswordEntityInterface
    {
        $key = OneTimePasswordEntity::getKeyStatically($identifier, $token);

        /**
         * @var array<string, string>|false|null $result
         */
        $result = $this->connection->hGetAll(self::getKey($key));

        if (!is_array($result)) {
            return null;
        }

        return OneTimePasswordEntity::getBuilder()::fromArray($identifier, $key, $result);
    }

    public function isOneTimePasswordExists(AuthIdentifierInterface $identifier, string $token): bool
    {
        $key = OneTimePasswordEntity::getKeyStatically($identifier, $token);

        return $this->connection->exists(self::getKey($key)) === 1;
    }

    public function removeOneTimePassword(OneTimePasswordEntityInterface $entity): bool
    {
        return $this->connection->unlink(self::getKey($entity->getKey())) === 1;
    }
}
