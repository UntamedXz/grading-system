<?php
require_once '../../../database/database.php';

$request = $_REQUEST;
$col = array(
    0   =>  'studentno',
    1   =>  'student_lname',
    2   =>  'student_fname',
    3   =>  'student_mname',
    4   =>  'classname',
    5   =>  'yearlevel',
);
//create column like table in database

$sql = "SELECT student.studentno, student.student_lname, student.student_fname, student.student_mname, class.classname, yearlevel.yearlevel
FROM student
LEFT JOIN class
ON student.class_id = class.class_id
LEFT JOIN yearlevel
ON student.yearlevel_id = yearlevel.yearlevel_id";
$query = mysqli_query($connection, $sql);

$totalData = mysqli_num_rows($query);

$totalFilter = $totalData;

//Search
$sql = "SELECT student.studentno, student.student_lname, student.student_fname, student.student_mname, class.classname, yearlevel.yearlevel
FROM student
LEFT JOIN class
ON student.class_id = class.class_id
LEFT JOIN yearlevel
ON student.yearlevel_id = yearlevel.yearlevel_id WHERE 1=1";
if (!empty($request['search']['value'])) {
    $sql .= " AND (studentno Like '" . $request['search']['value'] . "%' ";
    $sql .= " OR student_lname Like '" . $request['search']['value'] . "%' ";
    $sql .= " OR student_fname Like '" . $request['search']['value'] . "%' ";
    $sql .= " OR student_mname Like '" . $request['search']['value'] . "%' ";
    $sql .= " OR classname Like '" . $request['search']['value'] . "%' ";
    $sql .= " OR yearlevel Like '" . $request['search']['value'] . "%' )";
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
    $subdata[] = $row[0];
    $subdata[] = $row[1] .", " . $row[2] . ", " . $row[3];
    $subdata[] = $row[4];
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
