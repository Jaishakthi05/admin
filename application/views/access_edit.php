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
    background: linear-gradient(to bottom, #000000, #34495e);
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


    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-7 form-container">
                <div class="form-header">
                    <h2 class="form-title">Edit Access</h2>
                </div>
                <div class="form-body">
                    <form id="form" action="<?php echo base_url('Welcome/update_access/'.$n->id);?>" method="post">
                        <input type="hidden" name="user_id" value="<?php echo $n->id; ?>">

                        <div class="form-group">
                            <label for="email">Name:</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="<?php echo $n->name; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="<?php echo $n->email; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="role">Role:</label>
                            <select name="role" class="form-control" value="<?php echo $n->role; ?>" required>
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
                            <label for="access">Access:</label>
                            <select name="access" class="form-control" required>
                                <option value="" selected disabled>Select Access</option>
                                <option value="HR">HR</option>
                                <option value="manager">Manager</option>
                                <option value="senior developer">Senior Developer</option>
                            </select>
                        </div>

                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <button type="button" id="updateButton" class="btn btn-dark btn-block">Update</button>
                            </div>
                            <div class="col-md-6 mb-3">
                                <!--<a class="btn btn-danger btn-block" href="<?php echo base_url('Welcome/show'); ?>">Back</a>-->
                                <a href="javascript:history.go(-1)" class="btn btn-danger btn-block">Back</a>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    $(document).ready(function () {
        $("#updateButton").click(function () {
            // Trigger the AJAX form submission when the button is clicked
            submitForm();
        });

        // Function to submit the form using AJAX
        function submitForm() {
            $.ajax({
                type: "POST",
                url: $("#form").attr("action"),
                data: $("#form").serialize(),
                success: function (response) {
                    // Show SweetAlert success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Access Changed',
                        text: 'Access has been successfully changed.',
                        showConfirmButton: false,
                        timer: 2000 // Display for 3 seconds
                    }).then(() => {
                        // Redirect after the message is closed
                        window.location.href = '<?php echo base_url("Welcome/access_show"); ?>';
                    });
                },
                error: function (error) {
                    // Handle the error if the AJAX request fails
                    console.error('Error:', error);
                    // You may want to show an error message to the user here
                }
            });
        }
    });
</script>


</body>

</html>
