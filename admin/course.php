<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- jquery cdn -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
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
            <h2>Manage Course</h2>
        </div>

        <section class="school_year">
            <div class="button_wrapper">
                <button type="button" class="btn btn-primary" id="add_btn">Add
                    Course</button>
            </div>

            <!-- CREATE COURSE -->
            <div class="modal-dialog" id="add_modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Course</h5>
                        <button type="button" class="btn-close close_modal"></button>
                    </div>
                    <div class="modal-body">
                        <form id="add_course_form">
                            <div class="alert alert-secondary alert_style" role="alert">
                                <span class="alert_text"></span>
                                <i class="fa-solid fa-xmark close_alert"></i>
                            </div>
                            <div class="form_group">
                                <span>Course Name</span>
                                <input class="form-control" type="text" name="coursename" id="coursename">
                                <span class="text-danger error_coursename_add" style="font-size: 13px; font-weight: 700;"></span>
                            </div>
                            <div class="form_group">
                                <span>Course Description</span>
                                <input type="text" class="form-control" name="description" id="description">
                                <span class="text-danger error_description_add" style="font-size: 13px; font-weight: 700;"></span>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary close_modal">Close</button>
                        <button type="submit" form="add_course_form" class="btn btn-primary">Add</button>
                    </div>
                </div>
            </div>
            <!-- EDIT COURSE -->
            <div class="modal-dialog" id="edit_modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Course</h5>
                        <button type="button" class="btn-close close_modal"></button>
                    </div>
                    <div class="modal-body">
                        <form id="edit_course_form">
                            <div class="alert alert-secondary alert_style" role="alert">
                                <span class="alert_text"></span>
                                <i class="fa-solid fa-xmark close_alert"></i>
                            </div>
                            <input type="hidden" name="course_id_edit" id="course_id_edit">
                            <div class="form_group">
                                <span>Course Name</span>
                                <input class="form-control" type="text" name="coursename_edit" id="coursename_edit">
                                <span class="text-danger error_coursename_edit" style="font-size: 13px; font-weight: 700;"></span>
                            </div>
                            <div class="form_group">
                                <span>Course Description</span>
                                <input type="text" class="form-control" name="description_edit" id="description_edit">
                                <span class="text-danger error_description_edit" style="font-size: 13px; font-weight: 700;"></span>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary close_modal">Close</button>
                        <button type="submit" form="edit_course_form" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
            <!-- DELETE COURSE -->
            <div class="modal-dialog" id="delete_modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete Course</h5>
                        <button type="button" class="btn-close close_modal"></button>
                    </div>
                    <div class="modal-body">
                        <form id="delete_course_form">
                            <input type="hidden" name="course_id_delete" id="course_id_delete">
                            <h6>Are you sure, you want to delete this course?</h6>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary close_modal">Close</button>
                        <button type="submit" form="delete_course_form" class="btn btn-danger">Delete</button>
                    </div>
                </div>
            </div>
            <div id="overlay"></div>

            <!-- DATA TABLES -->
            <table class="display" id="example">
                <thead>
                    <th>Course</th>
                    <th>Description</th>
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
            order: [
                [0, 'desc']
            ],
            "ajax": {
                url: "./functions/tables/course-table.php",
                type: "post"
            }
        });

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
            var course_id_edit = $(this).data('id');

            $.ajax({
                url: './functions/crud/course-crud.php',
                type: 'POST',
                data: {
                    'course_id_edit': course_id_edit,
                    'get_edit': true,
                },
                success: function (res) {
                    var obj = JSON.parse(res);
                    $("#edit_modal").toggleClass("active");
                    $('#overlay').toggleClass("active");
                    $("#course_id_edit").val(obj.course_id);
                    $("#coursename_edit").val(obj.coursename);
                    $("#description_edit").val(obj.description);
                }
            })
        })

        // GET DELETE
        $(document).on('click', '#delete_btn', function(e) {
            e.preventDefault();
            $('#delete_modal').toggleClass('active');
            $('#overlay').toggleClass('active');
            var course_id_delete = $(this).data('id');
            $('#course_id_delete').val(course_id_delete);
        })

        // SUBMIT INSERT
        $('#add_course_form').on('submit', function(e) {
            e.preventDefault();
            if($.trim($('#coursename').val()).length == 0) {
                $('.error_coursename_add').text('Coursename is empty!');
            } else {
                $('.error_coursename_add').text('');
            }

            if($.trim($('#description').val()).length == 0) {
                $('.error_description_add').text('Description is empty!');
            } else {
                $('.error_description_add').text('');
            }

            if($('.error_coursename_add').text() != '' || $('.error_description_add').text() != '') {
                $('.alert_style').toggleClass('active');
                $('.alert_text').text('Fill all required fields!');
            } else {
                var form = new FormData(this);
                form.append('add_course', true);
                $.ajax({
                    type: "POST",
                    url: "./functions/crud/course-crud.php",
                    data: form,
                    dataType: "text",
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response) {
                        if(response == 'already exist') {
                            $('.alert_style').toggleClass('active');
                            $('.alert_text').text('Course already exist!');
                        } else if(response == 'success') {
                            $('#add_modal').removeClass('active');
                            $('#overlay').removeClass('active');
                            $('.alert_style').removeClass('active');
                            $('#add_course_form')[0].reset();
                            $('#example').DataTable().ajax.reload();
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
        $('#edit_course_form').on('submit', function(e) {
            e.preventDefault();
            
            if($.trim($('#coursename_edit').val()).length == 0) {
                $('.error_coursename_edit').text('Coursename is empty!');
            } else {
                $('.error_coursename_edit').text('');
            }

            if($.trim($('#description_edit').val()).length == 0) {
                $('.error_description_edit').text('Description is empty!');
            } else {
                $('.error_description_edit').text('');
            }

            if($('.error_coursename_edit').text() != '' || $('.error_description_edit').text() != '') {
                $('.alert_style').toggleClass('active');
                $('.alert_text').text('Fill all required fields!');
            } else {
                var form = new FormData(this);
                form.append('edit_course', true);
                $.ajax({
                    type: "POST",
                    url: "./functions/crud/course-crud.php",
                    data: form,
                    dataType: "text",
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response) {
                        if(response == 'already exist') {
                            $('.alert_style').toggleClass('active');
                            $('.alert_text').text('Course already exist!');
                        } else if(response == 'success') {
                            $('#edit_modal').removeClass('active');
                            $('#overlay').removeClass('active');
                            $('.alert_style').removeClass('active');
                            $('#edit_course_form')[0].reset();
                            $('#example').DataTable().ajax.reload();
                        } else {
                            $('.alert_style').toggleClass('active');
                            $('.alert_text').text('Something went wrong!');
                        }
                        console.log(response);
                    }
                })
            }

        })

        // SUBMIT DELETE
        $('#delete_course_form').on('submit', function(e) {
            e.preventDefault();
            var form = new FormData(this);
            form.append('delete_course', true);
            $.ajax({
                type: "POST",
                url: "./functions/crud/course-crud.php",
                data: form,
                dataType: "text",
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {
                    if(response == 'success') {
                        $('#delete_modal').removeClass('active');
                        $('#overlay').removeClass('active');
                        $('#example').DataTable().ajax.reload();
                    } else {
                        $('.alert_style').toggleClass('active');
                        $('.alert_text').text('Something went wrong!');
                    }
                    console.log(response);
                }
            })
        })

        // CLOSE ALERT
        $('.close_alert').on('click', function(e) {
            $('.alert_style').removeClass('active');
        })
    </script>
</body>

</html>