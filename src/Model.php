<?php
/**
 * Luminova Framework
 *
 * @package Luminova
 * @author Ujah Chigozie Peter
 * @copyright (c) Nanoblock Technology Ltd
 * @license See LICENSE file
 * @link https://luminova.ng
 */
namespace Luminova\AI;

use \ReflectionClass;

/**
 * Catalogue of AI model identifiers for all supported Luminova providers.
 *
 * Every constant maps a readable PHP name to the exact API model string that
 * each provider expects in its `model` field. Use the constants in place of
 * raw strings so that typos fail at parse-time and IDEs can autocomplete:
 *
 * ```php
 * use Luminova\AI\Model;
 * 
 * use Luminova\AI\Model;
 * use Luminova\AI\AI;
 *
 * $reply = AI::Openai($key)->message('Hello!', ['model' => Model::GPT_4_1_MINI]);
 * $reply = AI::Anthropic($key)->message('Hello!', ['model' => Model::CLAUDE_SONNET_4_6]);
 * $reply = AI::Ollama()->message('Hello!', ['model' => Model::LLAMA_3_2]);
 * ```
 *
 * **Constant naming convention**
 * - Dots and hyphens in model IDs become underscores: `gpt-4.1-mini` → `GPT_4_1_MINI`.
 * - Tag suffixes (e.g. `:8b`) are appended with an underscore: `llama3.2:8b` → `LLAMA_3_2_8B`.
 * - Versioned snapshot suffixes are preserved: `CLAUDE_HAIKU_4_5_SNAP` points to
 *   the full dated snapshot string.
 *
 * **Sections**
 * - [OPENAI]  GPT-5, GPT-4.1, GPT-4o, Reasoning (o-series), Image, Audio, Embeddings
 * - [CLAUDE]  Opus, Sonnet, Haiku — current + recent generations
 * - [OLLAMA]  General, Reasoning, Coding, Vision, Embedding models
 *
 * @see https://platform.openai.com/docs/models
 * @see https://docs.anthropic.com/en/docs/about-claude/models
 * @see https://ollama.com/library
 */
final class Model
{
    /**
     * GPT-5 — OpenAI's flagship model (complex reasoning, coding, multimodal).
     * Supports text + image input, text output. Up to 256 K tokens context.
     *
     * @link https://platform.openai.com/docs/models/gpt-5
     */
    public const GPT_5 = 'gpt-5';

    /**
     * GPT-5 Mini — faster, more cost-effective variant of GPT-5.
     * Strong balance of capability and price for well-defined tasks.
     */
    public const GPT_5_MINI = 'gpt-5-mini';

    /**
     * GPT-5 Nano — smallest GPT-5 variant; optimised for latency and cost.
     */
    public const GPT_5_NANO = 'gpt-5-nano';

    /**
     * GPT-4.1 — improved instruction-following, coding, and long-context (1 M tokens).
     * Supports fine-tuning.
     *
     * @link https://platform.openai.com/docs/models/gpt-4-1
     */
    public const GPT_4_1 = 'gpt-4.1';

    /**
     * GPT-4.1 Mini — efficient mid-tier model, also supports fine-tuning.
     * Default chat model for the Luminova OpenAI provider.
     */
    public const GPT_4_1_MINI = 'gpt-4.1-mini';

    /**
     * GPT-4.1 Nano — fastest, lowest-cost GPT-4.1 variant.
     * Supports fine-tuning. Ideal for simple classification or extraction tasks.
     */
    public const GPT_4_1_NANO = 'gpt-4.1-nano';

    /**
     * GPT-4o — multimodal model with text and image input, audio I/O capability.
     * 128 K token context window.
     */
    public const GPT_4O = 'gpt-4o';

    /**
     * GPT-4o Mini — lightweight, cost-effective GPT-4o variant.
     * Handles large contexts (128 K) at a fraction of GPT-4o's cost.
     */
    public const GPT_4O_MINI = 'gpt-4o-mini';

    /**
     * GPT-4o Audio — GPT-4o with native audio input and output support.
     * Best used with the Realtime and Audio APIs.
     */
    public const GPT_4O_AUDIO = 'gpt-4o-audio-preview';

    /**
     * GPT-4o Mini Audio — lower-cost audio variant of GPT-4o Mini.
     */
    public const GPT_4O_MINI_AUDIO = 'gpt-4o-mini-audio-preview';

    /**
     * GPT-4o Realtime — optimised for low-latency real-time speech and text.
     */
    public const GPT_4O_REALTIME = 'gpt-4o-realtime-preview';

    /**
     * GPT-4o Mini Realtime — low-latency, lower-cost realtime variant.
     */
    public const GPT_4O_MINI_REALTIME = 'gpt-4o-mini-realtime-preview';

    /**
     * Computer Use Preview — model tuned to interact with GUI interfaces.
     * Used alongside the Computer Use tool in the Responses API.
     */
    public const COMPUTER_USE = 'computer-use-preview';

    /**
     * o3 — OpenAI's most capable general-purpose reasoning model.
     * Excels at math, science, coding, and multi-step analysis.
     * Supports visual reasoning and agentic tool use.
     *
     * @link https://platform.openai.com/docs/models/o3
     */
    public const O3 = 'o3';

