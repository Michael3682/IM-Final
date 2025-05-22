<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="studentlistdesign.css">
</head>

<body>
    <div class="view-section">
        <h1>Enrolled Student List</h1>
        <table class="students-list-container">
        </table>
        <button id="back" type="button" onclick="window.location.href='form.php'">Back</button>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        $(document).ready(function () {
            function list() {
                const frm = new FormData();
                frm.append("method", "readUsers");
                axios.post("handler.php", frm)
                    .then(function (response) {
                        if (response.data.retval == 1) {
                            let users = response.data.users;
                            let userHtml = `
                                        <tr class="student-table">
                                            <th>Id</th> 
                                            <th>Full Name</th>
                                            <th>Course</th>
                                            <th>Grade & Section</th>
                                            <th>Age</th>
                                        </tr>
                                        `;
                            users.forEach(function (user) {
                                userHtml += `
                                            <tr class="student-list">
                                                <td>${user.id}</td>
                                                <td>${user.fullname}</td>
                                                <td>${user.course}</td>
                                                <td>${user.gradesection}</td>
                                                <td>${user.age}</td>
                                            </tr>
                                            `;
                            });
                            $('.students-list-container').html(userHtml);
                        } else {
                            Swal.fire({
                                toast: true,
                                position: 'bottom-right',
                                showConfirmButton: false,
                                timer: 1500,
                                timerProgressBar: true,
                                icon: "info",
                                iconColor: "rgb(0, 0, 0)",
                                title: "No Enrolled Students",
                                background: "rgb(43, 210, 252)",
                                color: "rgb(0, 0, 0)"
                            });
                        }
                    })
                    .catch(function (error) {
                        console.error("Error fetching users:", error);
                    });
            }
            list();
        });
    </script>
</body>

</html>