<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>AceMeister64</title>
  <link rel="icon" type="image/x-icon" href="media/meister.png">
  <link href="styles/style.css" rel="stylesheet" />
  <link href="styles/grades-style.css" rel="stylesheet" />
  <link href="styles/utils.css" rel="stylesheet" />
  <link href="styles/popups.css" rel="stylesheet" />
</head>

<body>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script>
  </script>
  <div id="wrapper">
    <div class="content left-panel">
      <div id="course-selection">
        <?php include 'components/semester_dropdown.php' ?>
        <?php include 'components/course_list.php' ?>
      </div>
      <?php if (!empty($semester)) { ?>
        <?php include 'components/course_summary.php' ?>
      <?php } ?>
    </div>
    <?php if (!empty($semester)) { ?>
      <?php include 'components/rubrik_panels.php' ?>
    <?php } ?>
    <img src="media/bauhaus-right.webp" id="bauhaus-right" />
  </div>
  <button id="user-account"><img src="media/user.webp" /></button>
  <button id="save-changes"><img src="media/sync.png" /></button>
  <div id="blanket"></div>
  <?php include 'components/settings_popup.php' ?>
  <!-- 1. STATE FIRST -->
  <script src="js/state.js"></script>

  <!-- 2. DATA FROM PHP -->
  <script>
    const datas = <?php
    $mapped = [];
    foreach ($courses as $course) {
      $mapped[$course["id"]] = json_decode($course["data"], true);
    }
    echo json_encode($mapped, JSON_PRETTY_PRINT);
    ?>;

    const semester = <?php echo json_encode($semester ?? ''); ?>;
  </script>

  <!-- 3. API -->
  <script src="js/api.js"></script>

  <!-- 4. RUBRIC CORE LOGIC -->
  <script src="js/rubric/calculations.js"></script>
  <script src="js/rubric/utils.js"></script>

  <!-- 5. RUBRIC MUTATIONS -->
  <script src="js/rubric/mutations.js"></script>

  <!-- 6. RUBRIC RENDERING -->
  <script src="js/rubric/rendering.js"></script>

  <!-- 7. UI LAYER -->
  <script src="js/dropdown_utils.js"></script>
  <script src="js/events.js"></script>
  <script src="js/course.js"></script>

  <!-- 8. GRAPHICS -->
  <?php if (!empty($semester)) { ?>
    <script src="js/graphic.js"></script>
  <?php } ?>

  <!-- 9. BOOT SCRIPT (NEW - recommended) -->
  <script>
    $(document).ready(function () {
      $(document).on("focus", "input.numerical", function () {
        this.select();
      });
    });
  </script>
</body>

</html>