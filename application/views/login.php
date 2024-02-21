<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>TW Login</title>

    <!-- Custom fonts for this template-->
    <link href="<?php echo base_url();?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?php echo base_url();?>assets/css/sb-admin-2.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(to bottom, #343a40, #1d2124) no-repeat fixed; 
            background-size: cover;
            color: #fff; 
        }

        .card {
            border-radius: 15px;
        }

        .btn-google {
            background-color: #ea4335;
            color: #fff;
        }

        .password-toggle {
            position: relative;
        }

        .password-input {
            padding-right: 30px; /* Adjust as needed */
        }

        .eye-icon {
            position: absolute;
            top: 50%;
            right: 10px; /* Adjust as needed */
            transform: translateY(-50%);
            cursor: pointer;
            color: grey; /* Set the color to blue or your preferred color */
        }
    </style>

    <!-- Add reCAPTCHA script -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

</head>

<body class="bg-gradient-dark">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center mb-4">

            <div class="col-lg-6">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-12"> <!-- Set to take up the entire width -->
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                    </div>
                                    <form action="<?php echo base_url('Welcome/check');?>" method="post" class="user" onsubmit="return onSubmitForm();">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" id="email" placeholder="EMAIL" name="email" required>
                                        </div>

                                        <div class="form-group password-toggle">
        <input type="password" class="form-control form-control-user password-input"
            id="exampleInputPassword" placeholder="PASSWORD" name="password" required>
        <i class="eye-icon fas fa-eye" onclick="togglePasswordVisibility('exampleInputPassword', 'eyeIcon3')"></i>
    </div>

                                        <!-- Add reCAPTCHA widget with centering -->
                                        <div class="text-center mb-3">
                                            <div class="g-recaptcha" data-sitekey="6LdCBGApAAAAADZktl60ahfVHRXePrr79Yj6yXC2"></div>
                                        </div>

                                        <button type="submit" name="login" class="btn btn-dark btn-user btn-block">Login</button>
                                        <hr>
                                        <a href="<?php echo base_url('Welcome/google_login');?>" class="btn btn-google btn-user btn-block">
                                            <i class="fab fa-google fa-fw"></i> Login with Google
                                        </a>

                                        <hr>
                                        <a href="<?php echo base_url('Welcome/facebook_login');?>" class="btn btn-facebook btn-user btn-block">
                                            <i class="fab fa-facebook-f fa-fw"></i> Login with Facebook
                                        </a>
                                        <hr>
                                        <div style="text-align: center;">
                                            <a href="<?php echo base_url('Welcome/forgot_password');?>" style="color: blue; text-decoration: underline;">Forgot password</a>
                                            <br><br>
                                            <a href="<?php echo base_url('Welcome/register_page');?>" style="color: blue; text-decoration: underline;">Create an Account</a>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?php echo base_url();?>assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url();?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?php echo base_url();?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?php echo base_url();?>assets/js/sb-admin-2.min.js"></script>

    <!-- Additional JavaScript -->
    <script>
        function onSubmitForm() {
            var response = grecaptcha.getResponse();

            if (response.length == 0) {
                alert('Please complete the captcha.');
                return false;
            }

            return true;
        }
    </script>

<script>
        function togglePasswordVisibility(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const eyeIcon = document.querySelector(`#${iconId}`);

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>

</html>
