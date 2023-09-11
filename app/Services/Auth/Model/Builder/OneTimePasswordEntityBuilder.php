<?php

namespace App\Services\Auth\Model\Builder;

use App\Services\Auth\AuthIdentifier;
use App\Services\Auth\Contracts\AuthIdentifierInterface;
use App\Services\Auth\Enums\AuthIdentifierType;
use App\Services\Auth\Model\Contracts\OneTimePasswordEntityInterface;
use App\Services\Auth\Model\OneTimePasswordEntity;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Str;

class OneTimePasswordEntityBuilder
{
    protected AuthIdentifierInterface $identifier;
    protected ?string $token = null;
    protected ?string $code = null;
    protected ?CarbonInterval $interval = null;

    /**
     * @param string $key
     * @param array<string, string> $array
     * @return OneTimePasswordEntityInterface
     */
    public static function fromArray(string $key, array $array): OneTimePasswordEntityInterface
    {
        [$identifierType, $identifierValue, $token] = explode(':', $key, 3);

        return new OneTimePasswordEntity(
            new AuthIdentifier(AuthIdentifierType::from($identifierType), $identifierValue),
            $token,
            $array['c'],
            CarbonInterval::second($array['i']),
            Carbon::createFromTimestamp($array['t'])
        );
    }

    public function as(AuthIdentifierInterface $identifier): self
    {
        $this->identifier = $identifier;

        return $this;
    }

    public function validFor(CarbonInterval $interval): self
    {
        $this->interval = $interval;

        return $this;
    }

    public function build(): OneTimePasswordEntityInterface
    {
        if ($this->token === null) {
            $this->token = Str::password(8, true, false, false);
        }

        if ($this->code === null) {
            $this->code = Str::password(6, false, true, false);
        }

        if ($this->interval === null) {
            $this->interval = CarbonInterval::minute(2);
        }

        return new OneTimePasswordEntity($this->identifier, $this->token, $this->code, $this->interval, Date::now());
    }
}
