<?php

$conn = mysqli_connect(
    "localhost",
    "T00712793",
    "T00712793136",
    "C354_T00712793"
);

if (mysqli_connect_errno()) {
    echo "Failed to connect to the database: " . mysqli_connect_error();
    exit();
}

function escape($value)
{
    global $conn;
    return mysqli_real_escape_string($conn, $value);
}

function is_valid_user($email, $password)
{
    global $conn;
    $email = escape($email);

    $sql = "SELECT id, hash_password FROM Student WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) == 0) {
        return false;
    }

    if ($row = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $row['hash_password'])) {
            $_SESSION['student_id'] = $row['id'];
            $_SESSION['email'] = $email;
            return true;
        }
    }

    return false;
}

function signup_user($email, $password)
{
    global $conn;
    $email = escape($email);

    $sql = "SELECT id FROM Student WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        return "exists";
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);
    $username = explode("@", $email)[0];

    $stmt = mysqli_prepare($conn, "INSERT INTO Student (username, email, hash_password) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hash);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        return "success";
    }

    mysqli_stmt_close($stmt);
    return "error";
}

function get_user_by_id($student_id)
{
    global $conn;
    $stmt = mysqli_prepare($conn, "SELECT id, username, email FROM Student WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $student_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    return $user ?: null;
}

function update_user_profile($student_id, $new_email, $new_password = null)
{
    global $conn;
    $new_email = escape($new_email);

    $stmt = mysqli_prepare($conn, "SELECT id FROM Student WHERE email = ? AND id != ?");
    mysqli_stmt_bind_param($stmt, "si", $new_email, $student_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (mysqli_fetch_assoc($result)) {
        mysqli_stmt_close($stmt);
        return false;
    }
    mysqli_stmt_close($stmt);

    if ($new_password) {
        $hash = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = mysqli_prepare($conn, "UPDATE Student SET email = ?, hash_password = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "ssi", $new_email, $hash, $student_id);
    } else {
        $stmt = mysqli_prepare($conn, "UPDATE Student SET email = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "si", $new_email, $student_id);
    }

    $updated = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $updated;
}

function delete_user_account($student_id)
{
    global $conn;

    $stmt = mysqli_prepare($conn, "DELETE Course FROM Course JOIN Semester ON Course.semester_id = Semester.id WHERE Semester.student_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $student_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    $stmt = mysqli_prepare($conn, "DELETE FROM Semester WHERE student_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $student_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    $stmt = mysqli_prepare($conn, "DELETE FROM Student WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $student_id);
    $deleted = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    return $deleted;
}

function get_semesters($email)
{
    global $conn;
    $email = escape($email);

    $sql = "SELECT Semester.id, Semester.name FROM Semester JOIN Student ON Semester.student_id = Student.id WHERE Student.email = '$email' ORDER BY Semester.name ASC";
    $result = mysqli_query($conn, $sql);

    $semesters = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $semesters[] = $row;
    }

    return $semesters;
}

function get_courses($email, $semester_name)
{
    global $conn;
    $email = escape($email);
    $semester_name = escape($semester_name);

    $sql = "SELECT Course.id, Course.name, Course.data FROM Course JOIN Semester ON Course.semester_id = Semester.id JOIN Student ON Semester.student_id = Student.id WHERE Student.email = '$email' AND Semester.name = '$semester_name' ORDER BY Course.name ASC";
    $result = mysqli_query($conn, $sql);

    $courses = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $courses[] = $row;
    }

    return $courses;
}

function update_base($course_id, $data)
{
    global $conn;
    $json = json_encode($data);

    $stmt = mysqli_prepare($conn, "UPDATE Course SET data = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "si", $json, $course_id);
    $updated = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    return $updated;
}

function update_course_name($course_id, $name)
{
    global $conn;
    $stmt = mysqli_prepare($conn, "UPDATE Course SET name = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "si", $name, $course_id);
    $updated = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    return $updated;
}

function add_course($email, $semester_name, $course_name)
{
    global $conn;
    $email = escape($email);
    $semester_name = escape($semester_name);

    $stmt = mysqli_prepare($conn, "SELECT Semester.id FROM Semester JOIN Student ON Semester.student_id = Student.id WHERE Student.email = ? AND Semester.name = ?");
    mysqli_stmt_bind_param($stmt, "ss", $email, $semester_name);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $semester = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if (!$semester) {
        return false;
    }

    $stmt = mysqli_prepare($conn, "INSERT INTO Course (semester_id, name, data) VALUES (?, ?, '{}')");
    mysqli_stmt_bind_param($stmt, "is", $semester['id'], $course_name);
    $inserted = mysqli_stmt_execute($stmt);
    $course_id = mysqli_insert_id($conn);
    mysqli_stmt_close($stmt);

    return $inserted ? $course_id : false;
}

function add_semester($email, $semester_name)
{
    global $conn;
    $email = escape($email);
    $stmt = mysqli_prepare($conn, "SELECT id FROM Student WHERE email = ?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $student = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if (!$student) {
        return false;
    }

    $stmt = mysqli_prepare($conn, "INSERT INTO Semester (student_id, name) VALUES (?, ?)");
    mysqli_stmt_bind_param($stmt, "is", $student['id'], $semester_name);
    $inserted = mysqli_stmt_execute($stmt);
    $semester_id = mysqli_insert_id($conn);
    mysqli_stmt_close($stmt);

    return $inserted ? $semester_id : false;
}

function delete_course($course_id)
{
    global $conn;
    $stmt = mysqli_prepare($conn, "DELETE FROM Course WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $course_id);
    $deleted = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    return $deleted;
}
