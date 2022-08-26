<?php

namespace App\Services\TgStat;

use App\Utils\DOMDocumentXPathParser;
use App\Utils\Helper;
use DOMDocument;
use Illuminate\Support\Str;

class TgStatParser
{
    public static function parseChannelInfo(DOMDocumentXPathParser $parser, $asObject = false)
    {
        $res = [];

        $avatar = $parser->evaluateFirst("//div#wrap#/div#container#/div[1]/div[1]/div/img");
        if ($avatar) {
            $avatar        = 'https:' . trim($avatar->getAttribute('data-src'));
            $res['avatar'] = $avatar;
        }

        $title = $parser->evaluateFirst("//div#wrap#/div#container#/div[1]/div[2]/h1");
        if ($title) {
            $title        = trim($title->textContent);
            $res['title'] = $title;
        }

        $description = $parser->evaluateFirst("//div#wrap#/div#container#/div[1]/div[2]/div[last()]");
        if ($description) {
            $description        = trim($description->textContent);
            $description        = preg_replace('/[ ]+/', ' ', trim($description));
            $description        = preg_replace('/^[ ]/m', '', trim($description));
            $res['description'] = $description;
        }

        $subscribers = $parser->evaluateFirst("//div#wrap#/div#container#/div[3]/div[1]/div/div[1]");
        if ($subscribers) {
            $subscribers    = preg_replace('/\s/', '', trim($subscribers->textContent));
            $res['members'] = (int)$subscribers;
        }

        $avg_post_reach = $parser->evaluateFirst("//div#wrap#/div#container#/div[3]/div[2]/div/div[1]");
        if ($avg_post_reach) {
            $avg_post_reach            = trim($avg_post_reach->textContent);
            $res['avg_post_reach_raw'] = $avg_post_reach;
            $res['avg_post_reach']     = (int)Helper::normalizeNumber($avg_post_reach);
        }

        $avg_daily_reach = $parser->evaluateFirst("//div#wrap#/div#container#/div[3]/div[3]/div/div[1]");
        if ($avg_daily_reach) {
            $avg_daily_reach            = trim($avg_daily_reach->textContent);
            $res['avg_daily_reach_raw'] = $avg_daily_reach;
            $res['avg_daily_reach']     = (int)Helper::normalizeNumber($avg_daily_reach);
        }

        $avg_posts_per_day = $parser->evaluateFirst("//div#wrap#/div#container#/div[3]/div[4]/div/div[1]");
        if ($avg_posts_per_day) {
            $avg_posts_per_day            = trim($avg_posts_per_day->textContent);
            $res['avg_posts_per_day_raw'] = $avg_posts_per_day;
            $res['avg_posts_per_day']     = (int)Helper::normalizeNumber($avg_posts_per_day);
        }

        $err_percent = $parser->evaluateFirst("//div#wrap#/div#container#/div[3]/div[5]/div/div[1]");
        if ($err_percent) {
            $err_percent            = trim($err_percent->textContent);
            $res['err_percent_raw'] = $err_percent;
            $res['err_percent']     = floatval(trim($err_percent, '%'));
        }

        $citation_index = $parser->evaluateFirst("//div#wrap#/div#container#/div[3]/div[6]/div/div[1]");
        if ($citation_index) {
            $citation_index            = trim($citation_index->textContent);
            $res['citation_index_raw'] = $citation_index;
            $res['citation_index']     = floatval($citation_index);
        }

        $last_post_id = $parser->evaluateFirst("//div#posts-lists-container#//figure#post-container#/div#post-body-read-more-button#/a");
        if ($last_post_id) {
            $last_post_id = Str::afterLast(trim($last_post_id->getAttribute('data-src')), '/');
            $res['last_post_id'] = (int)$last_post_id;
        }

        return $asObject ? (object)$res : $res;
    }