    /**
     * o3 Pro — o3 with additional compute for maximum reasoning reliability.
     * Best for critical or research-grade tasks where accuracy is paramount.
     */
    public const O3_PRO = 'o3-pro';

    /**
     * o3 Deep Research — multi-step web and document research variant of o3.
     * Breaks queries into sub-questions, searches sources, and synthesises findings.
     */
    public const O3_DEEP_RESEARCH = 'o3-deep-research';

    /**
     * o4 Mini — fast, cost-efficient reasoning model.
     * Top-performing benchmark model for math, coding, and visual tasks.
     *
     * @link https://platform.openai.com/docs/models/o4-mini
     */
    public const O4_MINI = 'o4-mini';

    /**
     * o4 Mini Deep Research — deep research variant of o4 Mini.
     */
    public const O4_MINI_DEEP_RESEARCH = 'o4-mini-deep-research';

    /**
     * GPT Image 1.5 — latest and most capable OpenAI image generation model.
     * Supersedes GPT Image 1. Supports high-resolution generation and inpainting.
     * Requires access approval.
     */
    public const GPT_IMAGE_1_5 = 'gpt-image-1.5';

    /**
     * GPT Image 1 — first-generation unified image model.
     * Supports generation, inpainting, and editing workflows.
     * Requires access approval.
     */
    public const GPT_IMAGE_1 = 'gpt-image-1';

    /**
     * DALL-E 3 — high-quality image generation model, generally available.
     * Supports 1024×1024, 1792×1024, and 1024×1792 pixel outputs.
     */
    public const DALL_E_3 = 'dall-e-3';

    /**
     * DALL-E 2 — previous-generation image model; more affordable, lower detail.
     */
    public const DALL_E_2 = 'dall-e-2';

    /**
     * GPT-4o Mini TTS — expressive, controllable speech synthesis.
     * Default TTS model in the Luminova OpenAI provider.
     * Voices: `alloy`, `echo`, `fable`, `onyx`, `nova`, `shimmer`.
     */
    public const GPT_4O_MINI_TTS = 'gpt-4o-mini-tts';

    /**
     * TTS-1 — OpenAI's first-generation TTS model; optimised for real-time use.
     * Six preset voices. Lower latency than TTS-1 HD.
     */
    public const TTS_1 = 'tts-1';

    /**
     * TTS-1 HD — higher-quality TTS model; more natural intonation and smoothness.
     */
    public const TTS_1_HD = 'tts-1-hd';

    /**
     * GPT-4o Transcribe — superior transcription accuracy with multilingual support.
     * Recommended for high-accuracy production use.
     */
    public const GPT_4O_TRANSCRIBE = 'gpt-4o-transcribe';

    /**
     * GPT-4o Mini Transcribe — faster, lower-cost transcription model.
     * Currently recommended over GPT-4o Transcribe for most use cases.
     */
    public const GPT_4O_MINI_TRANSCRIBE = 'gpt-4o-mini-transcribe';

    /**
     * Whisper-1 — general-purpose speech recognition model.
     * Near-human accuracy across 99+ languages. Available via the Audio API.
     * Default transcription model in the Luminova OpenAI provider.
     */
    public const WHISPER_1 = 'whisper-1';

    /**
     * Text Embedding 3 Large — latest, highest-accuracy embedding model.
     * Best for semantic search, clustering, and production RAG pipelines.
     * 3072-dimensional output (reducible via `dimensions` parameter).
     */
    public const TEXT_EMBEDDING_3_LARGE = 'text-embedding-3-large';

    /**
     * Text Embedding 3 Small — efficient third-generation embedding model.
     * Default embedding model in the Luminova OpenAI provider.
     * 1536-dimensional output; outperforms text-embedding-ada-002.
     */
    public const TEXT_EMBEDDING_3_SMALL = 'text-embedding-3-small';

    /**
     * Text Embedding Ada 002 — second-generation embedding model (legacy).
     * Retained for backward compatibility. Prefer Text Embedding 3 Small for new work.
     */
    public const TEXT_EMBEDDING_ADA_002 = 'text-embedding-ada-002';

    /**
     * Omni Moderation Latest — multi-modal content moderation (text + image).
     */
    public const OMNI_MODERATION = 'omni-moderation-latest';

    /**
     * Text Moderation Latest — text-only content moderation model.
     */
    public const TEXT_MODERATION = 'text-moderation-latest';

    /**
     * Claude Opus 4.6 — Anthropic's most capable model (Feb 2026).
     * Exceptional coding, reasoning, and agent capabilities.
     * Supports up to 1 M token context with `context-1m-2025-08-07` beta header.
     * 50% task-completion horizon of ~14.5 hours (METR benchmark).
     *
     * @link https://docs.anthropic.com/en/docs/about-claude/models
     */
    public const CLAUDE_OPUS_4_6 = 'claude-opus-4-6';

    /**
     * Claude Sonnet 4.6 — latest Sonnet model (Feb 2026).
     * Preferred over previous Opus in coding evaluations by 59% of developers.
     * Same price as Sonnet 4.5. Supports 1 M token context with beta header.
     * Default Claude model in the Luminova Anthropic provider.
     */
    public const CLAUDE_SONNET_4_6 = 'claude-sonnet-4-6';

    /**
     * Claude Opus 4.5 — Opus-class model (Nov 2025).
     * 67% price cut over previous Opus; 76% fewer output tokens.
     * Strong coding, computer use, and cybersecurity capabilities.
     */
    public const CLAUDE_OPUS_4_5 = 'claude-opus-4-5';

