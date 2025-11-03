<?php
/**
 * Custom Bootstrap - Bypass Locale Class Issues
 * This file provides a workaround for missing PHP intl extension
 */

// Mock the Locale class if it doesn't exist
if (!class_exists('Locale')) {
    class Locale 
    {
        const DEFAULT_LOCALE = 'en';
        
        public static function getDefault()
        {
            return 'en';
        }
        
        public static function setDefault($locale)
        {
            return true;
        }
        
        public static function acceptFromHttp($header)
        {
            return 'en';
        }
        
        public static function canonicalize($locale)
        {
            return $locale ?? 'en';
        }
        
        public static function parseLocale($locale)
        {
            return ['language' => 'en'];
        }
    }
}

// Mock NumberFormatter if needed
if (!class_exists('NumberFormatter')) {
    class NumberFormatter 
    {
        const DECIMAL = 1;
        const CURRENCY = 2;
        const PERCENT = 3;
        
        private $locale;
        private $style;
        
        public function __construct($locale, $style, $pattern = null)
        {
            $this->locale = $locale;
            $this->style = $style;
        }
        
        public function format($value)
        {
            return number_format($value, 2);
        }
        
        public static function create($locale, $style, $pattern = null)
        {
            return new self($locale, $style, $pattern);
        }
    }
}