<?php 
$this->load->library('session');
$n = $this->session->userdata('name');
$i = $this->session->userdata('i');
$id = $this->session->userdata('person_id');
$row = $this->login_model->getdata_by_id($id);
$d=$this->login_model->pages();


?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Page</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-XXX" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
    // Assuming $row is the variable containing user data fetched from the database
    if (isset($row->name)) {
      echo "<h3>{$row->name}</h3>";
    }
    ?>
    <button class="btn btn-dark" onclick="closePopup()">Close </button>
  </div>

    
    <div class="m-4">
      <div class="row">
        <!-- Total Users Card -->
        <div class="col-xl-3 col-md-6 mb-4">
          <div class="card border-left-danger shadow h-100 py-2 ">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Total Users</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalUsers ?></div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-users fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Admin Card -->
        <div class="col-xl-3 col-md-6 mb-4">
          <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Admin</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalAdminUsers ?></div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-user-shield fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Managers Card -->
        <div class="col-xl-3 col-md-6 mb-4">
          <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Managers</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalManagerUsers ?></div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-user-circle fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- IT Support Card -->
        <div class="col-xl-3 col-md-6 mb-4">
          <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">IT Support</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalITSupportUsers ?></div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-desktop fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="m-4">
      <div class="row">
        <!-- HR Card -->
        <div class="col-xl-3 col-md-6 mb-4">
          <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">HR</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalHRUsers ?></div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-briefcase fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Senior Developer Card -->
        <div class="col-xl-3 col-md-6 mb-4">
          <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Senior Developer</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalSeniorDeveloperUsers ?></div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-user-tie fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Accountant Card -->
        <div class="col-xl-3 col-md-6 mb-4">
          <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Accountant</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalAccountantUsers ?></div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-money-check-alt fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Trainee Card -->
        <div class="col-xl-3 col-md-6 mb-4">
          <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Trainee</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalTraineeUsers ?></div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-graduation-cap fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
 
    <!-- Bar Chart Section -->
    <div class="card shadow mb-4 ml-3 mr-3" style="height: 300px;">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-dark">User Bar Chart</h6>
      </div>
      <div class="card-body">
        <div class="table">
          <div class="text-center">
            <!-- Adjust the height of the canvas element -->
            <canvas style="max-height:100%;" id="barChart"></canvas>
          </div>
        </div>
      </div>
    </div>

    <div class="row">

      <!-- Doughnut Chart for User Roles -->
      <div class="col-md-6 mb-4">
        <div class="card shadow m-3">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-dark">User Doughnut Chart</h6>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <h5 class="card-title text-center">User Roles Distribution</h5>
              <canvas id="userRolesChart" style="width: 100%; height: auto;"></canvas>
            </div>
          </div>
        </div>
      </div>
      <!--pie chart-->
      <div class="col-md-6 mb-4">
        <div class="card shadow m-3">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-dark">User Polar Chart</h6>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <h5 class="card-title text-center">User Gender Distribution</h5>
              <canvas id="genderChart" style="width: 100%; height: 100%;"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>

    
      
    <!--dount chart-->
    <script>
      var roles = ['TotalUsers','Admin', 'Managers', 'IT Support', 'HR', 'Senior Developer', 'Accountant', 'Trainee'];
      var userCounts = [
        <?=$totalUsers?>,
        <?= $totalAdminUsers ?>,
        <?= $totalManagerUsers ?>,
        <?= $totalITSupportUsers ?>,
        <?= $totalHRUsers ?>,
        <?= $totalSeniorDeveloperUsers ?>,
        <?= $totalAccountantUsers ?>,
        <?= $totalTraineeUsers ?>
      ];

      var ctx = document.getElementById('userRolesChart').getContext('2d');
      var userRolesChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
          labels: roles,
          datasets: [{
            data: userCounts,
            backgroundColor: [  
              '#FF5733', 
              '#33A2FF', 
              '#3361FF',
              '#FFD933', 
              '#FF3333', 
              '#33FF57', 
              '#3333FF', 
              '#FF33A2'
            ]
          }]
        },
        options: {
          legend: {
            display: true,
            position: 'bottom'
          }
        }
      });
    </script>

    <!--bar chart-->
    <script>
      // Sample data for the bar chart
      var barChartData = {
        labels: ['Total Users', 'Admin', 'Managers', 'IT Support', 'HR', 'Senior Developer', 'Accountant', 'Trainee'],
        datasets: [{
          label: 'Number of Users',
          backgroundColor: ['#FF5733', '#33A2FF', '#3361FF', '#FFD933', '#FF3333', '#33FF57', '#3333FF', '#FF33A2'],
          data: [<?= $totalUsers ?>, <?= $totalAdminUsers ?>, <?= $totalManagerUsers ?>, <?= $totalITSupportUsers ?>, <?= $totalHRUsers ?>, <?= $totalSeniorDeveloperUsers ?>, <?= $totalAccountantUsers ?>, <?= $totalTraineeUsers ?>]
        }]
      };

      // Bar chart options
      var barChartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          x: {
            beginAtZero: true
          },
          y: {
            beginAtZero: true
          }
        }
      };

      // Get the bar chart canvas
      var ctxBar = document.getElementById('barChart').getContext('2d');

      // Create the bar chart
      var barChart = new Chart(ctxBar, {
        type: 'bar',
        data: barChartData,
        options: barChartOptions
      });
    </script>



    <!-- Bootstrap JS and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    

    <script>
      // Explicitly set isLoggedIn to true for testing purposes
      const isLoggedIn = true;

      // Function to open the popup
      function openPopup() {
        document.getElementById('overlay').style.display = 'block';
        document.getElementById('popup').style.display = 'block';
      }

      // Function to close the popup
      function closePopup() {
        document.getElementById('overlay').style.display = 'none';
        document.getElementById('popup').style.display = 'none';
      }

      // Add an event listener to close the popup when clicking anywhere on the screen
      document.getElementById('overlay').addEventListener('click', closePopup);

      // Show the popup only if the user is logged in
      if (isLoggedIn) {
        openPopup();
      }
    </script>

<!--polar chart-->
<script>
    // Sample data for gender polar area chart
    var genderPolarData = {
        labels: ['Male', 'Female', 'Others'],
        datasets: [{
            data: [<?php echo $maleUsers; ?>, <?php echo $femaleUsers; ?>, <?php echo $otherGenderUsers; ?>],
            backgroundColor: [
                'rgba(255, 99, 132, 0.7)',
                'rgba(54, 162, 235, 0.7)',
                'rgba(255, 205, 86, 0.7)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 205, 86, 1)'
            ],
            borderWidth: 2,
        }]
    };

    // Configure the gender polar area chart
    var genderPolarConfig = {
        type: 'polarArea',
        data: genderPolarData,
        options: {
            elements: {
                arc: {
                    borderColor: '#fff',
                    borderWidth: 2
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            var label = context.label || '';
                            var value = context.formattedValue || '';
                            label += ': ' + value + ' users';
                            return label;
                        }
                    }
                }
            }
        }
    };

    // Get the canvas element and create the gender polar area chart
    var genderPolarCanvas = document.getElementById('genderChart').getContext('2d');
    new Chart(genderPolarCanvas, genderPolarConfig);
</script>







  </body>
</html>

