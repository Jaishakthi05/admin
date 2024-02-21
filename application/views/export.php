<?php 
$d=$this->login_model->pages();
$g=$this->login_model->color();

 $btns=explode(',',$d[2]->buttons);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload App</title>

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 20px;
        }

        .btn-dark {
        margin-bottom: 5px;
        border-radius: 5px;
        background: linear-gradient(to bottom, #343a40, #1d2124); /* Dark gradient background for primary button */
        color: #ffffff; /* Text color for the primary button */
        border: 1px solid #343a40; /* Border color for the primary button */
        }

        h1 {
            margin-bottom: 20px;
            font-size: 2.5rem;
            color: dark;
        }

        table {
            width: 100%;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        th,
        td {
            text-align: center;
            padding: 15px;
        }

        thead {
            background-color: #007bff;
            color: #fff;
        }

        tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }

        .file-link {
            color: #007bff;
            text-decoration: none;
        }

        .file-link:hover {
            text-decoration: underline;
        }

        .modal-dialog {
            max-width: 80%;
            margin: 1.75rem auto; 
        }

        .modal-content {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .modal-body img {
            width: auto;
            height: auto;
        }
    </style>
</head>

<body>

<!-- <a href="<?php echo site_url('welcome/excel2'); ?>" class="btn btn-success right">Export to Excel</a> -->


    <div class="container">
        
    <!-- <form action="<?php echo site_url('welcome/importExcel'); ?>" method="post" enctype="multipart/form-data">
        <label for="excelFile">Select Excel File:</label>
        <input type="file" name="excelFile" id="excelFile" accept=".xlsx, .xls">
        <button type="submit">Import</button>
    </form> -->
    <!-- <a href="#" id="exportToExcel" class="btn btn-success right">Export to Excel</a> -->
<a href="<?php echo base_url('welcome/excel2'); ?>" class="btn btn-success right">Export to Excel</a>

   
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-<?php echo $g[0]->color;?>">Export</h3>
        </div>
        <table class="table table-bordered">
            <thead class="thead-light">
            <tr>

                <!-- <?php 
                $x=explode(',',$d[2]->thead);

                
                foreach($x as $i){ ?>
                        <th><?php echo $i;?></th>
                    
                <?php }?> -->

                        <th>Name</th>
                        <th>Files</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Access</th>
                        </tr>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($records as $row) {
                    $fileNames = json_decode($row->file_name);
                    if ($fileNames !== null && count($fileNames) > 0) { ?>
                        <tr>
                            <td><?php echo $row->name; ?></td>
                            <td>
                                <?php
                                foreach ($fileNames as $fileName) {
                                    $encoded_url = base_url('uploads/' . urlencode($fileName));
                                    echo '<a href="#" class="file-link" data-file-url="' . $encoded_url . '"><i class="fas fa-external-link-alt"></i>' . $fileName . '</a><br>';
                                }
                                ?>
                            </td>
                            <td><?php echo $row->email; ?></td>
                            <td><?php echo $row->role; ?></td>
                            <td><?php echo $row->access; ?></td>



                        </tr>
                    <?php }
                } ?>
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div id="fileModal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">File Viewer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <iframe id="fileViewer" width="100%" height="600px" frameborder="0"></iframe>
                </div>
            </div>
        </div>
    </div>
                <!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">

<!-- DataTables JS -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        $('.table').DataTable();
    });
</script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>

 
       
        $(document).ready(function () {
            $('.file-link').click(function (e) {
                e.preventDefault(); 

                var fileUrl = $(this).data('file-url');

                $('#fileViewer').attr('src', fileUrl);

                $('#fileModal').modal('show');
            });

            $('.close, #fileModal').click(function () {
                $('#fileModal').modal('hide');
            });
        });
    </script>
</body>

</html>
