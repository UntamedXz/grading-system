<?php
require_once '../../../database/database.php';

$request = $_REQUEST;
$col = array(
    0   =>  'subject_id',
    1   =>  'subject_code',
    2   =>  'unit',
    3   =>  'coursename',
    4   =>  'yearlevel',
    5   =>  'semester',
);
//create column like table in database

$sql = "SELECT subject.subject_id, subject.subject_code, subject.subject_name, subject.unit, course.coursename, yearlevel.yearlevel, schoolyear.semester
FROM subject
LEFT JOIN course
ON subject.course = course.course_id
LEFT JOIN yearlevel
ON subject.yearlevel_id = yearlevel.yearlevel_id
LEFT JOIN schoolyear
ON subject.schoolyear_id = schoolyear.schoolyear_id";
$query = mysqli_query($connection, $sql);

$totalData = mysqli_num_rows($query);

$totalFilter = $totalData;

//Search
$sql = "SELECT subject.subject_id, subject.subject_code, subject.subject_name, subject.unit, course.coursename, yearlevel.yearlevel, schoolyear.semester
FROM subject
LEFT JOIN course
ON subject.course = course.course_id
LEFT JOIN yearlevel
ON subject.yearlevel_id = yearlevel.yearlevel_id
LEFT JOIN schoolyear
ON subject.schoolyear_id = schoolyear.schoolyear_id WHERE 1=1";
if (!empty($request['search']['value'])) {
    $sql .= " AND (subject_id Like '" . $request['search']['value'] . "%' ";
    $sql .= " OR subject_code Like '" . $request['search']['value'] . "%' ";
    $sql .= " OR subject_name Like '" . $request['search']['value'] . "%' ";
    $sql .= " OR unit Like '" . $request['search']['value'] . "%' ";
    $sql .= " OR coursename Like '" . $request['search']['value'] . "%' ";
    $sql .= " OR yearlevel Like '" . $request['search']['value'] . "%' ";
    $sql .= " OR semester Like '" . $request['search']['value'] . "%' )";
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
    $subdata[] = $row[1];
    $subdata[] = $row[2];
    $subdata[] = $row[3];
    $subdata[] = $row[4];
    $subdata[] = $row[5];
    $subdata[] = $row[6];
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
