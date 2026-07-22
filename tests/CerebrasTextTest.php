<?php

declare(strict_types=1);
use AiSdk\Cerebras;
use AiSdk\Cerebras\Tests\Fakes\FakeHttpClient;
use AiSdk\Generate;
use AiSdk\Support\Sdk;
use Nyholm\Psr7\Factory\Psr17Factory;

afterEach(function (): void {
    Generate::reset();
    Cerebras::reset();
});
it('uses Cerebras general OpenAI-compatible chat completions', function (): void {
    $client = new FakeHttpClient(200, json_encode(['id' => 'cerebras-chat', 'model' => 'gpt-oss-120b', 'choices' => [['message' => ['content' => 'Hello from Cerebras Inference'], 'finish_reason' => 'stop']], 'usage' => ['prompt_tokens' => 3, 'completion_tokens' => 4]]));
    $factory = new Psr17Factory();
    Generate::configure(new Sdk($client, $factory, $factory));
    Cerebras::create(['apiKey' => 'cerebras-test']);
    $result = Generate::text('Hi')->model(Cerebras::model('gpt-oss-120b'))->run();
    expect($result->text)->toBe('Hello from Cerebras Inference')->and((string) $client->lastRequest?->getUri())->toBe('https://api.cerebras.ai/v1/chat/completions')->and($client->lastRequest?->getHeaderLine('Authorization'))->toBe('Bearer cerebras-test')->and($client->sentBody()['model'])->toBe('gpt-oss-120b');
});
it('accepts opaque Cerebras model identifiers', function (): void {
    Cerebras::create(['apiKey' => 'cerebras-test']);
    expect(Cerebras::model('private-gpt-oss-120b-model')->modelId())->toBe('private-gpt-oss-120b-model');
});
