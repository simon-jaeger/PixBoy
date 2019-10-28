// item
////////////////////////////////////////////////////////////////////////////////
$(".item_toggle").click(function() {
  $(this)
    .closest(".item")
    .toggleClass("is-open")
    .siblings()
    .removeClass("is-open")
})

// item, modal
////////////////////////////////////////////////////////////////////////////////

// open modal and change delete target upon clicking delete button
$(".item_action[data-delete-id]").click(function() {
  const id = this.dataset.deleteId
  const name = this.dataset.deleteName
  $(".modal")
    .addClass("is-open")
    .find("[data-target-name]")
    .text(name)
    .end()
    .find("[data-target-id]")
    .attr("href", "?doDeleteItem=" + id)
})

// modal
////////////////////////////////////////////////////////////////////////////////
$(".modal").click(function(e) {
  const $target = $(e.target)
  const $modalOuter = $(this)
  const $close = $(".modal_close", this)
  const $cancel = $(".modal_cancel", this)
  if (
    $target.is($modalOuter) ||
    $target.is($cancel) ||
    $target.closest($close).length
  ) {
    $modalOuter.removeClass("is-open")
  }
})
