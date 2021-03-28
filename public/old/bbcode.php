<?php

/**
 * bbcode parser
 * @package lumasms
 */

/**
 * Parse bbcode
 *
 * @param string $text The text with bbcode to parse.
 *
 * @return  A string of parsed bbcode.
 */
function bbcode($text)
{
    global
        $list_open,
        $list_close,
        $quote_open,
        $quote_close,
        $spoiler_open,
        $spoiler_close
    ;

    $list_open = 0;
    $list_close = 0;
    $quote_open = 0;
    $quote_close = 0;
    $spoiler_open = 0;
    $spoiler_close = 0;










    // == SIMPLE TAGS ==

    $simple_codes = [
        'b' => 'bold',
        'i' => 'italic',
        'u' => 'underline',
        's' => 'strikethrough',
        'center' => 'center'
    ];

    foreach ($simple_codes as $key => $value) {
        $text = preg_replace(
            '/\[' . $key . '](.*)\[\/' . $key . ']/isU',
            '<span class="bbcode-' . $value . '">$1</span>',
            $text
        );
    }










    // == LESS SIMPLE TAGS ==

    // URLs

    $text = preg_replace_callback(
        '/\[url=(((http(s|)):\/\/|)[a-zA-Z0-9]{1}[a-zA-Z0-9\-]{1,251}'
        . '[a-zA-Z0-9]{1}\.[a-zA-Z]{1,10}(\/|)'
        . '[a-zA-Z0-9@:%_\+.~#?&\/=\-$\^\*\(\)\`]*)\](.+)\[\/url\]/isU',
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
                    global $quote_open;

                    $quote_open++;

                    $ret = '<blockquote><cite>';

                    if (!empty($matches[2])) {
                        $ret .= $matches[2] . ' said:';
                    } else {
                        $ret .= 'Quote:';
                    }

                    $ret .= '</cite><div class="card-block">';

                    return $ret;
                },
                $ret
            );

            $ret = preg_replace_callback(
                '/\[\/quote\]/is',
                function ($matches) {
                    global $quote_close;

                    $quote_close++;

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

    if ($quote_open != $quote_close) {
        if ($quote_open > $quote_close) {
            $text .= '</div></blockquote>';
        } else {
            $text = '<blockquote><cite>Quote:</cite><div class="card-block">' . $text;
        }
    }



    // Images

    $text = preg_replace(
        '/\[img\](((http(s|)):\/\/|)[a-zA-Z0-9]{1}[a-zA-Z0-9\-]{1,251}'
        . '[a-zA-Z0-9]{1}\.[a-zA-Z]{1,10}(\/|)'
        . '[a-zA-Z0-9@:%_\+.~#?&\/=\-$\^\*\(\)\`]*)\[\/img\]/isU',
        '<img src="$1" class="bbcode-image">',
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
        '/\[(youtube|ytaudio)\](((http(s|)):\/\/|)([a-z0-9\-]{1,255}\.|)'
        . '([a-zA-Z0-9]{1}[a-zA-Z0-9\-]{1,251}[a-zA-Z0-9]{1}\.[a-zA-Z]{1,10})'
        . '(\/|)([a-zA-Z0-9;@:%_\+.~#?&\/=\-$\^\*\(\)\`]*))'
        . '\[\/(youtube|ytaudio)\]/isU',
        function ($matches) {
            if ($matches[1] != $matches[10]) {
                return $matches[0];
            }

            if (!in_array($matches[7], ['youtube.com','youtu.be'])) {
                return '<div class="alert alert-warning">Non-YouTube URL detected</div>';
            }

            if ($matches[7] == 'youtu.be') {
                $code = $matches[9];
            } else {
                $code = array_pop(explode('v=', $matches[9]));
                $code = array_shift(explode('&', $code));
            }

            return '<iframe src="https://youtube.com/embed/'
                . $code
                . '" class="bbcode-youtube'
                . ($matches[1] == 'ytaudio' ? ' bbcode-youtube-audio' : '')
                . '"></iframe>';
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
                    global $list_open;

                    $list_open++;

                    $ret = '<ul class="bbcode-list">';

                    return $ret;
                },
                $ret
            );

            $ret = preg_replace_callback(
                '/\[\/list\]/is',
                function ($matches) {
                    global $list_close;

                    $list_close++;

                    $ret = '</ul>';

                    return $ret;
                },
                $ret
            );

            return $ret;
        },
        $text
    );

    if ($list_open != $list_close) {
        if ($list_open > $list_close) {
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
                    global $spoiler_open;

                    $spoiler_open++;

                    $ret = '<div class="bbcode-spoiler-container">'
                        . '<button type="button" class="btn btn-success spoiler-button">'
                        . lang('spoiler-button')
                        . '</button><div class="bbcode-spoiler">';

                    return $ret;
                },
                $ret
            );

            $ret = preg_replace_callback(
                '/\[\/spoiler\]/is',
                function ($matches) {
                    global $spoiler_close;

                    $spoiler_close++;

                    $ret = '</div></div>';

                    return $ret;
                },
                $ret
            );

            return $ret;
        },
        $text
    );

    if ($spoiler_open != $spoiler_close) {
        if ($spoiler_open > $spoiler_close) {
            $text .= '</div></div>';
        } else {
            $text = '<div class="bbcode-spoiler-container">'
                . '<button type="button" class="btn btn-success spoiler-button">'
                . lang('spoiler-button')
                . '</button><div class="bbcode-spoiler">'
                . $text;
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
