<div><?php foreach ([
    [
        [
            'fa' => 'bold',
            'tag' => '[b][/b]'
        ],
        [
            'fa' => 'italic',
            'tag' => '[i][/i]'
        ],
        [
            'fa' => 'underline',
            'tag' => '[u][/u]'
        ],
        [
            'fa' => 'strikethrough',
            'tag' => '[s][/s]'
        ],
    ],
    [
        [
            'fa' => 'align-center',
            'tag' => '[center][/center]'
        ],
        [
            'fa' => 'text-height',
            'tag' => '[size=100][/size]'
        ],
    ],
    [
        [
            'fa' => 'link',
            'tag' => '[url=example.com][/url]'
        ],
        [
            'fa' => 'quote-right',
            'tag' => '[quote][/quote]'
        ],
        [
            'fa' => 'picture-o',
            'tag' => '[img][/img]'
        ],
    ],
    [
        [
            'fa' => 'youtube-play',
            'tag' => '[ytaudio][/ytaudio]'
        ],
        [
            'fa' => 'youtube',
            'tag' => '[youtube][/youtube]'
        ],
        [
            'fa' => 'code',
            'tag' => '[code][/code]'
        ]
    ],
    [
        [
            'fa' => 'list-ul',
            'tag' => '[list][/list]'
        ],
        [
            'fa' => 'asterisk',
            'tag' => '[*]'
        ],
        [
            'fa' => 'eye-slash',
            'tag' => '[spoiler][/spoiler]'
        ],
        [
            'fa' => 'mouse-pointer',
            'tag' => '[ispoiler][/ispoiler]'
        ]
    ]
] as $bbcode_group) : ?>
<div class="bbcode-bar btn-group"><?php foreach ($bbcode_group as $bbcode) : ?>
    <button type="button" class="btn btn-blue" data-bbcode="<?=$bbcode['tag']?>">
        <span class="fa fa-<?=$bbcode['fa']?>"></span>
    </button>
                                    <?php endforeach; ?></div>

        <?php endforeach; ?></div>





<textarea
    name="<?=$name?>"
    class="form-control <?=$error ? 'form-control-danger' : ''?>"
    placeholder="<?=$title?>"
    <?php if ($minlength) {
        echo 'minlength="' . $minlength . '"';
} ?>
    <?php if ($maxlength) {
        echo 'maxlength="' . $maxlength . '"';
} ?>
    <?php if ($tabindex) {
        echo 'tabindex="' . $tabindex . '"';
} ?>
    <?=$required ? 'required' : ''?>
><?=$_POST[$name]?></textarea>