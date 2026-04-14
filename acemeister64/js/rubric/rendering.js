function to_grade_card(rubrik, i) {
  return `
    <div class="grade-card" data-index="${i}">
    <button class="delete-btn" onclick="delete_rubrik(${i})">×</button>
      <div class="content">
        <div class="progress-bar">
          <div class="progress" style="width: ${get_completeness(rubrik)}%"></div>
        </div>
        <div class="row">
          <input type="text"
                 value="${rubrik["name"] ?? ""}"
                 data-path="${i}"
                 onchange="handleFieldChange(this, 'name')" />

          <input type="text"
                 class="numerical"
                 value="${rubrik["grade"] !== undefined && rubrik["grade"] !== "" ? rubrik["grade"] : "-"}"
                 data-path="${i}"
                 ${"rubrik" in rubrik ? "disabled" : ""}
                 onchange="handleFieldChange(this, 'grade')" />

          <input type="text"
                 class="numerical"
                 value="${rubrik["weight"] ?? ""}"
                 data-path="${i}"
                 onchange="handleFieldChange(this, 'weight')" />
        </div>
        <div class="progress-bar">
          <div class="progress" style="width: ${get_completeness(rubrik)}%"></div>
        </div>
      </div>
      ${"rubrik" in rubrik ? `<button onclick="expand_grades(this)">></button>` : `<button onclick="convert_to_graded_rubrik(this)">+</button>`}
    </div>
  `;
}

function expand_grades(element) {
  const $card = $(element).closest(".grade-card");
  const index = parseInt($card.data("index"), 10);

  if (isNaN(index)) return;

  const item = current_data["rubrik"][index];

  const $sub = $("#subrubricator");
  $sub.empty();

  if (!item || !item.rubrik) return;

  current_expanded_index = index;
  $("#subrubrik-title").html(
    `${item.name} <button class="delete-btn" onclick="convert_to_normal_rubrik(${index})">×</button>`,
  );

  item.rubrik.forEach((sub, j) => {
    $sub.append(`
      <div class="grade-subcard">
        <div class="content">
          <div class="subcard-status"></div>
          <button class="delete-btn" onclick="delete_subrubrik(${index}, ${j})">×</button>
          <input type="text"
          value="${sub.name ?? ""}"
          data-path="${index}.${j}"
          onchange="handleFieldChange(this, 'name')" />
          
          <input type="text"
          class="numerical"
          value="${sub.grade !== undefined && sub.grade !== "" ? sub.grade : "-"}"
          data-path="${index}.${j}"
          onchange="handleFieldChange(this, 'grade')" />
          
          <input type="text"
          class="numerical"
          value="${sub.weight ?? ""}"
          data-path="${index}.${j}"
          onchange="handleFieldChange(this, 'weight')" disabled/>
        </div>
      </div>
    `);
  });

  $sub.append(`
  <div class="grade-subcard">
    <button onclick="add_subrubrik(${index})">+</button>
  </div>
`);
}

function update_data(course_name) {
  $("#rubricator").html("");
  $("#grade-selection>button").text(
    GRADE_LOOKUP[current_data["grade-goal"]] +
      " (" +
      current_data["grade-goal"] +
      "%)",
  );

  for (let i = 0; i < current_data["rubrik"].length; i++) {
    $("#rubricator").append(to_grade_card(current_data["rubrik"][i], i));
  }
  $("#rubricator").append(`
  <div class="grade-card">
    <button onclick="add_rubrik()">+</button>
  </div>
`);

  if (
    current_expanded_index !== null &&
    current_data.rubrik[current_expanded_index]
  ) {
    const $expandedCard = $(
      `.grade-card[data-index="${current_expanded_index}"]`,
    );
    if ($expandedCard.length > 0) {
      expand_grades($expandedCard.find("button")[0]);
    }
  }

  let grades = get_grades(current_data["rubrik"]);
  render(grades["done"] / 100);
  $("#predicted-grade").val(
    ((grades["gained"] / grades["done"]) * 100).toFixed(1),
  );
  $("#course-title").text(course_name);
  let final_aim =
    (current_data["grade-goal"] - grades["gained"]) / (100 - grades["done"]);
  $("#final-grade").val((final_aim * 100).toFixed(1));
}
