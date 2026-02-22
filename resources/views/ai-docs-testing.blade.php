<!DOCTYPE html>
<html lang="en" style="color-scheme: dark;">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel AI Docs — Test Lab</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --bg: #09090f;
            --surface: #12121e;
            --card: #1a1a2e;
            --border: rgba(120, 80, 255, .18);
            --accent: #7c4dff;
            --accent2: #00e5ff;
            --accent3: #ff4081;
            --accent4: #00c853;
            --text: #e8e8f5;
            --muted: #8888aa;
            --success: #00c853;
            --error: #ff5252;
            --warning: #ffab40;
            --radius: 14px;
            --radius-sm: 8px;
            --shadow: 0 8px 40px rgba(0, 0, 0, .5);
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0
        }

        html {
            scroll-behavior: smooth
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            overflow-x: hidden
        }

        /* ── Animated BG ── */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            z-index: -1;
            background: radial-gradient(ellipse 80% 60% at 20% 10%, rgba(124, 77, 255, .12) 0%, transparent 60%),
                radial-gradient(ellipse 60% 50% at 80% 90%, rgba(0, 229, 255, .08) 0%, transparent 60%),
                radial-gradient(ellipse 40% 40% at 60% 40%, rgba(255, 64, 129, .06) 0%, transparent 60%);
        }

        /* ── TOPBAR ── */
        .topbar {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(9, 9, 15, .85);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 14px 32px;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none
        }

        .logo-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            box-shadow: 0 0 20px rgba(124, 77, 255, .4);
        }

        .logo-text {
            font-size: 18px;
            font-weight: 700;
            background: linear-gradient(90deg, var(--accent), var(--accent2));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent
        }

        .topbar-badge {
            background: rgba(124, 77, 255, .15);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 3px 12px;
            font-size: 11px;
            color: var(--accent);
            letter-spacing: .5px;
            font-weight: 600
        }

        .topbar-right {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 12px
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--success);
            box-shadow: 0 0 8px var(--success);
            animation: pulse 2s ease-in-out infinite
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1
            }

            50% {
                opacity: .4
            }
        }

        /* ── LAYOUT ── */
        .container {
            max-width: 1380px;
            margin: 0 auto;
            padding: 0 24px
        }

        .hero {
            text-align: center;
            padding: 52px 24px 36px
        }

        .hero h1 {
            font-size: clamp(28px, 4vw, 48px);
            font-weight: 800;
            line-height: 1.2;
            background: linear-gradient(135deg, #fff 0%, var(--accent) 50%, var(--accent2) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 12px
        }

        .hero p {
            color: var(--muted);
            font-size: 16px;
            max-width: 600px;
            margin: 0 auto 28px
        }

        .hero-stats {
            display: flex;
            justify-content: center;
            gap: 32px;
            flex-wrap: wrap
        }

        .stat {
            text-align: center
        }

        .stat-num {
            font-size: 28px;
            font-weight: 800;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent
        }

        .stat-label {
            font-size: 12px;
            color: var(--muted);
            margin-top: 2px
        }

        /* ── GLOBAL CONFIG ── */
        .global-config {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 20px 28px;
            margin-bottom: 32px;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 20px;
        }

        .gc-label {
            font-size: 13px;
            font-weight: 600;
            color: var(--muted);
            letter-spacing: .5px
        }

        .select-wrap {
            position: relative
        }

        .select-wrap::after {
            content: '▾';
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted);
            pointer-events: none;
            font-size: 12px
        }

        select,
        input[type=text],
        textarea {
            background: rgba(255, 255, 255, .05);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            color: var(--text);
            font-family: inherit;
            font-size: 13px;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
        }

        select {
            padding: 8px 32px 8px 12px;
            appearance: none;
            cursor: pointer;
            min-width: 160px
        }

        input[type=text] {
            padding: 8px 14px;
            width: 100%
        }

        textarea {
            padding: 10px 14px;
            width: 100%;
            resize: vertical;
            min-height: 72px
        }

        select:focus,
        input:focus,
        textarea:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(124, 77, 255, .15)
        }

        select:hover,
        input:hover,
        textarea:hover {
            border-color: rgba(124, 77, 255, .4)
        }

        /* Fix Dropdown Visibility */
        select option,
        select optgroup {
            background: var(--card);
            color: var(--text);
            padding: 8px;
        }

        select::-webkit-scrollbar {
            width: 8px;
        }

        select::-webkit-scrollbar-thumb {
            background: var(--accent);
            border-radius: 4px;
        }

        /* ── TABS ── */
        .tabs-nav {
            display: flex;
            gap: 6px;
            margin-bottom: 28px;
            flex-wrap: wrap
        }

        .tab-btn {
            padding: 10px 22px;
            border-radius: 30px;
            border: 1px solid var(--border);
            background: transparent;
            color: var(--muted);
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all .2s;
            letter-spacing: .3px;
            display: flex;
            align-items: center;
            gap: 8px
        }

        .tab-btn:hover {
            border-color: var(--accent);
            color: var(--text)
        }

        .tab-btn.active {
            background: linear-gradient(135deg, var(--accent), rgba(0, 229, 255, .8));
            border-color: transparent;
            color: #fff;
            box-shadow: 0 4px 20px rgba(124, 77, 255, .4)
        }

        .tab-panel {
            display: none
        }

        .tab-panel.active {
            display: block
        }

        /* ── SECTION HEADER ── */
        .section-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 24px
        }

        .section-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0
        }

        .section-icon.pdf-icon {
            background: rgba(255, 64, 129, .15);
            border: 1px solid rgba(255, 64, 129, .25)
        }

        .section-icon.img-icon {
            background: rgba(0, 229, 255, .15);
            border: 1px solid rgba(0, 229, 255, .25)
        }

        .section-icon.aud-icon {
            background: rgba(0, 200, 83, .15);
            border: 1px solid rgba(0, 200, 83, .25)
        }

        .section-icon.doc-icon {
            background: rgba(255, 171, 64, .15);
            border: 1px solid rgba(255, 171, 64, .25)
        }

        .section-title h2 {
            font-size: 20px;
            font-weight: 700
        }

        .section-title p {
            font-size: 13px;
            color: var(--muted);
            margin-top: 2px
        }

        /* ── CARDS GRID ── */
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
            gap: 18px
        }

        /* ── TEST CARD ── */
        .test-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
            transition: box-shadow .25s, border-color .25s;
        }

        .test-card:hover {
            border-color: rgba(124, 77, 255, .35);
            box-shadow: 0 4px 30px rgba(124, 77, 255, .12)
        }

        .card-head {
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid var(--border);
            cursor: pointer;
            user-select: none
        }

        .method-badge {
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .8px;
            text-transform: uppercase;
        }

        .badge-get {
            background: rgba(0, 229, 255, .12);
            color: var(--accent2);
            border: 1px solid rgba(0, 229, 255, .2)
        }

        .badge-post {
            background: rgba(124, 77, 255, .12);
            color: var(--accent);
            border: 1px solid rgba(124, 77, 255, .2)
        }

        .card-head-title {
            font-size: 14px;
            font-weight: 600;
            flex: 1
        }

        .card-head-desc {
            font-size: 11px;
            color: var(--muted);
            margin-top: 2px
        }

        .card-chevron {
            color: var(--muted);
            transition: transform .25s;
            margin-left: auto;
            flex-shrink: 0;
            font-size: 12px
        }

        .test-card.expanded .card-chevron {
            transform: rotate(180deg)
        }

        .card-body {
            display: none;
            padding: 20px
        }

        .test-card.expanded .card-body {
            display: block
        }

        .card-api-path {
            font-family: 'JetBrains Mono', monospace;
            font-size: 11px;
            color: var(--accent2);
            background: rgba(0, 229, 255, .06);
            border: 1px solid rgba(0, 229, 255, .12);
            border-radius: 6px;
            padding: 6px 12px;
            margin-bottom: 16px;
            word-break: break-all
        }

        /* ── FORM FIELDS ── */
        .field {
            margin-bottom: 14px
        }

        .field label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: var(--muted);
            letter-spacing: .4px;
            margin-bottom: 6px;
            text-transform: uppercase
        }

        /* ── FILE DROP ZONE ── */
        .drop-zone {
            border: 2px dashed var(--border);
            border-radius: var(--radius-sm);
            padding: 24px 16px;
            text-align: center;
            cursor: pointer;
            transition: all .2s;
            background: rgba(255, 255, 255, .02);
            position: relative
        }

        .drop-zone:hover,
        .drop-zone.drag-over {
            border-color: var(--accent);
            background: rgba(124, 77, 255, .06)
        }

        .drop-zone input[type=file] {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer
        }

        .drop-icon {
            font-size: 28px;
            margin-bottom: 8px;
            display: block
        }

        .drop-text {
            font-size: 12px;
            color: var(--muted)
        }

        .drop-text strong {
            color: var(--text)
        }

        .file-preview {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 8px;
            background: rgba(124, 77, 255, .08);
            border-radius: 8px;
            padding: 8px 12px;
        }

        .file-preview-icon {
            font-size: 18px
        }

        .file-preview-name {
            font-size: 12px;
            font-weight: 600;
            flex: 1;
            word-break: break-all
        }

        .file-preview-size {
            font-size: 11px;
            color: var(--muted)
        }

        .file-preview-clear {
            background: none;
            border: none;
            color: var(--muted);
            cursor: pointer;
            font-size: 16px;
            padding: 2px 6px;
            border-radius: 4px;
        }

        .file-preview-clear:hover {
            color: var(--error);
            background: rgba(255, 82, 82, .1)
        }

        /* ── BUTTONS ── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 22px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            border: none;
            transition: all .2s;
            width: 100%;
            justify-content: center;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--accent), rgba(0, 229, 255, .9));
            color: #fff;
            box-shadow: 0 4px 16px rgba(124, 77, 255, .3)
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 24px rgba(124, 77, 255, .4)
        }

        .btn-primary:active {
            transform: translateY(0)
        }

        .btn-primary:disabled {
            opacity: .5;
            cursor: not-allowed;
            transform: none
        }

        .btn-sm {
            padding: 6px 14px;
            font-size: 12px;
            width: auto;
            border-radius: 20px
        }

        .spinner {
            width: 14px;
            height: 14px;
            border: 2px solid rgba(255, 255, 255, .3);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin .7s linear infinite
        }

        @keyframes spin {
            to {
                transform: rotate(360deg)
            }
        }

        /* ── RESULT ── */
        .result-box {
            margin-top: 16px;
            display: none
        }

        .result-box.show {
            display: block
        }

        .result-header {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
            flex-wrap: wrap
        }

        .result-status {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 20px
        }

        .result-status.ok {
            background: rgba(0, 200, 83, .1);
            color: var(--success);
            border: 1px solid rgba(0, 200, 83, .2)
        }

        .result-status.err {
            background: rgba(255, 82, 82, .1);
            color: var(--error);
            border: 1px solid rgba(255, 82, 82, .2)
        }

        .result-duration {
            font-size: 11px;
            color: var(--muted);
            margin-left: auto
        }

        .copy-btn {
            font-size: 11px;
            padding: 4px 10px;
            background: rgba(255, 255, 255, .06);
            border: 1px solid var(--border);
            border-radius: 16px;
            color: var(--muted);
            cursor: pointer;
            transition: all .15s;
            font-weight: 600
        }

        .copy-btn:hover {
            border-color: var(--accent);
            color: var(--accent)
        }

        .result-content {
            background: rgba(0, 0, 0, .3);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            font-family: 'JetBrains Mono', monospace;
            font-size: 12px;
            line-height: 1.6;
            padding: 16px;
            max-height: 340px;
            overflow-y: auto;
            white-space: pre-wrap;
            word-break: break-word;
            color: #c8d8e8;
        }

        .result-content::-webkit-scrollbar {
            width: 4px
        }

        .result-content::-webkit-scrollbar-track {
            background: transparent
        }

        .result-content::-webkit-scrollbar-thumb {
            background: var(--accent);
            border-radius: 4px
        }

        /* JSON highlighting */
        .json-key {
            color: #82aaff
        }

        .json-str {
            color: #c3e88d
        }

        .json-num {
            color: #f78c6c
        }

        .json-bool {
            color: #c792ea
        }

        .json-null {
            color: #546e7a
        }

        /* ── PROVIDER KEYS STATUS ── */
        .keys-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 12px;
            margin-bottom: 32px
        }

        .key-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 14px 18px;
            display: flex;
            align-items: center;
            gap: 12px
        }

        .key-indicator {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            flex-shrink: 0
        }

        .key-indicator.has-key {
            background: var(--success);
            box-shadow: 0 0 8px var(--success)
        }

        .key-indicator.no-key {
            background: var(--error);
            box-shadow: 0 0 8px var(--error)
        }

        .key-info {}

        .key-name {
            font-size: 13px;
            font-weight: 600
        }

        .key-status {
            font-size: 11px;
            color: var(--muted);
            margin-top: 2px
        }

        /* ── QUICK TIPS ── */
        .tips-box {
            background: rgba(124, 77, 255, .06);
            border: 1px solid rgba(124, 77, 255, .18);
            border-radius: var(--radius-sm);
            padding: 14px 18px;
            margin-bottom: 16px;
            font-size: 12px;
        }

        .tips-box code {
            font-family: 'JetBrains Mono', monospace;
            background: rgba(124, 77, 255, .15);
            padding: 1px 6px;
            border-radius: 4px;
            font-size: 11px
        }

        /* ── RESPONSIVE ── */
        @media(max-width:700px) {
            .topbar {
                padding: 12px 16px
            }

            .hero {
                padding: 36px 16px 24px
            }

            .cards-grid {
                grid-template-columns: 1fr
            }

            .global-config {
                flex-direction: column;
                align-items: flex-start
            }

            .tabs-nav {
                gap: 4px
            }

            .tab-btn {
                padding: 8px 14px;
                font-size: 12px
            }
        }
    </style>