    public static function parsePost(DOMDocumentXPathParser $parser, $asObject = false)
    {
        $post = ['video' => false, 'image' => false];

        $parsed_dt_string = $parser->evaluateFirst("div#post-header#/div[1]/div[2]/span");
        if ($parsed_dt_string) {
            $parsed_dt_string         = trim($parsed_dt_string->textContent);
            $post['parsed_dt_string'] = $parsed_dt_string;
        }

        $text = $parser->evaluateFirst("div#post-body#/div");
        if ($text) {
            $text         = preg_replace('/\s+/', ' ', $text->textContent);
            $text         = trim($text);
            $post['text'] = $text;
        }

        if ($parser->evaluateFirst("div#post-body#/div/a")) {
            $post['with_video'] = true;
        } elseif ($parser->evaluateFirst("div#post-body#/div/img")) {
            $post['with_image'] = true;
        }

        $stat_link = $parser->evaluateFirst("div#post-footer#/a");
        if ($stat_link) {
            $stat_link         = trim($stat_link->getAttribute('data-src'));
            $post['stat_link'] = $stat_link;
        }

        $views = $parser->evaluateFirst("div#post-footer#/a[1]");
        if ($views) {
            $views             = trim($views->textContent, " \n\r\t\v\0" . chr(194) . chr(160));
            $post['views_raw'] = $views;
            $post['views']     = Helper::normalizeNumber($views);
        }

        $reposts = $parser->evaluateFirst("div#post-footer#/a[2]");
        if ($reposts) {
            $reposts             = trim($reposts->textContent, " \n\r\t\v\0" . chr(194) . chr(160));
            $post['reposts_raw'] = $reposts;
            $post['reposts']     = Helper::normalizeNumber($reposts);
        }

        return $asObject ? (object)$post : $post;
    }

    public static function parsePostFromFeed(DOMDocumentXPathParser $parser, $asObject = false)
    {
        $post = ['video' => false, 'image' => false];

        $parsed_dt_string = $parser->evaluateFirst("div#post-header#/div[1]/div[2]/span");
        if ($parsed_dt_string) {
            $parsed_dt_string         = trim($parsed_dt_string->textContent);
            $post['parsed_dt_string'] = $parsed_dt_string;
        }

        $text = $parser->evaluateFirst("div#post-body#/div");
        if ($text) {
            $text         = preg_replace('/\s+/', ' ', $text->textContent);
            $text         = trim($text);
            $post['text'] = $text;
        }

        if ($parser->evaluateFirst("div#post-body#/div/a")) {
            $post['with_video'] = true;
        } elseif ($parser->evaluateFirst("div#post-body#/div/img")) {
            $post['with_image'] = true;
        }

        $stat_link = $parser->evaluateFirst("div#post-footer#/a");
        if ($stat_link) {
            $stat_link         = trim($stat_link->getAttribute('data-src'));
            $post['stat_link'] = $stat_link;
        }

        $views = $parser->evaluateFirst("div#post-footer#/a[1]");
        if ($views) {
            $views             = trim($views->textContent, " \n\r\t\v\0" . chr(194) . chr(160));
            $post['views_raw'] = $views;
            $post['views']     = Helper::normalizeNumber($views);
        }

        $reposts = $parser->evaluateFirst("div#post-footer#/a[2]");
        if ($reposts) {
            $reposts             = trim($reposts->textContent, " \n\r\t\v\0" . chr(194) . chr(160));
            $post['reposts_raw'] = $reposts;
            $post['reposts']     = Helper::normalizeNumber($reposts);
        }

        return $asObject ? (object)$post : $post;
    }

    public static function parsePostsFromFeed(DOMDocumentXPathParser $parser, $asObject = false): array
    {
        $posts = [];
        $data  = $parser->query("//div#posts-lists-container#//figure#post-container#");

        foreach ($data as $item) {
            $posts [] = static::parsePostFromFeed($parser->clone($item), $asObject);
        }

        return $posts;
    }

    public static function initParser(string $html): DOMDocumentXPathParser
    {
        $doc = new DOMDocument();
        $doc->loadHTML($html, LIBXML_NOWARNING | LIBXML_NOERROR | LIBXML_COMPACT | LIBXML_HTML_NOIMPLIED | LIBXML_NSCLEAN | LIBXML_PEDANTIC);
        return new DOMDocumentXPathParser($doc);
    }
}
