<?php
if (!empty($semester)) {
    foreach ($courses as $course) {
        echo ('<div class="course-item"><button class="delete-course-btn" onclick="delete_course(' . $course["id"] . ')">×</button><a data-id="' . $course["id"] . '" onclick="select_course(this)">' . $course["name"] . '</a></div>');
    }
    ?>
    <div class="content">
        <button onclick="add_new_course()">+</button>
    </div>
<?php } ?>