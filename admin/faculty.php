<?php 
require_once '../database/database.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- jquery cdn -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!-- fontawesome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <!-- custom css -->
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
    <!-- datatable lib -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.0/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js"></script>
    <title>Document</title>
</head>
<body>
    <?php include './includes/top.php'; ?>
    <div class="main">
        <div class="breadcrumbs">
            <a href="index.php">Home</a>
            <a href="#" class="divider">/</a>
            <a href="#" class="active">Faculty</a>
        </div>

        <div class="header_title">
            <h2>Manage Faculty</h2>
        </div>

        <section class="school_year">
            <div class="button_wrapper">
                <button type="button" class="btn btn-primary" id="add_btn">Add Faculty</button>
            </div>

            <!-- CREATE FACULTY -->
            <div class="modal-dialog" id="add_modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Faculty</h5>
                        <button type="button" class="btn-close close_modal"></button>
                    </div>
                    <div class="modal-body">
                        <form id="add_faculty_form">
                            <div class="alert alert-secondary alert_style" role="alert">
                                <span class="alert_text"></span>
                                <i class="fa-solid fa-xmark close_alert"></i>
                            </div>
                            <div class="group_form">
                                <div class="form_group">
                                    <span>Last Name</span>
                                    <input class="form-control" type="text" name="lastname" id="lastname">
                                    <span class="text-danger error_lastname_add" style="font-size: 13px; font-weight: 700;"></span>
                                </div>
                                <div class="form_group">
                                    <span>First Name</span>
                                    <input type="text" class="form-control" name="firstname" id="firstname">
                                    <span class="text-danger error_firstname_add" style="font-size: 13px; font-weight: 700;"></span>
                                </div>
                            </div>
                            <div class="group_form">
                                <div class="form_group">
                                    <span>Middle Name</span>
                                    <input class="form-control" type="text" name="middlename" id="middlename">
                                    <span class="text-danger error_middlename_add" style="font-size: 13px; font-weight: 700;"></span>
                                </div>
                                <div class="form_group">
                                    <span>Course</span>
                                    <select class="form-select course" aria-label="Default select example" name="course">
                                        <option selected value="">Select Course</option>
                                        <?php
                                        $get_course = mysqli_query($connection, "SELECT * FROM course");

                                        foreach($get_course as $course) {
                                        ?>
                                        <option value="<?php echo $course['course_id']; ?>"><?php echo $course['coursename']; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                    <span class="text-danger error_course_add" style="font-size: 13px; font-weight: 700;"></span>
                                </div>
                            </div>
                            <div class="group_form">
                                <div class="form_group">
                                    <span>Username</span>
                                    <input class="form-control" type="text" name="username" id="username">
                                    <span class="text-danger error_username_add" style="font-size: 13px; font-weight: 700;"></span>
                                </div>
                                <div class="form_group">
                                    <span>Password</span>
                                    <input type="password" class="form-control" name="password" id="password">
                                    <span class="text-danger error_password_add" style="font-size: 13px; font-weight: 700;"></span>
                                </div>
                            </div>
                            <div class="form_group">
                                <span>Faculty Level</span>
                                <select class="form-select faculty_level" aria-label="Default select example" name="faculty_level">
                                    <option selected value="">Select Faculty Level</option>
                                    <?php
                                    $get_faculty_level = mysqli_query($connection, "SELECT * FROM faculty_level");

                                    foreach($get_faculty_level as $faculty_level) {
                                    ?>
                                    <option value="<?php echo $faculty_level['faculty_level_id']; ?>"><?php echo $faculty_level['level']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <span class="text-danger error_faculty_level_add" style="font-size: 13px; font-weight: 700;"></span>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary close_modal">Close</button>
                        <button type="submit" form="add_faculty_form" class="btn btn-primary">Add</button>
                    </div>
                </div>
            </div>

            <!-- EDIT FACULTY -->
            <div class="modal-dialog" id="edit_modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Faculty</h5>
                        <button type="button" class="btn-close close_modal"></button>
                    </div>
                    <div class="modal-body">
                        <form id="edit_faculty_form">
                            <div class="alert alert-secondary alert_style" role="alert">
                                <span class="alert_text"></span>
                                <i class="fa-solid fa-xmark close_alert"></i>
                            </div>
                            <input type="hidden" name="faculty_id_edit" id="faculty_id_edit">
                            <div class="group_form">
                                <div class="form_group">
                                    <span>Last Name</span>
                                    <input class="form-control" type="text" name="lastname_edit" id="lastname_edit">
                                    <span class="text-danger error_lastname_edit" style="font-size: 13px; font-weight: 700;"></span>
                                </div>
                                <div class="form_group">
                                    <span>First Name</span>
                                    <input type="text" class="form-control" name="firstname_edit" id="firstname_edit">
                                    <span class="text-danger error_firstname_edit" style="font-size: 13px; font-weight: 700;"></span>
                                </div>
                            </div>
                            <div class="group_form">
                                <div class="form_group">
                                    <span>Middle Name</span>
                                    <input class="form-control" type="text" name="middlename_edit" id="middlename_edit">
                                    <span class="text-danger error_middlename_edit" style="font-size: 13px; font-weight: 700;"></span>
                                </div>
                                <div class="form_group">
                                    <span>Course</span>
                                    <select class="form-select course_edit" aria-label="Default select example" name="course_edit">
                                        <option selected value="">Select Course</option>
                                        <?php
                                        $get_course = mysqli_query($connection, "SELECT * FROM course");
                                        foreach($get_course as $course) {
                                        ?>
                                        <option value="<?php echo $course['course_id']; ?>"><?php echo $course['coursename']; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                    <span class="text-danger error_course_edit" style="font-size: 13px; font-weight: 700;"></span>
                                </div>
                            </div>
                            <div class="group_form">
                                <div class="form_group">
                                    <span>Username</span>
                                    <input class="form-control" type="text" name="username_edit" id="username_edit">
                                    <span class="text-danger error_username_edit" style="font-size: 13px; font-weight: 700;"></span>
                                </div>
                                <div class="form_group">
                                    <span>Password</span>
                                    <input type="password" class="form-control" name="password_edit" id="password_edit">
                                    <span class="text-danger error_password_edit" style="font-size: 13px; font-weight: 700;"></span>
                                </div>
                            </div>
                            <div class="form_group">
                                <span>Faculty Level</span>
                                <select class="form-select faculty_level_edit" aria-label="Default select example" name="faculty_level_edit">
                                    <option selected value="">Select Faculty Level</option>
                                    <?php
                                    $get_faculty_level = mysqli_query($connection, "SELECT * FROM faculty_level");

                                    foreach($get_faculty_level as $faculty_level) {
                                    ?>
                                    <option value="<?php echo $faculty_level['faculty_level_id']; ?>"><?php echo $faculty_level['level']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <span class="text-danger error_faculty_level_edit" style="font-size: 13px; font-weight: 700;"></span>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary close_modal">Close</button>
                        <button type="submit" form="edit_faculty_form" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
            <div id="overlay"></div>

            <table class="display" id="example">
                <thead>
                    <th>Faculty Number</th>
                    <th>Name</th>
                    <th>Course</th>
                    <th>Username</th>
                    <th>Action</th>
                </thead>
            </table>
        </section>
    </div>
    <?php include './includes/bottom.php'; ?>
    <script>
        // DATA TABLES
        var dataTable = $('#example').DataTable({
            "processing": true,
            "serverSide": true,
            "paging": true,
            "pagingType": "simple",
            "scrollX": true,
            "sScrollXInner": "100%",
            "aLengthMenu": [
                [5, 10, 15, 100],
                [5, 10, 15, 100]
            ],
            "iDisplayLength": 5,
            order: [[0, 'desc']],
            "ajax": {
                url: "./functions/tables/faculty-table.php",
                type: "post"
            }
        });

        // MODALS
        // Click Add Course
        var add_btn = $('#add_btn');
        var edit_btn = $('#edit_btn');
        var delete_btn = $('#delete_btn');
        var add_modal = $('#add_modal');
        var edit_modal = $('#edit_modal');
        var delete_modal = $('#delete_modal');
        var close = $('.close_modal');
        var overlay = $('#overlay');

        add_btn.click(function () {
            overlay.toggleClass('active');
            add_modal.toggleClass('active');
        })

        // Close Modal
        $('.close_modal').click(function () {
            overlay.removeClass('active');
            add_modal.removeClass('active');
            edit_modal.removeClass('active');
            delete_modal.removeClass('active');
            $('.alert_style').removeClass('active');
            $('#add_course_form')[0].reset();
            $('#edit_course_form')[0].reset();
        })

        overlay.click(function () {
            add_modal.removeClass('active');
            edit_modal.removeClass('active');
            delete_modal.removeClass('active');
            overlay.removeClass('active');
            $('.alert_style').removeClass('active');
            $('#add_course_form')[0].reset();
            $('#edit_course_form')[0].reset();
        })

        // GET EDIT
        $(document).on('click', '#edit_btn', function (e) {
            e.preventDefault();
            var faculty_id_edit = $(this).data('id');

            $.ajax({
                url: './functions/crud/faculty-crud.php',
                type: 'POST',
                data: {
                    'faculty_id_edit': faculty_id_edit,
                    'get_edit': true,
                },
                success: function (res) {
                    var obj = JSON.parse(res);
                    $("#edit_modal").toggleClass("active");
                    $('#overlay').toggleClass("active");
                    $("#faculty_id_edit").val(obj.faculty_id);
                    $("#lastname_edit").val(obj.lastname);
                    $("#firstname_edit").val(obj.firstname);
                    $("#middlename_edit").val(obj.middlename);
                    $(".course_edit").val(obj.course_id);
                    $("#username_edit").val(obj.username);
                    $("#password_edit").val(obj.password);
                    $(".faculty_level_edit").val(obj.faculty_level);
                }
            })
        })

        // SUBMIT ADD
        $('#add_faculty_form').on('submit', function(e) {
            e.preventDefault();

            if($.trim($('#lastname').val()).length == 0) {
                $('.error_lastname_add').text('Last name is empty!');
            } else {
                $('.error_lastname_add').text('');
            }

            if($.trim($('#firstname').val()).length == 0) {
                $('.error_firstname_add').text('First name is empty!');
            } else {
                $('.error_firstname_add').text('');
            }

            if($.trim($('#middlename').val()).length == 0) {
                $('.error_middlename_add').text('');
            } else {
                $('.error_middlename_add').text('');
            }

            if($('.course').val() == '') {
                $('.error_course_add').text('Select course!');
            } else {
                $('.error_course_add').text('');
            }

            if($.trim($('#username').val()).length == 0) {
                $('.error_username_add').text('User name is empty!');
            } else {
                $('.error_username_add').text('');
            }

            if($.trim($('#password').val()).length == 0) {
                $('.error_password_add').text('Password is empty!');
            } else {
                if($.trim($('#password').val()).length < 8) {
                    $('.error_password_add').text('Password too short!');
                } else {
                    $('.error_password_add').text('');
                }
            }

            if($('.faculty_level').val() == '') {
                $('.error_faculty_level_add').text('Select faculty level!');
            } else {
                $('.error_faculty_level_add').text('');
            }

            if($('.error_lastname_add').text() != '' || $('.error_firstname_add').text() != '' || $('.error_middlename_add').text() != '' || $('.error_course_add').text() != '' || $('.error_username_add').text() != '' || $('.error_password_add').text() != '' || $('.error_faculty_level_add').text() != '') {
                $('.alert_style').toggleClass('active');
                $('.alert_text').text('Fill all required fields!');
            } else {
                var form = new FormData(this);
                form.append('add_faculty', true);
                $.ajax({
                    type: "POST",
                    url: "./functions/crud/faculty-crud.php",
                    data: form,
                    dataType: "text",
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response) {
                        if(response == 'success') {
                            $('#add_modal').removeClass('active');
                            $('#overlay').removeClass('active');
                            $('.alert_style').removeClass('active');
                            $('#add_faculty_form')[0].reset();
                            $('#example').DataTable().ajax.reload();
                        } else if(response == 'already exist') {
                            $('.alert_style').toggleClass('active');
                            $('.alert_text').text('Faculty already exist!');
                        } else {
                            $('.alert_style').toggleClass('active');
                            $('.alert_text').text('Something went wrong!');
                        }
                        console.log(response);
                    }
                })
            }
        })

        // SUBMIT EDIT
        $('#edit_faculty_form').on('submit', function(e) {
            e.preventDefault();

            if($.trim($('#lastname_edit').val()).length == 0) {
                $('.error_lastname_edit').text('Last name is empty!');
            } else {
                $('.error_lastname_edit').text('');
            }

            if($.trim($('#firstname_edit').val()).length == 0) {
                $('.error_firstname_edit').text('First name is empty!');
            } else {
                $('.error_firstname_edit').text('');
            }

            if($.trim($('#middlename_edit').val()).length == 0) {
                $('.error_middlename_edit').text('');
            } else {
                $('.error_middlename_edit').text('');
            }

            if($('.course_edit').val() == '') {
                $('.error_course_edit').text('Select course!');
            } else {
                $('.error_course_edit').text('');
            }

            if($.trim($('#username_edit').val()).length == 0) {
                $('.error_username_edit').text('User name is empty!');
            } else {
                $('.error_username_edit').text('');
            }

            if($.trim($('#password_edit').val()).length == 0) {
                $('.error_password_edit').text('Password is empty!');
            } else {
                if($.trim($('#password_edit').val()).length < 8) {
                    $('.error_password_edit').text('Password too short!');
                } else {
                    $('.error_password_edit').text('');
                }
            }

            if($('.faculty_level_edit').val() == '') {
                $('.error_faculty_level_edit').text('Select faculty level!');
            } else {
                $('.error_faculty_level_edit').text('');
            }

            if($('.error_lastname_edit').text() != '' || $('.error_firstname_edit').text() != '' || $('.error_middlename_edit').text() != '' || $('.error_course_edit').text() != '' || $('.error_username_edit').text() != '' || $('.error_password_edit').text() != '' || $('.error_faculty_level_edit').text() != '') {
                $('.alert_style').toggleClass('active');
                $('.alert_text').text('Fill all required fields!');
            } else {
                var form = new FormData(this);
                form.append('edit_faculty', true);
                $.ajax({
                    type: "POST",
                    url: "./functions/crud/faculty-crud.php",
                    data: form,
                    dataType: "text",
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response) {
                        if(response == 'success') {
                            $('#edit_modal').removeClass('active');
                            $('#overlay').removeClass('active');
                            $('.alert_style').removeClass('active');
                            $('#edit_faculty_form')[0].reset();
                            $('#example').DataTable().ajax.reload();
                        } else if(response == 'already exist') {
                            $('.alert_style').toggleClass('active');
                            $('.alert_text').text('Faculty already exist!');
                        } else {
                            $('.alert_style').toggleClass('active');
                            $('.alert_text').text('Something went wrong!');
                        }
                        console.log(response);
                    }
                })
            }
        })

        // CLOSE ALERT
        $('.close_alert').on('click', function(e) {
            $('.alert_style').removeClass('active');
        })
    </script>
</body>
</html>