    /**
     * Claude Opus 4.5 (versioned snapshot) — pinned to the 2025-11-01 release.
     * Use this constant when you need guaranteed reproducibility across deployments.
     */
    public const CLAUDE_OPUS_4_5_SNAP = 'claude-opus-4-5-20251101';

    /**
     * Claude Sonnet 4.5 — Sonnet-class model with industry-leading agent capabilities.
     * Excels at coding, computer use, and working with office files.
     */
    public const CLAUDE_SONNET_4_5 = 'claude-sonnet-4-5';

    /**
     * Claude Haiku 4.5 — fastest, most cost-effective Claude 4.5 model (Oct 2025).
     * Targets smaller companies needing fast, affordable AI assistance.
     */
    public const CLAUDE_HAIKU_4_5 = 'claude-haiku-4-5';

    /**
     * Claude Haiku 4.5 (versioned snapshot) — pinned to the 2025-10-01 release.
     */
    public const CLAUDE_HAIKU_4_5_SNAP = 'claude-haiku-4-5-20251001';

    /**
     * Claude Opus 4.1 — Opus-class model (Aug 2025).
     * Industry leader for coding, agentic search, and long-horizon tasks.
     */
    public const CLAUDE_OPUS_4_1 = 'claude-opus-4-1';

    /**
     * Claude Opus 4.1 (versioned snapshot) — pinned to the 2025-08-05 release.
     */
    public const CLAUDE_OPUS_4_1_SNAP = 'claude-opus-4-1-20250805';

    /**
     * Claude Sonnet 4.1 — Sonnet-class model; production-ready agents at scale.
     */
    public const CLAUDE_SONNET_4_1 = 'claude-sonnet-4-1';

    /**
     * Claude Opus 4 — first Claude 4-generation Opus (May 2025).
     * State-of-the-art for coding and agent capabilities at release.
     */
    public const CLAUDE_OPUS_4 = 'claude-opus-4-0';

    /**
     * Claude Sonnet 4 — first Claude 4-generation Sonnet (May 2025).
     * Default for most claude.ai users; fast and context-aware.
     */
    public const CLAUDE_SONNET_4 = 'claude-sonnet-4-0';

    /**
     * Claude Sonnet 3.7 — introduced extended (hybrid) thinking in Feb 2025.
     * Significant capability jump for math, science, and multi-step code problems.
     */
    public const CLAUDE_SONNET_3_7 = 'claude-sonnet-3-7';

    /**
     * Claude Sonnet 3.7 (versioned snapshot) — pinned to the 2025-02-19 release.
     */
    public const CLAUDE_SONNET_3_7_SNAP = 'claude-3-7-sonnet-20250219';

    /**
     * Claude Sonnet 3.5 v2 — upgraded Sonnet with computer use capability (Oct 2024).
     */
    public const CLAUDE_SONNET_3_5 = 'claude-3-5-sonnet-20241022';

    /**
     * Claude Haiku 3.5 — lightweight, fast Claude 3.5 variant.
     * Ideal for low-cost summarisation and rapid completions.
     */
    public const CLAUDE_HAIKU_3_5 = 'claude-3-5-haiku-20241022';

    /**
     * Llama 3 (8 B) — Meta's baseline Llama 3 chat model.
     * Most widely used, best-supported, and most tested local model.
     * Ollama pull name: `llama3`
     */
    public const LLAMA_3 = 'llama3';

    /**
     * Llama 3.1 — improved Llama 3 with 128 K context support.
     * Ollama pull name: `llama3.1`
     */
    public const LLAMA_3_1 = 'llama3.1';

    /**
     * Llama 3.1 (8 B tag) — explicit 8 B parameter variant of Llama 3.1.
     */
    public const LLAMA_3_1_8B = 'llama3.1:8b';

    /**
     * Llama 3.1 (70 B tag) — large-scale Llama 3.1 for maximum capability.
     * Requires multi-GPU or high-VRAM hardware.
     */
    public const LLAMA_3_1_70B = 'llama3.1:70b';

    /**
     * Llama 3.2 — compact Meta model with 1 B and 3 B variants.
     * Optimised for dialogue and multilingual use cases on low-spec hardware.
     * Ollama pull name: `llama3.2`
     */
    public const LLAMA_3_2 = 'llama3.2';

    /**
     * Llama 3.2 (1 B tag) — ultra-compact variant for edge and embedded use.
     */
    public const LLAMA_3_2_1B = 'llama3.2:1b';

    /**
     * Llama 3.2 (3 B tag) — small but capable for CLI copilots and edge agents.
     */
    public const LLAMA_3_2_3B = 'llama3.2:3b';

    /**
     * Llama 3.3 (70 B) — latest generation large Llama model.
     * Excellent for content creation, long-form text, and complex chat.
     * Ollama pull name: `llama3.3`
     */
    public const LLAMA_3_3 = 'llama3.3';

    /**
     * Llama 3.3 (70 B tag) — explicit parameter-tagged variant.
     */
    public const LLAMA_3_3_70B = 'llama3.3:70b';

    /**
     * Gemma 3 — Google's current-generation high-performing open model.
     * Available in 1 B–27 B. 27 B variant outperforms models more than twice its size.
     * Supports up to 128 K context (4 B+). Also vision-capable (4 B+).
     * Ollama pull name: `gemma3`
     */
    public const GEMMA_3 = 'gemma3';

