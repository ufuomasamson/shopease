<?php

namespace App\Http\Controllers;

use App\Services\TranslationService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TranslationController extends Controller
{
    protected $translationService;

    public function __construct(TranslationService $translationService)
    {
        $this->translationService = $translationService;
    }

    /**
     * Switch language
     */
    public function switchLanguage(Request $request, $language)
    {
        if ($this->translationService->setCurrentLanguage($language)) {
            return redirect()->back()->with('success', 'Language changed successfully');
        }

        return redirect()->back()->with('error', 'Language not supported');
    }

    /**
     * Get supported languages
     */
    public function getLanguages(): JsonResponse
    {
        $languages = $this->translationService->getSupportedLanguages();
        $currentLanguage = $this->translationService->getCurrentLanguage();

        return response()->json([
            'success' => true,
            'languages' => $languages,
            'current_language' => $currentLanguage,
            'current_language_name' => $this->translationService->getLanguageName($currentLanguage),
            'is_rtl' => $this->translationService->isRtl()
        ]);
    }

    /**
     * Translate text via AJAX
     */
    public function translate(Request $request): JsonResponse
    {
        $request->validate([
            'text' => 'required|string|max:1000',
            'target_language' => 'nullable|string|max:5'
        ]);

        $text = $request->input('text');
        $targetLanguage = $request->input('target_language');

        $translatedText = $this->translationService->translate($text, $targetLanguage);

        return response()->json([
            'success' => true,
            'original_text' => $text,
            'translated_text' => $translatedText,
            'target_language' => $targetLanguage ?: $this->translationService->getCurrentLanguage()
        ]);
    }

    /**
     * Translate multiple texts
     */
    public function translateMultiple(Request $request): JsonResponse
    {
        $request->validate([
            'texts' => 'required|array',
            'texts.*' => 'string|max:1000',
            'target_language' => 'nullable|string|max:5'
        ]);

        $texts = $request->input('texts');
        $targetLanguage = $request->input('target_language');

        $translatedTexts = $this->translationService->translateMultiple($texts, $targetLanguage);

        return response()->json([
            'success' => true,
            'original_texts' => $texts,
            'translated_texts' => $translatedTexts,
            'target_language' => $targetLanguage ?: $this->translationService->getCurrentLanguage()
        ]);
    }

    /**
     * Detect language of text
     */
    public function detectLanguage(Request $request): JsonResponse
    {
        $request->validate([
            'text' => 'required|string|max:1000'
        ]);

        $text = $request->input('text');
        $detectedLanguage = $this->translationService->detectLanguage($text);
        $languageName = $this->translationService->getLanguageName($detectedLanguage);

        return response()->json([
            'success' => true,
            'text' => $text,
            'detected_language' => $detectedLanguage,
            'language_name' => $languageName
        ]);
    }

    /**
     * Get current language info
     */
    public function getCurrentLanguage(): JsonResponse
    {
        $currentLanguage = $this->translationService->getCurrentLanguage();
        $languageName = $this->translationService->getLanguageName($currentLanguage);
        $isRtl = $this->translationService->isRtl();

        return response()->json([
            'success' => true,
            'current_language' => $currentLanguage,
            'language_name' => $languageName,
            'is_rtl' => $isRtl
        ]);
    }
}
