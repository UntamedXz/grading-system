<?php
require_once '../../../database/database.php';

$request = $_REQUEST;
$col = array(
    0   =>  'faculty_subject_id',
    1   =>  'coursename',
    2   =>  'lastname',
    3   =>  'firstname',
    4   =>  'middlename',
    5   =>  'subject_name',
);
//create column like table in database

$sql = "SELECT facultysubject.faculty_subject_id, course.coursename, faculty.lastname, faculty.firstname, faculty.middlename, subject.subject_name
FROM facultysubject
LEFT JOIN faculty
ON facultysubject.faculty_id = faculty.faculty_id
LEFT JOIN course
ON facultysubject.course_id = course.course_id
LEFT JOIN subject
ON facultysubject.subject_id = subject.subject_id";
$query = mysqli_query($connection, $sql);

$totalData = mysqli_num_rows($query);

$totalFilter = $totalData;

//Search
$sql = "SELECT facultysubject.faculty_subject_id, course.coursename, faculty.lastname, faculty.firstname, faculty.middlename, subject.subject_name
FROM facultysubject
LEFT JOIN faculty
ON facultysubject.faculty_id = faculty.faculty_id
LEFT JOIN course
ON facultysubject.course_id = course.course_id
LEFT JOIN subject
ON facultysubject.subject_id = subject.subject_id WHERE 1=1";
if (!empty($request['search']['value'])) {
    $sql .= " AND (faculty_subject_id Like '" . $request['search']['value'] . "%' ";
    $sql .= " OR coursename Like '" . $request['search']['value'] . "%' ";
    $sql .= " OR lastname Like '" . $request['search']['value'] . "%' ";
    $sql .= " OR firstname Like '" . $request['search']['value'] . "%' ";
    $sql .= " OR middlename Like '" . $request['search']['value'] . "%' ";
    $sql .= " OR subject_name Like '" . $request['search']['value'] . "%' )";
}


$query = mysqli_query($connection, $sql);
$totalData = mysqli_num_rows($query);

//Order
$sql .= " ORDER BY " . $col[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'] . "  LIMIT " .
    $request['start'] . "  ," . $request['length'] . "  ";

$query = mysqli_query($connection, $sql);

$data = array();

while ($row = mysqli_fetch_array($query)) {
    $subdata = array();
    $subdata = $row[1];
    $subdata[] = $row[2] . ", " . $row[3] . ", " . $row[4];
    $subdata[] = $row[5];
    $subdata[] = '<div class="dropdown">
    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-gear"></i>
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
      <li><a class="dropdown-item" href="#" data-id="'.$row[0].'">Edit</a></li>
      <li><a class="dropdown-item" href="#" data-id="'.$row[0].'">Delete</a></li>
    </ul>
  </div>';
    $data[] = $subdata;
}

$json_data = array(
    "draw"              =>  intval($request['draw']),
    "recordsTotal"      =>  intval($totalData),
    "recordsFiltered"   =>  intval($totalFilter),
    "data"              =>  $data
);

echo json_encode($json_data);
