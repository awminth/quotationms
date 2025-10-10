<?php
include('config.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quotation MS</title>

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="<?php echo roothtml . 'lib/plugins/fontawesome-free/css/all.min.css' ?>">
    <link rel="stylesheet" href="<?php echo roothtml . 'lib/plugins/icheck-bootstrap/icheck-bootstrap.min.css' ?>">
    <link rel="stylesheet" href="<?php echo roothtml . 'lib/dist/css/adminlte.min.css' ?>">
    <link rel="shortcut icon" href="<?php echo roothtml . 'lib/images/naiip.jpg' ?>" />
    <link href="<?php echo roothtml . 'lib/sweet/sweetalert.css' ?>" rel="stylesheet" />
    <script src="<?php echo roothtml . 'lib/sweet/sweetalert.min.js' ?>"></script>
    <script src="<?php echo roothtml . 'lib/sweet/sweetalert.js' ?>"></script>

    <style>
    /* Custom styles for the new beautiful design */
    body {
        overflow: hidden;
        /* Prevent scrollbars from appearing when content doesn't fit */
         /* font-family: Arial, Helvetica, sans-serif; */
       font-family: "Times New Roman", Times, serif;
    }

    .login-container {
        min-height: 100vh;
        /* Ensure the container takes full viewport height */
    }

    /* --- BACKGROUND IMAGE SIDE MODIFICATION --- */
    .login-image-side {
        /* background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('<?php echo roothtml . 'lib/images/header2.jpg' ?>'); */
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        /* Make sure it takes the full height of its parent (login-container) */
        height: 100vh;
        /* This ensures it takes the full viewport height */
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: white;
        position: relative;
        /* Added for positioning text/logo */
        z-index: 1;
        /* Ensure content is above background if needed */
    }

    .login-form-side {
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f4f6f9;
        /* Light grey background */
        height: 100vh;
        /* Also ensure the form side takes full viewport height */
    }

    .login-box-custom {
        width: 100%;
        max-width: 550px;
    }

    .card {
        border-radius: 15px;
        /* Rounded corners for the card */
        border: none;
    }

    /* Loading Spinner Styles (Unchanged from original) */
    .loader {
        position: fixed;
        z-index: 999;
        height: 100%;
        width: 100%;
        top: 0;
        left: 0;
        background-color: Black;
        filter: alpha(opacity=60);
        opacity: 0.7;
        -moz-opacity: 0.8;
    }

    .center-load {
        z-index: 1000;
        margin: 300px auto;
        padding: 10px;
        width: 130px;
        background-color: black;
        border-radius: 10px;
        filter: 1;
        -moz-opacity: 1;
    }

    .center-load img {
        height: 128px;
        width: 128px;
    }
    </style>

</head>

<body>

    <div class="container-fluid">
        <div class="row g-0 login-container">

            <div class="col-lg-6 d-none d-lg-flex login-image-side">
                <div>
                    <img src="<?php echo roothtml.'lib/images/naiip.jpg' ?>" alt="Logo"
                        style="width: 80%;height:auto; margin-bottom: 30px;">
                    <h1 class="font-weight-bold text-info">Quotation Management System</h1>
                    <p class="lead text-success">Your Partner in Digital Transformation</p>
                </div>
            </div>

            <div class="col-lg-6 col-md-12 login-form-side bg-secondary">
                <div class="login-box-custom p-4">
                    <div class="card shadow-lg">
                        <div class="card-body p-5">
                            <div class="text-center mb-4">
                                <h3>Welcome Back!</h3>
                                <p class="text-muted">Please sign in to continue</p>
                            </div>

                            <form id="frm" method="post">
                                <div class="input-group mb-4">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" class="form-control form-control-lg" value="admin"
                                        name="username" placeholder="Username">
                                </div>
                                <div class="input-group mb-4">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" name="password" value="1"
                                        class="form-control form-control-lg" placeholder="Password">
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="icheck-primary">
                                            <input type="checkbox" id="remember">
                                            <label for="remember">
                                                Remember Me
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <!-- <a href="#" class="float-right">Forgot Password?</a> -->
                                    </div>
                                </div>
                                <div class="d-grid mt-4">
                                    <button type="submit" id="btnlogin" class="btn btn-primary btn-lg btn-block">Sign
                                        In</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="loader" style="display:none;">
        <div class="center-load">
            <img src="<?php echo roothtml . 'lib/images/ajax-loader1.gif'; ?>" />
        </div>
    </div>

    <script src="<?php echo roothtml . 'lib/plugins/jquery/jquery.min.js' ?>"></script>
    <script src="<?php echo roothtml . 'lib/plugins/bootstrap/js/bootstrap.bundle.min.js' ?>"></script>
    <script src="<?php echo roothtml . 'lib/dist/js/adminlte.min.js' ?>"></script>
    <script>
    $(document).ready(function() {
        // Your AJAX login script (Unchanged)
        $(document).on("click", "#btnlogin", function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: "<?php echo roothtml . 'index_action.php' ?>",
                data: $("#frm").serialize() + "&action=login",
                beforeSend: function() {
                    $(".loader").show();
                },
                success: function(data) {
                    $(".loader").hide();
                    if (data == 1) {
                        swal("Successful!",
                            "Login Successful.",
                            "success");
                        // Redirect after a short delay to show the success message
                        setTimeout(function() {
                            location.href =
                                "<?php echo roothtml . 'home/home.php' ?>";
                        }, 1000);
                    } else {
                        swal("Error!",
                            "User Name or Password incorrect.",
                            "error");
                    }
                }
            });
        });
    });
    </script>
</body>

</html>