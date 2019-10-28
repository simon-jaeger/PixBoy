// prevent transitions from playing on page load
////////////////////////////////////////////////////////////////////////////////
$(window).on("load", () => {
  setTimeout(() => {
    $("body").removeClass("blockTransitions")
  }, 100)
})

// ping server in regular intervals (5min) to keep the current session alive
////////////////////////////////////////////////////////////////////////////////
setInterval(() => {
  fetch("/_api/ping.php").catch(e => console.error(e))
}, 300000)

// avoid unwanted resubmissions of post forms on refresh/reload
////////////////////////////////////////////////////////////////////////////////
if (window.history.replaceState) {
  window.history.replaceState( null, null, window.location.href );
}

// header, nav
////////////////////////////////////////////////////////////////////////////////
$(".header").click(function(e) {
  const $header = $(this)
  const $target = $(e.target)
  if ($header.is(".is-navOpen") || $target.closest(".header_burger").length) {
    $header.toggleClass("is-navOpen")
  }
})

