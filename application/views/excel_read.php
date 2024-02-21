<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excel Upload</title>
</head>
<body>
    <?php $this->load->view('header'); ?>

    <h2>Excel Upload</h2>
    <form action="<?php echo base_url('welcome/excel_upload'); ?>" method="post" enctype="multipart/form-data">
    <label for="file">Select File:</label>
    <input type="file" name="pic" id="file" accept=".xls, .xlsx, .docx, .pdf">
    <!-- Note: "pic[]" is used as the name to handle multiple file uploads -->
    <br>
    <input type="submit" value="Upload">
</form>


    <?php $this->load->view('footer'); ?>
</body>
</html>


