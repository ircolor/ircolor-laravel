<?php

namespace App\Services\Colors;

use App\Services\AuthResult\AuthResultBuilder;

class ColorService
{
    public function __construct(private AuthResultBuilder $authResultBuilder) {}

    public function generateDarkBrightColors($hex, int $times = 10)
    {
        $colors = [
            'dark' => $this->darkColors($hex, $times),
            'bright' => $this->brightColors($hex, $times),
            'complementary' => $this->complementaryColor($hex, $times),
            'color' => $hex,
            'is_dark' => $this->isLightOrDark($hex),
        ];

        return $this->authResultBuilder->setSuccess(true)->setData($colors)->build();
    }

    private function darkColors($hex, $times)
    {
        $hex = str_replace('#', '', $hex);

        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));

        $colors = [];

        for ($i = 0; $i < $times; $i++) {
            $r = max(0, $r - 3);
            $g = max(0, $g - 3);
            $b = max(0, $b - 3);

            $newHex = sprintf('#%02x%02x%02x', $r, $g, $b);
            $colors[] = $newHex;
        }

        return $colors;
    }

    private function brightColors($hex, $times)
    {
        $hex = str_replace('#', '', $hex);

        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));

        $colors = [];

        for ($i = 0; $i < $times; $i++) {
            $r = min(255, $r + 3);
            $g = min(255, $g + 3);
            $b = min(255, $b + 3);

            $newHex = sprintf('#%02x%02x%02x', $r, $g, $b);
            $colors[] = $newHex;
        }

        return $colors;
    }

    private function complementaryColor($hex, $times)
    {
        $hex = str_replace('#', '', $hex);

        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));

        $complementaryR = 255 - $r;
        $complementaryG = 255 - $g;
        $complementaryB = 255 - $b;

        $complementaryColor = sprintf('#%02X%02X%02X', $complementaryR, $complementaryG, $complementaryB);

        return $this->brightColors($complementaryColor, $times);
    }

    private function isLightOrDark($hex)
    {
        $hex = str_replace('#', '', $hex);

        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));

        return (0.299 * $r + 0.587 * $g + 0.114 * $b > 128) ? false : true; // true = dark | false = bright
    }
}
