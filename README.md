# Cerebras provider for PHP AI SDK

```bash
composer require aisdk/cerebras
```

```php
use AiSdk\Generate;
use AiSdk\Cerebras;

Cerebras::create(['apiKey' => $_ENV['CEREBRAS_API_KEY']]);

$result = Generate::text('Explain this code briefly.')
    ->model(Cerebras::model('gpt-oss-120b'))
    ->run();
```

This package uses Cerebras Inference's official OpenAI-compatible API at `https://api.cerebras.ai/v1`. It supports text and streaming generation; tool calling, structured output, reasoning, and image input are passed through for Model API models that expose those capabilities. See [Cerebras API documentation](https://inference-docs.cerebras.ai/resources/openai) and [PHP AI SDK documentation](https://phpaisdk.com/docs/cerebras).
