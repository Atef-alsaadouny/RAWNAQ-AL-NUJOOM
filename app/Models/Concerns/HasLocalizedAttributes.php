<?php

namespace App\Models\Concerns;

trait HasLocalizedAttributes
{
    public function getNameAttribute(): string
    {
        return $this->getLocalizedAttribute('name');
    }

    public function getDescriptionAttribute(): string
    {
        return $this->getLocalizedAttribute('description');
    }

    public function getLocalizedAttribute(string $field): string
    {
        $locale = app()->getLocale();
        $localizedField = "{$field}_{$locale}";
        $englishField = "{$field}_en";
        $arabicField = "{$field}_ar";
        return $this->$localizedField ?? $this->$englishField ?? $this->$arabicField ?? '';
    }
}