    /**
     * Gemma 3 (4 B tag) — efficient vision-capable variant; fits in 8 GB VRAM.
     */
    public const GEMMA_3_4B = 'gemma3:4b';

    /**
     * Gemma 3 (12 B tag) — strong performance for its size; ideal for 12–16 GB VRAM.
     */
    public const GEMMA_3_12B = 'gemma3:12b';

    /**
     * Gemma 3 (27 B tag) — flagship Gemma 3 variant.
     */
    public const GEMMA_3_27B = 'gemma3:27b';

    /**
     * Gemma 2 — previous Google Gemma generation (2 B, 9 B, 27 B sizes).
     * Proven reliability and broad compatibility.
     * Ollama pull name: `gemma2`
     */
    public const GEMMA_2 = 'gemma2';

    /**
     * Gemma 2 (2 B tag) — smallest Gemma 2 variant; suitable for edge deployments.
     */
    public const GEMMA_2_2B = 'gemma2:2b';

    /**
     * Gemma 2 (9 B tag) — good general-purpose performance within 10 GB VRAM.
     */
    public const GEMMA_2_9B = 'gemma2:9b';

    /**
     * Gemma 2 (27 B tag) — large-scale Gemma 2; creative and NLP-focused tasks.
     */
    public const GEMMA_2_27B = 'gemma2:27b';

    /**
     * Mistral 7B v0.3 — fast, efficient 7 B model from Mistral AI.
     * Excellent for everyday tasks with strong European language performance.
     * Ollama pull name: `mistral`
     */
    public const MISTRAL = 'mistral';

    /**
     * Mistral (7 B explicit tag).
     */
    public const MISTRAL_7B = 'mistral:7b';

    /**
     * Mixtral 8×7B — Mixture-of-Experts model from Mistral AI.
     * Activates 2 experts at a time for efficient, high-quality inference.
     * Ollama pull name: `mixtral:8x7b`
     */
    public const MIXTRAL_8X7B = 'mixtral:8x7b';

    /**
     * Mixtral 8×22B — larger MoE variant; near-frontier quality for local hardware.
     * Ollama pull name: `mixtral:8x22b`
     */
    public const MIXTRAL_8X22B = 'mixtral:8x22b';

    /**
     * Qwen 3 — latest Qwen generation; dense and MoE variants.
     * Supports up to 256 K token context; strong multilingual support.
     * Ollama pull name: `qwen3`
     */
    public const QWEN_3 = 'qwen3';

    /**
     * Qwen 3 (4 B tag) — compact variant fitting low-VRAM hardware.
     */
    public const QWEN_3_4B = 'qwen3:4b';

    /**
     * Qwen 3 (8 B tag) — compact variant fitting low-VRAM hardware.
     */
    public const QWEN_3_8B = 'qwen3:8b';

    /**
     * Qwen 3 (14 B tag) — solid mid-range capability for a single consumer GPU.
     */
    public const QWEN_3_14B = 'qwen3:14b';

    /**
     * Qwen 3 (72 B tag) — maximum Qwen 3 capability; enterprise-grade output.
     */
    public const QWEN_3_72B = 'qwen3:72b';

    /**
     * Qwen 2.5 — Alibaba's previous-generation general model.
     * Trained on up to 18 trillion tokens; 128 K context window.
     * Ollama pull name: `qwen2.5`
     */
    public const QWEN_2_5 = 'qwen2.5';

    /**
     * Qwen 2.5 (7 B tag) — fast, practical for medium-grade GPUs.
     */
    public const QWEN_2_5_7B = 'qwen2.5:7b';

    /**
     * Qwen 2.5 (14 B tag) — heavier reasoning on a single consumer GPU.
     */
    public const QWEN_2_5_14B = 'qwen2.5:14b';

    /**
     * Qwen 2.5 Coder — coding-focused Qwen 2.5 variant.
     * Matches GPT-4o on code repair benchmarks at the 32 B scale.
     * Ollama pull name: `qwen2.5-coder`
     */
    public const QWEN_2_5_CODER = 'qwen2.5-coder';

    /**
     * Qwen 2.5 Coder (7 B tag) — excellent code quality for limited hardware.
     */
    public const QWEN_2_5_CODER_7B = 'qwen2.5-coder:7b';

    /**
     * Qwen 2.5 Coder (32 B tag) — best local coding model at this parameter scale.
     */
    public const QWEN_2_5_CODER_32B = 'qwen2.5-coder:32b';

    /**
     * DeepSeek R1 — open reasoning model family approaching frontier performance.
     * Matches o3 and Gemini 2.5 Pro on key reasoning benchmarks.
     * Ollama pull name: `deepseek-r1`
     */
    public const DEEPSEEK_R1 = 'deepseek-r1';

    /**
     * DeepSeek R1 (7 B tag) — smallest R1 variant; usable on 8–10 GB VRAM.
     */
    public const DEEPSEEK_R1_7B = 'deepseek-r1:7b';

    /**
     * DeepSeek R1 (14 B tag) — best mid-range reasoning option for home labs.
     */
    public const DEEPSEEK_R1_14B = 'deepseek-r1:14b';

