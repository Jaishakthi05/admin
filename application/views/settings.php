    <?php
    $g = $this->login_model->color();
    $x = $this->login_model->color();
    $selectedColor = $x[0]->color; // Retrieve the saved color from the database

    $d=$this->login_model->pages();
    $btns=explode(',',$d[5]->buttons);


    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Data Table</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
        
        <style>
            body {
                background-color: #f8f9fa;
            }

            header {
                margin-bottom: 10px;
            }

            h1 {
                margin-bottom: 0;
                font-size: 24px;
            }

            .container {
                margin-top: 10px;
            }

            .btn-dark {
                margin-bottom: 5px;
                border-radius: 5px;
                background: linear-gradient(to bottom, #343a40, #1d2124);
                color: #ffffff;
                border: 1px solid #343a40;
            }

            .btn-dark:hover {
                background: linear-gradient(to bottom, #1d2124, #0d1112);
                border-color: #1d2124;
            }

            .btn-danger {
                border-radius: 5px;
                margin-bottom: 5px;
            }

            .card {
                border: none;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }

            .table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
            }

            th,
            td {
                border: 1px solid #dddddd;
                text-align: left;
                padding: 12px;
            }

            th {
                background-color: #f2f2f2;
            }

            .eye-icon {
                cursor: pointer;
                border: none;
                background: transparent;
                padding: 0;
                color: #007bff;
            }

            .eye-icon:focus {
                outline: none;
            }

            .password-input {
                border: none;
                background: transparent;
                width: calc(100% - 30px);
                margin-right: -30px;
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
        </style>
    </head>

    <body>

        <div class="container">

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h3 class="m-0 font-weight-bold text-<?php echo $g[0]->color; ?>"><?php echo $d[5]->title;?></h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <form method="post" action="<?php echo base_url('welcome/update_theme'); ?>" enctype="multipart/form-data">

                            <div class="container-fluid">
                                <div class="row justify-content-center">
                                    <div class="col-lg-7 form-container">

                                        <?php
                                            $row = $this->login_model->color();
                                            $img = $row[0]->logo; 
                                            $imageSource = (strpos($img, "https") === 0) ? $img : base_url('uploads/') . $img; 

                                        ?>

                                        <img id="preview" class="img-profile rounded-circle" src="<?= $imageSource ?>" alt="Profile Picture">
                                        
                                        <div class="form-body">
                                            <label for="page_title">Page Title:</label>
                                            <input type="text" class="form-control" id="page_title" name="page_title" value="<?php echo $x[0]->title; ?>">
                                        </div>

                                        <div class="form-body">
                                            <label for="page_footer">Page Footer:</label>
                                            <input type="text" class="form-control" id="page_footer" name="page_footer" value="<?php echo $x[0]->footer; ?>">
                                        </div>
                                        
                                        <!-- Logo Upload -->
                                        <div class="form-body">
                                            <label for="logo">Upload Logo:</label>
                                            <input type="file" name="fileuploadpicture"  class="form-control" id="logo" onchange="preview(this)"  >                                            
                                        </div> 

                                        <!-- Color Change Option -->
                                        <div class="form-group">
                                            <label for="color">Select Color:</label>
                                            <select class="form-control" id="color" name="color">
                                                <option value="" selected>Select your Color</option>
                                                <option value="success" <?php echo ($selectedColor == 'success') ? 'selected' : ''; ?>>Success</option>
                                                <option value="danger" <?php echo ($selectedColor == 'danger') ? 'selected' : ''; ?>>Danger</option>
                                                <option value="info" <?php echo ($selectedColor == 'info') ? 'selected' : ''; ?>>Info</option>
                                                <option value="dark" <?php echo ($selectedColor == 'dark') ? 'selected' : ''; ?>>Dark</option>
                                                <option value="warning" <?php echo ($selectedColor == 'warning') ? 'selected' : ''; ?>>Warning</option>
                                                <option value="primary" <?php echo ($selectedColor == 'primary') ? 'selected' : ''; ?>>Primary</option>
                                            </select>
                                        </div>


                                        <div class="form-row text-center">
                                            <div class="col-md-6 mb-3 mx-auto">
                                                <input type="submit" class="btn btn-<?php echo $x[0]->color; ?> btn-block" value="<?php echo $btns[0];?>" onclick="validateForm()">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <script src="path/to/bootstrap.js"></script>
        <script>
    function preview(input) {
        console.log('Preview function called');

        var preview = document.getElementById('preview');
        console.log('Preview element:', preview);

        var file = input.files[0];
        console.log('Selected file:', file);

        var reader = new FileReader();

        reader.onloadend = function () {
            console.log('Reader result:', reader.result);
            preview.src = reader.result;
        };

        if (file) {
            reader.readAsDataURL(file);
        } else {
            console.log('No file selected');
            preview.src = "";
        }
    }
</script>


        <!-- Include the JavaScript code for saving the color -->
        <script>
            function validateForm() {
                // Add any validation logic if needed

                // Get the selected color value
                var selectedColor = document.getElementById('color').value;

            }
        </script>



    </body>
</html>
