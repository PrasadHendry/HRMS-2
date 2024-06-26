<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function showPass() {
            var x = document.getElementById("password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
    <title>login form</title>
</head>

<body>
    <section class="vh-100" style="background-color: hsl(219, 98%, 62%);">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow-2-strong" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">
                            <div class="mb-md-5 mt-md-4 pb-5">
                                <form id="login-form" class="form" action="login.php" method="POST">

                                    <h3 class="mb-5">Sign in</h3>
                                    <?php
                                    if (isset($_GET["lerr"])) {
                                        $login_error = $_GET["lerr"];
                                        if($login_error == 1)
                                            echo "<div class='alert alert-danger' role='alert'> User does not exist!</div>";

                                        else if($login_error == 2)
                                            echo "<div class='alert alert-danger' role='alert'> Password is invalid</div>";

                                        else if($login_error == 3)
                                            echo "<div class='alert alert-warning' role='alert'> Session has expired. Please login again</div>";
                                    }

                                    ?>

                                    <div class="form-floating mb-4">
                                        <input type="text" id="username" name="username" class="form-control form-control-lg" placeholder="Username" />
                                        <label class="form-label" for="username">Username</label>
                                    </div>

                                    <div class="form-floating mb-4">
                                        <input type="password" id="password" name="password" class="form-control form-control-lg" placeholder="Password" />
                                        <label class="form-label" for="password">Password</label>
                                    </div>

                                    <!-- Checkbox -->
                                    <div class="form-check d-flex justify-content-start mb-4">
                                        <input class="form-check-input" type="checkbox" value="" id="form1Example3" onclick="showPass()" />
                                        <label class="form-check-label" for="form1Example3"> &nbsp; Show password
                                        </label>
                                    </div>
                                    <div class="pt-1 mb-4">
                                        <button class="btn btn-outline-primary btn-medium w-100 rounded-5 text-uppercase" type="submit">Login</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>

</html>