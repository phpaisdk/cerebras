<?php

declare(strict_types=1);

namespace AiSdk;

use AiSdk\Cerebras\CerebrasOptions;
use AiSdk\Cerebras\CerebrasProvider;
use AiSdk\Contracts\Model;

final class Cerebras
{
    private static ?CerebrasProvider $default = null;
    /** @param array<string, mixed> $config */
    public static function create(array $config = []): CerebrasProvider
    {
        return self::$default = new CerebrasProvider(CerebrasOptions::fromArray($config));
    }
    public static function default(): CerebrasProvider
    {
        return self::$default ??= self::create();
    }
    public static function reset(): void
    {
        self::$default = null;
    }
    public static function model(string $modelId): Model
    {
        return self::default()->model($modelId);
    }
}
