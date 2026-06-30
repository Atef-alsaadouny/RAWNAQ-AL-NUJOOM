<?php

if (!function_exists('normalizeArabicDigits')) {
    function normalizeArabicDigits(?string $input): string
    {
        if ($input === null) {
            return '';
        }
        $arabic = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
        $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        return str_replace($arabic, $english, $input);
    }
}

if (!function_exists('formatCurrency')) {
    function formatCurrency(float|int $amount): string
    {
        if ($amount == (int) $amount) {
            return (int) $amount . ' ' . __('KWD');
        }
        return rtrim(rtrim(number_format($amount, 3, '.', ''), '0'), '.') . ' ' . __('KWD');
    }
}
