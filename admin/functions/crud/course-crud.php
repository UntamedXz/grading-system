<?php
require_once '../../../database/database.php';

if(isset($_POST['get_edit'])) {
    $course_id = $_POST['course_id_edit'];
    $get_course = mysqli_query($connection, "SELECT * FROM course WHERE course_id = $course_id");

    $result_array = array();

    while($result = mysqli_fetch_assoc($get_course)) {
        $result_array['course_id'] = $result['course_id'];
        $result_array['coursename'] = $result['coursename'];
        $result_array['description'] = $result['description'];
    }

    echo json_encode($result_array);
}

if(isset($_POST['add_course'])) {
    $coursename = mysqli_real_escape_string($connection, $_POST['coursename']);
    $description = mysqli_real_escape_string($connection, $_POST['description']);

    $check_if_coursename_exist = mysqli_query($connection, "SELECT * FROM course WHERE coursename = '$coursename'");

    if(mysqli_num_rows($check_if_coursename_exist) > 0) {
        echo 'already exist';
    } else {
        $insert_course = mysqli_query($connection, "INSERT INTO course (coursename, description) VALUE ('$coursename', '$description')");

        if($insert_course) {
            echo 'success';
        }
    }
}

// EDIT COURSE
if(isset($_POST['edit_course'])) {
    $course_id = $_POST['course_id_edit'];
    $coursename = $_POST['coursename_edit'];
    $description = $_POST['description_edit'];

    $check_if_coursename_exist = mysqli_query($connection, "SELECT * FROM course WHERE coursename = '$coursename'");

    if(mysqli_num_rows($check_if_coursename_exist) > 0) {
        $check_if_coursename_exist_1 = mysqli_query($connection, "SELECT * FROM course WHERE course_id = $course_id AND coursename = '$coursename'");

        if(mysqli_num_rows($check_if_coursename_exist_1) == 1) {
            $edit_course = mysqli_query($connection, "UPDATE course SET description = '$description' WHERE course_id = $course_id");

            if($edit_course) {
                echo 'success';
            }
        } else {
            echo 'already exist';
        }
    } else {
        $edit_course = mysqli_query($connection, "INSERT INTO course (coursename, description) VALUES ('$coursename', '$description')");

        if($edit_course) {
            echo 'success';
        }
    }
}

// DELETE COURSE
if(isset($_POST['delete_course'])) {
    $course_id = $_POST['course_id_delete'];

    $delete_course = mysqli_query($connection, "DELETE FROM course WHERE course_id = $course_id");

    if($delete_course) {
        echo 'success';
    }
}