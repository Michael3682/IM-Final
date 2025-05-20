<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="design2.css">
</head>

<body>
    <div class="view-section">
        <h1>Enrolled Student List</h1>
        <table class="students-list-container">
        </table>
        <button id="back" type="button" onclick="window.location.href='index.php'">Back</button>
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
                                            <th>Student ID</th>    
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
                                                <td>${user.studentid}</td>
                                                <td>${user.fullname}</td>
                                                <td>${user.course}</td>
                                                <td>${user.gradesection}</td>
                                                <td>${user.age}</td>
                                            </tr>`;
                            });
                            // <td>
                            //     <button class="btnEdit" data-id="${user.id}">Edit</button>
                            //     <button class="btnDelete" data-id="${user.id}">Delete</button>
                            // </td>
                            $('.students-list-container').html(userHtml);
                        } else {
                            Swal.fire({
                                icon: "info",
                                title: "Oops...",
                                text: response.data.message

                            });
                        }
                    })
                    .catch(function (error) {
                        console.error("Error fetching users:", error);
                    });
            }
            list();
            $(document).on('click', '.btnDelete', function (event) {
                event.preventDefault();
                const userId = $(this).data('id');
                if (confirm("Are you sure you want to delete this user?")) {
                    const frm = new FormData();
                    frm.append("method", "deleteUser");
                    frm.append("id", userId);
                    axios.post("handler.php", frm)
                        .then(function (response) {
                            if (response.data.retval == 1) {
                                alert("Data Deleted Successfully");
                                list();
                            }
                        });
                }
            });
        });
    </script>
</body>

</html>