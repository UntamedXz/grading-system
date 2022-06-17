<div class="sidebar_admin">
        <div class="logo_container">
            <a href="#" class="logo">GRADING SYSTEM</a>
        </div>
        <div class="greetings">
            <span>Hello, Admin!</span>
        </div>
        <div class="links">
            <ul>
                <li><a href="index.php">DASHBOARD</a></li>
                <li><a href="course.php">COURSE</a></li>
                <li class="link" id="faculty">
                    <a href="#">FACULTY</a>
                    <ul class="tab" id="faculty_dropdown">
                        <li><a href="faculty.php">- Faculty</a></li>
                        <li><a href="faculty-subject.php">- Faculty Subject</a></li>
                    </ul>
                </li>
                <li class="link" id="student">
                    <a href="#">STUDENTS</a>
                    <ul class="tab" id="student_dropdown">
                        <li><a href="student-information.php">- Student</a></li>
                        <li><a href="student-subject.php">- Student Subject</a></li>
                    </ul>
                </li>
                <li><a href="subject.php">SUBJECT</a></li>
                <li><a href="section.php">SECTION</a></li>
                <li><a href="school-year.php">SCHOOL YEAR</a></li>
                <li><a href="#">SEMESTER</a></li>
            </ul>
        </div>
    </div>

    <div class="navbar_admin">
        <div class="nav-logo">
            <a href="">Grading System</a>
        </div>
        <i class="fa-solid fa-bars navbtn" id="nav-btn"></i>
        <div class="navlinks">
            <a href="">LOGOUT</a>
        </div>
    </div>

    <div class="mobile-nav">
        <ul>
            <li><a href="#">DASHBOARD</a></li>
            <li><a href="#">COURSE</a></li>
            <li><a href="#">FACULTY</a></li>
            <li><a href="#">STUDENTS</a></li>
            <li><a href="subject.php">SUBJECT</a></li>
            <li><a href="section.php">SECTION</a></li>
            <li><a href="school-year.php">SCHOOL YEAR</a></li>
            <li><a href="#">SEMESTER</a></li>
        </ul>
    </div>
    

    <script>
        var student = document.querySelector('#student');
        var faculty = document.querySelector('#faculty');
        var student_dropdown = document.querySelector('#student_dropdown');
        var faculty_dropdown = document.querySelector('#faculty_dropdown');

        student.addEventListener('click', function() {
            student_dropdown.classList.toggle('active');
        })

        faculty.addEventListener('click', function() {
            faculty_dropdown.classList.toggle('active');
        })
    </script>