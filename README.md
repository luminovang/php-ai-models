# PHP AI Model Helper Class

> **Type:** `const Model: string` *(final-class)* 

A static catalogue of AI model identifiers. Constants eliminate typos, enable IDE autocompletion, and create a single source across codebase.

---

## Installation

```php
composer install luminovang/php-ai-models
```

[`Luminova\AI\Model` (enum version)](https://github.com/luminovang/php-ai-models-enum) — PHP string-backed enum class.

---

## Table of Contents

- [Overview](#overview)
- [Installation / Import](#installation--import)
- [Naming Convention](#naming-convention)
- [Constants Reference](#constants-reference)
  - [OpenAI — GPT-5](#openai--gpt-5-family)
  - [OpenAI — GPT-4.1](#openai--gpt-41-family)
  - [OpenAI — GPT-4o](#openai--gpt-4o-family)
  - [OpenAI — Reasoning (o-series)](#openai--reasoning-o-series)
  - [OpenAI — Image Generation](#openai--image-generation)
  - [OpenAI — Text-to-Speech](#openai--text-to-speech)
  - [OpenAI — Transcription](#openai--transcription)
  - [OpenAI — Embeddings](#openai--embeddings)
  - [OpenAI — Moderation](#openai--moderation)
  - [Claude (Anthropic) — 4.6 Generation](#claude-anthropic--46-generation-current)
  - [Claude (Anthropic) — 4.5 Generation](#claude-anthropic--45-generation)
  - [Claude (Anthropic) — 4.1 Generation](#claude-anthropic--41-generation)
  - [Claude (Anthropic) — 4.0 Generation](#claude-anthropic--40-generation)
  - [Claude (Anthropic) — 3.7 Generation](#claude-anthropic--37-generation)
  - [Claude (Anthropic) — 3.5 Generation](#claude-anthropic--35-generation-legacy)
  - [Ollama — Llama](#ollama--llama-family-meta)
  - [Ollama — Gemma](#ollama--gemma-family-google)
  - [Ollama — Mistral / Mixtral](#ollama--mistral--mixtral)
  - [Ollama — Qwen](#ollama--qwen-family-alibaba)
  - [Ollama — DeepSeek](#ollama--deepseek-family)
  - [Ollama — Phi](#ollama--phi-family-microsoft)
  - [Ollama — Coding Models](#ollama--coding-models)
  - [Ollama — Vision Models](#ollama--vision-models)
  - [Ollama — Embedding Models](#ollama--embedding-models)
- [Static Methods](#static-methods)
  - [`client()`](#clientstring-model-string)
  - [`forClient()`](#forclientstring-client-array)
  - [`forCapability()`](#forcapabilitystring-capability-array)
  - [`capabilities()`](#capabilitiesstring-model-array)
  - [`isVision()`](#isvisionstring-model-bool)
  - [`isReasoning()`](#isreasoningstring-model-bool)
  - [`isEmbedding()`](#isembeddingstring-model-bool)
  - [`exists()`](#existsstring-model-bool)
  - [`all()`](#all-array)
- [Usage Examples](#usage-examples)
  - [Basic Usage](#basic-usage)
  - [Validating User Input](#validating-user-input)
  - [Iterating a Client's Models](#iterating-a-clients-models)
  - [Filtering by Capability](#filtering-by-capability)
  - [Guarding Vision Calls](#guarding-vision-calls)
  - [Routing by Client](#routing-by-client)

---

## Overview

`Model` is a `final` class that cannot be instantiated. All constants and methods are accessed statically:

```php
use Luminova\AI\Model;

// Anywhere a model string is expected — pass the constant value.
$ai->message('Hello!', ['model' => Model::GPT_4_1_MINI]);
$ai->embed('Hello world', ['model' => Model::TEXT_EMBEDDING_3_SMALL]);
$ai->vision('Describe this.', '/tmp/img.png', ['model' => Model::LLAVA]);
```

---

## Import

```php
use Luminova\AI\Model;
```

No additional dependencies. The class uses `ReflectionClass` (PHP core) only for the `all()` helper method.

---

## Naming Convention

| Rule | Example |
|---|---|
| Hyphens and dots → underscores | `gpt-4.1-mini` → `GPT_4_1_MINI` |
| Size tag suffix (`:8b`) | `llama3.1:8b` → `LLAMA_3_1_8B` |
| MoE tag (`8x7b`) | `mixtral:8x7b` → `MIXTRAL_8X7B` |
| Versioned snapshot | `claude-opus-4-5-20251101` → `CLAUDE_OPUS_4_5_SNAP` |
| Clean alias alongside snapshot | `claude-opus-4-5` → `CLAUDE_OPUS_4_5` |

---

## Constants Reference

### OpenAI — GPT-5 Family

| Constant | API Value | Notes |
|---|---|---|
| `Model::GPT_5` | `gpt-5` | Flagship model. Complex reasoning, multimodal, 256 K context. |
| `Model::GPT_5_MINI` | `gpt-5-mini` | Faster, more affordable GPT-5 variant. |
| `Model::GPT_5_NANO` | `gpt-5-nano` | Smallest GPT-5; optimized for latency and cost. |

### OpenAI — GPT-4.1 Family

| Constant | API Value | Notes |
|---|---|---|
| `Model::GPT_4_1` | `gpt-4.1` | 1 M token context, instruction-following, coding. Supports fine-tuning. |
| `Model::GPT_4_1_MINI` | `gpt-4.1-mini` | **Default chat model** for the Luminova OpenAI client. Supports fine-tuning. |
| `Model::GPT_4_1_NANO` | `gpt-4.1-nano` | Fastest / cheapest GPT-4.1. Supports fine-tuning. |

### OpenAI — GPT-4o Family

| Constant | API Value | Notes |
|---|---|---|
| `Model::GPT_4O` | `gpt-4o` | Multimodal (text + image + audio). 128 K context. |
| `Model::GPT_4O_MINI` | `gpt-4o-mini` | Lightweight GPT-4o. 128 K context. |
| `Model::GPT_4O_AUDIO` | `gpt-4o-audio-preview` | Native audio I/O. |
| `Model::GPT_4O_MINI_AUDIO` | `gpt-4o-mini-audio-preview` | Lower-cost audio variant. |
| `Model::GPT_4O_REALTIME` | `gpt-4o-realtime-preview` | Low-latency real-time speech and text. |
| `Model::GPT_4O_MINI_REALTIME` | `gpt-4o-mini-realtime-preview` | Lower-cost realtime variant. |
| `Model::COMPUTER_USE` | `computer-use-preview` | GUI interaction via the Responses API. |

### OpenAI — Reasoning (o-series)

| Constant | API Value | Notes |
|---|---|---|
| `Model::O3` | `o3` | Most capable reasoning model. Supports visual reasoning. |
| `Model::O3_PRO` | `o3-pro` | o3 with extra compute for critical tasks. |
| `Model::O3_DEEP_RESEARCH` | `o3-deep-research` | Multi-step web and document research. |
| `Model::O4_MINI` | `o4-mini` | Fast reasoning; top benchmark for math/coding/vision. |
| `Model::O4_MINI_DEEP_RESEARCH` | `o4-mini-deep-research` | Deep research variant of o4 Mini. |

### OpenAI — Image Generation

| Constant | API Value | Notes |
|---|---|---|
| `Model::GPT_IMAGE_1_5` | `gpt-image-1.5` | Latest image model. High-resolution + inpainting. Requires approval. |
| `Model::GPT_IMAGE_1` | `gpt-image-1` | **Default image model** for the Luminova OpenAI client. Requires approval. |
| `Model::DALL_E_3` | `dall-e-3` | Generally available. Up to 1792×1024 px. |
| `Model::DALL_E_2` | `dall-e-2` | Previous generation; lower cost. |

### OpenAI — Text-to-Speech

| Constant | API Value | Notes |
|---|---|---|
| `Model::GPT_4O_MINI_TTS` | `gpt-4o-mini-tts` | **Default TTS model.** Voices: `alloy`, `echo`, `fable`, `onyx`, `nova`, `shimmer`. |
| `Model::TTS_1` | `tts-1` | Optimized for real-time use. |
| `Model::TTS_1_HD` | `tts-1-hd` | Higher quality, more natural intonation. |

### OpenAI — Transcription

| Constant | API Value | Notes |
|---|---|---|
| `Model::GPT_4O_TRANSCRIBE` | `gpt-4o-transcribe` | Superior accuracy, multilingual. |
| `Model::GPT_4O_MINI_TRANSCRIBE` | `gpt-4o-mini-transcribe` | Faster, lower-cost. Currently recommended. |
| `Model::WHISPER_1` | `whisper-1` | **Default transcription model.** 99+ languages. |

### OpenAI — Embeddings

| Constant | API Value | Notes |
|---|---|---|
| `Model::TEXT_EMBEDDING_3_LARGE` | `text-embedding-3-large` | Highest accuracy. 3072-dimensional (reducible). Best for RAG. |
| `Model::TEXT_EMBEDDING_3_SMALL` | `text-embedding-3-small` | **Default embedding model.** 1536-dimensional. |
| `Model::TEXT_EMBEDDING_ADA_002` | `text-embedding-ada-002` | Legacy. Prefer `TEXT_EMBEDDING_3_SMALL` for new work. |

### OpenAI — Moderation

| Constant | API Value | Notes |
|---|---|---|
| `Model::OMNI_MODERATION` | `omni-moderation-latest` | Text + image moderation. |
| `Model::TEXT_MODERATION` | `text-moderation-latest` | Text-only moderation. |

---

### Claude (Anthropic) — 4.6 Generation *(current)*

| Constant | API Value | Notes |
|---|---|---|
| `Model::CLAUDE_OPUS_4_6` | `claude-opus-4-6` | Most capable. ~14.5 h task horizon. 1 M context (beta). |
| `Model::CLAUDE_SONNET_4_6` | `claude-sonnet-4-6` | **Default Claude model.** Preferred by developers over previous Opus. |

### Claude (Anthropic) — 4.5 Generation

| Constant | API Value | Notes |
|---|---|---|
| `Model::CLAUDE_OPUS_4_5` | `claude-opus-4-5` | 67% price cut, 76% fewer output tokens vs previous Opus. |
| `Model::CLAUDE_OPUS_4_5_SNAP` | `claude-opus-4-5-20251101` | Pinned snapshot — guaranteed reproducibility. |
| `Model::CLAUDE_SONNET_4_5` | `claude-sonnet-4-5` | Industry-leading agent capabilities. |
| `Model::CLAUDE_HAIKU_4_5` | `claude-haiku-4-5` | Fastest, most cost-effective Claude 4.5. |
| `Model::CLAUDE_HAIKU_4_5_SNAP` | `claude-haiku-4-5-20251001` | Pinned snapshot. |

### Claude (Anthropic) — 4.1 Generation

| Constant | API Value | Notes |
|---|---|---|
| `Model::CLAUDE_OPUS_4_1` | `claude-opus-4-1` | Industry leader for coding and long-horizon agentic tasks. |
| `Model::CLAUDE_OPUS_4_1_SNAP` | `claude-opus-4-1-20250805` | Pinned snapshot. |
| `Model::CLAUDE_SONNET_4_1` | `claude-sonnet-4-1` | Production-ready agents at scale. |

### Claude (Anthropic) — 4.0 Generation

| Constant | API Value | Notes |
|---|---|---|
| `Model::CLAUDE_OPUS_4` | `claude-opus-4-0` | First Claude 4-gen Opus. State-of-the-art coding at release. |
| `Model::CLAUDE_SONNET_4` | `claude-sonnet-4-0` | First Claude 4-gen Sonnet. Fast and context-aware. |

### Claude (Anthropic) — 3.7 Generation

| Constant | API Value | Notes |
|---|---|---|
| `Model::CLAUDE_SONNET_3_7` | `claude-sonnet-3-7` | Introduced extended (hybrid) thinking. |
| `Model::CLAUDE_SONNET_3_7_SNAP` | `claude-3-7-sonnet-20250219` | Pinned snapshot. |

### Claude (Anthropic) — 3.5 Generation *(legacy)*

| Constant | API Value | Notes |
|---|---|---|
| `Model::CLAUDE_SONNET_3_5` | `claude-3-5-sonnet-20241022` | Upgraded Sonnet with computer use (Oct 2024). |
| `Model::CLAUDE_HAIKU_3_5` | `claude-3-5-haiku-20241022` | Lightweight, fast. Ideal for rapid completions. |

---

### Ollama — Llama Family (Meta)

| Constant | API Value | Notes |
|---|---|---|
| `Model::LLAMA_3` | `llama3` | Baseline Llama 3 (8 B). Most widely deployed. |
| `Model::LLAMA_3_1` | `llama3.1` | 128 K context support. |
| `Model::LLAMA_3_1_8B` | `llama3.1:8b` | Explicit 8 B tag. |
| `Model::LLAMA_3_1_70B` | `llama3.1:70b` | Large-scale; multi-GPU or high-VRAM. |
| `Model::LLAMA_3_2` | `llama3.2` | Compact (1 B / 3 B). Optimized for edge hardware. |
| `Model::LLAMA_3_2_1B` | `llama3.2:1b` | Ultra-compact for edge and embedded use. |
| `Model::LLAMA_3_2_3B` | `llama3.2:3b` | Small but capable for CLI copilots. |
| `Model::LLAMA_3_3` | `llama3.3` | Latest large Llama (70 B). Excellent long-form chat. |
| `Model::LLAMA_3_3_70B` | `llama3.3:70b` | Explicit 70 B tag. |

### Ollama — Gemma Family (Google)

| Constant | API Value | Notes |
|---|---|---|
| `Model::GEMMA_3` | `gemma3` | Current-gen (1 B–27 B). 128 K context; vision-capable (4 B+). |
| `Model::GEMMA_3_4B` | `gemma3:4b` | Vision-capable; fits 8 GB VRAM. |
| `Model::GEMMA_3_12B` | `gemma3:12b` | 12–16 GB VRAM sweet spot. |
| `Model::GEMMA_3_27B` | `gemma3:27b` | Flagship Gemma 3 variant. |
| `Model::GEMMA_2` | `gemma2` | Previous gen; proven reliability (2 B, 9 B, 27 B). |
| `Model::GEMMA_2_2B` | `gemma2:2b` | Smallest Gemma 2; edge deployments. |
| `Model::GEMMA_2_9B` | `gemma2:9b` | Good performance within 10 GB VRAM. |
| `Model::GEMMA_2_27B` | `gemma2:27b` | Creative and NLP-focused tasks. |

### Ollama — Mistral / Mixtral

| Constant | API Value | Notes |
|---|---|---|
| `Model::MISTRAL` | `mistral` | Fast 7 B model with strong European language support. |
| `Model::MISTRAL_7B` | `mistral:7b` | Explicit 7 B tag. |
| `Model::MIXTRAL_8X7B` | `mixtral:8x7b` | Mixture-of-Experts; 2 experts active per token. |
| `Model::MIXTRAL_8X22B` | `mixtral:8x22b` | Larger MoE; near-frontier quality for local hardware. |

### Ollama — Qwen Family (Alibaba)

| Constant | API Value | Notes |
|---|---|---|
| `Model::QWEN_3` | `qwen3` | Latest generation. Up to 256 K context; strong multilingual. |
| `Model::QWEN_3_4B` | `qwen3:4b` | Compact; fits low-VRAM hardware. |
| `Model::QWEN_3_14B` | `qwen3:14b` | Mid-range; single consumer GPU. |
| `Model::QWEN_3_72B` | `qwen3:72b` | Maximum capability; enterprise-grade. |
| `Model::QWEN_2_5` | `qwen2.5` | Previous gen; 18 T tokens; 128 K context. |
| `Model::QWEN_2_5_7B` | `qwen2.5:7b` | |
| `Model::QWEN_2_5_14B` | `qwen2.5:14b` | |
| `Model::QWEN_2_5_CODER` | `qwen2.5-coder` | Coding-focused; 87 languages; matches GPT-4o at 32 B. |
| `Model::QWEN_2_5_CODER_7B` | `qwen2.5-coder:7b` | Excellent code quality on limited hardware. |
| `Model::QWEN_2_5_CODER_32B` | `qwen2.5-coder:32b` | Best local coding model at this scale. |

### Ollama — DeepSeek Family

| Constant | API Value | Notes |
|---|---|---|
| `Model::DEEPSEEK_R1` | `deepseek-r1` | Open reasoning model; matches o3 on key benchmarks. |
| `Model::DEEPSEEK_R1_7B` | `deepseek-r1:7b` | Smallest R1; 8–10 GB VRAM. |
| `Model::DEEPSEEK_R1_14B` | `deepseek-r1:14b` | Best mid-range reasoning for home labs. |
| `Model::DEEPSEEK_R1_32B` | `deepseek-r1:32b` | 24 GB+ VRAM setups. |
| `Model::DEEPSEEK_R1_70B` | `deepseek-r1:70b` | Near-frontier; multi-GPU recommended. |
| `Model::DEEPSEEK_CODER` | `deepseek-coder` | 87 programming languages; 2 T training tokens. |
| `Model::DEEPSEEK_CODER_33B` | `deepseek-coder:33b` | Top-quality local code generation. |

### Ollama — Phi Family (Microsoft)

| Constant | API Value | Notes |
|---|---|---|
| `Model::PHI_4` | `phi4` | Latest lightweight model; 14 B, 128 K context. |
| `Model::PHI_4_14B` | `phi4:14b` | Explicit 14 B tag. |
| `Model::PHI_3` | `phi3` | Previous gen (3.8 B Mini / 14 B Medium). |
| `Model::PHI_3_MINI` | `phi3:mini` | 3.8 B; suitable for on-device and IoT. |

### Ollama — Coding Models

| Constant | API Value | Notes |
|---|---|---|
| `Model::CODE_LLAMA` | `codellama` | Meta's code-focused Llama (7 B–70 B). Fill-in-the-middle support. |
| `Model::CODE_LLAMA_13B` | `codellama:13b` | Good balance of code quality and hardware. |
| `Model::CODE_LLAMA_34B` | `codellama:34b` | High-quality generation for 24 GB VRAM. |

### Ollama — Vision Models

| Constant | API Value | Notes |
|---|---|---|
| `Model::LLAVA` | `llava` | **Default vision model** for the Luminova Ollama client. |
| `Model::LLAVA_13B` | `llava:13b` | Stronger vision understanding. |
| `Model::LLAVA_34B` | `llava:34b` | Highest-quality LLaVA; 24+ GB VRAM. |
| `Model::LLAMA_3_2_VISION` | `llama3.2-vision` | Better structured-output than LLaVA. |
| `Model::MOONDREAM` | `moondream` | Tiny (1.8 B); edge devices; fast captioning. |
| `Model::BAKLLAVA` | `bakllava` | Mistral-7B base with LLaVA multimodal fine-tuning. |

### Ollama — Embedding Models

| Constant | API Value | Notes |
|---|---|---|
| `Model::NOMIC_EMBED_TEXT` | `nomic-embed-text` | **Default embedding model.** 8 K context; strong MTEB scores. |
| `Model::MXBAI_EMBED_LARGE` | `mxbai-embed-large` | 1024-dimensional; competitive with OpenAI's large model. |
| `Model::ALL_MINILM` | `all-minilm` | 384-dimensional; very fast similarity search. |

---

## Static Methods

### `client(string $model): string|null`

Return the client short-name for a given model string. Returns `null` for unknown models.

```php
Model::client(Model::GPT_4_1_MINI);      // 'openai'
Model::client(Model::CLAUDE_SONNET_4_6); // 'anthropic'
Model::client(Model::LLAVA);             // 'ollama'
Model::client('my-custom-model');        // null
```

---

### `forClient(string $client): array`

Return all `['CONST_NAME' => 'model-id']` pairs that belong to a specific client.

```php
$openaiModels    = Model::forClient('openai');
$anthropicModels = Model::forClient('anthropic');
$ollamaModels    = Model::forClient('ollama');

foreach ($ollamaModels as $name => $id) {
    echo "{$name} => {$id}" . PHP_EOL;
}
// LLAMA_3 => llama3
// LLAMA_3_1 => llama3.1
// ...
```

---

### `forCapability(string $capability): array`

Return all `['CONST_NAME' => 'model-id']` pairs that support a given capability tag.

**Available tags:** `chat`, `vision`, `image`, `embedding`, `speech`, `transcription`, `reasoning`, `coding`, `fine-tuning`, `moderation`.

```php
$visionModels    = Model::forCapability('vision');
$embeddingModels = Model::forCapability('embedding');
$reasoningModels = Model::forCapability('reasoning');
```

---

### `capabilities(string $model): array`

Return all capability tags for a given model string.

```php
Model::capabilities(Model::O3);
// ['chat', 'vision', 'reasoning', 'coding']

Model::capabilities(Model::NOMIC_EMBED_TEXT);
// ['embedding']

Model::capabilities(Model::DALL_E_3);
// ['image']
```

---

### `isVision(string $model): bool`

```php
Model::isVision(Model::GPT_4_1);          // true
Model::isVision(Model::LLAVA);            // true
Model::isVision(Model::NOMIC_EMBED_TEXT); // false
```

---

### `isReasoning(string $model): bool`

```php
Model::isReasoning(Model::O3);            // true
Model::isReasoning(Model::DEEPSEEK_R1);  // true
Model::isReasoning(Model::GPT_4_1_MINI); // false
```

---

### `isEmbedding(string $model): bool`

```php
Model::isEmbedding(Model::TEXT_EMBEDDING_3_SMALL); // true
Model::isEmbedding(Model::NOMIC_EMBED_TEXT);       // true
Model::isEmbedding(Model::GPT_4_1);                // false
```

---

### `exists(string $model): bool`

Check whether a model string is catalogued. Useful for validating user-supplied input before sending it to a client API.

```php
Model::exists(Model::GPT_4_1_MINI);  // true
Model::exists('my-custom-model');    // false
```

---

### `all(): array`

Return every public constant as a `['CONST_NAME' => 'model-id']` map using reflection. Private constants (`PROVIDER_MAP`, `CAPABILITY_MAP`) are automatically excluded.

```php
$all = Model::all();
// [
//   'GPT_5'          => 'gpt-5',
//   'GPT_5_MINI'     => 'gpt-5-mini',
//   'GPT_4_1_MINI'   => 'gpt-4.1-mini',
//   ...
// ]

echo count(Model::all()); // 103
```

---

## Usage Examples

### Basic Usage

```php
use Luminova\AI\Model;
use Luminova\AI\AI;

// Chat
$reply = AI::Openai($key)->message('Hello!', [
    'model' => Model::GPT_4_1_MINI,
]);

// Chat with Claude
$reply = AI::Anthropic($key)->message('Summarise this.', [
    'model' => Model::CLAUDE_SONNET_4_6,
]);

// Local inference with Ollama
$reply = AI::Ollama()->message('Explain recursion.', [
    'model' => Model::LLAMA_3_2,
]);

// Embeddings
$vector = AI::Openai($key)->embed('Hello world', [
    'model' => Model::TEXT_EMBEDDING_3_SMALL,
]);

// Vision
$output = AI::Openai($key)->vision('What is in this image?', '/tmp/photo.jpg', [
    'model' => Model::GPT_4_1,
]);
```

---

### Validating User Input

```php
$userModel = $request->get('model', Model::GPT_4_1_MINI);

if (!Model::exists($userModel)) {
    throw new InvalidArgumentException("Unknown model: {$userModel}");
}

$reply = $ai->message('Hello!', ['model' => $userModel]);
```

---

### Iterating a Client's Models

```php
// Build a select list for a UI
$options = [];

foreach (Model::forClient('openai') as $name => $id) {
    $options[$id] = str_replace('_', ' ', ucfirst(strtolower($name)));
}

// ['gpt-4.1-mini' => 'Gpt 4 1 mini', ...]
```

---

### Filtering by Capability

```php
// Only offer vision-capable models in the UI
$visionModels = Model::forCapability('vision');

// Only offer embedding models for the vector store config
$embeddingModels = Model::forCapability('embedding');

// Show reasoning models separately
$reasoningModels = Model::forCapability('reasoning');
```

---

### Guarding Vision Calls

```php
function analyzeImage(string $prompt, string $imagePath, string $model): array
{
    if (!Model::isVision($model)) {
        throw new RuntimeException(
            "Model '{$model}' does not support vision. " .
            "Try: " . Model::GPT_4_1 . " or " . Model::LLAVA
        );
    }

    return AI::getInstance()->vision($prompt, $imagePath, ['model' => $model]);
}

analyzeImage('Describe this chart.', '/tmp/q4.png', Model::GPT_4_1);   // OK
analyzeImage('Describe this chart.', '/tmp/q4.png', Model::WHISPER_1); // throws
```

---

### Routing by Client

```php
use Luminova\AI\AI;
use Luminova\AI\Model;

function chat(string $prompt, string $model): array
{
    $client = Model::client($model);

    return match ($client) {
        'openai'    => AI::Openai($_ENV['OPENAI_KEY'])->message($prompt, ['model' => $model]),
        'anthropic' => AI::Anthropic($_ENV['ANTHROPIC_KEY'])->message($prompt, ['model' => $model]),
        'ollama'    => AI::Ollama()->message($prompt, ['model' => $model]),
        default     => throw new RuntimeException("Unsupported client: {$client}"),
    };
}

chat('Tell me a joke.', Model::GPT_4_1_MINI);   // routed to OpenAI
chat('Tell me a joke.', Model::CLAUDE_SONNET_4_6); // routed to Anthropic
chat('Tell me a joke.', Model::LLAMA_3_2);      // routed to Ollama
```

---

## See Also

- [`Luminova\AI\Model` (enum version)](https://github.com/luminovang/php-ai-models-enum) — PHP 8.1+ string-backed enum with instance methods and type-safe signatures.
