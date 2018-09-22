/*
 HTML5 Shiv v3.7.0 | @afarkas @jdalton @jon_neal @rem | MIT/GPL2 Licensed
*/
(function (l, f) {
  function m() {
    const a = e.elements;
    return typeof a === 'string' ? a.split(' ') : a;
  }
  function i(a) {
    let b = n[a[o]];
    b || ((b = {}), h++, (a[o] = h), (n[h] = b));
    return b;
  }
  function p(a, b, c) {
    b || (b = f);
    if (g) return b.createElement(a);
    c || (c = i(b));
    b = c.cache[a]
      ? c.cache[a].cloneNode()
      : r.test(a)
        ? (c.cache[a] = c.createElem(a)).cloneNode()
        : c.createElem(a);
    return b.canHaveChildren && !s.test(a) ? c.frag.appendChild(b) : b;
  }
  function t(a, b) {
    if (!b.cache) {
      (b.cache = {}),
      (b.createElem = a.createElement),
      (b.createFrag = a.createDocumentFragment),
      (b.frag = b.createFrag());
    }
    a.createElement = function (c) {
      return !e.shivMethods ? b.createElem(c) : p(c, a, b);
    };
    a.createDocumentFragment = Function(
      'h,f',
      `return function(){var n=f.cloneNode(),c=n.createElement;h.shivMethods&&(${
        m()
          .join()
          .replace(/[\w\-]+/g, (a) => {
            b.createElem(a);
            b.frag.createElement(a);
            return `c("${a}")`;
          })
      });return n}`,
    )(e, b.frag);
  }
  function q(a) {
    a || (a = f);
    const b = i(a);
    if (e.shivCSS && !j && !b.hasCSS) {
      let c;


      let d = a;
      c = d.createElement('p');
      d = d.getElementsByTagName('head')[0] || d.documentElement;
      c.innerHTML = 'x<style>article,aside,dialog,figcaption,figure,footer,header,hgroup,main,nav,section{display:block}mark{background:#FF0;color:#000}template{display:none}</style>';
      c = d.insertBefore(c.lastChild, d.firstChild);
      b.hasCSS = !!c;
    }
    g || t(a, b);
    return a;
  }
  const k = l.html5 || {};


  var s = /^<|^(?:button|map|select|textarea|object|iframe|option|optgroup)$/i;


  var r = /^(?:a|b|code|div|fieldset|h1|h2|h3|h4|h5|h6|i|label|li|ol|p|q|span|strong|style|table|tbody|td|th|tr|ul)$/i;


  let j;


  var o = '_html5shiv';


  var h = 0;


  var n = {};


  let g;
  (function () {
    try {
      const a = f.createElement('a');
      a.innerHTML = '<xyz></xyz>';
      j = 'hidden' in a;
      let b;
      if (!(b = a.childNodes.length == 1)) {
        f.createElement('a');
        const c = f.createDocumentFragment();
        b = typeof c.cloneNode === 'undefined'
          || typeof c.createDocumentFragment === 'undefined'
          || typeof c.createElement === 'undefined';
      }
      g = b;
    } catch (d) {
      g = j = !0;
    }
  }());
  var e = {
    elements:
      k.elements
      || 'abbr article aside audio bdi canvas data datalist details dialog figcaption figure footer header hgroup main mark meter nav output progress section summary template time video',
    version: '3.7.0',
    shivCSS: !1 !== k.shivCSS,
    supportsUnknownElements: g,
    shivMethods: !1 !== k.shivMethods,
    type: 'default',
    shivDocument: q,
    createElement: p,
    createDocumentFragment(a, b) {
      a || (a = f);
      if (g) return a.createDocumentFragment();
      for (
        var b = b || i(a), c = b.frag.cloneNode(), d = 0, e = m(), h = e.length;
        d < h;
        d++
      ) c.createElement(e[d]);
      return c;
    },
  };
  l.html5 = e;
  q(f);
}(this, document));
