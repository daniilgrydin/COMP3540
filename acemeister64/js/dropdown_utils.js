function dropdownClicked(button) {
  $(button).siblings(".dropdown-content").toggleClass("show");
}

$(document).on("click", function (event) {
  if (!$(event.target).closest(".dropbtn").length) {
    $(".dropdown-content").removeClass("show");
  }
});
