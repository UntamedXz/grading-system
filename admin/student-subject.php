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
            <a href="#" class="active">School Year</a>
        </div>

        <div class="header_title">
            <h2>Manage Student Subject</h2>
        </div>

        <section class="school_year">
            <div class="button_wrapper">
                <button type="button" class="btn btn-primary">Add Student Subject</button>
            </div>

            <table class="display" id="example">
                <thead>
                    <th>Student Number</th>
                    <th>Name</th>
                    <th>Adviser</th>
                    <th>Subject</th>
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
            order: [[0, 'asc']],
            "ajax": {
                url: "./functions/tables/student-sub-table.php",
                type: "post"
            }
        });
    </script>
</body>
</html>