</head>

<body>

    <!-- TOPBAR -->
    <header class="topbar">
        <a href="#" class="logo">
            <div class="logo-icon">🧠</div>
            <span class="logo-text">Laravel AI Docs</span>
        </a>
        <span class="topbar-badge">TEST LAB</span>
        <div class="topbar-right">
            <div class="status-dot"></div>
            <span style="font-size:12px;color:var(--muted)">Live API</span>
        </div>
    </header>

    <div class="container">

        <!-- HERO -->
        <div class="hero">
            <h1>AI Docs — Complete Test Lab</h1>
            <p>Test every method of the <strong>laravel-ai-docs</strong> package in real-time. Upload files, choose a
                model, and see live AI results.</p>
            <div class="hero-stats">
                <div class="stat">
                    <div class="stat-num">4</div>
                    <div class="stat-label">Document Types</div>
                </div>
                <div class="stat">
                    <div class="stat-num">23</div>
                    <div class="stat-label">API Methods</div>
                </div>
                <div class="stat">
                    <div class="stat-num">3</div>
                    <div class="stat-label">AI Providers</div>
                </div>
                <div class="stat">
                    <div class="stat-num">23</div>
                    <div class="stat-label">AI Models</div>
                </div>
            </div>
        </div>

        <!-- PROVIDER KEY STATUS -->
        <div class="keys-grid">
            <div class="key-card">
                <div class="key-indicator {{ env('OPENAI_API_KEY') ? 'has-key' : 'no-key' }}"></div>
                <div class="key-info">
                    <div class="key-name">🟢 OpenAI</div>
                    <div class="key-status">{{ env('OPENAI_API_KEY') ? '✓ API Key Set' : '✗ No API Key' }}</div>
                </div>
            </div>
            <div class="key-card">
                <div class="key-indicator {{ env('ANTHROPIC_API_KEY') ? 'has-key' : 'no-key' }}"></div>
                <div class="key-info">
                    <div class="key-name">🟣 Claude (Anthropic)</div>
                    <div class="key-status">{{ env('ANTHROPIC_API_KEY') ? '✓ API Key Set' : '✗ No API Key' }}</div>
                </div>
            </div>
            <div class="key-card">
                <div class="key-indicator {{ env('GEMINI_API_KEY') ? 'has-key' : 'no-key' }}"></div>
                <div class="key-info">
                    <div class="key-name">🔵 Google Gemini</div>
                    <div class="key-status">{{ env('GEMINI_API_KEY') ? '✓ API Key Set' : '✗ No API Key' }}</div>
                </div>
            </div>
            <div class="key-card">
                <div class="key-indicator has-key"></div>
                <div class="key-info">
                    <div class="key-name">⚙️ Default Provider</div>
                    <div class="key-status">{{ env('AI_DOCS_PROVIDER', 'openai') }}</div>
                </div>
            </div>
        </div>

        <!-- GLOBAL CONFIG -->
        <div class="global-config">
            <span class="gc-label">🌐 Global Override</span>
            <div class="select-wrap">
                <select id="global-model">
                    <option value="">— Default Model —</option>
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
                    <optgroup label="Claude">
                        <option value="claude-opus-4-6">claude-opus-4-6</option>
                        <option value="claude-sonnet-4-6">claude-sonnet-4-6</option>
                        <option value="claude-haiku-4-5">claude-haiku-4-5</option>
                        <option value="claude-3-5-sonnet">claude-3-5-sonnet</option>
                        <option value="claude-3-5-haiku">claude-3-5-haiku</option>
                        <option value="claude-3-opus">claude-3-opus</option>
                    </optgroup>
                    <optgroup label="Gemini">
                        <option value="gemini-3.1-pro-preview">gemini-3.1-pro-preview</option>
                        <option value="gemini-3-pro-preview">gemini-3-pro-preview</option>
                        <option value="gemini-3-flash-preview">gemini-3-flash-preview</option>
                        <option value="gemini-2.5-pro">gemini-2.5-pro</option>
                    </optgroup>
                </select>
            </div>
            <div class="select-wrap">
                <select id="global-language">
                    <option value="">— Auto Language —</option>
                    <option value="en">English (en)</option>
                    <option value="ar">Arabic (ar)</option>
                    <option value="fr">French (fr)</option>
                    <option value="de">German (de)</option>
                    <option value="es">Spanish (es)</option>
                    <option value="zh">Chinese (zh)</option>
                    <option value="ja">Japanese (ja)</option>
                    <option value="hi">Hindi (hi)</option>
                    <option value="ur">Urdu (ur)</option>
                    <option value="pt">Portuguese (pt)</option>
                </select>
            </div>
            <span style="font-size:12px;color:var(--muted)">These apply to all tests unless individually
                overridden</span>
        </div>

        <!-- TABS -->
        <div class="tabs-nav">
            <button class="tab-btn active" data-tab="pdf">📄 PDF Builder <span
                    style="background:rgba(255,64,129,.15);color:#ff4081;border-radius:20px;padding:1px 8px;font-size:10px">8</span></button>
            <button class="tab-btn" data-tab="image">🖼️ Image Builder <span
                    style="background:rgba(0,229,255,.12);color:var(--accent2);border-radius:20px;padding:1px 8px;font-size:10px">6</span></button>
            <button class="tab-btn" data-tab="audio">🎙️ Audio Builder <span
                    style="background:rgba(0,200,83,.12);color:var(--success);border-radius:20px;padding:1px 8px;font-size:10px">3</span></button>
            <button class="tab-btn" data-tab="document">📝 Document Builder <span
                    style="background:rgba(255,171,64,.12);color:var(--warning);border-radius:20px;padding:1px 8px;font-size:10px">7</span></button>
        </div>

        <!-- ===================================================== -->
        <!-- PDF TAB -->
        <!-- ===================================================== -->
        <div class="tab-panel active" id="tab-pdf">
            <div class="section-header">
                <div class="section-icon pdf-icon">📄</div>
                <div class="section-title">
                    <h2>PDFBuilder — Full Method Reference</h2>
                    <p>AIDocs::pdf($path) → all terminal & chainable methods. Supports .pdf files up to 20 MB.</p>
                </div>
            </div>
            <div class="tips-box">
                💡 <strong>Tip:</strong> Use <code>AIDocs::pdf($file)->text()</code> for raw text,
                <code>->summarize()->text()</code> for AI summary, <code>->ask('question')</code> for RAG Q&A,
                <code>->toJson()</code> for structured extraction, <code>->pages()</code> for page count,
                <code>->tables()->result()</code> for table extraction, <code>->toMarkdown()</code> for markdown output,
                and <code>->enhance()->tables()->summarize()->result()</code> for the full DocumentResultDTO pipeline.
            </div>
            <div class="cards-grid">

                {{-- CARD: PDF Text --}}
                @include('partials.test-card', [
                    'id' => 'pdf-text',
                    'title' => 'Extract Raw Text',
                    'desc' => '->text()',
                    'endpoint' => '/ai-docs/api/pdf/text',
                    'fileType' => 'pdf',
                    'fileAccept' => '.pdf',
                    'fileMimes' => 'PDF',
                    'extraFields' => '',
                    'resultKey' => 'text',
                ])

                {{-- CARD: PDF Pages --}}
                @include('partials.test-card', [
                    'id' => 'pdf-pages',
                    'title' => 'Get Page Count',
                    'desc' => '->pages()',
                    'endpoint' => '/ai-docs/api/pdf/pages',
                    'fileType' => 'pdf',
                    'fileAccept' => '.pdf',
                    'fileMimes' => 'PDF',
                    'extraFields' => '',
                    'resultKey' => 'pages',
                ])

                {{-- CARD: PDF Summarize --}}
                @include('partials.test-card', [
                    'id' => 'pdf-summarize',
                    'title' => 'Summarize PDF',
                    'desc' => '->summarize(?$prompt)->text()',
                    'endpoint' => '/ai-docs/api/pdf/summarize',
                    'fileType' => 'pdf',
                    'fileAccept' => '.pdf',
                    'fileMimes' => 'PDF',
                    'extraFields' => 'prompt',
                    'resultKey' => 'summary',
                ])

                {{-- CARD: PDF Ask --}}
                @include('partials.test-card', [
                    'id' => 'pdf-ask',
                    'title' => 'Ask PDF (RAG)',
                    'desc' => '->ask($question)',
                    'endpoint' => '/ai-docs/api/pdf/ask',
                    'fileType' => 'pdf',
                    'fileAccept' => '.pdf',
                    'fileMimes' => 'PDF',
                    'extraFields' => 'question',
                    'resultKey' => 'answer',
                ])

                {{-- CARD: PDF to JSON --}}
                @include('partials.test-card', [
                    'id' => 'pdf-to-json',
                    'title' => 'Convert to JSON',
                    'desc' => '->toJson(?$prompt)',
                    'endpoint' => '/ai-docs/api/pdf/to-json',
                    'fileType' => 'pdf',
                    'fileAccept' => '.pdf',
                    'fileMimes' => 'PDF',
                    'extraFields' => 'prompt',
                    'resultKey' => 'json',
                ])

                {{-- CARD: PDF to Markdown --}}
                @include('partials.test-card', [
                    'id' => 'pdf-to-markdown',
                    'title' => 'Convert to Markdown',
                    'desc' => '->toMarkdown()',
                    'endpoint' => '/ai-docs/api/pdf/to-markdown',
                    'fileType' => 'pdf',
                    'fileAccept' => '.pdf',
                    'fileMimes' => 'PDF',
                    'extraFields' => '',
                    'resultKey' => 'markdown',
                ])

                {{-- CARD: PDF Tables --}}
                @include('partials.test-card', [
                    'id' => 'pdf-tables',
                    'title' => 'Extract Tables',
                    'desc' => '->tables()->result()',
                    'endpoint' => '/ai-docs/api/pdf/tables',
                    'fileType' => 'pdf',
                    'fileAccept' => '.pdf',
                    'fileMimes' => 'PDF',
                    'extraFields' => '',
                    'resultKey' => 'tables',
                ])

                {{-- CARD: PDF Full Result --}}
                @include('partials.test-card', [
                    'id' => 'pdf-full-result',
                    'title' => 'Full Pipeline Result',
                    'desc' => '->enhance()->tables()->summarize()->result()',
                    'endpoint' => '/ai-docs/api/pdf/full-result',
                    'fileType' => 'pdf',
                    'fileAccept' => '.pdf',
                    'fileMimes' => 'PDF',
                    'extraFields' => '',
                    'resultKey' => 'result',
                ])

            </div>
        </div>

        <!-- ===================================================== -->
        <!-- IMAGE TAB -->
        <!-- ===================================================== -->
        <div class="tab-panel" id="tab-image">
            <div class="section-header">
                <div class="section-icon img-icon">🖼️</div>
                <div class="section-title">
                    <h2>ImageBuilder — Full Method Reference</h2>
                    <p>AIDocs::image($path) → OCR and AI vision. Supports JPG, PNG, WEBP, GIF, BMP, TIFF up to 10 MB.
                    </p>
                </div>
            </div>
            <div class="tips-box">
                💡 <strong>Tip:</strong> ImageBuilder uses <strong>lazy extraction</strong> — text is only extracted
                when you call a terminal method. Use <code>->text(?$prompt)</code> for OCR, <code>->summarize()</code>
                for description, <code>->ask('question')</code> for Q&A, <code>->tables()</code> for table extraction,
                <code>->toJson()</code> for structured data, and <code>->result()</code> for the full DocumentResultDTO.
            </div>
            <div class="cards-grid">

                @include('partials.test-card', [
                    'id' => 'image-text',
                    'title' => 'OCR — Extract Text',
                    'desc' => '->text(?$prompt)',
                    'endpoint' => '/ai-docs/api/image/text',
                    'fileType' => 'image',
                    'fileAccept' => '.jpg,.jpeg,.png,.gif,.bmp,.webp,.tiff',
                    'fileMimes' => 'JPG, PNG, WEBP, TIFF',
                    'extraFields' => 'prompt',
                    'resultKey' => 'text',
                ])

                @include('partials.test-card', [
                    'id' => 'image-summarize',
                    'title' => 'Summarize Image',
                    'desc' => '->summarize(?$prompt)',
                    'endpoint' => '/ai-docs/api/image/summarize',
                    'fileType' => 'image',
                    'fileAccept' => '.jpg,.jpeg,.png,.gif,.bmp,.webp,.tiff',
                    'fileMimes' => 'JPG, PNG, WEBP, TIFF',
                    'extraFields' => 'prompt',
                    'resultKey' => 'summary',
                ])

                @include('partials.test-card', [
                    'id' => 'image-tables',
                    'title' => 'Extract Tables',
                    'desc' => '->tables()',
                    'endpoint' => '/ai-docs/api/image/tables',
                    'fileType' => 'image',
                    'fileAccept' => '.jpg,.jpeg,.png,.gif,.bmp,.webp,.tiff',
                    'fileMimes' => 'JPG, PNG, WEBP, TIFF',
                    'extraFields' => '',
                    'resultKey' => 'tables',
                ])

                @include('partials.test-card', [
                    'id' => 'image-ask',
                    'title' => 'Ask About Image',
                    'desc' => '->ask($question)',
                    'endpoint' => '/ai-docs/api/image/ask',
                    'fileType' => 'image',
                    'fileAccept' => '.jpg,.jpeg,.png,.gif,.bmp,.webp,.tiff',
                    'fileMimes' => 'JPG, PNG, WEBP, TIFF',
                    'extraFields' => 'question',
                    'resultKey' => 'answer',
                ])

                @include('partials.test-card', [
                    'id' => 'image-to-json',
                    'title' => 'Convert to JSON',
                    'desc' => '->toJson()',
                    'endpoint' => '/ai-docs/api/image/to-json',
                    'fileType' => 'image',
                    'fileAccept' => '.jpg,.jpeg,.png,.gif,.bmp,.webp,.tiff',
                    'fileMimes' => 'JPG, PNG, WEBP, TIFF',
                    'extraFields' => '',
                    'resultKey' => 'json',
                ])

                @include('partials.test-card', [
                    'id' => 'image-result',
                    'title' => 'Full DocumentResultDTO',
                    'desc' => '->result()',
                    'endpoint' => '/ai-docs/api/image/result',
                    'fileType' => 'image',
                    'fileAccept' => '.jpg,.jpeg,.png,.gif,.bmp,.webp,.tiff',
                    'fileMimes' => 'JPG, PNG, WEBP, TIFF',
                    'extraFields' => '',
                    'resultKey' => 'result',
                ])

            </div>
        </div>

        <!-- ===================================================== -->
        <!-- AUDIO TAB -->
        <!-- ===================================================== -->
        <div class="tab-panel" id="tab-audio">
            <div class="section-header">
                <div class="section-icon aud-icon">🎙️</div>
                <div class="section-title">
                    <h2>AudioBuilder — Full Method Reference</h2>
                    <p>AIDocs::audio($path) → OpenAI Whisper transcription. Supports MP3, MP4, M4A, WAV, WEBM, OGG up to
                        25 MB.</p>
                </div>
            </div>
            <div class="tips-box">
                ⚠️ <strong>Note:</strong> Audio transcription requires <strong>OpenAI API key</strong> (Whisper). Claude
                and Gemini do not support direct audio transcription. Use <code>->transcribe()</code> for raw
                transcript, <code>->summarize()</code> to get a summary, and <code>->result()</code> for the full
                DocumentResultDTO with both transcript and metadata.
            </div>
            <div class="cards-grid">

                @include('partials.test-card', [
                    'id' => 'audio-transcribe',
                    'title' => 'Transcribe Audio',
                    'desc' => '->transcribe()',
                    'endpoint' => '/ai-docs/api/audio/transcribe',
                    'fileType' => 'audio',
                    'fileAccept' => '.mp3,.mp4,.m4a,.wav,.webm,.ogg',
                    'fileMimes' => 'MP3, MP4, M4A, WAV, WEBM, OGG',
                    'extraFields' => '',
                    'resultKey' => 'transcript',
                ])

                @include('partials.test-card', [
                    'id' => 'audio-summarize',
                    'title' => 'Transcribe & Summarize',
                    'desc' => '->summarize(?$prompt)',
                    'endpoint' => '/ai-docs/api/audio/summarize',
                    'fileType' => 'audio',
                    'fileAccept' => '.mp3,.mp4,.m4a,.wav,.webm,.ogg',
                    'fileMimes' => 'MP3, MP4, M4A, WAV, WEBM, OGG',
                    'extraFields' => 'prompt',
                    'resultKey' => 'summary',
                ])

                @include('partials.test-card', [
                    'id' => 'audio-result',
                    'title' => 'Full Result DTO',
                    'desc' => '->result()',
                    'endpoint' => '/ai-docs/api/audio/result',
                    'fileType' => 'audio',
                    'fileAccept' => '.mp3,.mp4,.m4a,.wav,.webm,.ogg',
                    'fileMimes' => 'MP3, MP4, M4A, WAV, WEBM, OGG',
                    'extraFields' => '',
                    'resultKey' => 'result',
                ])

            </div>
        </div>

        <!-- ===================================================== -->
        <!-- DOCUMENT TAB -->
        <!-- ===================================================== -->
        <div class="tab-panel" id="tab-document">
            <div class="section-header">
                <div class="section-icon doc-icon">📝</div>
                <div class="section-title">
                    <h2>DocumentBuilder — Full Method Reference</h2>
                    <p>AIDocs::document($path) → Handles PDF, DOCX, DOC, TXT, MD. Text is extracted on construction.</p>
                </div>
            </div>
            <div class="tips-box">
                💡 <strong>Tip:</strong> <code>AIDocs::document($path)</code> is a universal entry point — it
                auto-detects the file type. Use it for DOCX/DOC instead of <code>AIDocs::pdf()</code>. Methods:
                <code>->text()</code>, <code>->summarize()->text()</code>, <code>->ask()</code>,
                <code>->toJson()</code>, <code>->toMarkdown()</code>, <code>->tables()->result()</code>, and the full
                pipeline <code>->enhance()->tables()->summarize()->result()</code>.
            </div>
            <div class="cards-grid">

                @include('partials.test-card', [
                    'id' => 'doc-text',
                    'title' => 'Extract Text',
                    'desc' => '->text()',
                    'endpoint' => '/ai-docs/api/document/text',
                    'fileType' => 'document',
                    'fileAccept' => '.pdf,.doc,.docx,.txt,.md',
                    'fileMimes' => 'PDF, DOCX, DOC, TXT, MD',
                    'extraFields' => '',
                    'resultKey' => 'text',
                ])

                @include('partials.test-card', [
                    'id' => 'doc-summarize',
                    'title' => 'Summarize Document',
                    'desc' => '->summarize(?$prompt)->text()',
                    'endpoint' => '/ai-docs/api/document/summarize',
                    'fileType' => 'document',
                    'fileAccept' => '.pdf,.doc,.docx,.txt,.md',
                    'fileMimes' => 'PDF, DOCX, DOC, TXT, MD',
                    'extraFields' => 'prompt',
                    'resultKey' => 'summary',
                ])

                @include('partials.test-card', [
                    'id' => 'doc-ask',
                    'title' => 'Ask About Document',
                    'desc' => '->ask($question)',
                    'endpoint' => '/ai-docs/api/document/ask',
                    'fileType' => 'document',
                    'fileAccept' => '.pdf,.doc,.docx,.txt,.md',
                    'fileMimes' => 'PDF, DOCX, DOC, TXT, MD',
                    'extraFields' => 'question',
                    'resultKey' => 'answer',
                ])

                @include('partials.test-card', [
                    'id' => 'doc-to-json',
                    'title' => 'Convert to JSON',
                    'desc' => '->toJson(?$prompt)',
                    'endpoint' => '/ai-docs/api/document/to-json',
                    'fileType' => 'document',
                    'fileAccept' => '.pdf,.doc,.docx,.txt,.md',
                    'fileMimes' => 'PDF, DOCX, DOC, TXT, MD',
                    'extraFields' => 'prompt',
                    'resultKey' => 'json',
                ])

                @include('partials.test-card', [
                    'id' => 'doc-to-markdown',
                    'title' => 'Convert to Markdown',
                    'desc' => '->summarize()->toMarkdown()',
                    'endpoint' => '/ai-docs/api/document/to-markdown',
                    'fileType' => 'document',
                    'fileAccept' => '.pdf,.doc,.docx,.txt,.md',
                    'fileMimes' => 'PDF, DOCX, DOC, TXT, MD',
                    'extraFields' => '',
                    'resultKey' => 'markdown',
                ])

                @include('partials.test-card', [
                    'id' => 'doc-tables',
                    'title' => 'Extract Tables',
                    'desc' => '->tables()->result()',
                    'endpoint' => '/ai-docs/api/document/tables',
                    'fileType' => 'document',
                    'fileAccept' => '.pdf,.doc,.docx,.txt,.md',
                    'fileMimes' => 'PDF, DOCX, DOC, TXT, MD',
                    'extraFields' => '',
                    'resultKey' => 'tables',
                ])

                @include('partials.test-card', [
                    'id' => 'doc-full-result',
                    'title' => 'Full Pipeline Result',
                    'desc' => '->enhance()->tables()->summarize()->result()',
                    'endpoint' => '/ai-docs/api/document/full-result',
                    'fileType' => 'document',
                    'fileAccept' => '.pdf,.doc,.docx,.txt,.md',
                    'fileMimes' => 'PDF, DOCX, DOC, TXT, MD',
                    'extraFields' => '',
                    'resultKey' => 'result',
                ])

            </div>
        </div>

        <div style="height:60px"></div>
    </div><!-- /container -->

    <script>
        // ── TABS ──
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
                document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
                btn.classList.add('active');
                document.getElementById('tab-' + btn.dataset.tab).classList.add('active');
            });
        });

        // ── CARD ACCORDION ──
        document.querySelectorAll('.card-head').forEach(head => {
            head.addEventListener('click', () => {
                head.closest('.test-card').classList.toggle('expanded');
            });
        });

        // ── FILE DROP ZONES ──
        document.querySelectorAll('.drop-zone').forEach(zone => {
            const input = zone.querySelector('input[type=file]');
            const preview = zone.closest('.field').querySelector('.file-preview');
            const previewName = preview?.querySelector('.file-preview-name');
            const previewSize = preview?.querySelector('.file-preview-size');
            const clearBtn = preview?.querySelector('.file-preview-clear');

            ['dragover', 'dragenter'].forEach(e => zone.addEventListener(e, ev => {
                ev.preventDefault();
                zone.classList.add('drag-over');
            }));
            ['dragleave', 'drop'].forEach(e => zone.addEventListener(e, ev => {
                zone.classList.remove('drag-over');
            }));

            input?.addEventListener('change', () => {
                if (input.files[0] && preview) {
                    previewName.textContent = input.files[0].name;
                    previewSize.textContent = formatBytes(input.files[0].size);
                    preview.style.display = 'flex';
                    zone.style.display = 'none';
                }
            });

            clearBtn?.addEventListener('click', () => {
                input.value = '';
                preview.style.display = 'none';
                zone.style.display = 'block';
            });
        });

        function formatBytes(bytes) {
            if (bytes < 1024) return bytes + ' B';
            if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
            return (bytes / 1048576).toFixed(1) + ' MB';
        }

        // ── FORM SUBMISSIONS ──
        document.querySelectorAll('.test-form').forEach(form => {
            form.addEventListener('submit', async (e) => {
                e.preventDefault();
                const card = form.closest('.test-card');
                const btn = form.querySelector('.run-btn');
                const resultBox = card.querySelector('.result-box');
                const resultContent = card.querySelector('.result-content');
                const statusEl = card.querySelector('.result-status');
                const durationEl = card.querySelector('.result-duration');

                // Collect FormData
                const fd = new FormData(form);

                // Apply global overrides
                const gModel = document.getElementById('global-model').value;
                const gLang = document.getElementById('global-language').value;
                if (gModel && !fd.get('model')) fd.append('model', gModel);
                if (gLang && !fd.get('language')) fd.append('language', gLang);

                // CSRF
                fd.append('_token', document.querySelector('meta[name=csrf-token]').content);

                // Loading state
                btn.disabled = true;
                btn.innerHTML = '<div class="spinner"></div> Processing…';
                resultBox.classList.remove('show');

                try {
                    const res = await fetch(form.dataset.endpoint, {
                        method: 'POST',
                        body: fd,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    const json = await res.json();

                    resultBox.classList.add('show');
                    if (json.success) {
                        statusEl.className = 'result-status ok';
                        statusEl.innerHTML = '✓ Success';
                        durationEl.textContent = json.duration + 's';
                        const resultKey = form.dataset.resultKey;
                        const displayData = resultKey ? (json.data[resultKey] ?? json.data) : json.data;
                        resultContent.innerHTML = syntaxHighlight(typeof displayData === 'string' ?
                            displayData :
                            JSON.stringify(displayData, null, 2));
                    } else {
                        statusEl.className = 'result-status err';
                        statusEl.innerHTML = '✗ ' + (json.type || 'Error');
                        durationEl.textContent = '';
                        resultContent.textContent = json.error || 'Unknown error';
                    }
                } catch (err) {
                    resultBox.classList.add('show');
                    statusEl.className = 'result-status err';
                    statusEl.innerHTML = '✗ Network Error';
                    durationEl.textContent = '';
                    resultContent.textContent = err.message;
                } finally {
                    btn.disabled = false;
                    btn.innerHTML = '▶ Run Test';
                }
            });
        });

        // ── COPY BUTTONS ──
        document.querySelectorAll('.copy-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const content = btn.closest('.result-box').querySelector('.result-content').textContent;
                navigator.clipboard.writeText(content).then(() => {
                    btn.textContent = '✓ Copied!';
                    setTimeout(() => btn.textContent = '⧉ Copy', 1500);
                });
            });
        });

        // ── SYNTAX HIGHLIGHT ──
        function syntaxHighlight(json) {
            if (typeof json !== 'string') return json;
            return json.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
                .replace(
                    /("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?)/g,
                    match => {
                        let cls = 'json-num';
                        if (/^"/.test(match)) cls = /:$/.test(match) ? 'json-key' : 'json-str';
                        else if (/true|false/.test(match)) cls = 'json-bool';
                        else if (/null/.test(match)) cls = 'json-null';
                        return `<span class="${cls}">${match}</span>`;
                    });
        }
    </script>
</body>

</html>
