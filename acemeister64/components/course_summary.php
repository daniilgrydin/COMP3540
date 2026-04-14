<div id="course-summary">
    <h2 id="course-title" contenteditable="true" onblur="update_course_name(this)"
        onkeydown="handle_course_name_keydown(event, this)">Linear Algebra</h2>
    <div class="field">
        <p>Final Grade Goal:</p>
        <div id="grade-selection" class="dropdown">
            <button onclick="dropdownClicked(this)" class="dropbtn">Dropdown</button>
            <div class="dropdown-content">
                <a href="#" onclick="change_grade(this)">A+ (90%)</a>
                <a href="#" onclick="change_grade(this)">A (85%)</a>
                <a href="#" onclick="change_grade(this)">A- (80%)</a>
                <a href="#" onclick="change_grade(this)">B+ (77%)</a>
                <a href="#" onclick="change_grade(this)">B (73%)</a>
                <a href="#" onclick="change_grade(this)">B- (70%)</a>
                <a href="#" onclick="change_grade(this)">C+ (65%)</a>
                <a href="#" onclick="change_grade(this)">C (60%)</a>
                <a href="#" onclick="change_grade(this)">C- (55%)</a>
                <a href="#" onclick="change_grade(this)">D (50%)</a>
                <a href="#" onclick="change_grade(this)">F (0%)</a>
            </div>
        </div>
    </div>
    <div class="field">
        <p>Predicted Final Grade:</p>
        <input class="selector" id="predicted-grade" type="text" disabled />
    </div>
    <div class="field">
        <p>Min to Achieve Goal:</p>
        <input class="selector" id="final-grade" type="text" disabled />
    </div>
    <canvas id="course-done" style="background-color: transparent" width="1080" height="1080">
        <p>10%</p>
    </canvas>
</div>