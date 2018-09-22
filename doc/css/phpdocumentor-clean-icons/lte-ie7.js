/* Load this script using conditional IE comments if you need to support IE 7 and IE 6. */

window.onload = function () {
  function addIcon(el, entity) {
    const html = el.innerHTML;
    el.innerHTML = `<span style="font-family: 'phpdocumentor-clean-icons'">${
      entity
    }</span>${
      html}`;
  }
  const icons = {
    'icon-trait': '&#xe000;',
    'icon-interface': '&#xe001;',
    'icon-class': '&#xe002;',
  };


  const els = document.getElementsByTagName('*');


  let i;


  let attr;


  let html;


  let c;


  let el;
  for (i = 0; ; i += 1) {
    el = els[i];
    if (!el) {
      break;
    }
    attr = el.getAttribute('data-icon');
    if (attr) {
      addIcon(el, attr);
    }
    c = el.className;
    c = c.match(/icon-[^\s'"]+/);
    if (c && icons[c[0]]) {
      addIcon(el, icons[c[0]]);
    }
  }
};
