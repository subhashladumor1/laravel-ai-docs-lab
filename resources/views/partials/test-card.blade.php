{{--
Reusable test card partial.
Variables expected:
$id - unique card ID
$title - card title
$desc - method signature description
$endpoint - POST endpoint URL
$fileType - 'pdf', 'image', 'audio', 'document'
$fileAccept - HTML accept string for file input
$fileMimes - human-readable accepted types label
$extraFields - 'prompt', 'question', or ''
$resultKey - key to extract from data response
--}}
<div class="test-card" id="card-{{ $id }}">

    <div class="card-head">
        <span class="method-badge badge-post">POST</span>
        <div>
            <div class="card-head-title">{{ $title }}</div>
            <div class="card-head-desc" style="font-family:'JetBrains Mono',monospace;font-size:11px;color:var(--accent)">
                AIDocs::{{ $fileType }}($file){{ $desc }}</div>
        </div>
        <span class="card-chevron">▼</span>
    </div>

    <div class="card-body">
        <div class="card-api-path">POST {{ $endpoint }}</div>

        <form class="test-form" data-endpoint="{{ $endpoint }}" data-result-key="{{ $resultKey }}">

            {{-- File Upload --}}
            <div class="field">
                <label>📎 Upload File ({{ $fileMimes }})</label>
                <div class="drop-zone" id="dz-{{ $id }}">
                    <input type="file" name="file" accept="{{ $fileAccept }}" required>
                    <span class="drop-icon">
                        @if ($fileType === 'pdf')
                            📄
                        @elseif($fileType === 'image')
                            🖼️
                        @elseif($fileType === 'audio')
                            🎵
                        @else
                            📝
                        @endif
                    </span>
                    <div class="drop-text"><strong>Drop {{ $fileType }} file here</strong><br>or click to browse •
                        {{ $fileMimes }}
                    </div>
                </div>
                <div class="file-preview" style="display:none">
                    <span class="file-preview-icon">
                        @if ($fileType === 'pdf')
                            📄
                        @elseif($fileType === 'image')
                            🖼️
                        @elseif($fileType === 'audio')
                            🎵
                        @else
                            📝
                        @endif
                    </span>
                    <span class="file-preview-name"></span>
                    <span class="file-preview-size"></span>
                    <button type="button" class="file-preview-clear" title="Remove file">✕</button>
                </div>
            </div>

            {{-- Prompt field --}}
            @if ($extraFields === 'prompt')
                <div class="field">
                    <label>💬 Custom Prompt (optional)</label>
                    <textarea name="prompt" placeholder="e.g. Return 5 bullet points only. / Extract: vendor, total, due_date as JSON."></textarea>
                </div>
            @endif

            {{-- Question field --}}
            @if ($extraFields === 'question')
                <div class="field">
                    <label>❓ Question (required)</label>
                    <input type="text" name="question"
                        placeholder="e.g. What is the contract value? / Who signed this?" required>
                </div>
            @endif

            {{-- Per-card model override --}}
            <div style="display:flex;gap:10px;flex-wrap:wrap;margin-bottom:14px">
                <div class="field" style="flex:1;min-width:140px;margin-bottom:0">
                    <label>🤖 Model Override</label>
                    <div class="select-wrap" style="width:100%">
                        <select name="model" style="width:100%">
                            <option value="">— Use Global —</option>
                            <optgroup label="OpenAI">
                                <option value="gpt-5.2">gpt-5.2</option>
                                <option value="gpt-5.2-pro">gpt-5.2-pro</option>
                                <option value="gpt-5">gpt-5</option>
                                <option value="gpt-5-mini">gpt-5-mini</option>
                                <option value="gpt-5-nano">gpt-5-nano</option>
                                <option value="gpt-4.1">gpt-4.1</option>
                                <option value="gpt-4o">gpt-4o</option>
                                <option value="gpt-4-turbo">gpt-4-turbo</option>
                            </optgroup>
                            @if ($fileType !== 'audio')
                                <optgroup label="Claude">
                                    <option value="claude-opus-4-6">claude-opus-4-6</option>
                                    <option value="claude-sonnet-4-6">claude-sonnet-4-6</option>
                                    <option value="claude-haiku-4-5">claude-haiku-4-5</option>
                                    <option value="claude-3-5-sonnet">claude-3-5-sonnet</option>
                                    <option value="claude-3-5-haiku">claude-3-5-haiku</option>
                                </optgroup>
                                <optgroup label="Gemini">
                                    <option value="gemini-3.1-pro-preview">gemini-3.1-pro-preview</option>
                                    <option value="gemini-3-pro-preview">gemini-3-pro-preview</option>
                                    <option value="gemini-3-flash-preview">gemini-3-flash-preview</option>
                                    <option value="gemini-2.5-pro">gemini-2.5-pro</option>

                                </optgroup>
                            @else
                                <option disabled>── Audio: OpenAI only ──</option>
                            @endif
                        </select>
                    </div>
                </div>
                <div class="field" style="flex:1;min-width:140px;margin-bottom:0">
                    <label>🌐 Language</label>
                    <div class="select-wrap" style="width:100%">
                        <select name="language" style="width:100%">
                            <option value="">— Auto Detect —</option>
                            <option value="en">English</option>
                            <option value="ar">Arabic</option>
                            <option value="fr">French</option>
                            <option value="de">German</option>
                            <option value="es">Spanish</option>
                            <option value="zh">Chinese</option>
                            <option value="ja">Japanese</option>
                            <option value="hi">Hindi</option>
                            <option value="ur">Urdu</option>
                        </select>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary run-btn">▶ Run Test</button>
        </form>

        {{-- Result Box --}}
        <div class="result-box">
            <div class="result-header">
                <div class="result-status ok">✓ Success</div>
                <span class="result-duration"></span>
                <button class="copy-btn">⧉ Copy</button>
            </div>
            <div class="result-content"></div>
        </div>

    </div>
</div>
