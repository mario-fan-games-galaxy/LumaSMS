// Document ready

$(() => {
  prepareForm();
  fixNavbar();

  bbcode();
  countdowns();

  $("#show-menu").click(e => {
    e.preventDefault();

    $("header nav ul.top-menu")
      .stop()
      .slideToggle(100);
  });

  $(document).click(e => {
    if (window.innerWidth < 992 && !$("header nav").is(":hover")) {
      $("header nav ul.top-menu")
        .stop()
        .slideUp(100);
    }
  });

  $(window).scroll(fixNavbar);

  $(window).resize(() => {
    $("header nav ul.top-menu").css("display", "");
  });

  $(".no-js").removeClass("no-js");

  if ($(".redirect-url").get().length) {
    setTimeout(() => {
      window.location = $(".redirect-url").attr("href");
    }, 3000);
  }

  $("[data-bbcode]").click(bbcodeButton);
  $("button[data-bbcode-preview]").click(bbcodePreview);
});

// == FORM FUNCTIONS ==

function checkForm(e) {
  if ($(this).attr("data-fasttrack")) {
    return;
  }

  clearForm(this);

  let hasError = false;

  const list = $(this)
    .find("[data-required]")
    .get();
  for (const i in list) {
    const $field = $(list[i]);

    if ($field.val().length <= 0) {
      hasError = true;
      $field
        .addClass("form-control-danger")
        .closest(".field")
        .addClass("has-danger")
        .find("strong")
        .addClass("text-danger");
    }
  }

  if (hasError) {
    e.preventDefault();
    $("body,html")
      .stop()
      .animate(
        {
          scrollTop: `${$(this).offset().top}px`
        },
        100
      );
  }
}

function checkRegistrationForm(e) {
  if ($(this).attr("data-fasttrack")) {
    return;
  }

  e.preventDefault();

  $(this).attr("data-fasttrack");

  $.ajax({
    type: "POST",
    url: API(),
    data: {
      data: {
        purpose: "verify-registration",
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

    for (const i in response.data) {
      const error = response.data[i];

      if (!error) {
        continue;
      }

      hasError = true;

      setFieldError(i, error);
    }

    if (!hasError) {
      $("form.registration-form")
        .attr("data-fasttrack", true)
        .submit();
    }
  });
}

function checkNewTopicForm(e) {
  if ($(this).attr("data-fasttrack")) {
    return;
  }

  e.preventDefault();

  $(this).attr("data-fasttrack");

  $.ajax({
    type: "POST",
    url: API(),
    data: {
      data: {
        purpose: "verify-new-topic",
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

    console.log(response.data);

    for (const i in response.data) {
      const error = response.data[i];

      if (!error) {
        continue;
      }

      hasError = true;

      setFieldError(i, error);
    }

    if (!hasError) {
      $("form.new-topic-form")
        .attr("data-fasttrack", true)
        .submit();
    }
  });
}

function clearForm(f) {
  if (f.nodeType == undefined) {
    f = this;
  }

  $(f)
    .find(".form-control-danger")
    .removeClass("form-control-danger");
  $(f)
    .find(".text-danger")
    .removeClass("text-danger");
  $(f)
    .find(".has-danger")
    .removeClass("has-danger");
  $(f)
    .find(".error-info")
    .html("");
}

function prepareForm() {
  const list = $("form").get();
  for (const i in list) {
    const $form = $(list[i])
      .submit(checkForm)
      .on("reset", clearForm);

    if ($form.hasClass("registration-form")) {
      $form.submit(checkRegistrationForm);
    }

    if ($form.hasClass("new-topic-form")) {
      $form.submit(checkNewTopicForm);
    }

    $form
      .find("[required]")
      .attr("required", false)
      .attr("data-required", true);
  }
}

function setFieldError(field, error) {
  const $field = $(`.field [name="${field}"]`).closest(".field");

  $field.addClass("has-danger");
  $field.find("strong").addClass("text-danger");
  $field.find(".form-control").addClass("form-control-danger");
  $field.find("small").html(error);
}

// == NAVBAR FUNCTIONS ==

function fixNavbar() {
  const scroll = $(window).scrollTop();
  const $nav = $("header nav");

  if (window.navTop == undefined) {
    window.navTop = $nav.offset().top + parseInt($nav.css("padding-top"));
  }

  let func = "remove";

  if (scroll > window.navTop) {
    func = "add";
    $("header").css("margin-bottom", $nav.outerHeight());
  } else {
    $("header").css("margin-bottom", "");
  }

  $nav[`${func}Class`]("stick");
}

// == BBCODE FUNCTIONS ==

function bbcode() {
  setupSpoilerButton();
  highlightJS();
}

function bbcodeButton(e) {
  e.preventDefault();

  const $textarea = $(this)
    .closest(".field")
    .find("textarea");

  let start = $textarea.prop("selectionStart");

  if (!start) {
    start = 0;
  }

  const pre = $textarea.val().substring(0, start);
  const post = $textarea.val().substring(start);

  const bbcode = $(this).attr("data-bbcode");

  let final = bbcode.indexOf("]") + 1;

  if (final < 0) {
    final = 0;
  }

  final += start;

  $textarea
    .val(pre + bbcode + post)
    .prop("selectionStart", final)
    .prop("selectionEnd", final)
    .focus();
}

function bbcodePreview(e) {
  e.preventDefault();

  $.ajax({
    type: "POST",
    url: API(),
    data: {
      data: {
        message: $('[name="message"]').val(),
        purpose: "bbcode-preview"
      }
    }
  }).done(response => {
    $("#bbcode-preview")
      .html(response.data)
      .closest(".bbcode-preview-container")
      .stop()
      .slideDown(100);
    bbcode();
  });
}

function highlightJS() {
  const list = $(".bbcode-code").get();
  for (const i in list) {
    hljs.highlightBlock(list[i]);
  }
}

function setupSpoilerButton() {
  const list = $(".bbcode-spoiler-container button.spoiler-button").get();
  for (const i in list) {
    list[i].onclick = spoilerButton;
  }
}

function spoilerButton() {
  $(this)
    .closest(".bbcode-spoiler-container")
    .find("> .bbcode-spoiler")
    .stop()
    .slideToggle(100);
}

// == DATE FUNCTIONS ==

function countdowns() {
  const list = $(".countdown-container").get();
  for (const i in list) {
    setInterval(
      element => {
        let date = $(element).attr("data-timer");

        $(element).attr("data-timer", --date);

        const suffixes = {
          0: "second",
          60: "minute",
          3600: "hour",
          86400: "day",
          604800: "week",
          31536000: "year"
        };

        let _date = "";
        let val = "";
        for (const i in suffixes) {
          if (Math.abs(date) < i) {
            break;
          }

          if (i != 0) {
            val = Math.floor(Math.abs(date) / i);
          } else {
            val = Math.abs(date);
          }

          _date = `${val} ${suffixes[i]}`;

          if (val != 1) {
            _date += "s";
          }

          if (date < 0) {
            _date += " ago";
          } else {
            _date += " from now";
          }
        }

        element.innerHTML = _date;
      },
      1000,
      list[i]
    );
  }
}
