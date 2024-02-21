
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
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
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
</head>

<body class="bg-gradient-dark">

<div class="container">
        <div class="row justify-content-center mb-4">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                                </div>
                                <form class="user" method="post" action="<?= base_url('welcome/process_registration') ?>"  onsubmit="return validatePassword()">
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="text" class="form-control form-control-user" id="exampleFirstName" 
                                                name="name" placeholder="First Name" Required>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control form-control-user" id="exampleLastName"
                                            name="father_name" placeholder="Last Name" Required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-user" id="exampleInputEmail" name="email" placeholder="Email Address" required>
                                    </div>


                                    <div class="form-group password-toggle">
    <input type="password" class="form-control form-control-user password-input"
        name="password" id="exampleInputPassword" placeholder="Password">
    <i class="eye-icon fas fa-eye" onclick="togglePasswordVisibility('exampleInputPassword', 'eyeIcon1')"></i>
</div>

<div class="form-group password-toggle">
    <input type="password" class="form-control form-control-user password-input"
        name="Repeat_Password" id="exampleRepeatPassword" placeholder="Repeat Password">
    <i class="eye-icon fas fa-eye" onclick="togglePasswordVisibility('exampleRepeatPassword', 'eyeIcon2')"></i>
</div>


                                    
                                    <button type="submit" class="btn btn-primary btn-user btn-block">Register Account</button>
                                </form>
                                <hr>
                                <a href="<?= base_url('welcome/google_login') ?>" class="btn btn-google btn-user btn-block">
                                    <i class="fab fa-google fa-fw"></i> Register with Google
                                </a>
                                <a href="<?php echo base_url('Welcome/facebook_login');?>" class="btn btn-facebook btn-user btn-block">
                                    <i class="fab fa-facebook-f fa-fw"></i> Register with Facebook
                                </a>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="<?= base_url('welcome/forgot_password') ?>">Forgot Password?</a>
                                </div>
                                <div class="text-center">
                                    <a class="small" href="<?= base_url('welcome/index') ?>">Already have an account? Login!</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add this script in your head or at the end of the body -->


<script>
    function validatePassword() {
        var password = document.getElementById("exampleInputPassword").value;
        var repeatPassword = document.getElementById("exampleRepeatPassword").value;
        var passwordRegex = /^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+]).{8,}$/;

        if (!passwordRegex.test(password)) {
            alert("Password should contain at least one capital letter, one number, and one special character.");
            return false;
        }

        if (password !== repeatPassword) {
            alert("Repeat password should match the original password.");
            return false;
        }

        return true;
    }
</script>

<script>
    function togglePasswordVisibility(inputId, iconId) {
      const passwordInput = document.getElementById(inputId);
      const eyeIcon = document.getElementById(iconId);

      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.classList.remove('fa-eye-slash');
        eyeIcon.classList.add('fa-eye');
      } else {
        passwordInput.type = 'password';
        eyeIcon.classList.remove('fa-eye');
        eyeIcon.classList.add('fa-eye-slash');
      }
    }
  </script>


    <!-- Bootstrap core JavaScript-->
    <script src="<?php echo base_url();?>assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url();?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?php echo base_url();?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?php echo base_url();?>assets/js/sb-admin-2.min.js"></script>
        
</body>

</html>