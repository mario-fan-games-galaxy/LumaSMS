/* globals API */
import { $, jQuery } from 'jquery';
import 'bootstrap';
import hljs from 'highlight.js';

// Let jQuery be accessed globally
window.$ = $;
window.jQuery = jQuery;

// == FORM FUNCTIONS ==

function clearForm(f) {
  const form = f.nodeType === undefined ? this : f;

  $(form)
    .find('.form-control-danger')
    .removeClass('form-control-danger');
  $(form)
    .find('.text-danger')
    .removeClass('text-danger');
  $(form)
    .find('.has-danger')
    .removeClass('has-danger');
  $(form)
    .find('.error-info')
    .html('');
}

function checkForm(e) {
  if ($(this).attr('data-fasttrack')) {
    return;
  }

  clearForm(this);

  let hasError = false;

  const list = $(this)
    .find('[data-required]')
    .get();

  Object.values(list).forEach(item => {
    const $field = $(item);

    if ($field.val().length <= 0) {
      hasError = true;
      $field
        .addClass('form-control-danger')
        .closest('.field')
        .addClass('has-danger')
        .find('strong')
        .addClass('text-danger');
    }
  });

  if (hasError) {
    e.preventDefault();
    $('body,html')
      .stop()
      .animate(
        {
          scrollTop: `${$(this).offset().top}px`
        },
        100
      );
  }
}

function setFieldError(field, error) {
  const $field = $(`.field [name="${field}"]`).closest('.field');

  $field.addClass('has-danger');
  $field.find('strong').addClass('text-danger');
  $field.find('.form-control').addClass('form-control-danger');
  $field.find('small').html(error);
}

function checkRegistrationForm(e) {
  if ($(this).attr('data-fasttrack')) {
    return;
  }

  e.preventDefault();

  $(this).attr('data-fasttrack');

  $.ajax({
    type: 'POST',
    url: API(),
    data: {
      data: {
        purpose: 'verify-registration',
        username: $(this)
          .find('[name="username"]')
          .val(),
        password: $(this)
          .find('[name="password"]')
          .val(),
        email: $(this)
          .find('[name="email"]')
          .val()
      }
    }
  }).done(response => {
    let hasError = false;

    Object.entries(response.data).forEach(item => {
      const error = item[1];

      if (!error) {
        return;
      }

      hasError = true;

      setFieldError(item[0], error);
    });

    if (!hasError) {
      $('form.registration-form')
        .attr('data-fasttrack', true)
        .submit();
    }
  });
}

function checkNewTopicForm(e) {
  if ($(this).attr('data-fasttrack')) {
    return;
  }

  e.preventDefault();

  $(this).attr('data-fasttrack');

  $.ajax({
    type: 'POST',
    url: API(),
    data: {
      data: {
        purpose: 'verify-new-topic',
        title: $(this)
          .find('[name="title"]')
          .val(),
        message: $(this)
          .find('[name="message"]')
          .val()
      }
    }
  }).done(response => {
    let hasError = false;

    Object.entries(response.data).forEach(item => {
      const error = item[1];

      if (!error) {
        return;
      }

      hasError = true;

      setFieldError(item[0], error);
    });

    if (!hasError) {
      $('form.new-topic-form')
        .attr('data-fasttrack', true)
        .submit();
    }
  });
}

function prepareForm() {
  const list = $('form').get();
  Object.values(list).forEach(item => {
    const $form = $(item)
      .submit(checkForm)
      .on('reset', clearForm);

    if ($form.hasClass('registration-form')) {
      $form.submit(checkRegistrationForm);
    }

    if ($form.hasClass('new-topic-form')) {
      $form.submit(checkNewTopicForm);
    }

    $form
      .find('[required]')
      .attr('required', false)
      .attr('data-required', true);
  });
}

// == NAVBAR FUNCTIONS ==

