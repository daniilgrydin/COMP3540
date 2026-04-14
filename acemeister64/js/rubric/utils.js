function getItemByPath(path) {
  let item = current_data;
  for (const idx of path) {
    item = item.rubrik[idx];
  }
  return item;
}

function parseFieldValue(field, value) {
  if (field === "name") return value;
  if (value === "" || (field === "grade" && value === "-")) return "";
  const n = Number(value);
  return Number.isFinite(n) ? n : 0;
}

function hasValidGrade(item) {
  return (
    item &&
    item.grade !== undefined &&
    item.grade !== "" &&
    Number.isFinite(Number(item.grade))
  );
}

function get_grades(rubrik) {
  let percent_done = 0;
  let percents_gained = 0;

  for (let i = 0; i < rubrik.length; i++) {
    const graded_item = rubrik[i];

    if ("rubrik" in graded_item) {
      const subrubrik = graded_item["rubrik"];

      for (let j = 0; j < subrubrik.length; j++) {
        const graded_subitem = subrubrik[j];

        if (hasValidGrade(graded_subitem)) {
          let percent = 0;

          if ("weight" in graded_subitem && graded_subitem["weight"] !== "") {
            percent =
              (Number(graded_subitem["weight"]) *
                Number(graded_item["weight"])) /
              100;
          } else {
            percent = Number(graded_item["weight"]) / subrubrik.length;
          }

          percent_done += percent;
          percents_gained += (Number(graded_subitem["grade"]) * percent) / 100;
        }
      }
    } else if (hasValidGrade(graded_item)) {
      const weight = Number(graded_item["weight"]) || 0;
      percent_done += weight;
      percents_gained += (weight * Number(graded_item["grade"])) / 100;
    }
  }

  return { done: percent_done, gained: percents_gained };
}
