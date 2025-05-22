<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="indexregisterdesign.css">
</head>

<body>
    <form action="#" method="POST">
        <h1>Register</h1>
        <div class="form-group">
            <div class="form-label">
                <label for="username">Username</label>
            </div>
            <div class="form-input">
                <input type="text" name="username" id="username" placeholder="Username" required>
            </div>
        </div>
        <div class="form-group">
            <div class="form-label">
                <label for="password">Password</label>
            </div>
            <div class="form-input">
                <input type="password" name="password" id="password" placeholder="Password" required>
            </div>
        </div>
        <div class="btn-container">
            <button id="btnRegister" type="button">Register</button>
            <div class="label">
                <p>Already have an account?</p>
                <button type="button" onclick="window.location.href='index.php'">Login</button>
            </div>
        </div>
    </form>

    <canvas id="canvas"></canvas>
    <script src="bg.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#btnRegister').click(() => {
                const username = $('#username').val();
                const password = $('#password').val();

                if (!username || !password) {
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
                        background: "rgb(43, 210, 252)",
                        color: "rgb(0, 0, 0)"
                    });
                    return;
                }

                const frm = new FormData();
                frm.append("method", "checkUsername");
                frm.append('username', username);
                frm.append('password', password);
                axios.post("handler.php", frm)
                    .then(function (response) {
                        if (response.data.ret == 1) {
                            Swal.fire({
                                toast: true,
                                position: 'bottom-right',
                                showConfirmButton: false,
                                timer: 1500,
                                timerProgressBar: true,
                                icon: "warning",
                                iconColor: "rgb(0, 0, 0)",
                                title: "Username already exist",
                                background: "rgb(43, 210, 252)",
                                color: "rgb(0, 0, 0)"
                            });
                            $("#username").val("");
                            $("#password").val("");
                        }
                        else if (response.data.ret == 0) {
                            const createNewUser = new FormData();
                            createNewUser.append("method", "createNewUser");
                            createNewUser.append('username', username);
                            createNewUser.append('password', password);
                            axios.post("handler.php", createNewUser)
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
                                            title: "Register successfully",
                                            background: "rgb(43, 210, 252)",
                                            color: "rgb(0, 0, 0)"
                                        }).then(() => {
                                            window.location.href = "index.php";
                                        })
                                    }
                                    else {
                                        Swal.fire({
                                            toast: true,
                                            position: 'bottom-right',
                                            showConfirmButton: false,
                                            timer: 1500,
                                            timerProgressBar: true,
                                            icon: "warning",
                                            iconColor: "rgb(0, 0, 0)",
                                            title: "Register failed",
                                            background: "rgb(43, 210, 252)",
                                            color: "rgb(0, 0, 0)"
                                        });
                                    }
                                })
                        }
                    })
            })
        });
    </script>
</body>

</html>