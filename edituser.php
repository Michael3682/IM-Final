<?php
require_once('dbcontroller.php');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$db = new DbController();
$user = [];

if ($db->getState()) {
    $conn = $db->getDb();
    $stmt = $conn->prepare("SELECT * FROM studentenrollment WHERE id = :id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "<h2 style='color:red;'>User not found.</h2>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="formDesign.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
</head>

<body>

    <form action="#" method="POST">
        <div class="form-section">
            <h1>Update User Data</h1>
            <input type="hidden" id="id" value="<?= htmlspecialchars($user['id']) ?>">
            <div class="form-group">
                <div class="form-label">
                    <label for="username">Username</label>
                </div>
                <div class="form-input">
                    <input type="text" name="username" id="username" value="<?= htmlspecialchars($user['username']) ?>"
                        readonly>
                </div>
            </div>

            <div class="form-group">
                <div class="form-label">
                    <label for="studentid">Student ID</label>
                </div>
                <div class="form-input">
                    <input type="text" name="studentid" id="studentid" maxlength="7"
                        value="<?= htmlspecialchars($user['studentid']) ?>" placeholder="Ex. (1234567)">
                </div>
            </div>

            <div class="form-group">
                <div class="form-label">
                    <label for="fullname">Full Name</label>
                </div>
                <div class="form-input">
                    <input type="text" name="fullname" id="fullname" value="<?= htmlspecialchars($user['fullname']) ?>"
                        placeholder="Family name, First name and Middle name">
                </div>
            </div>

            <div class="form-group">
                <div class="form-label">
                    <label for="course">Course</label>
                </div>
                <select id="course" name="course" class="js-example-basic-single">
                    <option value="BEED" <?= $user['course'] == 'BEED' ? 'selected' : '' ?>>BEED - Bachelor of Elementary
                        Education</option>
                    <option value="BSED" <?= $user['course'] == 'BSED' ? 'selected' : '' ?>>BSED - Bachelor of Secondary
                        Education</option>
                    <option value="BSHM" <?= $user['course'] == 'BSHM' ? 'selected' : '' ?>>BSHM - Bachelor of Science in
                        Hospitality Management</option>
                    <option value="BSIT" <?= $user['course'] == 'BSIT' ? 'selected' : '' ?>>BSIT - Bachelor of Science in
                        Information Technology</option>
                </select>
            </div>

            <div class="group-container">
                <div class="form-group">
                    <div class="form-label">
                        <label for="gradesection">Grade & Section</label>
                    </div>
                    <select id="gradesection" name="gradesection" class="js-example-basic-single">
                        <?php
                        $sections = ['1A', '1B', '1C', '1D', '2A', '2B', '2C', '2D', '3A', '3B', '3C', '3D', '4A', '4B', '4C', '4D'];
                        foreach ($sections as $section) {
                            $selected = $user['gradesection'] == $section ? 'selected' : '';
                            echo "<option value=\"$section\" $selected>$section</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <div class="form-label">
                        <label for="age">Age</label>
                    </div>
                    <div class="form-input">
                        <input type="text" name="age" id="age" maxlength="3"
                            value="<?= htmlspecialchars($user['age']) ?>">
                    </div>
                </div>
            </div>
            <div class="btn-container">
                <button type="button" id="btnUpdate">Update</button>
                <button type="button" onclick="window.location.href='adminpanel.php'">Cancel</button>
            </div>
        </div>
    </form>

    <canvas id="canvas"></canvas>
    <script src="bg.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#btnUpdate').click(function () {
                const id = $('#id').val();
                const studentid = $('#studentid').val().trim();
                const fullname = $('#fullname').val().trim();
                const course = $('#course').val();
                const gradesection = $('#gradesection').val();
                const age = $('#age').val().trim();
                const username = $('#username').val();

                if (!studentid || !fullname || !course || !gradesection || !age) {
                    Swal.fire({
                        toast: true,
                        position: 'bottom-right',
                        showConfirmButton: false,
                        timer: 1500,
                        timerProgressBar: true,
                        icon: "warning",
                        iconColor: "rgb(0, 0, 0)",
                        title: "Oops...",
                        text: "Please fill out all the fields!",
                        background: "rgb(20, 20, 20)",
                        color: "rgb(240, 240, 240)"
                    });
                    return;
                }

                const frm = new FormData();
                frm.append("method", "updateUser");
                frm.append("id", id);
                frm.append("studentid", studentid);
                frm.append("fullname", fullname);
                frm.append("course", course);
                frm.append("gradesection", gradesection);
                frm.append("age", age);
                frm.append("username", username);
                frm.append("password", "");

                axios.post("handler.php", frm)
                    .then(function (response) {
                        if (response.data.ret == 1) {
                            Swal.fire({
                                toast: true,
                                position: 'bottom-right',
                                showConfirmButton: false,
                                timer: 1500,
                                timerProgressBar: true,
                                icon: "success",
                                iconColor: "rgb(0, 0, 0)",
                                title: "Updated successfully!",
                                background: "rgb(20, 20, 20)",
                                color: "rgb(240, 240, 240)"
                            }).then(() => {
                                window.location.href = "adminpanel.php";
                            });
                        } else {
                            Swal.fire("Update failed", response.data.message || "", "error");
                        }
                    })
                    .catch(function (err) {
                        console.error(err);
                        Swal.fire("Error occurred", "", "error");
                    });
            });
        });
    </script>
</body>

</html>