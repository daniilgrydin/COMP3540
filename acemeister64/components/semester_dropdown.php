<div id="dropdown-prefab" class="dropdown additive">
    <button onclick="dropdownClicked(this)" class="dropbtn">Courses for
        "<?php echo ($semester ?? 'Select Semester'); ?>"</button>
    <div class="dropdown-content">
        <form id="semester_selector" method="post" action="controller.php">
            <input type="hidden" name="page" value="main" />
            <input type="hidden" name="command" value="semester" />
            <input type="hidden" id="semester_name" name="semester" value="" />
        </form>
        <?php
        foreach ($semesters as $item) {
            $semester_name = $item["name"];
            $selected = ($semester_name === ($semester ?? '')) ? ' class="selected"' : '';
            echo ("<a onclick=\"select_semester(this)\"$selected>$semester_name</a>");
        }
        echo ("<a href=\"javascript:void(0)\" id=\"add-semester\">+</a>");
        ?>
    </div>
</div>