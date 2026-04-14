<?php

session_start();

require_once 'model.php';

$page = $_POST['page'] ?? $_GET['page'] ?? '';
$command = $_POST['command'] ?? $_GET['command'] ?? '';
$semester = $_POST['semester'] ?? $_GET['semester'] ?? '';

function render_main($semester = '')
{
    if (!isset($_SESSION['student_id'])) {
        include 'start.php';
        exit();
    }

    $currentUser = get_user_by_id($_SESSION['student_id']);
    if (!$currentUser) {
        session_destroy();
        include 'start.php';
        exit();
    }

    $semesters = get_semesters($currentUser['email']);
    $courses = [];
    if ($semester !== '') {
        $courses = get_courses($currentUser['email'], $semester);
    }

    include 'main.php';
    exit();
}

if ($page === '') {
    include 'start.php';
    exit();
}

if ($page === 'start') {
    if ($command === 'login') {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (is_valid_user($email, $password)) {
            render_main();
        }

        $error = 'Invalid login';
        include 'start.php';
        exit();
    }

    if ($command === 'signup') {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $result = signup_user($email, $password);
        if ($result === 'success' && is_valid_user($email, $password)) {
            render_main();
        }

        $error = $result === 'exists' ? 'Email already registered' : 'Signup failed';
        include 'start.php';
        exit();
    }
}

if ($page === 'main') {
    if (!isset($_SESSION['student_id'])) {
        include 'start.php';
        exit();
    }

    if ($command === 'logout') {
        session_destroy();
        header('Location: controller.php');
        exit();
    }

    if ($command === 'semester') {
        render_main($semester);
    }

    if ($command === 'save') {
        header('Content-Type: application/json');
        $course_id = intval($_POST['course_id'] ?? 0);
        $data = json_decode($_POST['data'] ?? 'null', true);
        $success = false;

        if ($course_id && is_array($data)) {
            $success = update_base($course_id, $data);
        }

        echo json_encode(['status' => $success ? 'ok' : 'error']);
        exit();
    }

    if ($command === 'update_course_name') {
        header('Content-Type: application/json');
        $course_id = intval($_POST['course_id'] ?? 0);
        $name = trim($_POST['name'] ?? '');
        $success = $course_id > 0 && $name !== '' ? update_course_name($course_id, $name) : false;
        echo json_encode(['status' => $success ? 'ok' : 'error']);
        exit();
    }

    if ($command === 'add_course') {
        header('Content-Type: application/json');
        $course_name = trim($_POST['course_name'] ?? '');
        $semester_name = trim($_POST['semester'] ?? '');
        $success = false;
        $course_id = false;

        if ($course_name !== '' && $semester_name !== '') {
            $course_id = add_course($_SESSION['email'], $semester_name, $course_name);
            $success = $course_id !== false;
        }

        echo json_encode(['status' => $success ? 'ok' : 'error', 'course_id' => $course_id]);
        exit();
    }

    if ($command === 'add_semester') {
        header('Content-Type: application/json');
        $semester_name = trim($_POST['semester_name'] ?? '');
        $semester_id = false;

        if ($semester_name !== '') {
            $semester_id = add_semester($_SESSION['email'], $semester_name);
        }

        echo json_encode(['status' => $semester_id ? 'ok' : 'error', 'semester_id' => $semester_id]);
        exit();
    }

    if ($command === 'delete_course') {
        header('Content-Type: application/json');
        $course_id = intval($_POST['course_id'] ?? 0);
        $success = $course_id ? delete_course($course_id) : false;
        echo json_encode(['status' => $success ? 'ok' : 'error']);
        exit();
    }

    if ($command === 'update_profile') {
        header('Content-Type: application/json');
        $current_password = $_POST['current_password'] ?? '';
        $new_email = trim($_POST['new_email'] ?? '');
        $new_password = trim($_POST['new_password'] ?? '');
        $success = false;
        $message = 'Update failed';

        if ($current_password !== '' && $new_email !== '') {
            if (is_valid_user($_SESSION['email'], $current_password)) {
                $success = update_user_profile($_SESSION['student_id'], $new_email, $new_password !== '' ? $new_password : null);
                if ($success) {
                    $_SESSION['email'] = $new_email;
                    $message = 'Profile updated';
                } else {
                    $message = 'Email already in use';
                }
            } else {
                $message = 'Current password is incorrect';
            }
        }

        echo json_encode(['status' => $success ? 'ok' : 'error', 'message' => $message]);
        exit();
    }

    if ($command === 'delete_account') {
        header('Content-Type: application/json');
        $success = delete_user_account($_SESSION['student_id']);
        session_destroy();
        echo json_encode(['status' => $success ? 'ok' : 'error']);
        exit();
    }

    render_main($semester);
}
