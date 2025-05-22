<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="design.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
</head>

<body>
    <form action="#" method="POST">
        <div class="enrollment-section">
            <h1>Enrollment Form</h1>
            <div class="form-group">
                <div class="form-label">
                    <label for="username">Username</label>
                </div>
                <div class="form-input">
                    <input type="text" name="username" id="username">
                </div>
            </div>
            <div class="form-group">
                <div class="form-label">
                    <label for="fullname">Student ID</label>
                </div>
                <div class="form-input">
                    <input type="text" name="studentid" id="studentid" placeholder="Ex. (1234567)" maxlength="7">
                </div>
            </div>
            <div class="form-group">
                <div class="form-label">
                    <label for="fullname">Full Name</label>
                </div>
                <div class="form-input">
                    <input type="text" name="fullname" id="fullname"
                        placeholder="Family name, First name and Middle name">
                </div>
            </div>
            <div class="form-group">
                <div class="form-label">
                    <label for="course">Course</label>
                </div>
                <select id="course" name="course" class="js-example-basic-single">
                    <option value="BEED">BEED - Bachelor of Elementary Education</option>
                    <option value="BSED">BSED - Bachelor of Secondary Education</option>
                    <option value="BSHM">BSHM - Bachelor of Science in Hospitality Management</option>
                    <option value="BSIT">BSIT - Bachelor of Science in Information Technology</option>
                </select>
            </div>
            <div class="group-container">
                <div class="form-group">
                    <div class="form-label">
                        <label for="gradesection">Grade & Section</label>
                    </div>
                    <select id="gradesection" name="gradesection" class="js-example-basic-single">
                        <option value="1A">1A</option>
                        <option value="1B">1B</option>
                        <option value="1C">1C</option>
                        <option value="1D">1D</option>
                        <option value="2A">2A</option>
                        <option value="2B">2B</option>
                        <option value="2C">2C</option>
                        <option value="2D">2D</option>
                        <option value="3A">3A</option>
                        <option value="3B">3B</option>
                        <option value="3C">3C</option>
                        <option value="3D">3D</option>
                        <option value="4A">4A</option>
                        <option value="4B">4B</option>
                        <option value="4C">4C</option>
                        <option value="4D">4D</option>
                    </select>
                </div>
                <div class="form-group">
                    <div class="form-label">
                        <label for="age">Age</label>
                    </div>
                    <div class="form-input">
                        <input type="text" name="age" id="age" maxlength="3">
                    </div>
                </div>
            </div>
            <div class="btn-container">
                <button id="btnSave" type='button'>Enroll</button>
                <button type="button" onclick="window.location.href='enrolledstudents.php'">View Enrolled
                    Students</button>
            </div>
        </div>
    </form>
    <canvas id="canvas"></canvas>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="bg.js"></script>
    <script>
        $(document).ready(function () {
            $('#btnSave').click(() => {
                let username = $('#username').val().trim();
                let studentid = $('#studentid').val().trim();
                let fullname = $('#fullname').val();
                let gradesection = $('#gradesection').val();
                let course = $('#course').val();
                let age = $('#age').val().trim();
                console.log("dwadwa")
                if (!username || !studentid || !fullname || !age || !gradesection || !course) {
                    Swal.fire({
                        icon: "warning",
                        title: "Oops...",
                        text: "Please fill out all the fields!",
                        background: "rgb(20, 20, 20)",
                        color: "rgb(240, 240, 240)",
                        confirmButtonColor: "rgb(62, 216, 255)"
                    });
                    return;
                }
                if (!/^\d{7}$/.test(studentid)) {
                    Swal.fire({
                        icon: "warning",
                        title: "Invalid Student ID",
                        text: "Student ID must be a 7-digit number.",
                        background: "rgb(20, 20, 20)",
                        color: "rgb(240, 240, 240)",
                        confirmButtonColor: "rgb(62, 216, 255)"
                    });
                    $('#studentid').val('');
                    return;
                }
                if (!/^\d{1,3}$/.test(age)) {
                    Swal.fire({
                        icon: "warning",
                        title: "Invalid Age",
                        text: "Age must be a number (max 3 digits).",
                        background: "rgb(20, 20, 20)",
                        color: "rgb(240, 240, 240)",
                        confirmButtonColor: "rgb(62, 216, 255)"
                    });
                    $('#age').val('');
                    return;
                }
                else {
                    const frm = new FormData();
                    frm.append("method", "saveUser");
                    frm.append('username', username);
                    frm.append('studentid', studentid);
                    frm.append('fullname', fullname);
                    frm.append("gradesection", gradesection);
                    frm.append("course", course);
                    frm.append('age', age);
                    axios.post("handler.php", frm)
                        .then(function (response) {
                            if (response.data.ret == 1) {
                                Swal.fire({
                                    icon: "success",
                                    title: "You're now officially enrolled",
                                    background: "rgb(20, 20, 20)",
                                    color: "rgb(240, 240, 240)",
                                    confirmButtonColor: "rgb(62, 216, 255)"
                                });
                                $('#username').val('');
                                $('#studentid').val('');
                                $('#fullname').val('');
                                $('#age').val('');
                                $('#gradesection').val('');
                                $('#course').val('');
                            }
                        })
                }
            })
            $('.js-example-basic-single').select2();
        });
    </script>
</body>

</html>