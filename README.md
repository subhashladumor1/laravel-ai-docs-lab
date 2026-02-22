# 🚀 Laravel AI Docs Test Lab 🧪

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/AI%20Providers-3-blue?style=for-the-badge" alt="AI Providers">
  <img src="https://img.shields.io/badge/AI%20Models-18-purple?style=for-the-badge" alt="AI Models">
  <img src="https://img.shields.io/badge/Open%20Source-Yes-brightgreen?style=for-the-badge" alt="Open Source">
</p>

<p align="center">
  <strong>The Ultimate Playground for AI Document Processing & Intelligence in Laravel</strong><br>
  Built on top of the powerful <a href="https://github.com/subhashladumor1/laravel-ai-docs">subhashladumor1/laravel-ai-docs</a> package!
</p>

---

## 🌟 Overview

Welcome to the **Laravel AI Docs Test Lab**! 🧪 This project serves as a comprehensive, interactive laboratory designed to showcase and test the full capabilities of the `laravel-ai-docs` package.

Say goodbye to blind API calls! 🚫 This open-source lab provides a beautiful, dark-mode GUI to experiment with **18 cutting-edge AI models** across the **Top 3 leading AI providers**: OpenAI 🔵, Anthropic Claude 🟧, and Google Gemini ✨.

Whether you need to extract text from a scanned PDF 📄, transcribe an audio recording 🎵, or perform deep document analysis and data extraction into native JSON 📦, this test lab acts as your interactive proving ground.

Stop guessing how your AI pipelines will behave—visualize, test, and validate them here! 🎯

---

## 💡 Key Features

- **🚀 Live Testing Arena:** Instantly test API capabilities for PDF, Images, Audio, and Documents (DOCX/TXT/MD).
- **🤖 18 Supported Models:** Choose from the very latest models including `gpt-5.2` 🧠, `claude-sonnet-4-6` ⚡, and `gemini-3.1-pro-preview` 🔮.
- **🌐 3 AI Providers:** Native support for OpenAI, Anthropic Claude, and Google Gemini.
- **🛠 23 Distinct API Methods:** Test everything from OCR, Markdown conversions, Table Extraction, Translations, to direct Q&A (RAG).
- **✨ Responsive GUI:** A sleek, modern, and dark-mode optimized aesthetic user interface.
- **⏱ Real-Time Metrics:** Track exact API response duration and view structured raw JSON outputs instantly.

---

## 📸 Explore the Playground

### 📄 PDF Intelligence

Execute OCR, text extraction, visual layout understanding, summarization, and RAG pipelines directly on your PDF files!
![PDF Builder](screenshots/pdf-builder.png)

### 🖼️ Image Vision

Seamlessly extract text, tables, structured JSON, or ask direct visual questions about any complex diagram, invoice, or receipt.
![Image Builder](screenshots/image-builder.png)

### 🎵 Audio Transcription

Turn spoken language into highly accurate text transcripts or summarize hour-long audio files in seconds.
![Audio Builder](screenshots/audio-builder.png)

### 📝 Document Analysis

Process native documents (DOCX, MD, TXT) and instantly structure unstructured information effortlessly.
![Document Builder](screenshots/document-builder.png)

---

## � Sample Files Included

Don't have documents ready to test? No problem! We have included a `sample` folder in this repository containing a variety of files (PDFs, Images, Audio, and text documents) so you can start testing immediately after installation without needing to hunt down your own files. 📁

---

## �🚀 Installation & Setup

Getting this test lab up and running in your local environment is incredibly straightforward. Let's get building! 🏗️

### 1. Clone the Repository

```bash
git clone https://github.com/your-username/laravel-ai-docs-lab.git
cd laravel-ai-docs-lab
```

### 2. Install Dependencies 📦

This project requires PHP 8.2+ and Composer.

```bash
composer install
```

Since this project relies on the incredible foundation provided by the core package, pull it in (if running fresh):

```bash
composer require subhashladumor1/laravel-ai-docs
```

### 3. Environment Setup ⚙️

Copy the `.env.example` to `.env` and generate the Laravel application key:

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configure Your API Keys 🔑

Open your new `.env` file and append the required API keys for the providers you want to test. **You do not need all three**—just provide the API keys for the providers you intend to play with!

```env
# AI Docs Default Provider
AI_DOCS_PROVIDER=openai # Options: openai, claude, gemini

# OpenAI Configuration
OPENAI_API_KEY="sk-proj-your-openai-api-key"

# Anthropic Claude Configuration
ANTHROPIC_API_KEY="sk-ant-api03-your-claude-api-key"

# Google Gemini Configuration
GEMINI_API_KEY="AIzaSy-your-gemini-api-key"
```

### 5. Publish Configuration (Optional but Recommended) 📜

Publish the package configuration to modify specific global fallbacks or custom model settings.

```bash
php artisan vendor:publish --tag=ai-docs-config
```

### 6. Run the Lab! 🏃‍♂️

Spin up your local Laravel server:

```bash
php artisan serve
```

Visit `http://localhost:8000/test-lab` (or the root URL route `http://localhost:8000` depending on your routing setup) in your browser to launch the AI Docs Testing UI! 🎉

---

## 🛠 Integrating `laravel-ai-docs` in Your Own Projects

Loved what you saw in the test lab? Adding the core logic to your own Laravel applications is just as easy as calling a simple Facade! 🪄

```php
use Subhashladumor1\LaravelAiDocs\Facades\AIDocs;

// 1. Summarize a scanned PDF using Anthropic's Claude 4.6 🟧
$summary = AIDocs::model('claude-sonnet-4-6')
    ->pdf(storage_path('invoice.pdf'))
    ->summarize()
    ->text();

// 2. Extract structured JSON Data from an Image using Gemini ✨
$json = AIDocs::provider('gemini')
    ->image(storage_path('receipt.jpg'))
    ->toJson("Extract vendor_name, total_amount, date");

// 3. Perform Q&A on a Word Document using the default provider 🔵
$answer = AIDocs::document(storage_path('contract.docx'))
    ->ask("What is the termination clause penalty?");
```

📖 Check out the **[official package repository](https://github.com/subhashladumor1/laravel-ai-docs)** for complete API documentation!

---

## ⚙️ Repository Meta (For GitHub Configuration)

**💡 Suggested Repository Name:**
`laravel-ai-docs-lab`

**📢 Repository Short Description:**
`🚀 An interactive GUI testing laboratory playground for the laravel-ai-docs package. Instantly test 18 cutting-edge LLMs across OpenAI, Claude, & Gemini for OCR, PDF, Image, and Audio AI pipelines! 🧪`

**🏷️ Suggested GitHub Topics (Tags):**
`laravel`, `php`, `ai`, `openai`, `gemini`, `claude`, `ocr`, `pdf-processing`, `document-intelligence`, `rag`, `laravel-package`, `api-testing`, `ai-agents`

---

## 🤝 Contributing

Open source thrives on collaboration! 🌍 Found a bug? Want to add a shiny new feature?
Feel free to open an Issue or submit a Pull Request. Let's build the best Document Intelligence toolkit for Laravel together! 💪

## 📜 License

The Laravel AI Docs Test Lab is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
