<?php
$g=$this->login_model->color();


$d=$this->login_model->pages();
$btns=explode(',',$d[6]->buttons);

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
    background: linear-gradient(to bottom, #343a40, #1d2124); /* Dark gradient background for primary button */
    color: #ffffff; /* Text color for the primary button */
    border: 1px solid #343a40; /* Border color for the primary button */
}

.btn-dark:hover {
    background: linear-gradient(to bottom, #1d2124, #0d1112); /* Dark gradient on hover for primary button */
    border-color: #1d2124; /* Border color on hover for primary button */
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

        .form-group label {
            font-weight: bold; /* Make the label bold */
            font-size:20px;
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
    </style>
</head>

<body>

    <div class="container">

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h3 class="m-0 font-weight-bold text-<?php echo $g[0]->color;?>"><?php echo $d[6]->title;?></h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <?php echo form_open('welcome/dictionary_update', 'id="registrationForm"'); ?>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-7 form-container">

            <div class="form-body">
                <div class="form-group">
                    <label for="name">Pages:</label>
                    <select name="name" id="name" class="form-control" required>
                        <?php foreach ($d as $i) { ?>
                            <option value="<?php echo $i->side_menu ?>"><?php echo $i->side_menu; ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-row text-center">
                    <div class="col-md-6 mb-3 ">
                        <input type="submit" class="btn btn-<?php echo $g[0]->color;?> btn-block" value="<?php echo $btns[0];?>" onclick="validateForm()">
                    </div>

                    <div class="col-md-6 mb-3">
                                <a href="javascript:history.go(-1)" class="btn btn-danger btn-block">Back</a>
                            </div>
                </div>
                <?php echo form_close(); ?>
                        
                      
                    </table>
                </div>
            </div>
        </div>
    </div>

</body>

</html>

