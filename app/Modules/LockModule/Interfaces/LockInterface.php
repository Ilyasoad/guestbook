<?php

namespace App\Modules\LockModule\Interfaces;

use Carbon\Carbon;

/**
 * Interface LockInterface
 * Интерфейс для выставления, снятия локов
 *
 * @package App\Modules\LockModule\Interfaces
 */
interface LockInterface
{
    const TTL = Carbon::SECONDS_PER_MINUTE;

    public function lock(string $key, int $ttl = self::TTL): bool;

    public function unlock(string $key): bool;
}
