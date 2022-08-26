<?php

namespace App\Utils;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Helper
{
    public static function splitNumber(int $num, $divider = 1000): array
    {
        $res = [];

        for ($x = $num; $x >= $divider; $x = intdiv($x, $divider)) $res[] = $x % $divider;

        $res[] = $x;

        return array_reverse($res);
    }

    public static function storePublicFile($fileUri, $pathPart):? string
    {
        if (!$info = pathinfo($fileUri)) return null;

        $content = file_get_contents($fileUri);

        if (!$pathPart) $pathPart = Str::random();

        $path = $pathPart . '.' . $info['extension'];

        if (!Storage::disk('public')->put($path, $content)) return null;

        return Storage::url($path);
    }

    public static function normalizeNumber($data)
    {
        $result  = floatval($data);
        $matches = null;
        if (preg_match('/^(?:~)?\s*([-+]?\d+(?:[.,]\d+)?)\s*(k|m)?\b$/', strtolower(trim($data)), $matches)) {
            $result = floatval($matches[1]);
            if (count($matches) > 2)
                if     ($matches[2] === 'k') $result *= 1000;
                elseif ($matches[2] === 'm') $result *= 1000000;
        }
        return $result;
    }

    public static function concatPath(string $path, string $fileName): string
    {
        return Str::finish($path, '/') . $fileName;
    }
}
