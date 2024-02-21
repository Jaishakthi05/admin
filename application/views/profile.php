<?php
$this->load->library('session');
$n = $this->session->userdata('name');
$i = $this->session->userdata('i');
$id = $this->session->userdata('person_id');
$g=$this->login_model->color();

$this->session->set_userdata('page', 'Profile Page');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link rel="stylesheet" href="path/to/bootstrap.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            max-width: 800px;
        }

        .card {
            border: none;
        }

        .card-header {
            color: transparent;
            border-radius: 8px;
            text-align: center;
        }

        .card-body {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .img-profile {
            margin-top: 20px;
            margin-bottom: 20px;
            width: 200px;
            height: 200px;
            display: block;
            margin-left: auto;
            margin-right: auto;
            border-radius: 50%;
            border: 2px solid blue; 
        }

        h4 {
            color: #333;
        }

        label {
            font-weight: bold;
        }

        input[type="file"] {
            display: none;
        }

        .custom-file-upload {
            cursor: pointer;
            padding: 10px 15px;
            display: inline-block;
            background-color: #ffc107;
            color: #fff;
            border-radius: 5px;
        }

        button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            text-decoration: none;
            border: 1px solid #4e4e4e;
            border-radius: 5px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        /* Hover styles for all buttons */
        button:hover {
            transform: translateY(-2px);
            box-shadow: 0px 6px 10px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3 m-2">
                <h3 class="m-0 font-weight text-<?php echo $g[0]->color;?>">Profile Page</h3>
            </div>
            <div class="card-body">
                <div class="container-lg text-center">
                <?php
                    $row = $this->login_model->getdata_by_id($id);
                    $img = $row->pic;

                    // Check if the user has uploaded a profile picture
                    if (!empty($img)) {
                        $imageSource = (strpos($img, "https") === 0) ? $img : base_url('uploads/') . $img;
                    } else {
                        // If there's no image, display a default circular image
                        $imageSource = base_url('uploads/default.jpg');
                    }
                    ?>

                    <img id="previewImage" class="img-profile rounded-circle" src="<?= $imageSource ?>" alt="Profile Picture">


                        <form action="<?= base_url('welcome/dashboard_img') ?>" method="post" enctype="multipart/form-data" onsubmit="return showUploadSuccess()">
                            <label for="fileUpload" class="custom-file-upload">Choose your profile picture</label>
                            <input type="file" id="fileUpload" name="pic" onchange="previewImage(this)"><br>
                            <button type="submit" class="btn btn-sm btn-success mt-2" id="uploadButton" >Upload</button>
                        </form>


<br>
<form action="<?= base_url('welcome/remove_profile') ?>" method="post" id="removeProfileForm" onsubmit="return confirmRemoveProfile()">
    <button type="submit" class="btn btn-sm btn-danger mt-2">Remove Profile Picture</button>
</form>

                    <div class="container mt-4">
                        <h4>Name: <?= $row->name ?></h4>
                        <h4>Gender: <?= $row->gender ?></h4>
                        <h4>Email: <?= $row->email  ?></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- ... (previous code) ... -->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    function confirmRemoveProfile() {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You will not be able to recover your profile picture!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, remove it!',
            cancelButtonText: 'No, keep it'
        }).then((result) => {
            if (result.isConfirmed) {
                // If the user clicks "Yes, remove it," submit the form
                document.getElementById('removeProfileForm').submit();
            }
        });

        // Prevent the form from being submitted immediately
        return false;
    }
</script>

    <script src="path/to/bootstrap.js"></script>
    <script>
        function previewImage(input) {
            var preview = document.getElementById('previewImage');
            var file = input.files[0];
            var reader = new FileReader();

            reader.onloadend = function () {
                preview.src = reader.result;
            }

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = "";
            }
        }
    </script>


<script>
    function showUploadSuccess() {
        var fileInput = document.getElementById('fileUpload');
        var uploadButton = document.getElementById('uploadButton');

        if (!fileInput.files.length) {
            Swal.fire({
                icon: 'error',
                title: 'Please select a file before uploading.',
                showConfirmButton: false,
                timer: 2000 // Adjust the duration of the error message (in milliseconds)
            });
            return false; // Prevent form submission
        }

        // If a file is selected, proceed with the success message
        Swal.fire({
            icon: 'success',
            title: 'Profile picture uploaded successfully!',
            showConfirmButton: false,
            timer: 2000 // Adjust the duration of the success message (in milliseconds)
        });

        // Disable the button to prevent accidental clicks

        // Allow form submission
        return true;
    }
</script>


</body>

</html>

