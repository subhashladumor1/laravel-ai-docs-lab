<?php

use App\Http\Controllers\AiDocsTestController;
use Illuminate\Support\Facades\Route;

// ============================================================
//  AI DOCS — Testing UI & API
// ============================================================
Route::get('/', [AiDocsTestController::class, 'index'])->name('ai-docs.testing');

Route::prefix('ai-docs/api')->name('ai-docs.api.')->group(function () {
    // PDF
    Route::post('/pdf/text', [AiDocsTestController::class, 'pdfText'])->name('pdf.text');
    Route::post('/pdf/pages', [AiDocsTestController::class, 'pdfPages'])->name('pdf.pages');
    Route::post('/pdf/summarize', [AiDocsTestController::class, 'pdfSummarize'])->name('pdf.summarize');
    Route::post('/pdf/ask', [AiDocsTestController::class, 'pdfAsk'])->name('pdf.ask');
    Route::post('/pdf/to-json', [AiDocsTestController::class, 'pdfToJson'])->name('pdf.toJson');
    Route::post('/pdf/to-markdown', [AiDocsTestController::class, 'pdfToMarkdown'])->name('pdf.toMarkdown');
    Route::post('/pdf/tables', [AiDocsTestController::class, 'pdfTables'])->name('pdf.tables');
    Route::post('/pdf/full-result', [AiDocsTestController::class, 'pdfFullResult'])->name('pdf.fullResult');

    // Image
    Route::post('/image/text', [AiDocsTestController::class, 'imageText'])->name('image.text');
    Route::post('/image/summarize', [AiDocsTestController::class, 'imageSummarize'])->name('image.summarize');
    Route::post('/image/tables', [AiDocsTestController::class, 'imageTables'])->name('image.tables');
    Route::post('/image/ask', [AiDocsTestController::class, 'imageAsk'])->name('image.ask');
    Route::post('/image/to-json', [AiDocsTestController::class, 'imageToJson'])->name('image.toJson');
    Route::post('/image/result', [AiDocsTestController::class, 'imageResult'])->name('image.result');

    // Audio
    Route::post('/audio/transcribe', [AiDocsTestController::class, 'audioTranscribe'])->name('audio.transcribe');
    Route::post('/audio/summarize', [AiDocsTestController::class, 'audioSummarize'])->name('audio.summarize');
    Route::post('/audio/result', [AiDocsTestController::class, 'audioResult'])->name('audio.result');

    // Document (DOCX/TXT/MD)
    Route::post('/document/text', [AiDocsTestController::class, 'documentText'])->name('document.text');
    Route::post('/document/summarize', [AiDocsTestController::class, 'documentSummarize'])->name('document.summarize');
    Route::post('/document/ask', [AiDocsTestController::class, 'documentAsk'])->name('document.ask');
    Route::post('/document/to-json', [AiDocsTestController::class, 'documentToJson'])->name('document.toJson');
    Route::post('/document/to-markdown', [AiDocsTestController::class, 'documentToMarkdown'])->name('document.toMarkdown');
    Route::post('/document/tables', [AiDocsTestController::class, 'documentTables'])->name('document.tables');
    Route::post('/document/full-result', [AiDocsTestController::class, 'documentFullResult'])->name('document.fullResult');
});
