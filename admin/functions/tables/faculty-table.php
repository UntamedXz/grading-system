<?php
require_once '../../../database/database.php';

$request = $_REQUEST;
$col = array(
    0   =>  'faculty_id',
    1   =>  'lastname',
    2   =>  'firstname',
    3   =>  'middlename',
    4   =>  'username',
    5   =>  'coursename',
);
//create column like table in database

$sql = "SELECT faculty.faculty_id, faculty.lastname, faculty.firstname, faculty.middlename, faculty.username, course.coursename
FROM faculty
LEFT JOIN course
ON faculty.course_id = course.course_id";
$query = mysqli_query($connection, $sql);

$totalData = mysqli_num_rows($query);

$totalFilter = $totalData;

//Search
$sql = "SELECT faculty.faculty_id, faculty.lastname, faculty.firstname, faculty.middlename, faculty.username, course.coursename
FROM faculty
LEFT JOIN course
ON faculty.course_id = course.course_id WHERE 1=1";
if (!empty($request['search']['value'])) {
    $sql .= " AND (faculty_id Like '" . $request['search']['value'] . "%' ";
    $sql .= " OR lastname Like '" . $request['search']['value'] . "%' ";
    $sql .= " OR firstname Like '" . $request['search']['value'] . "%' ";
    $sql .= " OR middlename Like '" . $request['search']['value'] . "%' ";
    $sql .= " OR username Like '" . $request['search']['value'] . "%' ";
    $sql .= " OR coursename Like '" . $request['search']['value'] . "%' )";
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
    $subdata[] = $row[1] . ", " . $row[2] . " " . $row[3];
    $subdata[] = $row[5];
    $subdata[] = $row[4];
    $subdata[] = '<div class="dropdown">
    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-gear"></i>
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
      <li><a class="dropdown-item" href="#" id="edit_btn" data-id="'.$row[0].'">Edit</a></li>
      <li><a class="dropdown-item" href="#" id="delete_btn" data-id="'.$row[0].'">Delete</a></li>
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
