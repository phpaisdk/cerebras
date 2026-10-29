# aisdk/cerebras: guide for coding agents

Official Cerebras provider for the PHP AI SDK. Part of the framework-agnostic [PHP AI SDK](https://phpaisdk.com); build on `aisdk/core`, keep provider wire details in this package.

## Using it

```php
use AiSdk\Cerebras;
use AiSdk\Generate;

Cerebras::create(['apiKey' => '...']); // optional: environment variables below are read automatically

$result = Generate::text('Hello')
    ->model(Cerebras::model('model-id'))
    ->run();
```

- Entry point: `AiSdk\Cerebras` (`create()`, `default()`, `reset()`, `model()`), source in `src/Root/Cerebras.php`.
- Namespace: `AiSdk\Cerebras\` in `src/`.
- Provider key for call options: `->providerOptions('cerebras', [...])`.
- Common environment variables (see README.md for the full list): `CEREBRAS_API_KEY`, `CEREBRAS_BASE_URL`.

## Supported capabilities

| Capability | Support |
| --- | --- |
| Text generation and streaming | Native OpenAI-compatible chat |
| Tool calling, structured output, reasoning | Passed through for supported models |
| Image input | Passed through for compatible models |

Use `providerOptions('cerebras', ['raw' => [...]])` for documented Cerebras chat-completions fields outside the portable SDK surface. Model IDs are opaque strings and are validated by Cerebras.

## Rules for changes

1. **Model ids are opaque strings.** Use `Cerebras::model('id')`. Never validate an id against a list, never ship a model catalog, and never add capability-specific public factories such as `textModel()` or `imageModel()`. The operation (`Generate::text()`, `Generate::image()`, ...) resolves the right adapter when it runs.
2. **Provider wire behavior lives here, portable behavior lives in `aisdk/core`.** Do not leak this provider's request/response shapes into core, and do not put portable logic here.
3. **The request/response mapping is shared** through `aisdk/openai-compatible`. If a change would apply to other OpenAI-compatible providers, make it there; keep only this provider's quirks (endpoint, headers, parameter names via a request profile) in this package.
4. **Do not invent generation defaults.** Send `maxTokens`, `temperature` and `topP` only when the `TextModelRequest` carries a value. Apply a provider default only where the API requires the field.
5. **Credentials come from config or environment**, never from code. Do not log request headers or bodies that contain keys.
6. **Unsupported features fail fast** with a typed exception from `AiSdk\Exceptions` before any HTTP call, rather than sending a request the provider will reject.

## Layout

| Path | Purpose |
|---|---|
| `src/Root/Cerebras.php` | Public facade |
| `src/CerebrasProvider.php` | Provider: resolves a model id to a capability adapter |
| `src/CerebrasOptions.php` | Configuration (config array and environment) |
| `tests/` | Pest tests |

## Commands

```bash
composer lint      # pint --test
composer analyze   # phpstan level 8
composer test      # pest
composer test:all  # all of the above
```

## Testing

- Tests never touch the network. Use `tests/Fakes/FakeHttpClient.php` with a PSR-17 factory and `Generate::configure(new Sdk(...))`; see an existing test for the pattern.
- Cover request shaping (assert the JSON body), response parsing, streaming, and error mapping for every capability you change.
- Do not edit `vendor/`. This package is installed against a released `aisdk/core`; if a test needs unreleased core behavior, run it against the local core checkout rather than loosening assertions.

## Docs

- Package docs: https://phpaisdk.com/docs/cerebras.md
- All documentation for agents: https://phpaisdk.com/llms.txt (full text: https://phpaisdk.com/llms-full.txt)
- Core concepts (providers, models, tools, streaming): https://phpaisdk.com/docs/introduction.md

## Changelog

Keep `CHANGELOG.md` current: add short, user-facing entries (what users can do now, dependency compatibility) for every release. Release notes on GitHub should match.
