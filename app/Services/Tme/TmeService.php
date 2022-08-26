<?php

namespace App\Services\Tme;

use App\Utils\DOMDocumentXPathParser;
use DOMDocument;
use DOMXPath;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Exception;

class TmeService {

    const LINK_PREFIX                   = 'https://t.me/';
    const LINK_PREFIX_LENGTH            = 13; // strlen(static::LINK_PREFIX)
    const PRIVATE_CHANNEL_PREFIX        = 'joinchat/';
    const PRIVATE_CHANNEL_PREFIX_LENGTH = 9; // strlen(static::PRIVATE_CHANNEL_PREFIX)

    public static function channelExists($uri): bool
    {
        $slugInfo = static::getChannelSlugInfoOrFalse($uri);
        if (!$slugInfo) return false; // Invalid uri
        $slug = static::constructValidChannelSlug($slugInfo->slug, $slugInfo->is_public);
        $url  = static::LINK_PREFIX . $slug;

        $guzzle = new Client();

        try {
            $res = $guzzle->request('GET', $url, ['allow_redirects' => false]);
        } catch (GuzzleException $e) {
            return false; // no request (unbelievable)
        }

        if ($res->getStatusCode() === 302) return false; // Undefined slug
        if ($res->getStatusCode() !== 200) return false; // unused situation

        $body   = $res->getBody();
        $parser = DOMDocumentXPathParser::create($body);
        $node   = $parser->evaluateFirst('//div#tgme_page_action#/a#tgme_action_button_new#');

        if (!$node) return false; // it is not channel

        $checkReg = $slugInfo->is_public ? '#View\sin\sTelegram#i' : '#Join\sChannel#i';

        return (boolean) preg_match($checkReg, $node->textContent);
    }

    public static function validateChannelLink(string $s): bool
    {
        return $s && is_string($s) && Str::startsWith($s, static::LINK_PREFIX);
    }

    public static function validateChannelSlug(string $s): bool
    {
        return !Str::contains($s, '/');
    }

    public static function isPrivateChannelSlug(string $s): bool
    {
        return Str::startsWith($s, static::PRIVATE_CHANNEL_PREFIX);
    }

    public static function getChannelSlugInfoOrFalse($s)
    {
        if (!static::validateChannelLink($s)) return false;

        $slug = substr($s, static::LINK_PREFIX_LENGTH);
        $is_public = true;

        if (static::isPrivateChannelSlug($slug)) {
            $slug = substr($slug, static::PRIVATE_CHANNEL_PREFIX_LENGTH);
            $is_public = false;
        }

        if (!static::validateChannelSlug($slug)) return false;

        return (object) [
            'slug'      => rtrim($slug),
            'is_public' => $is_public
        ];
    }

    public static function constructValidChannelSlug(string $channel_slug, bool $is_public): string
    {
        return $is_public ? $channel_slug : static::PRIVATE_CHANNEL_PREFIX . $channel_slug;
    }
}