    /**
     * DeepSeek R1 (32 B tag) — stronger reasoning for 24 GB+ VRAM setups.
     */
    public const DEEPSEEK_R1_32B = 'deepseek-r1:32b';

    /**
     * DeepSeek R1 (70 B tag) — near-frontier reasoning; multi-GPU recommended.
     */
    public const DEEPSEEK_R1_70B = 'deepseek-r1:70b';

    /**
     * DeepSeek Coder — code-generation model; knows 87 programming languages.
     * Trained on 2 trillion tokens; handles cross-file code changes.
     * Ollama pull name: `deepseek-coder`
     */
    public const DEEPSEEK_CODER = 'deepseek-coder';

    /**
     * DeepSeek Coder (33 B tag) — top-quality local code generation.
     */
    public const DEEPSEEK_CODER_33B = 'deepseek-coder:33b';

    /**
     * Phi-4 — Microsoft's latest lightweight model with strong reasoning.
     * Excellent performance per parameter; 14 B, 128 K context.
     * Ollama pull name: `phi4`
     */
    public const PHI_4 = 'phi4';

    /**
     * Phi-4 (14 B tag) — full Phi-4 variant.
     */
    public const PHI_4_14B = 'phi4:14b';

    /**
     * Phi-3 — previous-generation Microsoft lightweight model (3.8 B Mini / 14 B Medium).
     * Phi-3 Mini runs on phones and edge tools; Phi-3.5 extends context to 128 K.
     * Ollama pull name: `phi3`
     */
    public const PHI_3 = 'phi3';

    /**
     * Phi-3 Mini (3.8 B tag) — ultra-compact; usable for on-device and IoT use cases.
     */
    public const PHI_3_MINI = 'phi3:mini';

    /**
     * Code Llama — Meta's code-focused Llama model.
     * Available in 7 B, 13 B, 34 B, and 70 B. Strong across many languages.
     * Ollama pull name: `codellama`
     */
    public const CODE_LLAMA = 'codellama';

    /**
     * Code Llama (13 B tag) — good balance of code quality and hardware requirement.
     */
    public const CODE_LLAMA_13B = 'codellama:13b';

    /**
     * Code Llama (34 B tag) — high-quality code generation for 24 GB VRAM setups.
     */
    public const CODE_LLAMA_34B = 'codellama:34b';

    /**
     * LLaVA — original multimodal vision-language model for Ollama.
     * Canonical first choice for local image understanding.
     * Default vision model in the Luminova Ollama provider (`vision()`).
     * Ollama pull name: `llava`
     */
    public const LLAVA = 'llava';

    /**
     * LLaVA (13 B tag) — stronger vision understanding at 13 B parameters.
     */
    public const LLAVA_13B = 'llava:13b';

    /**
     * LLaVA (34 B tag) — highest-quality LLaVA variant; requires 24+ GB VRAM.
     */
    public const LLAVA_34B = 'llava:34b';

    /**
     * Llama 3.2 Vision — Meta's multimodal Llama 3.2 with image understanding.
     * Better structured-output and instruction-following than LLaVA.
     * Ollama pull name: `llama3.2-vision`
     */
    public const LLAMA_3_2_VISION = 'llama3.2-vision';

    /**
     * Moondream — tiny (1.8 B) vision-language model.
     * Designed for edge devices; very fast image captioning and Q&A.
     * Ollama pull name: `moondream`
     */
    public const MOONDREAM = 'moondream';

    /**
     * BakLLaVA — Mistral-7B base with LLaVA multimodal fine-tuning.
     * Alternative vision model with strong language generation quality.
     * Ollama pull name: `bakllava`
     */
    public const BAKLLAVA = 'bakllava';

    /**
     * Nomic Embed Text — high-performing open embedding model.
     * Supports 8 K token context; strong MTEB benchmark scores.
     * Default embedding model in the Luminova Ollama provider.
     * Ollama pull name: `nomic-embed-text`
     */
    public const NOMIC_EMBED_TEXT = 'nomic-embed-text';

    /**
     * Mxbai Embed Large — strong open embedding model with 1024-dimensional output.
     * Competitive with OpenAI text-embedding-3-large on several benchmarks.
     * Ollama pull name: `mxbai-embed-large`
     */
    public const MXBAI_EMBED_LARGE = 'mxbai-embed-large';

    /**
     * All-MiniLM — lightweight sentence embedding model (384-dimensional).
     * Very fast; ideal for real-time similarity search.
     * Ollama pull name: `all-minilm`
     */
    public const ALL_MINILM = 'all-minilm';

