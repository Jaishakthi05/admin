<?php
$d = $this->login_model->pages();
$btns = explode(',', $d[0]->buttons);
$g = $this->login_model->color();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Data Table</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

    <!-- DataTables CSS -->
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

        /* DataTables Wrapper */
        .dataTables_wrapper {
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <div class="container">
        <a href="<?php echo base_url('Welcome/add_user'); ?>" class="btn btn-<?php echo $g[0]->color; ?> btn-sm mb-2"><i class="fas fa-user-plus"></i><?php echo $btns[0]; ?></a>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h3 class="m-0 font-weight-bold  font-size-24 text-<?php echo $g[0]->color; ?>"><?php echo $d[0]->title; ?></h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="dataTable">
                        <thead>
                            <?php
                            $x = explode(',', $d[0]->thead);
                            foreach ($x as $i) {
                                echo "<th>{$i}</th>";
                            }
                            ?>
                        </thead>
                        <tbody>
                            <?php foreach ($records as $row) { ?>
                                <tr>
                                    <td><?php echo $row->name; ?></td>
                                    <td><?php echo $row->email; ?></td>
                                    <td><?php echo $row->gender; ?></td>
                                    <td><?php echo $row->role; ?></td>
                                    <td><?php echo $row->father_name; ?></td>
                                    <td><?php echo $row->mother_name; ?></td>
                                    <td><?php echo $row->country; ?></td>
                                    <td><?php echo $row->mobile; ?></td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="<?php echo base_url('Welcome/edit_user/' . $row->id); ?>" class="btn btn-sm btn-dark btn-md mr-1"><?php echo $btns[1]; ?></a>
                                            <button onclick="confirmDelete(<?php echo $row->id; ?>)" class="btn btn-sm btn-danger btn-md"><?php echo $btns[2]; ?></button>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function () {
            // DataTable initialization
            $('#dataTable').DataTable();
        });

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
    </script>
</body>

</html>
