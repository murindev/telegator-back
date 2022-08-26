<?php

namespace App\Services\TgStat;

use App\Services\HttpClient\HttpClient;
use App\Services\TgStat\Models\TgStatChannel;
use App\Utils\DOMDocumentXPathParser;

class TgStatService
{
    const CHANNEL_URL_PREFIX = 'https://tgstat.ru/channel/';

    protected ?object $client;

    public static function getChannelSlug(string $slug, bool $is_public): string
    {
        return ($is_public ? '@' : '') . $slug;
    }

    public static function getChannelUrl(string $TgStatChannelSlug): string
    {
        return static::CHANNEL_URL_PREFIX . $TgStatChannelSlug;
    }

    public static function getPostUrl(string $TgStatChannelSlug, int $postId): string
    {
        return static::CHANNEL_URL_PREFIX . $TgStatChannelSlug . '/' . $postId;
    }

    public static function getPostStatUrl(string $TgStatChannelSlug, int $postId): string
    {
        return static::getPostUrl($TgStatChannelSlug, $postId) . '/stat';
    }

    public function __construct(HttpClient $client)
    {
        $this->client = $client;
    }

    public function fetchUrl(string $url)
    {
        return $this->client->fetch($url);
    }

    public function fetchUrlAndInitParser(string $url): ?DOMDocumentXPathParser
    {
        $html = $this->fetchUrl($url);

        return $html ? TgStatParser::initParser($html) : null;
    }

    public function fetchChannelInfo(TgStatChannel $channel, $as_object = false)
    {
        $parser = $this->fetchUrlAndInitParser($channel->url);

        return $parser ? TgStatParser::parseChannelInfo($parser, $as_object) : null;
    }

//    public function fetchChannelPosts(TgStatsChannel $channel, $as_object = false)
//    {
//        $parser = $this->fetchUrlAndInitParser($channel->url);
//
//        return TgStatParser::parsePosts($parser, $as_object);
//    }
//
//    public function fetchChannelAndPosts(TgStatsChannel $channel, $as_object = false)
//    {
//        $parser = $this->fetchUrlAndInitParser($channel->url);
//        $res    = TgStatParser::parseChannelInfo($parser) +[
//            'posts' => TgStatParser::parsePosts($parser)
//        ];
//
//        return (object)$res;
//    }
}
