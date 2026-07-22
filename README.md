# aisdk/cerebras

<a href="https://github.com/phpaisdk/cerebras/actions"><img alt="GitHub Workflow Status" src="https://img.shields.io/github/actions/workflow/status/phpaisdk/cerebras/tests.yml?branch=main&label=Tests"></a>
<a href="https://packagist.org/packages/aisdk/cerebras"><img alt="Latest Version" src="https://img.shields.io/packagist/v/aisdk/cerebras"></a>
<a href="https://packagist.org/packages/aisdk/cerebras"><img alt="License" src="https://img.shields.io/packagist/l/aisdk/cerebras"></a>

------

Official Cerebras provider for the PHP AI SDK. Uses Cerebras Inference's OpenAI-compatible API.

## Installation

```bash
composer require aisdk/cerebras
```

## Basic Usage

```php
use AiSdk\Cerebras;
use AiSdk\Generate;

Cerebras::create(['apiKey' => $_ENV['CEREBRAS_API_KEY']]);

$result = Generate::text('Explain this code briefly.')
    ->model(Cerebras::model('gpt-oss-120b'))
    ->run();
```

## Configuration

| Variable | Description | Default |
| --- | --- | --- |
| `CEREBRAS_API_KEY` | API key for authentication | Required |
| `CEREBRAS_BASE_URL` | Base URL for API requests | `https://api.cerebras.ai/v1` |

## Supported Capabilities

| Capability | Support |
| --- | --- |
| Text generation and streaming | Native OpenAI-compatible chat |
| Tool calling, structured output, reasoning | Passed through for supported models |
| Image input | Passed through for compatible models |

Use `providerOptions('cerebras', ['raw' => [...]])` for documented Cerebras chat-completions fields outside the portable SDK surface. Model IDs are opaque strings and are validated by Cerebras.

## Documentation

- [Cerebras OpenAI compatibility documentation](https://inference-docs.cerebras.ai/resources/openai)
- [PHP AI SDK documentation](https://phpaisdk.com/docs/cerebras)
