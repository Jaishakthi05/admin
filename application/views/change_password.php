<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fc;
        }

        h2 {
            color: #333;
        }

        form {
            max-width: 400px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        label {
            font-weight: bold;
            margin-bottom: 8px;
            display: block;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background: linear-gradient(to bottom, #343a40, #1d2124); /* Dark gradient background for submit button */
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background: linear-gradient(to bottom, #1d2124, #0d1112); /* Dark gradient on hover for submit button */
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

        .tick {
            color: green;
        }

        .cross {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center mt-4 mb-4">Change Password</h2>

        <form action="<?php echo base_url('welcome/change_password'); ?>" method="post" onsubmit="return showSuccessMessage();">
            <!-- Old Password Field -->
            <div class="form-group">
                <label for="old_password">Old Password:</label>
                <div style="position: relative;">
                    <input type="password" class="form-control" id="old_password" name="old_password" required>
                    <button type="button" class="btn btn-outline-secondary eye-icon" onclick="togglePassword('old_password')">
                        <i class="far fa-eye"></i>
                    </button>
                </div>
            </div>

            <!-- New Password Field -->
            <div class="form-group">
                <label for="password">New Password:</label>
                <div style="position: relative;">
                    <input type="password" class="form-control" id="password" name="password" required oninput="validateNewPassword()">
                    <button type="button" class="btn btn-outline-secondary eye-icon" onclick="togglePassword('password')">
                        <i class="far fa-eye"></i>
                    </button>
                </div>
                <!-- Display password strength feedback for New Password -->
                <div id="password-strength"></div>
                <!-- Display ticks and crosses for password requirements -->
                <div id="uppercase-tick"></div>
                <div id="number-tick"></div>
                <div id="special-char-tick"></div>
                <div id="min-length-tick"></div>
            </div>

            <!-- Repeat Password Field -->
            <div class="form-group">
                <label for="repeat_password">Repeat Password:</label>
                <div style="position: relative;">
                    <input type="password" class="form-control" id="repeat_password" name="repeat_password" required oninput="validateRepeatPassword()">
                    <button type="button" class="btn btn-outline-secondary eye-icon" onclick="togglePassword('repeat_password')">
                        <i class="far fa-eye"></i>
                    </button>
                </div>
                <!-- Display feedback for Repeat Password -->
                <div id="repeat-password-feedback"></div>
            </div>

            <!-- Submit and Back Buttons -->
            <div class="form-group">
                <input type="submit" value="Change Password" class="btn btn-dark btn-block">
                <a class="btn btn-danger btn-block" href="<?php echo base_url('Welcome/dashboard');?>">Back</a>
            </div>
        </form>
    </div>

    <script>
        function togglePassword(inputId) {
            var passwordInput = document.getElementById(inputId);
            passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';
        }

        function validateNewPassword() {
    var newPassword = document.getElementById('password').value;
    var passwordStrength = document.getElementById('password-strength');
    var uppercaseTick = document.getElementById('uppercase-tick');
    var numberTick = document.getElementById('number-tick');
    var specialCharTick = document.getElementById('special-char-tick');
    var minLengthTick = document.getElementById('min-length-tick');

    // Password validation
    var passwordRegex = /^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/;

    if (!passwordRegex.test(newPassword)) {
        passwordStrength.style.display = "none"; // Hide the message
        document.getElementById('password').style.borderColor = "red";
    } else {
        passwordStrength.style.display = "block"; // Show the message
        passwordStrength.innerHTML = "Password strength: Strong";
        passwordStrength.style.color = "green";
        document.getElementById('password').style.borderColor = "green";
    }

    // Display ticks and crosses for password requirements
    uppercaseTick.innerHTML = newPassword.match(/[A-Z]/) ? "✔ Uppercase" : "✖ Uppercase";
    uppercaseTick.style.color = newPassword.match(/[A-Z]/) ? "green" : "red";

    numberTick.innerHTML = newPassword.match(/\d/) ? "✔ Number" : "✖ Number";
    numberTick.style.color = newPassword.match(/\d/) ? "green" : "red";

    specialCharTick.innerHTML = newPassword.match(/[@$!%*?&]/) ? "✔ Special Character" : "✖ Special Character";
    specialCharTick.style.color = newPassword.match(/[@$!%*?&]/) ? "green" : "red";

    minLengthTick.innerHTML = newPassword.length >= 6 ? "✔ Minimum 6 characters" : "✖ Minimum 6 characters";
    minLengthTick.style.color = newPassword.length >= 6 ? "green" : "red";
}


        function validateRepeatPassword() {
            var newPassword = document.getElementById('password').value;
            var repeatPassword = document.getElementById('repeat_password').value;
            var repeatPasswordFeedback = document.getElementById('repeat-password-feedback');

            // Check if the new password and repeat password match
            if (newPassword !== repeatPassword) {
                repeatPasswordFeedback.innerHTML = "New password and repeat password do not match.";
                repeatPasswordFeedback.style.color = "red";
                document.getElementById('repeat_password').style.borderColor = "red";
            } else {
                repeatPasswordFeedback.innerHTML = "Passwords match.";
                repeatPasswordFeedback.style.color = "green";
                document.getElementById('repeat_password').style.borderColor = "green";
            }
        }

        function showSuccessMessage() {
            var newPassword = document.getElementById('password').value;
            var repeatPassword = document.getElementById('repeat_password').value;

            if (newPassword !== repeatPassword) {
                alert("New password and repeat password do not match!");
                return false;
            }

            var passwordRegex = /^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/;
            
            if (!passwordRegex.test(newPassword)) {
                alert("Password must contain at least one uppercase letter, one number, one special character, and be at least 6 characters long.");
                return false;
            }

            alert("Password changed successfully!");
            return true;
        }
    </script>
</body>
</html>
