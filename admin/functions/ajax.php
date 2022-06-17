<?php
require_once '../../database/database.php';

if(isset($_REQUEST['course_id_edit'])) {
    $course_id = $_REQUEST['course_id_edit'];
    $get_course = mysqli_query($connection, "SELECT * FROM course WHERE course_id = $course_id");

    $result_array = array();

    while($result = mysqli_fetch_assoc($get_course)) {
        $result_array['course_id'] = $result['course_id'];
        $result_array['coursename'] = $result['coursename'];
        $result_array['description'] = $result['description'];
    }

    echo json_encode($result_array);
}