<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="studentlistdesign.css">
</head>

<body>
    <nav>
        <a id="#logout" href="index.php">Log out</a>
    </nav>
    <div class="view-section">
        <h1>Enrolled Student List</h1>
        <table class="students-list-container">
        </table>
        <button id="back" type="button" onclick="window.location.href='form.php'">Back</button>
    </div>
    
    <canvas id="canvas"></canvas>
    <script src="bg.js"></script>
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
                                                <td>
                                                    <button type="button" class="btnEdit" data-id="${user.id}">Edit</button>
                                                    <button type="button" class="btnDelete" data-id="${user.id}">Delete</button>
                                                </td>
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
                                icon: "error",
                                iconColor: "rgb(0, 0, 0)",
                                title: "Error fetching users",
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
            $(document).on('click', '.btnEdit', function () {
                const id = $(this).data('id');
                window.location.href = `edituser.php?id=${id}`;
            })
            $(document).on('click', '.btnDelete', function () {
                const id = $(this).data('id');
                Swal.fire({
                    toast: true,
                    position: 'bottom-right',
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    cancelButtonColor: "rgb(0, 101, 126)",
                    iconColor: "rgb(0, 0, 0)",
                    confirmButtonText: "Yes, delete it!",
                    background: "rgb(43, 210, 252)",
                    color: "rgb(0, 0, 0)",
                    confirmButtonColor: "rgb(0, 0, 0)"
                }).then((result) => {
                    if (result.isConfirmed) {
                        const frm = new FormData();
                        frm.append("method", "deleteUser");
                        frm.append("id", id);
                        axios.post("handler.php", frm)
                            .then(function (response) {
                                console.log(response.data.ret);
                                if (response.data.ret == 1) {
                                    Swal.fire({
                                        toast: true,
                                        position: 'bottom-right',
                                        showConfirmButton: false,
                                        timer: 1500,
                                        timerProgressBar: true,
                                        icon: "success",
                                        iconColor: "rgb(0, 0, 0)",
                                        title: "User deleted successfully",
                                        background: "rgb(43, 210, 252)",
                                        color: "rgb(0, 0, 0)"
                                    }).then(() => {
                                        location.reload();
                                        list();
                                    });
                                } else {
                                    Swal.fire({
                                        toast: true,
                                        position: 'bottom-right',
                                        showConfirmButton: false,
                                        timer: 1500,
                                        timerProgressBar: true,
                                        icon: "error",
                                        iconColor: "rgb(0, 0, 0)",
                                        title: "Error deleting user",
                                        background: "rgb(43, 210, 252)",
                                        color: "rgb(0, 0, 0)"
                                    });
                                }
                            })
                            .catch(function (error) {
                                console.error("Error deleting user:", error);
                            });
                    }
                });
            });
        });
    </script>
</body>

</html>