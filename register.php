<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
        <button id="btnRegister" type="button">Register</button>
        <button type="button" onclick="window.location.href='index.php'">Login</button>
    </form>

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
                        icon: 'warning',
                        title: 'Fields required',
                        background: "rgb(20, 20, 20)",
                        color: "rgb(240, 240, 240)",
                        showConfirmButton: false,
                        timer: 1000
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
                            icon: 'warning',
                            title: 'Username already exists',
                            background: "rgb(20, 20, 20)",
                            color: "rgb(240, 240, 240)",
                            showConfirmButton: false,
                            timer: 1000
                        });
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
                                        icon: "success",
                                        title: "You're now officially registered",
                                        background: "rgb(20, 20, 20)",
                                        color: "rgb(240, 240, 240)",
                                        showConfirmButton: false,
                                        timer: 1000
                                    }).then(() => {
                                        window.location.href = "index.php";
                                    })
                                }
                                else {
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Something went wrong',
                                        background: "rgb(20, 20, 20)",
                                        color: "rgb(240, 240, 240)",
                                        showConfirmButton: false,
                                        timer: 1000
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