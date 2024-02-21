
<?php 
$d=$this->login_model->pages();
$g=$this->login_model->color();

 $btns=explode(',',$d[3]->buttons);
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
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <!-- jQuery UI Datepicker CSS -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <style>
        body {
            background-color: #f8f9fa;
        }

        header {
            margin-bottom: 5px;
        }

        h1 {
            margin-bottom: 0;
            font-size: 24px;
        }

        .container {
            margin-top: 5px;
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

        .dataTables_wrapper {
            margin-top: 20px;
        }

        .datepicker {
            width: 100%;
        }

        .search-buttons-container {
            margin-top: 3px;
        }

        .search-buttons-container .btn-primary {
            margin-top: 0px;
            margin-right: 10px;
        }

        .search-buttons-container .btn-secondary {
            margin-top: 0px;
            margin-right:2px;
        }
    </style>
</head>

<body>
    
    <div class="container">
        <div class="row mb-">
            <div class="col-md-3 search-buttons-container">
                <!-- Filter button triggers the modal -->
                <button class="btn btn-<?php echo $g[0]->color;?>" id="filterButton" data-toggle="modal" data-target="#filterModal"><i class="fas fa-filter"></i><?php echo $btns[0];?></button>
                <!-- Main Reset Button -->
                <button type="button" class="btn btn-secondary" id="mainResetButton"><i class="fas fa-undo"></i> <?php echo $btns[1];?></button>
            </div>

            <!-- Filter Modal -->
            <div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="filterModalLabel">Filter Options</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Your filter options go here -->
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label for="nameSearch">Name</label>
                                    <input type="text" class="form-control" id="nameSearch">
                                </div>
                                <div class="col-md-3">
                                    <label for="actionSearch">Action</label>
                                    <input type="text" class="form-control" id="actionSearch">
                                </div>
                                <div class="col-md-3">
                                    <label for="pageSearch">Page</label>
                                    <input type="text" class="form-control" id="pageSearch">
                                </div>
                                <div class="col-md-3">
                                    <label for="messageSearch">Message</label>
                                    <input type="text" class="form-control" id="messageSearch">
                                </div>

                                <div class="col-md-3">
                                    <label for="fromDate">From Date</label>
                                    <input type="text" class="form-control datepicker" id="fromDate" placeholder="From">
                                </div>
                                <div class="col-md-3">
                                    <label for="toDate">To Date</label>
                                    <input type="text" class="form-control datepicker" id="toDate" placeholder="To ">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <!-- Search and Reset buttons -->
                            <button type="button" class="btn btn-primary" id="searchButton">  <i class="fas fa-search"></i> Search</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <!-- Modal Reset Button -->
                            <button type="button" class="btn btn-secondary" id="modalResetButton">Reset</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow mt-4">
            <div class="card-header py-3">
                <h3 class="m-0 font-weight-bold text-<?php echo $g[0]->color;?>">Logs</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="dataTable">
                        <thead>
                        <tr>

                            <?php 
                            $x=explode(',',$d[3]->thead);

                            
                            foreach($x as $i){ ?>
                                    <th><?php echo $i;?></th>
                                
                            <?php }?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($records as $row) { ?>
                                <tr>
                                    <td><?php echo $row->name; ?></td>
                                    <td><?php echo $row->action; ?></td>
                                    <td><?php echo $row->page; ?></td>
                                    <td><?php echo $row->message; ?></td>
                                    <td><?php echo $row->timestamp; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- jQuery UI Datepicker JS -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script>
        $(document).ready(function () {
            var dataTable = $('#dataTable').DataTable({
                "order": [[4, "desc"]]
            });

            $('.datepicker').datepicker({
                dateFormat: 'yy-mm-dd',
                onSelect: function () {
                    updateTable();
                }
            });

            $('#filterButton').on('click', function () {
                $('#filterModal').modal('show');
            });

            // Main Reset Button
            $('#mainResetButton').on('click', function () {
                resetFilters();
            });

            // Filter Modal Reset Button
            $('#modalResetButton').on('click', function () {
                resetFilters();
            });

            $('#searchButton').on('click', function () {
                $('#filterModal').modal('hide');
                updateTable();
            });

            function updateTable() {
                dataTable.columns(0).search($('#nameSearch').val()).draw();
                dataTable.columns(1).search($('#actionSearch').val()).draw();
                dataTable.columns(2).search($('#pageSearch').val()).draw();
                dataTable.columns(3).search($('#messageSearch').val()).draw();

                var fromDate = $('#fromDate').val();
                var toDate = $('#toDate').val();

                if (fromDate !== '' && toDate !== '') {
                    dataTable.columns(4).search(fromDate, toDate).draw();
                }
            }

            function resetFilters() {
                $('#nameSearch, #actionSearch, #pageSearch, #messageSearch, #fromDate, #toDate').val('');
                dataTable.columns().search('').draw();
            }
        });
    </script>
</body>

</html>
