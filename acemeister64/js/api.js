function update_base(course_id, current_data) {
  $.post(
    "controller.php",
    {
      page: "main",
      command: "save",
      course_id: course_id,
      data: JSON.stringify(current_data),
    },
    function (response) {
      console.log("Saved:", response);
    },
  );
}
function update_course_name_db(course_id, name) {
  $.post(
    "controller.php",
    {
      page: "main",
      command: "update_course_name",
      course_id: course_id,
      name: name,
    },
    function (response) {
      console.log("Course name updated:", response);
    },
  );
}
function add_new_semester(event) {
  event.preventDefault();
  const semester_name = prompt("Enter the name of the new semester:");
  if (!semester_name) return;

  $.ajax({
    url: "controller.php",
    method: "POST",
    dataType: "json",
    data: {
      page: "main",
      command: "add_semester",
      semester_name: semester_name,
    },
  })
    .done(function (response) {
      console.log("Add semester response:", response);
      if (response.status === "ok") {
        const newSemester = document.createElement("a");
        newSemester.textContent = semester_name;
        newSemester.setAttribute("onclick", "select_semester(this)");
        $("#course-selection .dropdown-content a:last").before(newSemester);
        select_semester(newSemester);
      } else {
        alert("Could not add semester. Please try again.");
      }
    })
    .fail(function (xhr, status, error) {
      console.error("Add semester failed:", status, error, xhr.responseText);
      alert("Could not add semester. Please check the console for details.");
    });
}

function delete_course(course_id) {
  if (
    !confirm(
      "Are you sure you want to delete this course? This action cannot be undone.",
    )
  ) {
    return;
  }

  $.ajax({
    url: "controller.php",
    method: "POST",
    dataType: "json",
    data: {
      page: "main",
      command: "delete_course",
      course_id: course_id,
    },
  })
    .done(function (response) {
      console.log("Delete course response:", response);
      if (response.status === "ok") {
        $('a[data-id="' + course_id + '"]')
          .parent(".course-item")
          .remove();
        if (window.current_course_id == course_id) {
          window.current_course_id = null;
          current_data = null;
          $("#course-title").text("Select a Course");
          $("#rubricator").html("");
          $("#subrubricator").empty();
          $("#subrubrik-title").text("");
        }
        delete datas[course_id];
      } else {
        alert("Could not delete course. Please try again.");
      }
    })
    .fail(function (xhr, status, error) {
      console.error("Delete course failed:", status, error, xhr.responseText);
      alert("Could not delete course. Please check the console for details.");
    });
}

function update_profile(newEmail, currentPassword, newPassword) {
  $.ajax({
    url: "controller.php",
    method: "POST",
    dataType: "json",
    data: {
      page: "main",
      command: "update_profile",
      new_email: newEmail,
      current_password: currentPassword,
      new_password: newPassword,
    },
  })
    .done(function (response) {
      console.log("Update profile response:", response);
      if (response.status === "ok") {
        $("#account-message").text(response.message).css("color", "green");
      } else {
        $("#account-message").text(response.message).css("color", "red");
      }
    })
    .fail(function (xhr, status, error) {
      console.error("Update profile failed:", status, error, xhr.responseText);
      $("#account-message")
        .text("Unable to update profile.")
        .css("color", "red");
    });
}

function delete_account() {
  if (!confirm("Delete your account permanently? This cannot be undone.")) {
    return;
  }

  $.ajax({
    url: "controller.php",
    method: "POST",
    dataType: "json",
    data: {
      page: "main",
      command: "delete_account",
    },
  })
    .done(function (response) {
      console.log("Delete account response:", response);
      if (response.status === "ok") {
        window.location = "controller.php";
      } else {
        alert("Could not delete account. Please try again.");
      }
    })
    .fail(function (xhr, status, error) {
      console.error("Delete account failed:", status, error, xhr.responseText);
      alert("Could not delete account. Please check the console for details.");
    });
}
