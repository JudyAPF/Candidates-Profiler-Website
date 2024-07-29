<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Candidates Profiler</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
  <style>
    /* Add shadow to the container */
    .container-box {
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
      padding: 20px;
      border-radius: 10px;
    }

    /* Center the heading */
    .center-heading {
      text-align: center;
    }
  </style>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
  <script src="https://kit.fontawesome.com/97f8e8674e.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.all.min.js"></script>
  <script>
    $(document).ready(function() {
      // Initialize DataTable
      var dataTable = $("#myTable").DataTable();

      // Add Candidate Button Click Event
      $("#addCandidateBtn").click(function() {
        Swal.fire({
          title: 'Add Candidate',
          html: '<form id="addCandidateForm">' +
            '<div class="form-group">' +
            '<label for="firstname">First Name</label>' +
            '<input type="text" class="form-control" id="firstname" name="firstname" required>' +
            '</div>' +
            '<div class="form-group">' +
            '<label for="lastname">Last Name</label>' +
            '<input type="text" class="form-control" id="lastname" name="lastname" required>' +
            '</div>' +
            '<div class="form-group">' +
            '<label for="mi">Middle Initial</label>' +
            '<input type="text" class="form-control" id="mi" name="mi">' +
            '</div>' +
            '<div class="form-group">' +
            '<label for="sex">Sex</label>' +
            '<select class="form-control" id="sex" name="sex" required>' +
            '<option value="Male">Male</option>' +
            '<option value="Female">Female</option>' +
            '</select>' +
            '</div>' +
            '<div class="form-group">' +
            '<label for="address">Address</label>' +
            '<input type="text" class="form-control" id="address" name="address" required>' +
            '</div>' +
            '<div class="form-group">' +
            '<label for="party">Party</label>' +
            '<select class="form-control" id="party" name="party" required>' +
            '<option value=""></option>' +
            '<option value="1-PACMAN">1-PACMAN</option>' +
            '<option value="1-RIDER PARTYLIST">1-RIDER PARTYLIST</option>' +
            '<option value="4PS">4PS</option>' +
            '<option value="AAMBIS-OWA">AAMBIS-OWA</option>' +
            '<option value="ABANG LINGKOD">ABANG LINGKOD</option>' +
            '<option value="ABONO">ABONO</option>' +
            '<option value="ACT TEACHERS">ACT TEACHERS</option>' +
            '<option value="ACT-CIS">ACT-CIS</option>' +
            '<option value="AGAP">AGAP</option>' +
            '<option value="AGIMAT">AGIMAT</option>' +
            '</select>' +
            '</div>' +
            '<div class="form-group">' +
            '<label for="picture">Picture</label>' +
            '<input type="file" class="form-control" id="picture" name="picture" accept=".jpg, .jpeg, .png" required>' +
            '</div>' +
            '</form>',
          showCancelButton: true,
          confirmButtonText: 'Add Candidate',
          preConfirm: () => {
            const formData = new FormData(document.getElementById('addCandidateForm'));

            // Send the form data to the server using AJAX
            $.ajax({
              type: 'POST',
              url: 'create.php',  
              data: formData,
              processData: false,
              contentType: false,
              dataType: 'json', // Expect JSON response
              success: function(response) {
                if (response.status === 'success') {
                  // Show a success message
                  Swal.fire('Candidate Added!', response.message, 'success');

                  // Destroy the DataTable instance and reinitialize it
                  if ($.fn.DataTable.isDataTable("#myTable")) {
                    $("#myTable").DataTable().destroy();
                  }

                  dataTable = $("#myTable").DataTable();
                } else {
                  Swal.fire('Error', response.message, 'error');
                }
              },
              error: function() {
                Swal.fire('Error', 'Failed to connect to the server.', 'error');
              }
            });
          }
        });
      });
    });
  </script>
</head>

<body>
  <div class="container mt-5">
    <div class="row">
      <div class="col-md-8 mx-auto">
        <div class="container-box p-4">
          <h1 class="center-heading mb-4">Candidates Profiler</h1>
          <button class="btn btn-primary mb-3" id="addCandidateBtn">Add Candidate</button>
          <div class="table-responsive"> <!-- Add this div for responsiveness -->
            <table id="myTable" class="table table-bordered">
              <thead>
                <tr>
                  <th>Firstname</th>
                  <th>Lastname</th>
                  <th>MI</th>
                  <th>Sex</th>
                  <th>Address</th>
                  <th>Party</th>
                  <th>Picture</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php
                require "config.php";
                $dataset = $connect->query("select * from candidates") or die("error");
                while ($row = $dataset->fetch_assoc()) {
                ?>
                  <tr>
                    <td><?php echo $row['firstname']; ?></td>
                    <td><?php echo $row['lastname']; ?></td>
                    <td><?php echo $row['mi']; ?></td>
                    <td><?php echo $row['sex']; ?></td>
                    <td><?php echo $row['address']; ?></td>
                    <td><?php echo $row['party']; ?></td>
                    <td> <?php echo '<img src="' . $row['picture'] . '" width="100" height="100" alt="Candidate Picture">';?></td>
                    <td>
                      <a href="update.php?id=<?php echo $row['idno']; ?>" ><i class="fas fa-pen"></i></a>
                      <a href="delete.php?id=<?php echo $row['idno']; ?>"><i class="fas fa-trash"></i></a>
                      <a href="read.php?id=<?php echo $row['idno']; ?>"><i class="fa-solid fa-eye"></i></a>
                    </td>

                  </tr>
                <?php
                }
                $dataset->free_result();
                $connect->close();
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>