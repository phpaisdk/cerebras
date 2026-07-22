<?php

declare(strict_types=1);

namespace AiSdk\Cerebras;

use AiSdk\Cerebras\Models\CerebrasTextModel;
use AiSdk\Contracts\BaseProvider;
use AiSdk\Contracts\TextModelInterface;
use AiSdk\Contracts\TextProviderInterface;

final class CerebrasProvider extends BaseProvider implements TextProviderInterface
{
    public function __construct(public readonly CerebrasOptions $options) {}
    public function name(): string
    {
        return CerebrasOptions::PROVIDER_NAME;
    }
    protected function textModel(string $modelId): TextModelInterface
    {
        return new CerebrasTextModel($modelId, $this->options);
    }
}
