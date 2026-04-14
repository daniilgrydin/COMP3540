$("#user-account").click(function () {
  $("#blanket").show();
  $("#account-settings").show();
});

$("#blanket").click(function () {
  $("#blanket").hide();
  $("#account-settings").hide();
});

$(document).on("click", "#add-semester", add_new_semester);
$("#save-changes").click(function () {
  if (!window.current_course_id || !current_data) return;
  update_base(window.current_course_id, current_data);
});

$("#profile-form").submit(function (event) {
  event.preventDefault();
  update_profile(
    $(this).find("[name=new_email]").val(),
    $(this).find("[name=current_password]").val(),
    $(this).find("[name=new_password]").val(),
  );
});

$("#delete-account-button").click(function () {
  delete_account();
});

$(document).on("focus", "input.numerical", function () {
  this.select();
});

function handleFieldChange(el, field) {
  if (!current_data) return;

  const path = (el.dataset.path || "").split(".").filter(Boolean).map(Number);

  const item = getItemByPath(path);

  const value = el.value;

  if (value === "") {
    delete item[field];
  } else {
    item[field] = parseFieldValue(field, value);
  }

  if (window.current_course_id) {
    datas[window.current_course_id] = structuredClone(current_data);
  }

  update_data($("#course-title").text());
}
