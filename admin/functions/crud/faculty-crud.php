<?php
require_once '../../../database/database.php';

if (isset($_POST['add_faculty'])) {
    date_default_timezone_set('Asia/Manila');
    $lastname = mysqli_real_escape_string($connection, $_POST['lastname']);
    $firstname = mysqli_real_escape_string($connection, $_POST['firstname']);
    $middlename = mysqli_real_escape_string($connection, $_POST['middlename']);
    $course = mysqli_real_escape_string($connection, $_POST['course']);
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);
    $faculty_level = mysqli_real_escape_string($connection, $_POST['faculty_level']);
    $created = date("m-d-Y");

    $check_if_username_exist = mysqli_query($connection, "SELECT * FROM faculty WHERE username = '$username'");

    if (mysqli_num_rows($check_if_username_exist) > 0) {
        echo 'already exist';
    } else {
        $insert_faculty = mysqli_query($connection, "INSERT INTO faculty (firstname, middlename, lastname, username, password, course_id, faculty_level, created) VALUES ('$firstname', '$middlename', '$lastname', '$username', '$password', '$course', '$faculty_level', '$created')");

        if ($insert_faculty) {
            echo 'success';
        }
    }
}

if (isset($_POST['get_edit'])) {
    $faculty_id = $_POST['faculty_id_edit'];
    $get_course = mysqli_query($connection, "SELECT * FROM faculty WHERE faculty_id = $faculty_id");

    $result_array = array();

    while ($result = mysqli_fetch_assoc($get_course)) {
        $result_array['faculty_id'] = $result['faculty_id'];
        $result_array['lastname'] = $result['lastname'];
        $result_array['firstname'] = $result['firstname'];
        $result_array['middlename'] = $result['middlename'];
        $result_array['course_id'] = $result['course_id'];
        $result_array['username'] = $result['username'];
        $result_array['password'] = $result['password'];
        $result_array['faculty_level'] = $result['faculty_level'];
    }

    echo json_encode($result_array);
}

if (isset($_POST['edit_faculty'])) {
    $faculty_id = mysqli_real_escape_string($connection, $_POST['faculty_id_edit']);
    $lastname = mysqli_real_escape_string($connection, $_POST['lastname_edit']);
    $firstname = mysqli_real_escape_string($connection, $_POST['firstname_edit']);
    $middlename = mysqli_real_escape_string($connection, $_POST['middlename_edit']);
    $course = mysqli_real_escape_string($connection, $_POST['course_edit']);
    $username = mysqli_real_escape_string($connection, $_POST['username_edit']);
    $password = mysqli_real_escape_string($connection, $_POST['password_edit']);
    $faculty_level = mysqli_real_escape_string($connection, $_POST['faculty_level_edit']);

    $check_if_username_exist = mysqli_query($connection, "SELECT * FROM faculty WHERE username = '$username'");

    if (mysqli_num_rows($check_if_username_exist) > 0) {
        $check_if_username_exist_1 = mysqli_query($connection, "SELECT * FROM faculty WHERE username = '$username' AND $faculty_id = $faculty_id");

        if (mysqli_num_rows($check_if_username_exist_1) == 1) {
            $update_faculty = mysqli_query($connection, "UPDATE faculty SET lastname = '$lastname', firstname = '$firstname', middlename = '$middlename', course_id = '$course', username = '$username', password = '$password', faculty_level = '$faculty_level' WHERE faculty_id = $faculty_id");

            if ($update_faculty) {
                echo 'success';
            }
        } else {
            echo 'already exist';
        }
    } else {
        $update_faculty = mysqli_query($connection, "UPDATE faculty SET lastname = '$lastname', firstname = '$firstname', middlename = '$middlename', course_id = '$course', username = '$username', password = '$password', faculty_level = '$faculty_level' WHERE faculty_id = $faculty_id");

        if ($update_faculty) {
            echo 'success';
        }
    }
}
