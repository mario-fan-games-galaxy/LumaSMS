<?php

/**
 * BBCode functionality.
 *
 * @package LumaSMS
 * @license MIT <https://opensource.org/licenses/MIT>
 * @author  HylianDev <supergoombario@gmail.com>
 * @copyright Mario Fan Games Galaxy 2018 <https://www.mfgg.net>
 */

/**
 * Return formatted BBCode text
 *
 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
 * @SuppressWarnings(PHPMD.NPathComplexity)
 * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
 * @SuppressWarnings(PHPMD.ElseExpression)
 *
 * @param string $text The text to format.
 * @return string The formatted text.
 */
function bbcode($text)
{
    global
        $listOpen,
        $listClose,
        $quoteOpen,
        $quoteClose,
        $spoilerOpen,
        $spoilerClose
    ;

    $listOpen = 0;
    $listClose = 0;
    $quoteOpen = 0;
    $quoteClose = 0;
    $spoilerOpen = 0;
    $spoilerClose = 0;

    // == SIMPLE TAGS ==

    $simpleCodes = [
        'b' => 'bold',
        'i' => 'italic',
        'u' => 'underline',
        's' => 'strikethrough',
        'center' => 'center'
    ];

    foreach ($simpleCodes as $key => $value) {
        $text = preg_replace(
            '/\[' . $key . '](.*)\[\/' . $key . ']/isU',
            '<span class="bbcode-' . $value . '">$1</span>',
            $text
        );
    }

    // == LESS SIMPLE TAGS ==

    // URLs

    $text = preg_replace_callback(
        // phpcs:disable Generic.Files.LineLength
        '/\[url=(((http(s|)):\/\/|)[a-zA-Z0-9]{1}[a-zA-Z0-9\-]{1,251}[a-zA-Z0-9]{1}\.[a-zA-Z]{1,10}(\/|)[a-zA-Z0-9@:%_\+.~#?&\/=\-$\^\*\(\)\`]*)\](.+)\[\/url\]/isU',
        // phpcs:enable Generic.Files.LineLength
        function ($matches) {
            $url = $matches[1];

            if (empty($matches[2])) {
                $url = 'http://' . $url;
            }

            return '<a href="' . $url . '" target="_blank">' . $matches[6] . '</a>';
        },
        $text
    );

    // Quotes

    $text = preg_replace_callback(
        '/\[quote(=([a-zA-Z0-9@:%_\+.~#?&\/=\-$\^\*\(\)\`\ \<\>\"\']+)|)\](.+)\[\/quote\]/is',
        function ($matches) {
            $ret = $matches[0];

            $ret = preg_replace_callback(
                '/\[quote(=([a-zA-Z0-9@:%_\+.~#?&\/=\-$\^\*\(\)\`\ \<\>\"\']+)|)\]/is',
                function ($matches) {
                    global $quoteOpen;

                    $quoteOpen++;

                    $ret = '<blockquote><cite>';

                    $citationText = 'Quote:';
                    if (!empty($matches[2])) {
                        $citationText = $matches[2] . ' said:';
                    }
                    $ret .= $citationText;

                    $ret .= '</cite><div class="card-block">';

                    return $ret;
                },
                $ret
            );

            $ret = preg_replace_callback(
                '/\[\/quote\]/is',
                function ($matches) {
                    global $quoteClose;

                    $quoteClose++;

                    $ret = '';

                    $ret .= '</div></blockquote>';

                    return $ret;
                },
                $ret
            );

            return $ret;
        },
        $text
    );

    if ($quoteOpen != $quoteClose) {
        if ($quoteOpen > $quoteClose) {
            $text .= '</div></blockquote>';
        } else {
            $text = '<blockquote><cite>Quote:</cite><div class="card-block">' . $text;
        }
    }

    // Images

    $text = preg_replace(
        // phpcs:disable Generic.Files.LineLength
        '/\[img\](((http(s|)):\/\/|)[a-zA-Z0-9]{1}[a-zA-Z0-9\-]{1,251}[a-zA-Z0-9]{1}\.[a-zA-Z]{1,10}(\/|)[a-zA-Z0-9@:%_\+.~#?&\/=\-$\^\*\(\)\`]*)\[\/img\]/isU',
        '<img src="$1" class="bbcode-image">',
        // phpcs:enable Generic.Files.LineLength
        $text
    );

    // Text sizes

    $text = preg_replace(
        '/\[size\=(200|1[0-9]{2}|[5-9]{1}[0-9]{1})\](.+)\[\/size\]/isU',
        '<span class="bbcode-size" style="font-size:$1%;">$2</span>',
        $text
    );

    // YouTube / YouTube Audio

    $text = preg_replace_callback(
        // phpcs:disable Generic.Files.LineLength
        '/\[(youtube|ytaudio)\](((http(s|)):\/\/|)([a-z0-9\-]{1,255}\.|)([a-zA-Z0-9]{1}[a-zA-Z0-9\-]{1,251}[a-zA-Z0-9]{1}\.[a-zA-Z]{1,10})(\/|)([a-zA-Z0-9;@:%_\+.~#?&\/=\-$\^\*\(\)\`]*))\[\/(youtube|ytaudio)\]/isU',
        // phpcs:enable Generic.Files.LineLength
        function ($matches) {
            if ($matches[1] != $matches[10]) {
                return $matches[0];
            }

            if (!in_array($matches[7], ['youtube.com','youtu.be'])) {
                return '<div class="alert alert-warning">Non-YouTube URL detected</div>';
            }

            $code = array_pop(explode('v=', $matches[9]));
            $code = array_shift(explode('&', $code));
            if ($matches[7] == 'youtu.be') {
                $code = $matches[9];
            }

            return '<iframe src="https://youtube.com/embed/' .
                $code . '" class="bbcode-youtube' .
                ($matches[1] == 'ytaudio' ? ' bbcode-youtube-audio' : '') .
                '"></iframe>';
        },
        $text
    );

    // Code

    $text = preg_replace_callback(
        '/\[code\](.+)\[\/code\]/isU',
        function ($matches) {
            return '<div class="bbcode-code">' . str_replace("\t", '&emsp;&emsp;&emsp;&emsp;', $matches[1]) . '</div>';
            //return debug($matches);
        },
        $text
    );

    // List

    $text = preg_replace_callback(
        '/\[list\](.+)\[\/list\]/is',
        function ($matches) {
            $ret = str_replace('[*]', '<li class="bbcode-list-item">', $matches[0]);

            $ret = preg_replace_callback(
                '/\[list\]/is',
                function ($matches) {
                    global $listOpen;

                    $listOpen++;

                    $ret = '<ul class="bbcode-list">';

                    return $ret;
                },
                $ret
            );

            $ret = preg_replace_callback(
                '/\[\/list\]/is',
                function ($matches) {
                    global $listClose;

                    $listClose++;

                    $ret = '</ul>';

                    return $ret;
                },
                $ret
            );

            return $ret;
        },
        $text
    );

    if ($listOpen != $listClose) {
        if ($listOpen > $listClose) {
            $text .= '</ul>';
        } else {
            $text = '<ul class="bbcode-list">' . $text;
        }
    }

    // Spoiler

    $text = preg_replace_callback(
        '/\[spoiler\](.+)\[\/spoiler\]/is',
        function ($matches) {
            $ret = $matches[0];

            $ret = preg_replace_callback(
                '/\[spoiler\]/is',
                function ($matches) {
                    global $spoilerOpen;

                    $spoilerOpen++;

                    $ret = '<div class="bbcode-spoiler-container">' .
                        '<button type="button" class="btn btn-success spoiler-button">' .
                        lang('spoiler-button') .
                        '</button><div class="bbcode-spoiler">';

                    return $ret;
                },
                $ret
            );

            $ret = preg_replace_callback(
                '/\[\/spoiler\]/is',
                function ($matches) {
                    global $spoilerClose;

                    $spoilerClose++;

                    $ret = '</div></div>';

                    return $ret;
                },
                $ret
            );

            return $ret;
        },
        $text
    );

    if ($spoilerOpen != $spoilerClose) {
        if ($spoilerOpen > $spoilerClose) {
            $text .= '</div></div>';
        } else {
            $text = '<div class="bbcode-spoiler-container">' .
                '<button type="button" class="btn btn-success spoiler-button">' .
                lang('spoiler-button') .
                '</button><div class="bbcode-spoiler">' .
                $text;
        }
    }

    // iSpoiler

    $text = preg_replace(
        '/\[ispoiler\](.+)\[\/ispoiler\]/isU',
        '<div class="bbcode-ispoiler">$1</div>',
        $text
    );

    // == RETURN ==

    return $text;
}

