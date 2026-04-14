let current_expanded_index = null;

function createRubrikItem(weight = 0) {
  return {
    name: "Grade",
    weight: weight,
  };
}

function createSubRubrikItem(name = "") {
  return {
    name: name,
    grade: "",
  };
}

function add_rubrik() {
  if (!current_data) return;

  if (!current_data.rubrik) {
    current_data.rubrik = [];
  }

  const totalWeight = current_data.rubrik.reduce((sum, item) => {
    return sum + (Number(item.weight) || 0);
  }, 0);
  const remainingWeight = Math.max(100 - totalWeight, 0);

  current_data.rubrik.push(createRubrikItem(remainingWeight));

  if (window.current_course_id) {
    datas[window.current_course_id] = structuredClone(current_data);
  }

  update_data($("#course-title").text());
}

function delete_rubrik(index) {
  if (!current_data || !current_data.rubrik) return;

  current_data.rubrik.splice(index, 1);

  if (window.current_course_id) {
    datas[window.current_course_id] = structuredClone(current_data);
  }

  if (current_expanded_index === index) {
    current_expanded_index = null;
    $("#subrubricator").empty();
    $("#subrubrik-title").text("");
  }

  update_data($("#course-title").text());
}

function add_subrubrik(parentIndex) {
  const parent = current_data.rubrik[parentIndex];
  if (!parent) return;

  if (!parent.rubrik) {
    parent.rubrik = [];
  }

  const baseName = parent.name || "Grade";
  const subIndex = parent.rubrik.length + 1;
  parent.rubrik.push(createSubRubrikItem(`${baseName} ${subIndex}`));

  if (window.current_course_id) {
    datas[window.current_course_id] = structuredClone(current_data);
  }

  const $card = $(`.grade-card[data-index="${parentIndex}"]`);
  if ($card.length > 0) {
    expand_grades($card.find("button")[0]);
  }

  update_data($("#course-title").text());
}

function delete_subrubrik(parentIndex, subIndex) {
  if (!current_data || !current_data.rubrik) return;

  const parent = current_data.rubrik[parentIndex];
  if (!parent || !parent.rubrik) return;

  parent.rubrik.splice(subIndex, 1);

  if (window.current_course_id) {
    datas[window.current_course_id] = structuredClone(current_data);
  }

  const $card = $(`.grade-card[data-index="${parentIndex}"]`);
  if ($card.length > 0) {
    expand_grades($card.find("button")[0]);
  }

  update_data($("#course-title").text());
}

function convert_to_graded_rubrik(btn) {
  if (!current_data) return;

  const $card = $(btn).closest(".grade-card");
  const index = parseInt($card.data("index"), 10);

  if (isNaN(index)) return;

  const parent = current_data.rubrik[index];
  if (!parent) return;

  if (!parent.rubrik) {
    parent.rubrik = [];
  }

  const baseName = parent.name || "Grade";
  const subIndex = parent.rubrik.length + 1;
  parent.rubrik.push(createSubRubrikItem(`${baseName} ${subIndex}`));

  delete parent.grade;

  if (window.current_course_id) {
    datas[window.current_course_id] = structuredClone(current_data);
  }

  expand_grades(btn);

  update_data($("#course-title").text());
}

function convert_to_normal_rubrik(index) {
  if (!current_data || !current_data.rubrik) return;

  const item = current_data.rubrik[index];
  if (!item || !item.rubrik) return;

  delete item.rubrik;
  item.grade = "";

  if (window.current_course_id) {
    datas[window.current_course_id] = structuredClone(current_data);
  }

  current_expanded_index = null;
  $("#subrubricator").empty();
  $("#subrubrik-title").text("");

  update_data($("#course-title").text());
}
