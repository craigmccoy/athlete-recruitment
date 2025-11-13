<?php

namespace App\Helpers;

class VideoHelper
{
    /**
     * Convert a video URL to an embeddable URL
     */
    public static function getEmbedUrl(?string $url): ?string
    {
        if (empty($url)) {
            return null;
        }

        // YouTube
        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i', $url, $match)) {
            return 'https://www.youtube.com/embed/' . $match[1];
        }

        // YouTube Shorts
        if (preg_match('/youtube\.com\/shorts\/([^"&?\/ ]{11})/i', $url, $match)) {
            return 'https://www.youtube.com/embed/' . $match[1];
        }

        // Hudl
        if (preg_match('/hudl\.com\/(?:video|v)\/([a-zA-Z0-9]+)/i', $url, $match)) {
            return 'https://www.hudl.com/embed/video/' . $match[1];
        }

        // Vimeo
        if (preg_match('/vimeo\.com\/(\d+)/i', $url, $match)) {
            return 'https://player.vimeo.com/video/' . $match[1];
        }

        // If it's already an embed URL, return as-is
        if (strpos($url, '/embed/') !== false) {
            return $url;
        }

        return null;
    }

    /**
     * Check if a URL is a valid video URL
     */
    public static function isValidVideoUrl(?string $url): bool
    {
        if (empty($url)) {
            return false;
        }

        return preg_match('/(youtube\.com|youtu\.be|hudl\.com|vimeo\.com)/i', $url) === 1;
    }

    /**
     * Get video thumbnail URL
     */
    public static function getThumbnailUrl(?string $url): ?string
    {
        if (empty($url)) {
            return null;
        }

        // YouTube
        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i', $url, $match)) {
            return 'https://img.youtube.com/vi/' . $match[1] . '/maxresdefault.jpg';
        }

        return null;
    }
}
