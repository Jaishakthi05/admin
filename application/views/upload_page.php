<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload Page</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            max-width: 600px;
            margin: auto;
            margin-top: 50px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .selected-files {
            margin-top: 10px;
        }
        .btn-dark {
    transition: background 0.3s; 
    background: linear-gradient(to bottom, #343a40, #1d2124); 
    color: #ffffff; 
    border: 1px solid #343a40; 
}


.btn-dark:hover {
    background: linear-gradient(to bottom, #1d2124, #0d1112); 
    border-color: #1d2124; 
    color: #ffffff; 
}


        h3 {
            text-align: center;
        }

        
      


     
        .alert {
            margin-top: 20px;
        }
    </style>
</head>

<body>

<div class="container mt-4">
    <h3 class="mb-4">File Upload</h3>

    <?php if ($this->session->flashdata('error')) { ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $this->session->flashdata('error'); ?>
        </div>
    <?php } ?>

    <?php echo form_open_multipart(base_url('welcome/file_upload'), 'id="uploadForm" onsubmit="return showSuccessMessage();"'); ?>

    <div class="form-group">
        <label for="userfile">Choose File:</label>
        <div class="custom-file">
            <input type="file" name="userfile[]" class="custom-file-input" id="customFile" onchange="updateFileName(this)" multiple>
            <label class="custom-file-label" for="customFile">Choose file</label>
        </div>
    </div>

    <div class="selected-files" id="selectedFiles"></div>

    <button type="submit" name="submit" value="Upload" class="btn btn-dark">Upload</button>

    <?php echo form_close(); ?>

</div>

<!-- Bootstrap Modal for Success Message -->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Success</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="successMessage"></p>
            </div>
            
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

<script>
    function updateFileName(input) {
        var files = input.files;
        var label = input.nextElementSibling;
        var selectedFilesDiv = document.getElementById('selectedFiles');
        var validFileExtensions = ['gif', 'jpeg', 'jpg', 'png', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'csv', 'zip', 'rar', 'tar', '7z', 'mp3', 'mp4', 'avi', 'mkv'];

        if (files.length === 0) {
            label.innerHTML = 'Choose file';
            selectedFilesDiv.innerHTML = '';
        } else {
            var invalidFiles = Array.from(files).filter(file => {
                var fileExtension = file.name.split('.').pop().toLowerCase();
                return !validFileExtensions.includes(fileExtension);
            });

            if (invalidFiles.length > 0) {
                alert("Invalid file type selected. Please choose valid file types: " + validFileExtensions.join(', '));
                input.value = '';
                label.innerHTML = 'Choose file';
                selectedFilesDiv.innerHTML = '';
            } else {
                var fileList = Array.from(files).map(file => file.name).join(', ');
                label.innerHTML = fileList;
                selectedFilesDiv.innerHTML = '<strong>Selected Files (' + files.length + '):</strong> ' + fileList;
            }
        }
    }

    function showSuccessMessage() {
        var files = document.getElementById('customFile').files;

        if (files.length === 0) {
            alert("Please select a file before uploading.");
            return false;
        }

        var fileList = Array.from(files).map(file => file.name).join(', ');
        var successMessage = "File(s) uploaded successfully: " + fileList;

        $('#successMessage').text(successMessage);
        $('#successModal').modal('show');

        $('#successModal').on('hidden.bs.modal', function (e) {
            window.location.href = "<?php echo base_url('welcome/file_upload');?>";
        },3000);
    }
</script>

</body>

</html>