    /**
     * Maps every model constant value to its provider.
     * Keys are the exact API model string (constant value).
     * Values are the provider short-name as registered in AI::$providers.
     *
     * @var array<string,string>
     */
    private const PROVIDER_MAP = [
        // — OpenAI —
        'gpt-5'                       => 'openai',
        'gpt-5-mini'                  => 'openai',
        'gpt-5-nano'                  => 'openai',
        'gpt-4.1'                     => 'openai',
        'gpt-4.1-mini'                => 'openai',
        'gpt-4.1-nano'                => 'openai',
        'gpt-4o'                      => 'openai',
        'gpt-4o-mini'                 => 'openai',
        'gpt-4o-audio-preview'        => 'openai',
        'gpt-4o-mini-audio-preview'   => 'openai',
        'gpt-4o-realtime-preview'     => 'openai',
        'gpt-4o-mini-realtime-preview' => 'openai',
        'computer-use-preview'        => 'openai',
        'o3'                          => 'openai',
        'o3-pro'                      => 'openai',
        'o3-deep-research'            => 'openai',
        'o4-mini'                     => 'openai',
        'o4-mini-deep-research'       => 'openai',
        'gpt-image-1.5'               => 'openai',
        'gpt-image-1'                 => 'openai',
        'dall-e-3'                    => 'openai',
        'dall-e-2'                    => 'openai',
        'gpt-4o-mini-tts'             => 'openai',
        'tts-1'                       => 'openai',
        'tts-1-hd'                    => 'openai',
        'gpt-4o-transcribe'           => 'openai',
        'gpt-4o-mini-transcribe'      => 'openai',
        'whisper-1'                   => 'openai',
        'text-embedding-3-large'      => 'openai',
        'text-embedding-3-small'      => 'openai',
        'text-embedding-ada-002'      => 'openai',
        'omni-moderation-latest'      => 'openai',
        'text-moderation-latest'      => 'openai',
        // — Anthropic / Claude —
        'claude-opus-4-6'             => 'anthropic',
        'claude-sonnet-4-6'           => 'anthropic',
        'claude-opus-4-5'             => 'anthropic',
        'claude-opus-4-5-20251101'    => 'anthropic',
        'claude-sonnet-4-5'           => 'anthropic',
        'claude-haiku-4-5'            => 'anthropic',
        'claude-haiku-4-5-20251001'   => 'anthropic',
        'claude-opus-4-1'             => 'anthropic',
        'claude-opus-4-1-20250805'    => 'anthropic',
        'claude-sonnet-4-1'           => 'anthropic',
        'claude-opus-4-0'             => 'anthropic',
        'claude-sonnet-4-0'           => 'anthropic',
        'claude-sonnet-3-7'           => 'anthropic',
        'claude-3-7-sonnet-20250219'  => 'anthropic',
        'claude-3-5-sonnet-20241022'  => 'anthropic',
        'claude-3-5-haiku-20241022'   => 'anthropic',
        // — Ollama —
        'llama3'                      => 'ollama',
        'llama3.1'                    => 'ollama',
        'llama3.1:8b'                 => 'ollama',
        'llama3.1:70b'                => 'ollama',
        'llama3.2'                    => 'ollama',
        'llama3.2:1b'                 => 'ollama',
        'llama3.2:3b'                 => 'ollama',
        'llama3.3'                    => 'ollama',
        'llama3.3:70b'                => 'ollama',
        'gemma3'                      => 'ollama',
        'gemma3:4b'                   => 'ollama',
        'gemma3:12b'                  => 'ollama',
        'gemma3:27b'                  => 'ollama',
        'gemma2'                      => 'ollama',
        'gemma2:2b'                   => 'ollama',
        'gemma2:9b'                   => 'ollama',
        'gemma2:27b'                  => 'ollama',
        'mistral'                     => 'ollama',
        'mistral:7b'                  => 'ollama',
        'mixtral:8x7b'                => 'ollama',
        'mixtral:8x22b'               => 'ollama',
        'qwen3'                       => 'ollama',
        'qwen3:4b'                    => 'ollama',
        'qwen3:8b'                    => 'ollama',
        'qwen3:14b'                   => 'ollama',
        'qwen3:72b'                   => 'ollama',
        'qwen2.5'                     => 'ollama',
        'qwen2.5:7b'                  => 'ollama',
        'qwen2.5:14b'                 => 'ollama',
        'qwen2.5-coder'               => 'ollama',
        'qwen2.5-coder:7b'            => 'ollama',
        'qwen2.5-coder:32b'           => 'ollama',
        'deepseek-r1'                 => 'ollama',
        'deepseek-r1:7b'              => 'ollama',
        'deepseek-r1:14b'             => 'ollama',
        'deepseek-r1:32b'             => 'ollama',
        'deepseek-r1:70b'             => 'ollama',
        'deepseek-coder'              => 'ollama',
        'deepseek-coder:33b'          => 'ollama',
        'phi4'                        => 'ollama',
        'phi4:14b'                    => 'ollama',
        'phi3'                        => 'ollama',
        'phi3:mini'                   => 'ollama',
        'codellama'                   => 'ollama',
        'codellama:13b'               => 'ollama',
        'codellama:34b'               => 'ollama',
        'llava'                       => 'ollama',
        'llava:13b'                   => 'ollama',
        'llava:34b'                   => 'ollama',
        'llama3.2-vision'             => 'ollama',
        'moondream'                   => 'ollama',
        'bakllava'                    => 'ollama',
        'nomic-embed-text'            => 'ollama',
        'mxbai-embed-large'           => 'ollama',
        'all-minilm'                  => 'ollama',
    ];

