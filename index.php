<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="#" method="POST">
        <h1>Login</h1>
        <div class="form-group">
            <div class="form-label">
                <label for="username">Username</label>
            </div>
            <div class="form-input">
                <input type="text" name="username" id="username" placeholder="Username">
            </div>
        </div>
        <div class="form-group">
            <div class="form-label">
                <label for="password">Password</label>
            </div>
            <div class="form-input">
                <input type="password" name="password" id="password" placeholder="Password">
            </div>
        </div>
        <button id="btnLogin" type="button">Login</button>
        <button type="button" onclick="window.location.href='register.php'">Register</button>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#btnLogin').click(() => {
                const usernameAdmin = $('#username').val();
                const passwordAdmin = $('#password').val();

                if (usernameAdmin == 'admin' && passwordAdmin == 'admin') {
                    Swal.fire({
                        icon: "success",
                        title: "Logged In Successfully",
                        background: "rgb(20, 20, 20)",
                        color: "rgb(240, 240, 240)",
                        showConfirmButton: false,
                        timer: 1000
                    }).then(() => {
                        window.location.href = "adminpanel.php";
                    })
                }
                
                const username = usernameAdmin;
                const password = passwordAdmin;

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
                frm.append("method", "checkLoginUser");
                frm.append("username", username);
                frm.append("password", password);
                axios.post("handler.php", frm)
                    .then(function (response) {
                        if (response.data.ret == 0) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Invalid Username or Password',
                                background: "rgb(20, 20, 20)",
                                color: "rgb(240, 240, 240)",
                                showConfirmButton: false,
                                timer: 1000
                            });
                            console.log("fail");
                        }
                        else if (response.data.ret == 1) {
                            Swal.fire({
                                icon: "success",
                                title: "Logged In Successfully",
                                background: "rgb(20, 20, 20)",
                                color: "rgb(240, 240, 240)",
                                showConfirmButton: false,
                                timer: 1000
                            }).then(() => {
                                window.location.href = "form.php";
                            })
                            console.log("success");
                        }
                    })
            })
        });
    </script>
</body>

</html>