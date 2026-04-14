function select_semester(element) {
  $("#semester_name").val(element.textContent);
  $("#semester_selector").submit();
}

function add_new_course() {
  if (!semester) {
    alert("Please select a semester first");
    return;
  }

  $.ajax({
    url: "controller.php",
    method: "POST",
    dataType: "json",
    data: {
      page: "main",
      command: "add_course",
      semester: semester,
      course_name: "Class",
    },
  })
    .done(function (response) {
      console.log("Add course response:", response);
      if (response.status === "ok") {
        const newCourseHtml =
          '<div class="course-item"><button class="delete-course-btn" onclick="delete_course(' +
          response.course_id +
          ')">×</button><a data-id="' +
          response.course_id +
          '" onclick="select_course(this)">Class</a></div>';
        $("#course-selection .content").before(newCourseHtml);

        const highestGoal = Math.max(...Object.keys(GRADE_LOOKUP).map(Number));
        datas[response.course_id] = {
          rubrik: [],
          "grade-goal": highestGoal,
        };
      } else {
        alert("Could not add course. Please try again.");
      }
    })
    .fail(function (xhr, status, error) {
      console.error("Add course failed:", status, error, xhr.responseText);
      alert("Could not add course. Please check the console for details.");
    });
}

function select_course(el) {
  const id = el.dataset.id;

  window.current_course_id = id;
  current_data = structuredClone(datas[id]);

  $("#course-selection a").removeClass("selected-course");
  $(el).addClass("selected-course");

  if (!current_data.rubrik) {
    current_data.rubrik = [];
  }

  $("#course-summary, .center-panel, .right-panel").show();

  update_data(el.textContent);
}

function update_course_name(element) {
  const newName = element.textContent.trim();

  if (!newName) {
    element.textContent = $("#course-title").text();
    return;
  }

  if (window.current_course_id) {
    $(`#course-selection a[data-id='${window.current_course_id}']`).text(
      newName,
    );
    update_course_name_db(window.current_course_id, newName);
  }

  $("#course-title").text(newName);
}

function handle_course_name_keydown(event, element) {
  if (event.key === "Enter") {
    event.preventDefault();
    element.blur();
  } else if (event.key === "Escape") {
    element.textContent = $("#course-title").text();
    element.blur();
  }
}

function change_grade(el) {
  const text = el.textContent;

  const match = text.match(/\((\d+)\s*%\)/);
  if (!match || !current_data) return;

  const goal = Number(match[1]);

  current_data["grade-goal"] = goal;

  if (window.current_course_id) {
    datas[window.current_course_id] = structuredClone(current_data);
  }

  update_data($("#course-title").text());
}
