    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Edit User</title>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body {
                background-color: #f8f9fa;
            }

            .container-fluid {
                padding-top: 50px;
            }

            .form-container {
                background-color: #ffffff;
                border-radius: 10px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }

            .form-header {
        background: linear-gradient(to bottom, #343a40, #1d2124); /* Dark gradient background */
        color: #ffffff;
        border-radius: 10px 10px 0 0;
        padding: 20px;
        text-align: center;
    }

            .form-title {
                margin-bottom: 0;
            }

            .form-body {
                padding: 30px;
            }

            .form-group {
                margin-bottom: 20px;
            }

            .btn-dark {
        border-radius: 5px;
        margin-bottom: 5px;
        background: linear-gradient(to bottom, #343a40, #1d2124); /* Dark gradient background for the buttons */
        color: #ffffff; /* Text color for the buttons */
        border: 1px solid #343a40; /* Border color for the buttons */
    }

    .btn-dark:hover {
        background: linear-gradient(to bottom, #1d2124, #0d1112); /* Dark gradient on hover */
        border-color: #1d2124; /* Border color on hover */
        color: #ffffff; /* Text color on hover */
    }
            .btn-danger {
                background-color: #dc3545;
                border-color: #dc3545;
            }

            .btn-danger:hover {
                background-color: #bd2130;
                border-color: #bd2130;
            }

            .eye-icon {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        border: none;
        background: transparent;
        padding: 0;
        color: linear-gradient(to bottom, #343a40, #1d2124); /* Dark gradient color for the eye icon */
    }

    .eye-icon:focus {
        outline: none;
    }

        </style>
    </head>

    <body>
   
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-7 form-container">
                    <div class="form-header">
                        <h2 class="form-title">Edit User</h2>
                    </div>
                    <div class="form-body">
                        <form id="form" action="<?php echo base_url('Welcome/update');?>" method="post" onsubmit="return validateForm()">
                            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">

                            <div class="form-group">
                                <label for="email">Name:</label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="<?php echo $name; ?>" required>
                                </div>

                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="<?php echo $user_email; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Password:</label>
                                <div style="position: relative;">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" value="<?php echo $user_password; ?>" required>
                                    <button type="button" class="btn btn-outline-secondary eye-icon" onclick="togglePassword()">
                                        <i class="far fa-eye"></i>
                                    </button>
                                </div>
                            </div>
            
                                
                                <div class="form-group">
                                    <label for="role">Role:</label>
                                    <select name="role" class="form-control" required>
                                        <option value="" selected disabled>Select Role</option>
                                        <option value="admin">Admin</option>
                                        <option value="HR">HR</option>
                                        <option value="manager">Manager</option>
                                        <option value="senior developer">Senior Developer</option>
                                        <option value="accountant">Accountant</option>
                                        <option value="IT Support">IT Support</option>
                                        <option value="Trainee">Trainee</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="gender">Gender:</label>
                                    <select name="gender" class="form-control" value="<?php echo $gender; ?>"required >
                                    <option value="" selected disabled>Select your Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="others">Others</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="father_name">Father's Name:</label>
                                    <input type="text" name="father_name" class="form-control" value="<?php echo $father_name; ?>"required>
                                </div>

                                <div class="form-group">
                                    <label for="mother_name">Mother's Name:</label>
                                    <input type="text" name="mother_name" class="form-control" value="<?php echo $mother_name; ?>" required>
                                </div>


                                <div class="form-group">
                                    <label for="country">Country:</label>
                                    <select name="country" id="country" class="form-control" value="<?php echo $country; ?>" required>
                                        <option value="" selected disabled>Select your country</option>
                                        <option value="USA">United States</option>
                                        <option value="Canada">Canada</option>
                                        <option value="UK">United Kingdom</option>
                                        <option value="India">India</option>
                                        
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="mobile">Mobile Number (with country code):</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="country-code">+1</span>
                                        </div>
                                        <input type="tel" name="mobile" id="mobile" class="form-control" placeholder="Enter your mobile number" value="<?php echo $mobile; ?>" required>
                                    </div>
                                </div>
                                
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <a href="#" id="updateButton" class="btn btn-dark btn-block">Update</a>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <a class="btn btn-danger btn-block" href="<?php echo base_url('Welcome/show'); ?>">Back</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        function showSuccessMessageAndRedirect() {
            alert("User data successfully edited!");
            redirectToShowPage();
        }

        function redirectToShowPage() {
            window.location.href = "<?php echo base_url('Welcome/show'); ?>";
        }

        function validateForm() {
            // Your validation logic here
            return true; // For demonstration purposes, assuming validation is always successful
        }

        function togglePassword() {
            var passwordInput = document.getElementById('password');
            passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';
        }

        $(document).ready(function () {
            $('#updateButton').click(function (e) {
                e.preventDefault();

                if (validateForm()) {
                    $.ajax({
                        type: 'POST',
                        url: $('#form').attr('action'),
                        data: $('#form').serialize(),
                        success: function (data) {
                            showSuccessMessageAndRedirect();
                        },
                        error: function () {
                            // Handle error, if any
                        }
                    });
                }
            });
        });

        $(document).ready(function () {
            $('#country').change(function () {
                var selectedCountry = $(this).val();
                var countryCode;

                switch (selectedCountry) {
                    case 'USA':
                        countryCode = '+1';
                        break;
                    case 'Canada':
                        countryCode = '+1';
                        break;
                    case 'UK':
                        countryCode = '+44';
                        break;
                    case 'India':
                        countryCode = '+91';
                        break;
                }

                $('#country-code').text(countryCode);
            });
        });
    </script>     

    </body>

    </html>
