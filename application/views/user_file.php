<?php 
$d=$this->login_model->user_pages();
$g=$this->login_model->color();

 $btns=explode(',',$d[1]->buttons);


 $id = $this->session->userdata('id');

if ($id) {
    // User is logged in, fetch documents for the logged-in user
    $records = $this->login_model->get_user_documents($id);
}
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

        .btn-upload {
            margin-bottom: 10px;
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
            max-width: 100%;
            height: auto;
        }
    </style>
</head>

<body>

    <div class="container">
   

        <a href="<?php echo base_url('Welcome/file_upload'); ?>" class="btn btn-<?php echo $g[0]->color;?> btn-upload"><i
                class="fas fa-cloud-upload-alt"></i> <?php echo $btns[0];?></a>

        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-<?php echo $g[0]->color;?>"><?php echo $d[1]->title;?></h3>
        </div>
        <table class="table table-bordered">
            <thead class="thead-light">
            <tr>

                <?php 
                $x=explode(',',$d[1]->thead);

                
                foreach($x as $i){ ?>
                        <th><?php echo $i;?></th>
                    
                <?php }?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($records as $row) {
                    $fileNames = json_decode($row->file_name);
                    if ($fileNames !== null && count($fileNames) > 0) { ?>
                        <tr>
                            <!-- <td><?php echo $row->id; ?></td> -->
                            <td><?php echo $row->name; ?></td>
                            <td>
                                <?php
                                foreach ($fileNames as $fileName) {
                                    $encoded_url = base_url('uploads/' . urlencode($fileName));
                                    echo '<a href="#" class="file-link" data-file-url="' . $encoded_url . '"><i class="fas fa-external-link-alt"></i>' . $fileName . '</a><br>';
                                }
                                ?>
                            </td>
                            <td>
                                <a href="<?php echo base_url('Welcome/update_file/' . $row->id); ?>"
                                    class="btn btn-sm btn-dark btn-md mr-1"><?php echo $btns[1];?></a>
                                <button onclick="confirmDelete(<?php echo $row->id; ?>)"
                                    class="btn btn-sm btn-danger btn-md"><?php echo $btns[2];?></button>
                            </td>
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

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then(handleConfirmation);

            function handleConfirmation(result) {
                if (result.isConfirmed) {
                    deleteItem(id);
                }
            }

            function deleteItem(id) {
                $.ajax({
                    url: "<?php echo base_url('Welcome/delete_user/'); ?>" + id,
                    type: 'POST',
                    success: function (response) {
                        Swal.fire({
                            title: "Deleted!",
                            text: "Your file has been deleted.",
                            icon: "success"
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function (xhr, status, error) {
                        Swal.fire('Error!', 'Failed to delete the item.', 'error');
                        console.error(xhr, status, error);
                    }
                });
            }
        }

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
