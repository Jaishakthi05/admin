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
            background: linear-gradient(to bottom, #343a40, #1d2124);
            color: #ffffff;
            border: 1px solid #343a40;
        }

        .btn-dark:hover {
            background: linear-gradient(to bottom, #1d2124, #0d1112);
            border-color: #1d2124;
            color: #ffffff;
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
                    <h2 class="form-title"><?php echo $f->side_menu ?></h2>
                </div>
                <div class="form-body">
                    <form id="form" action="<?php echo base_url('Welcome/dict_update');?>" method="post">
                        <input type="hidden" name="user_id" value="<?php echo $f->id; ?>">

                        <div class="form-group">
                            <?php if (!empty($f->title)): ?>
                                <label for="title"><?php echo $f->title;?>:</label>
                                <input type="text" class="form-control" name="title" id="title" value="<?php echo $f->title; ?>" >
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <?php if (!empty($f->side_menu)): ?>
                                <label for="side_menu"><?php echo $f->side_menu; ?>:</label>
                                <input type="text" class="form-control" name="side_menu" id="side_menu" value="<?php echo $f->side_menu; ?>" >
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <?php $values = explode(',', $f->thead);
                            foreach($values as $i):
                                if (!empty($i)): ?>
                                    <label for="thead"><?php echo $i; ?>:</label>
                                    <input type="text" class="form-control" name="thead[]" value="<?php echo $i; ?>" >
                                <?php endif;
                            endforeach; ?>
                        </div>

                        <div class="form-group">
                            <?php $values = explode(',', $f->buttons);
                            foreach($values as $i):
                                if (!empty($i)): ?>
                                    <label for="buttons"><?php echo $i; ?>:</label>
                                    <input type="text" class="form-control" name="buttons[]" value="<?php echo $i; ?>" >
                                <?php endif;
                            endforeach; ?>
                        </div>

                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <button type="submit" id="updateButton" class="btn btn-dark btn-block">Update</button>
                            </div>
                            <div class="col-md-6 mb-3">
                                <a href="javascript:history.go(-1)" class="btn btn-danger btn-block">Back</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
