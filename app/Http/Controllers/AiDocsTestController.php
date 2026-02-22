<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Subhashladumor1\LaravelAiDocs\Facades\AIDocs;
use Throwable;

class AiDocsTestController extends Controller
{
    /**
     * Show the AI Docs Testing UI.
     */
    public function index()
    {
        return view('ai-docs-testing');
    }

    // =========================================================
    //  PDF ENDPOINTS
    // =========================================================

    public function pdfText(Request $request): JsonResponse
    {
        $request->validate(['file' => 'required|file|mimes:pdf|max:20480']);
        return $this->handle(function () use ($request) {
            $path = $request->file('file')->store('ai-docs-test', 'local');
            $fullPath = Storage::disk('local')->path($path);
            $model = $request->input('model');
            $lang = $request->input('language');

            $manager = $this->applyManagerConfig($model, $lang);
            $text = $manager->pdf($fullPath)->text();

            $this->cleanup($fullPath);
            return ['text' => $text];
        });
    }

    public function pdfPages(Request $request): JsonResponse
    {
        $request->validate(['file' => 'required|file|mimes:pdf|max:20480']);
        return $this->handle(function () use ($request) {
            $path = $request->file('file')->store('ai-docs-test', 'local');
            $fullPath = Storage::disk('local')->path($path);
            $model = $request->input('model');
            $lang = $request->input('language');

            $manager = $this->applyManagerConfig($model, $lang);
            $pages = $manager->pdf($fullPath)->pages();

            $this->cleanup($fullPath);
            return ['pages' => $pages];
        });
    }