    /**
     * Categorises models by capability.
     * A model may appear in multiple categories.
     *
     * @var array<string,string[]>
     */
    private const CAPABILITY_MAP = [
        'chat' => [
            'gpt-5', 'gpt-5-mini', 'gpt-5-nano',
            'gpt-4.1', 'gpt-4.1-mini', 'gpt-4.1-nano',
            'gpt-4o', 'gpt-4o-mini', 'gpt-4o-audio-preview', 'gpt-4o-mini-audio-preview',
            'gpt-4o-realtime-preview', 'gpt-4o-mini-realtime-preview',
            'o3', 'o3-pro', 'o3-deep-research', 'o4-mini', 'o4-mini-deep-research',
            'claude-opus-4-6', 'claude-sonnet-4-6',
            'claude-opus-4-5', 'claude-opus-4-5-20251101', 'claude-sonnet-4-5',
            'claude-haiku-4-5', 'claude-haiku-4-5-20251001',
            'claude-opus-4-1', 'claude-opus-4-1-20250805', 'claude-sonnet-4-1',
            'claude-opus-4-0', 'claude-sonnet-4-0',
            'claude-sonnet-3-7', 'claude-3-7-sonnet-20250219',
            'claude-3-5-sonnet-20241022', 'claude-3-5-haiku-20241022',
            'llama3', 'llama3.1', 'llama3.1:8b', 'llama3.1:70b',
            'llama3.2', 'llama3.2:1b', 'llama3.2:3b', 'llama3.3', 'llama3.3:70b',
            'gemma3', 'gemma3:4b', 'gemma3:12b', 'gemma3:27b',
            'gemma2', 'gemma2:2b', 'gemma2:9b', 'gemma2:27b',
            'mistral', 'mistral:7b', 'mixtral:8x7b', 'mixtral:8x22b',
            'qwen3', 'qwen3:4b', 'qwen3:8b', 'qwen3:14b', 'qwen3:72b',
            'qwen2.5', 'qwen2.5:7b', 'qwen2.5:14b',
            'deepseek-r1', 'deepseek-r1:7b', 'deepseek-r1:14b', 'deepseek-r1:32b', 'deepseek-r1:70b',
            'phi4', 'phi4:14b', 'phi3', 'phi3:mini',
            'codellama', 'codellama:13b', 'codellama:34b',
            'deepseek-coder', 'deepseek-coder:33b',
            'qwen2.5-coder', 'qwen2.5-coder:7b', 'qwen2.5-coder:32b',
        ],
        'vision' => [
            'gpt-5', 'gpt-5-mini', 'gpt-5-nano',
            'gpt-4.1', 'gpt-4.1-mini', 'gpt-4.1-nano',
            'gpt-4o', 'gpt-4o-mini',
            'o3', 'o3-pro', 'o4-mini',
            'claude-opus-4-6', 'claude-sonnet-4-6',
            'claude-opus-4-5', 'claude-opus-4-5-20251101', 'claude-sonnet-4-5',
            'claude-haiku-4-5', 'claude-haiku-4-5-20251001',
            'claude-opus-4-1', 'claude-opus-4-1-20250805', 'claude-sonnet-4-1',
            'claude-opus-4-0', 'claude-sonnet-4-0',
            'claude-sonnet-3-7', 'claude-3-7-sonnet-20250219',
            'claude-3-5-sonnet-20241022', 'claude-3-5-haiku-20241022',
            'llava', 'llava:13b', 'llava:34b',
            'llama3.2-vision',
            'moondream',
            'bakllava',
            'gemma3:4b', 'gemma3:12b', 'gemma3:27b',
        ],
        'image' => [
            'gpt-image-1.5', 'gpt-image-1', 'dall-e-3', 'dall-e-2',
        ],
        'embedding' => [
            'text-embedding-3-large', 'text-embedding-3-small', 'text-embedding-ada-002',
            'nomic-embed-text', 'mxbai-embed-large', 'all-minilm',
        ],
        'speech' => [
            'gpt-4o-mini-tts', 'tts-1', 'tts-1-hd',
        ],
        'transcription' => [
            'gpt-4o-transcribe', 'gpt-4o-mini-transcribe', 'whisper-1',
        ],
        'reasoning' => [
            'o3', 'o3-pro', 'o3-deep-research', 'o4-mini', 'o4-mini-deep-research',
            'deepseek-r1', 'deepseek-r1:7b', 'deepseek-r1:14b', 'deepseek-r1:32b', 'deepseek-r1:70b',
            'claude-sonnet-3-7', 'claude-3-7-sonnet-20250219',
        ],
        'coding' => [
            'gpt-4.1', 'gpt-4.1-mini', 'gpt-4.1-nano',
            'o3', 'o4-mini',
            'claude-opus-4-6', 'claude-sonnet-4-6',
            'claude-opus-4-1', 'claude-opus-4-1-20250805',
            'codellama', 'codellama:13b', 'codellama:34b',
            'deepseek-coder', 'deepseek-coder:33b',
            'qwen2.5-coder', 'qwen3:8b', 'qwen2.5-coder:7b', 'qwen2.5-coder:32b',
        ],
        'fine-tuning' => [
            'gpt-4.1', 'gpt-4.1-mini', 'gpt-4.1-nano',
        ],
        'moderation' => [
            'omni-moderation-latest', 'text-moderation-latest',
        ],
    ];

    /**
     * Prevent instantiation — this class is a static catalogue only.
     */
    private function __construct() {}

