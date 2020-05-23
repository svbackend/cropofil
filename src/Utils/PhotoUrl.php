<?php


namespace App\Utils;


class PhotoUrl
{
    public static function getUrl(string $galleryShortcut, string $filename): string
    {
        return sprintf('https://cropofil.s3.eu-central-1.amazonaws.com/%s/%s/%s', $_ENV['APP_ENV'], $galleryShortcut, $filename);
    }
}
