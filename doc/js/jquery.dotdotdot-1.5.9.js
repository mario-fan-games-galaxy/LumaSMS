/*
 *	jQuery dotdotdot 1.5.9
 *
 *	Copyright (c) 2013 Fred Heusschen
 *	www.frebsite.nl
 *
 *	Plugin website:
 *	dotdotdot.frebsite.nl
 *
 *	Dual licensed under the MIT and GPL licenses.
 *	http://en.wikipedia.org/wiki/MIT_License
 *	http://en.wikipedia.org/wiki/GNU_General_Public_License
 */

(function ($) {
  if ($.fn.dotdotdot) {
    return;
  }

  $.fn.dotdotdot = function (o) {
    if (this.length == 0) {
      if (!o || o.debug !== false) {
        debug(true, `No element found for "${this.selector}".`);
      }
      return this;
    }
    if (this.length > 1) {
      return this.each(function () {
        $(this).dotdotdot(o);
      });
    }

    const $dot = this;

    if ($dot.data('dotdotdot')) {
      $dot.trigger('destroy.dot');
    }

    $dot.data('dotdotdot-style', $dot.attr('style'));
    $dot.css('word-wrap', 'break-word');

    $dot.bind_events = function () {
      $dot
        .bind('update.dot', (e, c) => {
          e.preventDefault();
          e.stopPropagation();

          opts.maxHeight = typeof opts.height === 'number'
            ? opts.height
            : getTrueInnerHeight($dot);

          opts.maxHeight += opts.tolerance;

          if (typeof c !== 'undefined') {
            if (typeof c === 'string' || c instanceof HTMLElement) {
              c = $('<div />')
                .append(c)
                .contents();
            }
            if (c instanceof $) {
              orgContent = c;
            }
          }

          $inr = $dot.wrapInner('<div class="dotdotdot" />').children();
          $inr
            .empty()
            .append(orgContent.clone(true))
            .css({
              height: 'auto',
              width: 'auto',
              border: 'none',
              padding: 0,
              margin: 0,
            });

          let after = false;


          let trunc = false;

          if (conf.afterElement) {
            after = conf.afterElement.clone(true);
            conf.afterElement.remove();
          }
          if (test($inr, opts)) {
            if (opts.wrap == 'children') {
              trunc = children($inr, opts, after);
            } else {
              trunc = ellipsis($inr, $dot, $inr, opts, after);
            }
          }
          $inr.replaceWith($inr.contents());
          $inr = null;

          if ($.isFunction(opts.callback)) {
            opts.callback.call($dot[0], trunc, orgContent);
          }

          conf.isTruncated = trunc;
          return trunc;
        })
        .bind('isTruncated.dot', (e, fn) => {
          e.preventDefault();
          e.stopPropagation();

          if (typeof fn === 'function') {
            fn.call($dot[0], conf.isTruncated);
          }
          return conf.isTruncated;
        })
        .bind('originalContent.dot', (e, fn) => {
          e.preventDefault();
          e.stopPropagation();

          if (typeof fn === 'function') {
            fn.call($dot[0], orgContent);
          }
          return orgContent;
        })
        .bind('destroy.dot', (e) => {
          e.preventDefault();
          e.stopPropagation();

          $dot
            .unwatch()
            .unbind_events()
            .empty()
            .append(orgContent)
            .attr('style', $dot.data('dotdotdot-style'))
            .data('dotdotdot', false);
        });
      return $dot;
    }; //	/bind_events

    $dot.unbind_events = function () {
      $dot.unbind('.dot');
      return $dot;
    }; //	/unbind_events

    $dot.watch = function () {
      $dot.unwatch();
      if (opts.watch == 'window') {
        const $window = $(window);


        let _wWidth = $window.width();


        let _wHeight = $window.height();

        $window.bind(`resize.dot${conf.dotId}`, () => {
          if (
            _wWidth != $window.width()
            || _wHeight != $window.height()
            || !opts.windowResizeFix
          ) {
            _wWidth = $window.width();
            _wHeight = $window.height();

            if (watchInt) {
              clearInterval(watchInt);
            }
            watchInt = setTimeout(() => {
              $dot.trigger('update.dot');
            }, 10);
          }
        });
      } else {
        watchOrg = getSizes($dot);
        watchInt = setInterval(() => {
          const watchNew = getSizes($dot);
          if (
            watchOrg.width != watchNew.width
            || watchOrg.height != watchNew.height
          ) {
            $dot.trigger('update.dot');
            watchOrg = getSizes($dot);
          }
        }, 100);
      }
      return $dot;
    };
    $dot.unwatch = function () {
      $(window).unbind(`resize.dot${conf.dotId}`);
      if (watchInt) {
        clearInterval(watchInt);
      }
      return $dot;
    };

    var orgContent = $dot.contents();


    var opts = $.extend(true, {}, $.fn.dotdotdot.defaults, o);


    var conf = {};


    var watchOrg = {};


    var watchInt = null;


    var $inr = null;

    conf.afterElement = getElement(opts.after, $dot);
    conf.isTruncated = false;
    conf.dotId = dotId++;

    $dot
      .data('dotdotdot', true)
      .bind_events()
      .trigger('update.dot');

    if (opts.watch) {
      $dot.watch();
    }

    return $dot;
  };

  //	public
  $.fn.dotdotdot.defaults = {
    ellipsis: '... ',
    wrap: 'word',
    lastCharacter: {
      remove: [' ', ',', ';', '.', '!', '?'],
      noEllipsis: [],
    },
    tolerance: 0,
    callback: null,
    after: null,
    height: null,
    watch: false,
    windowResizeFix: true,
    debug: false,
  };

  //	private
  var dotId = 1;

  function children($elem, o, after) {
    const $elements = $elem.children();


    let isTruncated = false;

    $elem.empty();

    for (let a = 0, l = $elements.length; a < l; a++) {
      const $e = $elements.eq(a);
      $elem.append($e);
      if (after) {
        $elem.append(after);
      }
      if (test($elem, o)) {
        $e.remove();
        isTruncated = true;
        break;
      } else if (after) {
        after.remove();
      }
    }
    return isTruncated;
  }
  function ellipsis($elem, $d, $i, o, after) {
    const $elements = $elem.contents();


    let isTruncated = false;

    $elem.empty();

    const notx = 'table, thead, tbody, tfoot, tr, col, colgroup, object, embed, param, ol, ul, dl, select, optgroup, option, textarea, script, style';
    for (let a = 0, l = $elements.length; a < l; a++) {
      if (isTruncated) {
        break;
      }

      const e = $elements[a];


      const $e = $(e);

      if (typeof e === 'undefined') {
        continue;
      }

      $elem.append($e);
      if (after) {
        $elem[$elem.is(notx) ? 'after' : 'append'](after);
      }
      if (e.nodeType == 3) {
        if (test($i, o)) {
          isTruncated = ellipsisElement($e, $d, $i, o, after);
        }
      } else {
        isTruncated = ellipsis($e, $d, $i, o, after);
      }

      if (!isTruncated) {
        if (after) {
          after.remove();
        }
      }
    }
    return isTruncated;
  }
  function ellipsisElement($e, $d, $i, o, after) {
    let isTruncated = false;


    var e = $e[0];

    if (typeof e === 'undefined') {
      return false;
    }

    const seporator = o.wrap == 'letter' ? '' : ' ';


    const textArr = getTextContent(e).split(seporator);


    let position = -1;


    let midPos = -1;


    let startPos = 0;


    let endPos = textArr.length - 1;

    while (startPos <= endPos) {
      const m = Math.floor((startPos + endPos) / 2);
      if (m == midPos) {
        break;
      }
      midPos = m;

      setTextContent(
        e,
        textArr.slice(0, midPos + 1).join(seporator) + o.ellipsis,
      );

      if (!test($i, o)) {
        position = midPos;
        startPos = midPos;
      } else {
        endPos = midPos;
      }
    }

    if (position != -1 && !(textArr.length == 1 && textArr[0].length == 0)) {
      var txt = addEllipsis(textArr.slice(0, position + 1).join(seporator), o);
      isTruncated = true;
      setTextContent(e, txt);
    } else {
      const $w = $e.parent();
      $e.remove();

      const afterLength = after ? after.length : 0;

      if ($w.contents().size() > afterLength) {
        const $n = $w.contents().eq(-1 - afterLength);
        isTruncated = ellipsisElement($n, $d, $i, o, after);
      } else {
        const $p = $w.prev();
        var e = $p.contents().eq(-1)[0];

        if (typeof e !== 'undefined') {
          var txt = addEllipsis(getTextContent(e), o);
          setTextContent(e, txt);
          if (after) {
            $p.append(after);
          }
          $w.remove();
          isTruncated = true;
        }
      }
    }

    return isTruncated;
  }
  function test($i, o) {
    return $i.innerHeight() > o.maxHeight;
  }
  function addEllipsis(txt, o) {
    while ($.inArray(txt.slice(-1), o.lastCharacter.remove) > -1) {
      txt = txt.slice(0, -1);
    }
    if ($.inArray(txt.slice(-1), o.lastCharacter.noEllipsis) < 0) {
      txt += o.ellipsis;
    }
    return txt;
  }
  function getSizes($d) {
    return {
      width: $d.innerWidth(),
      height: $d.innerHeight(),
    };
  }
  function setTextContent(e, content) {
    if (e.innerText) {
      e.innerText = content;
    } else if (e.nodeValue) {
      e.nodeValue = content;
    } else if (e.textContent) {
      e.textContent = content;
    }
  }
  function getTextContent(e) {
    if (e.innerText) {
      return e.innerText;
    } if (e.nodeValue) {
      return e.nodeValue;
    } if (e.textContent) {
      return e.textContent;
    }
    return '';
  }
  function getElement(e, $i) {
    if (typeof e === 'undefined') {
      return false;
    }
    if (!e) {
      return false;
    }
    if (typeof e === 'string') {
      e = $(e, $i);
      return e.length ? e : false;
    }
    if (typeof e === 'object') {
      return typeof e.jquery === 'undefined' ? false : e;
    }
    return false;
  }
  function getTrueInnerHeight($el) {
    let h = $el.innerHeight();


    const a = ['paddingTop', 'paddingBottom'];

    for (let z = 0, l = a.length; z < l; z++) {
      let m = parseInt($el.css(a[z]), 10);
      if (isNaN(m)) {
        m = 0;
      }
      h -= m;
    }
    return h;
  }
  function debug(d, m) {
    if (!d) {
      return false;
    }
    if (typeof m === 'string') {
      m = `dotdotdot: ${m}`;
    } else {
      m = ['dotdotdot:', m];
    }

    if (typeof window.console !== 'undefined') {
      if (typeof window.console.log !== 'undefined') {
        window.console.log(m);
      }
    }
    return false;
  }

  //	override jQuery.html
  const _orgHtml = $.fn.html;
  $.fn.html = function (str) {
    if (typeof str !== 'undefined') {
      if (this.data('dotdotdot')) {
        if (typeof str !== 'function') {
          return this.trigger('update', [str]);
        }
      }
      return _orgHtml.call(this, str);
    }
    return _orgHtml.call(this);
  };

  //	override jQuery.text
  const _orgText = $.fn.text;
  $.fn.text = function (str) {
    if (typeof str !== 'undefined') {
      if (this.data('dotdotdot')) {
        const temp = $('<div />');
        temp.text(str);
        str = temp.html();
        temp.remove();
        return this.trigger('update', [str]);
      }
      return _orgText.call(this, str);
    }
    return _orgText.call(this);
  };
}(jQuery));