    /**
     * Return the provider short-name for a given model identifier.
     *
     * The returned string matches the key used in `AI::$providers`:
     * `'openai'`, `'anthropic'`, or `'ollama'`.
     * Returns `null` when the model is not catalogued.
     *
     * @param string $model Exact API model string (a constant value).
     *
     * @return string|null Provider short-name, or `null` if unknown.
     *
     * @example
     * ```php
     * use Luminova\AI\Model;
     * 
     * Model::provider(Model::GPT_4_1_MINI);   // 'openai'
     * Model::provider(Model::CLAUDE_SONNET_4_6); // 'anthropic'
     * Model::provider(Model::LLAVA);           // 'ollama'
     * Model::provider('custom-model');         // null
     * ```
     */
    public static function provider(string $model): ?string
    {
        return self::PROVIDER_MAP[$model] ?? null;
    }

    /**
     * Return all model constants as a `['CONST_NAME' => 'model-id']` map.
     *
     * Only public constants are included; private constants (such as
     * `PROVIDER_MAP` and `CAPABILITY_MAP`) are excluded automatically.
     *
     * @return array<string,string>
     *
     * @example
     * ```php
     * use Luminova\AI\Model;
     * 
     * $all = Model::all();
     * // ['GPT_5' => 'gpt-5', 'GPT_5_MINI' => 'gpt-5-mini', ...]
     * ```
     */
    public static function all(): array
    {
        return (new ReflectionClass(static::class))->getConstants(\ReflectionClassConstant::IS_PUBLIC);
    }

    /**
     * Return all model identifiers available for a specific provider.
     *
     * @param string $provider Provider short-name: `'openai'`, `'anthropic'`, or `'ollama'`.
     *
     * @return array<string,string> `['CONST_NAME' => 'model-id']` map filtered by provider.
     *
     * @example
     * ```php
     * use Luminova\AI\Model;
     * 
     * $openaiModels    = Model::forProvider('openai');
     * $anthropicModels = Model::forProvider('anthropic');
     * $ollamaModels    = Model::forProvider('ollama');
     * ```
     */
    public static function forProvider(string $provider): array
    {
        $provider = strtolower($provider);

        return array_filter(
            self::all(),
            fn(string $modelId): bool => (self::PROVIDER_MAP[$modelId] ?? null) === $provider
        );
    }

    /**
     * Return the capability tags for a given model.
     *
     * Possible tags: `chat`, `vision`, `image`, `embedding`, `speech`,
     * `transcription`, `reasoning`, `coding`, `fine-tuning`, `moderation`.
     *
     * @param string $model Exact API model string.
     *
     * @return string[] List of capability tags, or an empty array when unknown.
     *
     * @example
     * ```php
     * use Luminova\AI\Model;
     * 
     * Model::capabilities(Model::O3);
     * // ['chat', 'vision', 'reasoning', 'coding']
     *
     * Model::capabilities(Model::NOMIC_EMBED_TEXT);
     * // ['embedding']
     *
     * Model::capabilities(Model::DALL_E_3);
     * // ['image']
     * ```
     */
    public static function capabilities(string $model): array
    {
        $tags = [];

        foreach (self::CAPABILITY_MAP as $tag => $models) {
            if (in_array($model, $models, true)) {
                $tags[] = $tag;
            }
        }

        return $tags;
    }

    /**
     * Check whether a model supports vision (image input).
     *
     * @param string $model Exact API model string.
     *
     * @return bool `true` when the model accepts image input.
     *
     * @example
     * ```php
     * use Luminova\AI\Model;
     * 
     * Model::isVision(Model::GPT_4_1);           // true
     * Model::isVision(Model::LLAVA);             // true
     * Model::isVision(Model::NOMIC_EMBED_TEXT);  // false
     * ```
     */
    public static function isVision(string $model): bool
    {
        return in_array($model, self::CAPABILITY_MAP['vision'], true);
    }

    /**
     * Check whether a model is a reasoning / chain-of-thought model.
     *
     * @param string $model Exact API model string.
     *
     * @return bool `true` for reasoning-class models.
     *
     * @example
     * ```php
     * use Luminova\AI\Model;
     * 
     * Model::isReasoning(Model::O3);             // true
     * Model::isReasoning(Model::DEEPSEEK_R1);    // true
     * Model::isReasoning(Model::GPT_4_1_MINI);   // false
     * ```
     */
    public static function isReasoning(string $model): bool
    {
        return in_array($model, self::CAPABILITY_MAP['reasoning'], true);
    }

    /**
     * Check whether a model produces vector embeddings.
     *
     * @param string $model Exact API model string.
     *
     * @return bool `true` for embedding models.
     *
     * @example
     * ```php
     * use Luminova\AI\Model;
     * 
     * Model::isEmbedding(Model::TEXT_EMBEDDING_3_SMALL); // true
     * Model::isEmbedding(Model::NOMIC_EMBED_TEXT);       // true
     * Model::isEmbedding(Model::GPT_4_1);                // false
     * ```
     */
    public static function isEmbedding(string $model): bool
    {
        return in_array($model, self::CAPABILITY_MAP['embedding'], true);
    }

    /**
     * Check whether a model is listed in this catalogue.
     *
     * Useful for validating user-supplied model strings before sending
     * them to a provider API.
     *
     * @param string $model Exact API model string.
     *
     * @return bool `true` when the model is a known constant value.
     *
     * @example
     * ```php
     * use Luminova\AI\Model;
     * 
     * Model::exists(Model::GPT_4_1_MINI);  // true
     * Model::exists('my-custom-model');    // false
     * ```
     */
    public static function exists(string $model): bool
    {
        return isset(self::PROVIDER_MAP[$model]);
    }
}
