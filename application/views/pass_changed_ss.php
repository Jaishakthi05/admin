<!-- pass_changed_ss.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Password Reset Successful</title>
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Include jQuery UI for a simple modal -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <!-- Custom styles for the modal -->
    <style>
        .ui-dialog-titlebar {
            display: none;
        }
        .ui-dialog-content {
            font-size: 16px;
            padding: 20px;
        }
    </style>
</head>
<body>

<script>
    // Display a modal with the success message
    $(document).ready(function () {
        $("#success-modal").dialog({
            modal: true,
            buttons: {
                Ok: function () {
                    $(this).dialog("close");
                }
            },
            close: function () {
                // Perform additional actions after closing the modal
            }
        });
    });
</script>

<div id="success-modal" title="Password Reset Successful">
    <p>Your password has been reset successfully. Please check your email for the new password.</p>
</div>

</body>
</html>
