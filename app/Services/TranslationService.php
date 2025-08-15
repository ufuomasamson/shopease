<?php

namespace App\Services;

use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class TranslationService
{
    protected $translator;
    protected $defaultLanguage = 'en';
    protected $supportedLanguages = [
        'en' => 'English',
        'es' => 'Español',
        'fr' => 'Français',
        'de' => 'Deutsch',
        'it' => 'Italiano',
        'pt' => 'Português',
        'ru' => 'Русский',
        'ja' => '日本語',
        'ko' => '한국어',
        'zh' => '中文',
        'ar' => 'العربية',
        'hi' => 'हिन्दी',
        'tr' => 'Türkçe',
        'nl' => 'Nederlands',
        'pl' => 'Polski',
        'sv' => 'Svenska',
        'da' => 'Dansk',
        'no' => 'Norsk',
        'fi' => 'Suomi',
        'cs' => 'Čeština',
        'hu' => 'Magyar',
        'ro' => 'Română',
        'bg' => 'Български',
        'hr' => 'Hrvatski',
        'sk' => 'Slovenčina',
        'sl' => 'Slovenščina',
        'et' => 'Eesti',
        'lv' => 'Latviešu',
        'lt' => 'Lietuvių',
        'mt' => 'Malti',
        'ga' => 'Gaeilge'
    ];

    public function __construct()
    {
        $this->translator = new GoogleTranslate();
        $this->translator->setSource($this->defaultLanguage);
    }

    /**
     * Get all supported languages
     */
    public function getSupportedLanguages()
    {
        return $this->supportedLanguages;
    }

    /**
     * Get current language from session or default
     */
    public function getCurrentLanguage()
    {
        return session('locale', $this->defaultLanguage);
    }

    /**
     * Set current language
     */
    public function setCurrentLanguage($language)
    {
        if (array_key_exists($language, $this->supportedLanguages)) {
            session(['locale' => $language]);
            app()->setLocale($language);
            return true;
        }
        return false;
    }

    /**
     * Translate text to current language
     */
    public function translate($text, $targetLanguage = null)
    {
        if (empty($text)) {
            return $text;
        }

        $targetLanguage = $targetLanguage ?: $this->getCurrentLanguage();
        
        // Don't translate if target language is English
        if ($targetLanguage === 'en') {
            return $text;
        }

        try {
            // Create cache key for this translation
            $cacheKey = 'translation_' . md5($text . $targetLanguage);
            
            // Check if translation exists in cache
            if (Cache::has($cacheKey)) {
                return Cache::get($cacheKey);
            }

            // Set target language and translate
            $this->translator->setTarget($targetLanguage);
            $translatedText = $this->translator->translate($text);

            // Cache the translation for 24 hours
            Cache::put($cacheKey, $translatedText, now()->addHours(24));

            return $translatedText;
        } catch (\Exception $e) {
            Log::error('Translation error: ' . $e->getMessage(), [
                'text' => $text,
                'target_language' => $targetLanguage,
                'error' => $e->getMessage()
            ]);
            
            // Return original text if translation fails
            return $text;
        }
    }

    /**
     * Translate multiple texts
     */
    public function translateMultiple($texts, $targetLanguage = null)
    {
        $targetLanguage = $targetLanguage ?: $this->getCurrentLanguage();
        
        if ($targetLanguage === 'en') {
            return $texts;
        }

        $translated = [];
        foreach ($texts as $key => $text) {
            $translated[$key] = $this->translate($text, $targetLanguage);
        }

        return $translated;
    }

    /**
     * Detect language of text
     */
    public function detectLanguage($text)
    {
        try {
            $this->translator->setTarget('en');
            return $this->translator->getLastDetectedSource();
        } catch (\Exception $e) {
            Log::error('Language detection error: ' . $e->getMessage());
            return $this->defaultLanguage;
        }
    }

    /**
     * Get language name by code
     */
    public function getLanguageName($code)
    {
        return $this->supportedLanguages[$code] ?? $code;
    }

    /**
     * Check if language is supported
     */
    public function isLanguageSupported($code)
    {
        return array_key_exists($code, $this->supportedLanguages);
    }

    /**
     * Get RTL languages
     */
    public function getRtlLanguages()
    {
        return ['ar', 'he', 'fa', 'ur'];
    }

    /**
     * Check if current language is RTL
     */
    public function isRtl()
    {
        $currentLang = $this->getCurrentLanguage();
        return in_array($currentLang, $this->getRtlLanguages());
    }
}
