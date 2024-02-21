<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forgot Password</title>
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background: linear-gradient(to right, #1d2124, #343a40); /* Dark gradient background */
        }

        .container {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            padding: 20px;
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo img {
            max-width: 100%;
            height: 100px;
        }

        h1 {
            text-align: center;
            color: #dc3545; /* Danger color */
        }

        label {
            margin-bottom: 0.5rem;
            color: #495057;
        }

        input {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #dc3545; /* Danger color */
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #c82333; /* Darker Danger color on hover */
        }

        .error {
            color: red;
            margin-bottom: 10px;
        }

        .back-to-login {
            text-align: center;
            margin-top: 10px;
        }

        .back-to-login a {
            color: #007bff; /* Bootstrap primary color */
            text-decoration: none;
        }

        .back-to-login a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="logo">
            <img src="<?= base_url('uploads/logo.png') ?>" alt="Your Logo">
        </div>

        <header>
            <h1>Forgot Password</h1>
        </header>
        
        <div class="error"><?php echo validation_errors() ?></div>
        
        <form method="post" action="<?= base_url('welcome/send_password') ?>">
            <div class="form-group">
                <label for="email">Please enter your account email</label>
                <input type="text" id="email" name="email" class="form-control" placeholder="Your Email">
            </div>
            
            <div class="form-group">
                <input type="submit" value="Send Email" class="btn btn-danger">
            </div>
        </form>

        <div class="back-to-login">
            <a href="<?= base_url('welcome/index') ?>">Back to Login</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>