/**
 * The full format function
 *
 * This formats BBCode, decoverts leftover TCSMS bbcode, etc
 *
 * @param string $text The text to format.
 * @return string The formatted text.
 */
function format($text)
{
    $text = unconvert($text);

    $text = bbcode($text);

    $text = nl2br($text);

    return $text;
}

/**
 * Run this on text before putting it in the database
 *
 * @param string $text The text to format.
 * @return string The formatted text.
 */
function preFormat($text)
{
    $text = htmlentities($text);

    return $text;
}

/**
 * Unconvert TCSMS formatted BBCode
 * I stole this function directly from TCSMS lol
 *
 * @author unascribed
 * @author HylianDev <supergoombario@gmail.com>
 *
 * @param string $data The data to unconvert.
 * @return string The unconverted data.
 */
function unconvert($data)
{
    $data = preg_replace("/<b>(.*?)<\/b>/is", "[b]\\1[/b]", $data);
    $data = preg_replace("/<u>(.*?)<\/u>/is", "[u]\\1[/u]", $data);
    $data = preg_replace("/<i>(.*?)<\/i>/is", "[i]\\1[/i]", $data);
    $data = preg_replace("/<s>(.*?)<\/s>/is", "[s]\\1[/s]", $data);
    $data = preg_replace("/<sup>(.*?)<\/sup>/is", "[sup]\\1[/sup]", $data);
    $data = preg_replace("/<sub>(.*?)<\/sub>/is", "[sub]\\1[/sub]", $data);

    // URLs
    $data = preg_replace("/<a\s+href=[\"\']mailto:(\S+?)[\"\']>\s*\\1\s*<\/a>/is", "[email]\\1[/email]", $data);
    $data = preg_replace("/<a\s+href=[\"\'](\S+?)[\"\']>\s*\\1\s*<\/a>/is", "[url]\\1[/url]", $data);
    $data = preg_replace("#<img src=[\"'](\S+?)['\"].+?" . ">#", "[img]\\1[/img]", $data);
    $data = preg_replace("/<a\s+href=[\"\'](\S+?)[\"\']>(.*?)<\/a>/is", "[url=\\1]\\2[/url]", $data);

    // Quotes
    $data = preg_replace(
        "/<!--QuoteStart--><div class=\"quotetitle\">Quote<\/div><div class=\"quote\">/is",
        "[quote]",
        $data
    );

    $data = preg_replace(
        // phpcs:disable Generic.Files.LineLength
        "/<!--QuoteStart--><div class=\"quotetitle\">Quote <span style='font-weight:normal'>\((.+?)\)<\/span><\/div><div class=\"quote\">/is",
        // phpcs:enable Generic.Files.LineLength
        // Idk why this isn't working but it's just not being recognized
        // "[quote=$1]",
        "[quote]",
        $data
    );

    $data = preg_replace(
        "/<\/div><!--QuoteEnd-->/i",
        "[/quote]",
        $data
    );

    // Line breaks
    $data = preg_replace("/<br\s*\/?>/i", "\n", $data);

    // Content Updates
    $data = preg_replace("/<!--s_recent-->[\\x00-\\xFF]*<!--e_recent-->/", "{%recent_updates%}", $data);

    return $data;
}
