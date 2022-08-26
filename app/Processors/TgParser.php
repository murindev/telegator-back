<?php

namespace App\Processors;

use \DOMDocument;
use \DOMXPath;
use \InvalidArgumentException;
use \Exception;

class TgParser {

    const LINK_PREFIX                   = 'https://t.me/';
    const LINK_PREFIX_LENGTH            = 13; // strlen(static::LINK_PREFIX)
    const PRIVATE_CHANNEL_PREFIX        = 'joinchat/';
    const PRIVATE_CHANNEL_PREFIX_LENGTH = 9; // strlen(static::PRIVATE_CHANNEL_PREFIX)

    public static function validateChannelLink(string $s): bool
    {
        return $s && is_string($s) && substr($s, 0, static::LINK_PREFIX_LENGTH) === static::LINK_PREFIX;
    }

    public static function validateChannelSlug(string $s): bool
    {
        return strpos($s, '/') === false;
    }

    private static function isPrivateChannelSlug(string $s): bool
    {
        return substr($s, 0, static::PRIVATE_CHANNEL_PREFIX_LENGTH) === static::PRIVATE_CHANNEL_PREFIX;
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

	public static function fetchChannelInfo($channelSlug): object
    {
		$url = "https://t.me/$channelSlug";
		$doc = new DOMDocument();
		$doc->loadHTMLFile($url, LIBXML_NOWARNING | LIBXML_NOERROR | LIBXML_COMPACT | LIBXML_HTML_NOIMPLIED | LIBXML_NSCLEAN | LIBXML_PEDANTIC);
		$xpath = new DOMXPath($doc);
		$firstId = null;

		$res = array(
			'slug' => $channelSlug,
            'link' => $url,
 			'title' => null,
			'image' => null,
			'description' => null,
			'subscribers' => null,
		);

		$title = $xpath->query("//*[contains(concat(' ', @class, ' '), ' tgme_page_title ')]")->item(0);
		if ($title) {
			$title = trim($title->textContent);
			$res['title'] = $title;
		}

		$image = $xpath->query("//*[contains(concat(' ', @class, ' '), ' tgme_page_photo_image ')]")->item(0);
		if ($image) {
			$image = trim($image->getAttribute('src'));
			$res['image'] = $image;
		}

		$description = $xpath->query("//*[contains(concat(' ', @class, ' '), ' tgme_page_description ')]")->item(0);
		if ($description) {
			$description = trim($description->textContent);
			$res['description'] = $description;
		}

		$subscribers = $xpath
			->query("//*[contains(concat(' ', @class, ' '), ' tgme_page_extra ')][contains(., ' subscribers')]")
			->item(0)
		;
		if ($subscribers) {
			$subscribers = preg_replace('/(\d) (\d)/', '$1$2', $subscribers->textContent);
			$subscribers = self::normNumber($subscribers);
			$res['members'] = $subscribers;
		}

		$members = $xpath
			->query("//*[contains(concat(' ', @class, ' '), ' tgme_page_extra ')][contains(., ' members')]")
			->item(0)
		;
		if ($members) {
			$members = preg_replace('/(\d) (\d)/', '$1$2', $members->textContent);
			$members = self::normNumber($members);
			$res['members'] = $members;
		}

		return (object) $res;
	}

	public static function fetchPosts($channelSlug, $postCount = null, $tillId = null, $delay = 1): \Generator
    {
		$channelSlug = self::normChannelSlug($channelSlug);
		$url = "https://t.me/s/$channelSlug";
		if ($tillId) {
			$url .= '?before=' . ((int) $tillId);
		}
		$doc = new DOMDocument();
		$doc->loadHTMLFile($url, LIBXML_NOWARNING | LIBXML_NOERROR | LIBXML_COMPACT | LIBXML_HTML_NOIMPLIED | LIBXML_NSCLEAN | LIBXML_PEDANTIC);
		$xpath = new DOMXPath($doc);
		$firstId = null;
		$counter = 0;

		$messages = $xpath->query("/html/body//div[contains(concat(' ', @class, ' '), ' tgme_widget_message ')]");
		for ($i = $messages->count() - 1; $i >= 0; $i--) {
			$message = $messages->item($i);
			$text = $xpath->evaluate("*//*[contains(concat(' ', @class, ' '), ' tgme_widget_message_text ')]", $message)->item(0);
			if ($text) {
				$text = $text->ownerDocument->saveHTML($text);
				$text = trim($text);
				$text = preg_replace('/^<[^>]+>|<\/[^>]+>$/', '', $text);
				$text = trim($text);
			}

			$media = [];
			$photos = $xpath->evaluate("*//*[contains(concat(' ', @class, ' '), ' tgme_widget_message_photo_wrap ')]", $message);
			foreach ($photos as $photo) {
				if (!$photo) {
					continue;
				}
				$photo = self::parseStyleBackgroundUrl($photo->getAttribute('style') ?: '');
				if (!$photo) {
					continue;
				}
				$media[] = (object) array(
					'type' => 'photo',
					'url' => $photo,
				);
			}

			$players = $xpath->evaluate("*//*[contains(concat(' ', @class, ' '), ' tgme_widget_message_video_player ')]", $message);
			foreach ($players as $player) {
				$video = $xpath->evaluate("*//video[contains(concat(' ', @class, ' '), ' tgme_widget_message_video ')]", $player)->item(0);
				if (!$video) {
					continue;
				}
				$video = $video->getAttribute('src') ?? null;
				if (!$video) {
					continue;
				}
				$duration = $xpath->evaluate("time[contains(concat(' ', @class, ' '), ' message_video_duration ')]", $player)->item(0)->textContent ?? null;
				$duration = self::normDuration($duration);

				$media[] = (object) array(
					'type' => 'video',
					'url' => $video,
					'duration' => $duration,
				);
			}

			$views = $xpath->evaluate("*//*[contains(concat(' ', @class, ' '), ' tgme_widget_message_views ')]", $message)->item(0);
			if ($views) {
				$views = $views->textContent;
				$views = self::normNumber($views);
			}

			$time = null;
			$id = null;
			$link = $xpath->evaluate("*//a[contains(concat(' ', @class, ' '), ' tgme_widget_message_date ')]", $message)->item(0);
			if ($link) {
				$time = $xpath->evaluate("time", $link)->item(0);
				if ($time) {
					$time = $time->getAttribute('datetime');
				}
				$link = $link->getAttribute('href');
				$m = null;
				if (preg_match('/\/(\d+)\/?$/', $link, $m)) {
					$id = $m[1];
				}
			}

			$reactions = [];
			$buttons = $xpath->evaluate("*//*[contains(concat(' ', @class, ' '), ' tgme_widget_message_inline_button_text ')]", $message);
			foreach ($buttons as $button) {
				$reaction = $xpath->evaluate("i[contains(concat(' ', @class, ' '), ' emoji ')]", $button)->item(0);
				if (!$reaction) {
					continue;
				}
				$reactionCount = self::normNumber(trim($reaction->nextSibling->textContent ?? null));
				if (!$reactionCount) {
					continue;
				}
				$reactions[trim($reaction->textContent)] = $reactionCount;
			}

			$counter++;
			$firstId = $id;

			yield $id => (object) array(
				'id' => $id,
				'time' => $time,
				'text' => $text,
				'media' => $media ?: null,
				'views' => $views,
				'reactions' => $reactions ?: null,
			);
		}

		$postCount -= $counter;
		if ($postCount > 0 && $firstId > 1) {
			if ($delay > 0) {
				usleep($delay * 1000000);
			}
			yield from self::fetchPosts($channelSlug, $postCount, $firstId);
		}
	}

	// Helpers:

    public static function getChannelSlugFromLink($s) {
	    if (!is_string($s)) {
	        throw new Exception('Argument for getChannelSlugFromLink must be string');
        }
	    if (substr($s, 0, 13) !== "https://t.me/") {
            throw new Exception('Invalid channel link');
        }

	    return self::normChannelSlug(substr($s, 13));
    }

    public static function normChannelSlug($channelSlug) {
        $channelSlug = trim($channelSlug);
        if (strpos($channelSlug, '/') !== false) {
            throw new InvalidArgumentException("Channel slug ($channelSlug) contains invalid characters", 400);
        }
        return $channelSlug;
    }

	public static function parseStyleBackgroundUrl($s) {
		if (!$s || !preg_match('/\bbackground(?:-image)?\s*:[^;]*url\s*\((.+)/', $s, $s)) {
			return null;
		}
		$s = trim($s[1]);
		if ($s[0] === '"' || $s[0] === "'") {
			$s = substr($s, 1, strpos($s, $s[1], 1) - 1);
		}
		else {
			$s = substr($s, 0, strpos($s, ')') - 1);
		}
		return $s;
	}

	public static function normNumber($s) {
		$n = floatval($s);
		$m = null;
		if (preg_match('/^([-+]?\d+(?:[.,]\d+)?)\s*(k|m)\b/', strtolower($s), $m)) {
			if ($m[2] === 'k') {
				$n *= 1000;
			}
			else if ($m[2] === 'm') {
				$n *= 1000 * 1000;
			}
		}
		return $n;
	}

	public static function normDuration($s) {
		if (!is_string($s)) {
			return $s;
		}
		$s = explode(':', $s);
		if (count($s) > 3) {
			return false;
		}
		$s = array_reverse($s);
		return 0
			+ ($s[0] ?? 0)
			+ ($s[1] ?? 0) * 60
			+ ($s[2] ?? 0) * 3600
		;
	}
}
