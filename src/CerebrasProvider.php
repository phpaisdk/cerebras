<?php

declare(strict_types=1);

namespace AiSdk\Cerebras;

use AiSdk\Capability;
use AiSdk\Contracts\BaseProvider;
use AiSdk\Contracts\TextModelInterface;
use AiSdk\Contracts\TextProviderInterface;
use AiSdk\OpenAICompatible\CompatibleChatModel;

final class CerebrasProvider extends BaseProvider implements TextProviderInterface
{
    public function __construct(public readonly CerebrasOptions $options) {}
    public function name(): string
    {
        return CerebrasOptions::PROVIDER_NAME;
    }
    protected function textModel(string $modelId): TextModelInterface
    {
        return new CompatibleChatModel(
            modelId: $modelId,
            providerName: $this->name(),
            baseUrl: $this->options->baseUrl,
            headers: $this->options->authHeaders(),
            sdk: $this->options->sdk,
            capabilities: [Capability::TextGeneration, Capability::Streaming, Capability::ToolCalling, Capability::StructuredOutput, Capability::Reasoning, Capability::TextInput, Capability::ImageInput],
        );
    }
}
