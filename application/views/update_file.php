<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
</head>

<style>
        body {
            background-color: #f8f9fa;
            color: black; /* Set default text color */
        }

        .container {
            max-width: 600px;
            margin: auto;
            margin-top: 50px;
        }
    </style>
<body>

<div class="container">
    <?php echo form_open_multipart(base_url('welcome/file_upload/'), 'id="uploadForm" onsubmit="return showSuccessMessage();"'); ?>

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

    <?php 
    if (isset($file_name->name) && isset($file_name->files)) {
        $data = json_decode($file_name->files, true); 
        if (!empty($data)) {
            echo '<div>';
            foreach ($data as $filename) {
                $imagePath = base_url('uploads/') . $filename;
                echo "<br><a href='{$imagePath}' class='image-link' data-file='{$filename}'>{$filename}</a><br>";
            }
            echo '</div>';
        } else {
            echo '<p class="text-center pt-3" style="color: red;">No files uploaded yet!</p>';
        }
    } 
    ?>
</div>



<script>

function showSuccessMessage() {
        // Your existing code for form validation or other actions

        // After successful form submission, redirect to the previous page
        window.history.back();

        // Make sure to return false to prevent the default form submission
        return false;
    }

    
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
</script>
</body>
</html>
