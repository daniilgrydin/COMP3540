function get_completeness(rubrik) {
  if ("grade" in rubrik && rubrik["grade"] != "") {
    return 100;
  }
  if ("rubrik" in rubrik) {
    let completed_number = 0;
    let total_number = 0;
    for (let i = 0; i < rubrik["rubrik"].length; i++) {
      completed_number += get_completeness(rubrik["rubrik"][i]);
      total_number += 1;
    }
    return completed_number / total_number;
  }
  return 0;
}

function get_grade(body) {
  if ("grade" in body) return body["grade"];
  if ("rubrik" in body) {
    let grade = 0;
    let total_weight = 0;
    let weight = 100 / body["rubrik"].length;
    for (let i = 0; i < body["rubrik"].length; i++) {
      if ("weight" in body["rubrik"][i]) weight = body["rubrik"][i]["weight"];
      if ("grade" in body["rubrik"][i]) {
        grade += (body["rubrik"][i]["grade"] * weight) / 100;
        total_weight += weight;
      }
    }
    return (grade / total_weight) * 100;
  }
  return "";
}