function fixNavbar() {
  const scroll = $(window).scrollTop();
  const $nav = $('header nav');

  if (window.navTop === undefined) {
    window.navTop = $nav.offset().top + parseInt($nav.css('padding-top'), 10);
  }

  let func = 'remove';

  if (scroll > window.navTop) {
    func = 'add';
    $('header').css('margin-bottom', $nav.outerHeight());
  } else {
    $('header').css('margin-bottom', '');
  }

  $nav[`${func}Class`]('stick');
}

// == BBCODE FUNCTIONS ==

function highlightJS() {
  const list = $('.bbcode-code').get();
  Object.values(list).forEach(item => {
    hljs.highlightBlock(item);
  });
}

function spoilerButton() {
  $(this)
    .closest('.bbcode-spoiler-container')
    .find('> .bbcode-spoiler')
    .stop()
    .slideToggle(100);
}

function setupSpoilerButton() {
  const list = $('.bbcode-spoiler-container button.spoiler-button').get();
  Object.values(list).forEach(item => {
    item.onclick = spoilerButton;
  });
}

function bbcode() {
  setupSpoilerButton();
  highlightJS();
}

function bbcodeButton(e) {
  e.preventDefault();

  const $textarea = $(this)
    .closest('.field')
    .find('textarea');

  let start = $textarea.prop('selectionStart');

  if (!start) {
    start = 0;
  }

  const pre = $textarea.val().substring(0, start);
  const post = $textarea.val().substring(start);

  const bbcodeData = $(this).attr('data-bbcode');

  let final = bbcodeData.indexOf(']') + 1;

  if (final < 0) {
    final = 0;
  }

  final += start;

  $textarea
    .val(pre + bbcodeData + post)
    .prop('selectionStart', final)
    .prop('selectionEnd', final)
    .focus();
}

function bbcodePreview(e) {
  e.preventDefault();

  $.ajax({
    type: 'POST',
    url: API(),
    data: {
      data: {
        message: $('[name="message"]').val(),
        purpose: 'bbcode-preview'
      }
    }
  }).done(response => {
    $('#bbcode-preview')
      .html(response.data)
      .closest('.bbcode-preview-container')
      .stop()
      .slideDown(100);
    bbcode();
  });
}

// == DATE FUNCTIONS ==

function countdowns() {
  const list = $('.countdown-container').get();
  Object.values(list).forEach(item => {
    setInterval(
      element => {
        let date = $(element).attr('data-timer');

        $(element).attr('data-timer', (date -= 1));

        const suffixes = {
          0: 'second',
          60: 'minute',
          3600: 'hour',
          86400: 'day',
          604800: 'week',
          31536000: 'year'
        };

        let dateString = '';
        let val = '';
        Object.entries(suffixes).some(suffix => {
          if (Math.abs(date) < suffix[0]) {
            return true;
          }

          if (suffix[0] !== 0) {
            val = Math.floor(Math.abs(date) / suffix[0]);
          } else {
            val = Math.abs(date);
          }

          dateString = `${val} ${suffix[1]}`;

          if (val !== 1) {
            dateString += 's';
          }

          if (date < 0) {
            dateString += ' ago';
          } else {
            dateString += ' from now';
          }

          return false;
        });

        element.innerHTML = dateString;
      },
      1000,
      item
    );
  });
}

// Document Ready
$(() => {
  prepareForm();
  fixNavbar();

  bbcode();
  countdowns();

  $('#show-menu').click(e => {
    e.preventDefault();

    $('header nav ul.top-menu')
      .stop()
      .slideToggle(100);
  });

  $(document).click(() => {
    if (window.innerWidth < 992 && !$('header nav').is(':hover')) {
      $('header nav ul.top-menu')
        .stop()
        .slideUp(100);
    }
  });

  $(window).scroll(fixNavbar);

  $(window).resize(() => {
    $('header nav ul.top-menu').css('display', '');
  });

  $('.no-js').removeClass('no-js');

  if ($('.redirect-url').get().length) {
    setTimeout(() => {
      window.location = $('.redirect-url').attr('href');
    }, 3000);
  }

  $('[data-bbcode]').click(bbcodeButton);
  $('button[data-bbcode-preview]').click(bbcodePreview);
});
