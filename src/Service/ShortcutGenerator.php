<?php


namespace App\Service;


class ShortcutGenerator
{
    public function generateShortcut(): string
    {
        $allowedChars = [
            ...range(0,9), ...range('A', 'Z'), ...range('a', 'z'),
            '$', '-', '_', '.', '+', '!', '*', '(', ')', ','
        ];
        $allowedCharsSize = count($allowedChars) - 1;

        $length = random_int(6, 8); // todo
        $shortcut = [];

        for ($i = $length; $i > 0; $i--) {
            $shortcut[] = $allowedChars[random_int(0, $allowedCharsSize)];
        }

        return implode('', $shortcut);
    }
}