    public function pdfSummarize(Request $request): JsonResponse
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf|max:20480',
            'prompt' => 'nullable|string|max:500',
        ]);
        return $this->handle(function () use ($request) {
            $path = $request->file('file')->store('ai-docs-test', 'local');
            $fullPath = Storage::disk('local')->path($path);
            $prompt = $request->input('prompt') ?: null;
            $model = $request->input('model');
            $lang = $request->input('language');

            $manager = $this->applyManagerConfig($model, $lang);
            $summary = $manager->pdf($fullPath)->summarize($prompt)->result()->summary;

            $this->cleanup($fullPath);
            return ['summary' => $summary];
        });
    }

    /** PDF → Ask a question (RAG) */
    public function pdfAsk(Request $request): JsonResponse
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf|max:20480',
            'question' => 'required|string|max:1000',
        ]);
        return $this->handle(function () use ($request) {
            $path = $request->file('file')->store('ai-docs-test', 'local');
            $fullPath = Storage::disk('local')->path($path);
            $model = $request->input('model');
            $lang = $request->input('language');

            $manager = $this->applyManagerConfig($model, $lang);
            $answer = $manager->pdf($fullPath)->ask($request->input('question'));
            $this->cleanup($fullPath);
            return ['answer' => $answer];
        });
    }

    /** PDF → Convert to JSON */
    public function pdfToJson(Request $request): JsonResponse
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf|max:20480',
            'prompt' => 'nullable|string|max:500',
        ]);
        return $this->handle(function () use ($request) {
            $path = $request->file('file')->store('ai-docs-test', 'local');
            $fullPath = Storage::disk('local')->path($path);
            $prompt = $request->input('prompt') ?: null;
            $model = $request->input('model');
            $lang = $request->input('language');

            $manager = $this->applyManagerConfig($model, $lang);
            $data = $manager->pdf($fullPath)->toJson($prompt);
            $this->cleanup($fullPath);
            return ['json' => $data];
        });
    }

    /** PDF → Convert to Markdown */
    public function pdfToMarkdown(Request $request): JsonResponse
    {
        $request->validate(['file' => 'required|file|mimes:pdf|max:20480']);
        return $this->handle(function () use ($request) {
            $path = $request->file('file')->store('ai-docs-test', 'local');
            $fullPath = Storage::disk('local')->path($path);
            $model = $request->input('model');
            $lang = $request->input('language');

            $manager = $this->applyManagerConfig($model, $lang);
            $markdown = $manager->pdf($fullPath)->toMarkdown();
            $this->cleanup($fullPath);
            return ['markdown' => $markdown];
        });
    }

    /** PDF → Extract Tables */
    public function pdfTables(Request $request): JsonResponse
    {
        $request->validate(['file' => 'required|file|mimes:pdf|max:20480']);
        return $this->handle(function () use ($request) {
            $path = $request->file('file')->store('ai-docs-test', 'local');
            $fullPath = Storage::disk('local')->path($path);
            $model = $request->input('model');
            $lang = $request->input('language');

            $manager = $this->applyManagerConfig($model, $lang);
            $result = $manager->pdf($fullPath)->tables()->result();
            $tables = array_map(fn($t) => $t->toArray(), $result->tables);
            $this->cleanup($fullPath);
            return ['tables' => $tables, 'count' => count($tables)];
        });
    }

    /** PDF → Full Result DTO (enhance + tables + summarize) */
    public function pdfFullResult(Request $request): JsonResponse
    {
        $request->validate(['file' => 'required|file|mimes:pdf|max:20480']);
        return $this->handle(function () use ($request) {
            $path = $request->file('file')->store('ai-docs-test', 'local');
            $fullPath = Storage::disk('local')->path($path);
            $model = $request->input('model');
            $lang = $request->input('language');

            $manager = $this->applyManagerConfig($model, $lang);
            $result = $manager->pdf($fullPath)->enhance()->tables()->summarize()->result();
            $this->cleanup($fullPath);
            return ['result' => $result->toArray()];
        });
    }

    // =========================================================
    //  IMAGE ENDPOINTS
    // =========================================================

    /** Image → OCR / Extract text */
    public function imageText(Request $request): JsonResponse
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,gif,bmp,webp,tiff|max:10240',
            'prompt' => 'nullable|string|max:500',
        ]);
        return $this->handle(function () use ($request) {
            $path = $request->file('file')->store('ai-docs-test', 'local');
            $fullPath = Storage::disk('local')->path($path);
            $prompt = $request->input('prompt') ?: null;
            $model = $request->input('model');
            $lang = $request->input('language');

            $manager = $this->applyManagerConfig($model, $lang);
            $text = $manager->image($fullPath)->text($prompt);
            $this->cleanup($fullPath);
            return ['text' => $text];
        });
    }

    /** Image → Summarize */
    public function imageSummarize(Request $request): JsonResponse
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,gif,bmp,webp,tiff|max:10240',
            'prompt' => 'nullable|string|max:500',
        ]);
        return $this->handle(function () use ($request) {
            $path = $request->file('file')->store('ai-docs-test', 'local');
            $fullPath = Storage::disk('local')->path($path);
            $prompt = $request->input('prompt') ?: null;
            $model = $request->input('model');
            $lang = $request->input('language');

            $manager = $this->applyManagerConfig($model, $lang);
            $summary = $manager->image($fullPath)->summarize($prompt);
            $this->cleanup($fullPath);
            return ['summary' => $summary];
        });
    }

    /** Image → Extract tables */
    public function imageTables(Request $request): JsonResponse
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,gif,bmp,webp,tiff|max:10240',
        ]);
        return $this->handle(function () use ($request) {
            $path = $request->file('file')->store('ai-docs-test', 'local');
            $fullPath = Storage::disk('local')->path($path);
            $model = $request->input('model');
            $lang = $request->input('language');

            $manager = $this->applyManagerConfig($model, $lang);
            $tables = $manager->image($fullPath)->tables();
            $this->cleanup($fullPath);
            return ['tables' => array_map(fn($t) => $t->toArray(), $tables), 'count' => count($tables)];
        });
    }

    /** Image → Ask a question */
    public function imageAsk(Request $request): JsonResponse
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,gif,bmp,webp,tiff|max:10240',
            'question' => 'required|string|max:1000',
        ]);
        return $this->handle(function () use ($request) {
            $path = $request->file('file')->store('ai-docs-test', 'local');
            $fullPath = Storage::disk('local')->path($path);
            $model = $request->input('model');
            $lang = $request->input('language');

            $manager = $this->applyManagerConfig($model, $lang);
            $answer = $manager->image($fullPath)->ask($request->input('question'));
            $this->cleanup($fullPath);
            return ['answer' => $answer];
        });
    }

    /** Image → Convert to JSON */
    public function imageToJson(Request $request): JsonResponse
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,gif,bmp,webp,tiff|max:10240',
        ]);
        return $this->handle(function () use ($request) {
            $path = $request->file('file')->store('ai-docs-test', 'local');
            $fullPath = Storage::disk('local')->path($path);
            $model = $request->input('model');
            $lang = $request->input('language');

            $manager = $this->applyManagerConfig($model, $lang);
            $data = $manager->image($fullPath)->toJson();
            $this->cleanup($fullPath);
            return ['json' => $data];
        });
    }

    /** Image → Full DocumentResultDTO */
    public function imageResult(Request $request): JsonResponse
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,gif,bmp,webp,tiff|max:10240',
        ]);
        return $this->handle(function () use ($request) {
            $path = $request->file('file')->store('ai-docs-test', 'local');
            $fullPath = Storage::disk('local')->path($path);
            $model = $request->input('model');
            $lang = $request->input('language');

            $manager = $this->applyManagerConfig($model, $lang);
            $result = $manager->image($fullPath)->result();
            $this->cleanup($fullPath);
            return ['result' => $result->toArray()];
        });
    }

    // =========================================================
    //  AUDIO ENDPOINTS
    // =========================================================

    /** Audio → Transcribe */
    public function audioTranscribe(Request $request): JsonResponse
    {
        $request->validate([
            'file' => 'required|file|mimes:mp3,mp4,m4a,wav,webm,ogg|max:25600',
        ]);
        return $this->handle(function () use ($request) {
            $path = $request->file('file')->store('ai-docs-test', 'local');
            $fullPath = Storage::disk('local')->path($path);
            $lang = $request->input('language');

            $manager = $lang ? AIDocs::language($lang) : AIDocs::getFacadeRoot();
            $transcript = $manager->audio($fullPath)->transcribe();
            $this->cleanup($fullPath);
            return ['transcript' => $transcript];
        });
    }

    /** Audio → Summarize */
    public function audioSummarize(Request $request): JsonResponse
    {
        $request->validate([
            'file' => 'required|file|mimes:mp3,mp4,m4a,wav,webm,ogg|max:25600',
            'prompt' => 'nullable|string|max:500',
        ]);
        return $this->handle(function () use ($request) {
            $path = $request->file('file')->store('ai-docs-test', 'local');
            $fullPath = Storage::disk('local')->path($path);
            $prompt = $request->input('prompt') ?: null;
            $lang = $request->input('language');

            $manager = $lang ? AIDocs::language($lang) : AIDocs::getFacadeRoot();
            $summary = $manager->audio($fullPath)->summarize($prompt);
            $this->cleanup($fullPath);
            return ['summary' => $summary];
        });
    }

    /** Audio → Full result (transcript + summary) */
    public function audioResult(Request $request): JsonResponse
    {
        $request->validate([
            'file' => 'required|file|mimes:mp3,mp4,m4a,wav,webm,ogg|max:25600',
        ]);
        return $this->handle(function () use ($request) {
            $path = $request->file('file')->store('ai-docs-test', 'local');
            $fullPath = Storage::disk('local')->path($path);
            $lang = $request->input('language');

            $manager = $lang ? AIDocs::language($lang) : AIDocs::getFacadeRoot();
            $result = $manager->audio($fullPath)->result();
            $this->cleanup($fullPath);
            return ['result' => $result->toArray()];
        });
    }

    // =========================================================
    //  DOCUMENT (DOCX/TXT/MD) ENDPOINTS
    // =========================================================

    /** Document → Extract text */
    public function documentText(Request $request): JsonResponse
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx,txt,md|max:20480',
        ]);
        return $this->handle(function () use ($request) {
            $ext = $request->file('file')->getClientOriginalExtension();
            $path = $request->file('file')->storeAs('ai-docs-test', 'doc_' . time() . '.' . $ext, 'local');
            $fullPath = Storage::disk('local')->path($path);
            $model = $request->input('model');
            $lang = $request->input('language');

            $manager = $this->applyManagerConfig($model, $lang);
            $text = $manager->document($fullPath)->text();
            $this->cleanup($fullPath);
            return ['text' => $text];
        });
    }

    /** Document → Summarize */
    public function documentSummarize(Request $request): JsonResponse
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx,txt,md|max:20480',
            'prompt' => 'nullable|string|max:500',
        ]);
        return $this->handle(function () use ($request) {
            $ext = $request->file('file')->getClientOriginalExtension();
            $path = $request->file('file')->storeAs('ai-docs-test', 'doc_' . time() . '.' . $ext, 'local');
            $fullPath = Storage::disk('local')->path($path);
            $prompt = $request->input('prompt') ?: null;
            $model = $request->input('model');
            $lang = $request->input('language');

            $manager = $this->applyManagerConfig($model, $lang);
            $summary = $manager->document($fullPath)->summarize($prompt)->text();
            $this->cleanup($fullPath);
            return ['summary' => $summary];
        });
    }

    /** Document → Ask a question */
    public function documentAsk(Request $request): JsonResponse
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx,txt,md|max:20480',
            'question' => 'required|string|max:1000',
        ]);
        return $this->handle(function () use ($request) {
            $ext = $request->file('file')->getClientOriginalExtension();
            $path = $request->file('file')->storeAs('ai-docs-test', 'doc_' . time() . '.' . $ext, 'local');
            $fullPath = Storage::disk('local')->path($path);
            $model = $request->input('model');
            $lang = $request->input('language');

            $manager = $this->applyManagerConfig($model, $lang);
            $answer = $manager->document($fullPath)->ask($request->input('question'));
            $this->cleanup($fullPath);
            return ['answer' => $answer];
        });
    }

    /** Document → Extract to JSON */
    public function documentToJson(Request $request): JsonResponse
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx,txt,md|max:20480',
            'prompt' => 'nullable|string|max:500',
        ]);
        return $this->handle(function () use ($request) {
            $ext = $request->file('file')->getClientOriginalExtension();
            $path = $request->file('file')->storeAs('ai-docs-test', 'doc_' . time() . '.' . $ext, 'local');
            $fullPath = Storage::disk('local')->path($path);
            $prompt = $request->input('prompt') ?: null;
            $model = $request->input('model');
            $lang = $request->input('language');

            $manager = $this->applyManagerConfig($model, $lang);
            $data = $manager->document($fullPath)->toJson($prompt);
            $this->cleanup($fullPath);
            return ['json' => $data];
        });
    }

    /** Document → Convert to Markdown */
    public function documentToMarkdown(Request $request): JsonResponse
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx,txt,md|max:20480',
        ]);
        return $this->handle(function () use ($request) {
            $ext = $request->file('file')->getClientOriginalExtension();
            $path = $request->file('file')->storeAs('ai-docs-test', 'doc_' . time() . '.' . $ext, 'local');
            $fullPath = Storage::disk('local')->path($path);
            $model = $request->input('model');
            $lang = $request->input('language');

            $manager = $this->applyManagerConfig($model, $lang);
            $markdown = $manager->document($fullPath)->summarize()->toMarkdown();
            $this->cleanup($fullPath);
            return ['markdown' => $markdown];
        });
    }

    /** Document → Extract Tables */
    public function documentTables(Request $request): JsonResponse
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx,txt,md|max:20480',
        ]);
        return $this->handle(function () use ($request) {
            $ext = $request->file('file')->getClientOriginalExtension();
            $path = $request->file('file')->storeAs('ai-docs-test', 'doc_' . time() . '.' . $ext, 'local');
            $fullPath = Storage::disk('local')->path($path);
            $model = $request->input('model');
            $lang = $request->input('language');

            $manager = $this->applyManagerConfig($model, $lang);
            $result = $manager->document($fullPath)->tables()->result();
            $tables = array_map(fn($t) => $t->toArray(), $result->tables);
            $this->cleanup($fullPath);
            return ['tables' => $tables, 'count' => count($tables)];
        });
    }

    /** Document → Full pipeline result */
    public function documentFullResult(Request $request): JsonResponse
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx,txt,md|max:20480',
        ]);
        return $this->handle(function () use ($request) {
            $ext = $request->file('file')->getClientOriginalExtension();
            $path = $request->file('file')->storeAs('ai-docs-test', 'doc_' . time() . '.' . $ext, 'local');
            $fullPath = Storage::disk('local')->path($path);
            $model = $request->input('model');
            $lang = $request->input('language');

            $manager = $this->applyManagerConfig($model, $lang);
            $result = $manager->document($fullPath)->enhance()->tables()->summarize()->result();
            $this->cleanup($fullPath);
            return ['result' => $result->toArray()];
        });
    }

    // =========================================================
    //  HELPERS
    // =========================================================

    private function handle(\Closure $fn): JsonResponse
    {
        $start = microtime(true);
        try {
            $data = $fn();
            return response()->json([
                'success' => true,
                'data' => $data,
                'duration' => round(microtime(true) - $start, 3),
            ]);
        } catch (Throwable $e) {
            Log::error('AIDocs Test Error', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'type' => class_basename($e),
            ], 422);
        }
    }

    private function applyManagerConfig(?string $model, ?string $lang): object
    {
        $manager = AIDocs::getFacadeRoot();
        if ($model)
            $manager = $manager->model($model);
        if ($lang)
            $manager = $manager->language($lang);
        return $manager;
    }

    private function cleanup(string $path): void
    {
        if (file_exists($path)) {
            @unlink($path);
        }
    }
}
