<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait EnumOptions
{
    /**
     * values
     *
     * @return array
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * labels
     *
     * @return array
     */
    public static function labels(): array
    {
        return array_column(self::cases(), 'name');
    }

    /**
     * options
     *
     * @return array
     */
    public static function options(): array
    {
        $cases   = static::cases();
        $options = [];
        foreach ($cases as $case) {
            $label = $case->name;
            if (Str::contains($label, '_')) {
                $label = Str::replace('_', ' ', $label);
            }
            $options[] = [
                'value' => $case->value,
                'label' => Str::title($label)
            ];
        }
        return $options;
    }

    /**
     * fields
     *
     * @return array
     */
    public static function fieldset(): array
    {
        $cases   = static::cases();
        $options = [];
        foreach ($cases as $case) {
            $label = $case->name;
            if (Str::contains($label, '_')) {
                $label = Str::replace('_', ' ', $label);
            }
            $options[$case->value] = Str::title($label);
        }
        return $options;
    }

    public function toArray(): array
    {
        return [
            'label' => $this->name,
            'value' => $this->value
        ];
    }
}
