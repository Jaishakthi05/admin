<?php 
$this->load->library('session');
$n = $this->session->userdata('name');
$i = $this->session->userdata('i');
$id = $this->session->userdata('person_id');
$row = $this->login_model->getdata_by_id($id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome Page</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <style>
    body {
      background-color: #f8f9fa; /* Set a light background color */
    }

    #popup {
      display: none;
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      padding: 60px; /* Increase the padding for a larger popup */
      background-color: #ffffff;
      border: 1px solid #ced4da;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
      z-index: 1000;
      max-width: 800px; /* Increase the max-width to make the popup larger */
      border-radius: 10px; /* Add rounded corners */
    }

    #overlay {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      z-index: 900;
    }

    #popup h3 {
      color: black; /* Set a primary color for headings */
    }

    #popup button {
      margin-top: 20px;
    }
  </style>
</head>
<body>

<div id="overlay"></div>
<div id="popup" class="text-center">
  <h3 id="welcomeMessage">Welcome </h3>
  <?php
  if (isset($row->name)) {
    echo "<h3>{$row->name}</h3>";
  }
  ?>
  <button class="btn btn-dark" onclick="closePopup()">Close </button>
</div>


<!-- Bootstrap JS and Popper.js -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- Font Awesome Icons -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>

<script>
  window.onload = function() {
    showPopup();
  };

  function showPopup() {
    document.getElementById("popup").style.display = "block";
    document.getElementById("overlay").style.display = "block";
  }

  function closePopup() {
    document.getElementById("popup").style.display = "none";
    document.getElementById("overlay").style.display = "none";
  }
</script>

</body>
</html>
