<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Candidate</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        
        body {
            background-color: #f4f4f4;
        }

        .container-box {
            background-color: #ffffff;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
        }

        .center-heading {
            text-align: center;
        }

        .error {
            color: red;
        }

        .custom-padding {
            padding: 25px;
            
        }
    </style>
    <script>
        
        function validateForm() {
            var firstname = document.getElementById("firstname").value;
            var lastname = document.getElementById("lastname").value;
            var sex = document.getElementById("sex").value;
            var address = document.getElementById("address").value;
            var party = document.getElementById("party").value;
            var picture = document.getElementById("picture").value;

            // validation
            var isValid = true;
            var errorMessages = [];

            if (firstname.trim() === "") {
                errorMessages.push("First Name must not be empty.");
                isValid = false;
            }
            if (lastname.trim() === "") {
                errorMessages.push("Last Name must not be empty.");
                isValid = false;
            }
            if (sex === "") {
                errorMessages.push("Please select a Sex option.");
                isValid = false;
            }
            if (address.trim() === "") {
                errorMessages.push("Address must not be empty.");
                isValid = false;
            }
            if (party === "") {
                errorMessages.push("Please select a Party.");
                isValid = false;
            }

            // Check if a picture has been selected
            if (picture === "") {
                errorMessages.push("Please select a picture.");
                isValid = false;
            }

            // Check the file extension
            var allowedExtensions = ["jpg", "jpeg", "png"];
            var fileExtension = picture.split(".").pop().toLowerCase();
            if (allowedExtensions.indexOf(fileExtension) === -1) {
                errorMessages.push("Invalid file type. Please upload a JPG, JPEG, or PNG image.");
                isValid = false;
            }

           
            var maxSizeInBytes = 10 * 1024 * 1024;  
            var fileSize = document.getElementById("picture").files[0].size;
            if (fileSize > maxSizeInBytes) {
                errorMessages.push("File size exceeds the allowed limit (10MB). Please choose a smaller file.");
                isValid = false;
            }

            // Display error messages
            var errorContainer = document.getElementById("error-container");
            errorContainer.innerHTML = "";
            if (errorMessages.length > 0) {
                errorMessages.forEach(function(message) {
                    var errorElement = document.createElement("p");
                    errorElement.className = "error";
                    errorElement.textContent = message;
                    errorContainer.appendChild(errorElement);
                });
            }

            return isValid;
        }
    </script>
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="container-box p-4">
                    <h1 class="center-heading mb-4">Edit Candidate</h1>
                    <?php
                    require "config.php";

                    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                        $id = $_GET['id'];
                        $query = "SELECT * FROM candidates WHERE idno = $id";
                        $result = $connect->query($query);

                        if ($result && $result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                        } else {
                            echo "Candidate not found.";
                        }
                    } else {
                        echo "Invalid candidate ID.";
                    }

                    // Check if the form is submitted for updating the candidate
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $id = $_POST['id'];
                        $firstname = $_POST['firstname'];
                        $lastname = $_POST['lastname'];
                        $mi = $_POST['mi'];
                        $sex = $_POST['sex'];
                        $address = $_POST['address'];
                        $party = $_POST['party'];

                        // Update the candidate in the database
                        $updateQuery = "UPDATE candidates SET firstname = '$firstname', lastname = '$lastname', mi = '$mi', sex = '$sex', address = '$address', party = '$party' WHERE idno = $id";
                        if ($connect->query($updateQuery) === TRUE) {
                            echo '<div class="alert alert-success" role="alert">Candidate updated successfully!</div>';
                        } else {
                            echo '<div class="alert alert-danger" role="alert">Error updating candidate: ' . $connect->error . '</div>';
                        }
                    }

                    $connect->close();
                    ?>
                    <form action="" method="post" onsubmit="return validateForm()" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $row['idno']; ?>">
                        <div class="form-group">
                            <label for="firstname">First Name</label>
                            <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo $row['firstname']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="lastname">Last Name</label>
                            <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo $row['lastname']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="mi">Middle Initial</label>
                            <input type="text" class="form-control" id="mi" name="mi" value="<?php echo $row['mi']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="sex">Sex</label>
                            <select class="form-control" id="sex" name="sex" required>
                                <option value="Male" <?php if ($row['sex'] === 'Male') echo 'selected'; ?>>Male</option>
                                <option value="Female" <?php if ($row['sex'] === 'Female') echo 'selected'; ?>>Female</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" id="address" name="address" value="<?php echo $row['address']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="party">Party</label>
                            <select class="form-control" id="party" name="party" required>
                                <option value=""></option>
                                <option value="1-PACMAN" <?php if ($row['party'] === '1-PACMAN') echo 'selected'; ?>>1-PACMAN</option>
                                <option value="1-RIDER PARTYLIST" <?php if ($row['party'] === '1-RIDER PARTYLIST') echo 'selected'; ?>>1-RIDER PARTYLIST</option>
                                <option value="4PS" <?php if ($row['party'] === '4PS') echo 'selected'; ?>>4PS</option>
                                <option value="AAMBIS-OWA" <?php if ($row['party'] === 'AAMBIS-OWA') echo 'selected'; ?>>AAMBIS-OWA</option>
                                <option value="ABANG LINGKOD" <?php if ($row['party'] === 'ABANG LINGKOD') echo 'selected'; ?>>ABANG LINGKOD</option>
                                <option value="ABONO" <?php if ($row['party'] === 'ABONO') echo 'selected'; ?>>ABONO</option>
                                <option value="ACT TEACHERS" <?php if ($row['party'] === 'ACT TEACHERS') echo 'selected'; ?>>ACT TEACHERS</option>
                                <option value="ACT-CIS" <?php if ($row['party'] === 'ACT-CIS') echo 'selected'; ?>>ACT-CIS</option>
                                <option value="AGAP" <?php if ($row['party'] === 'AGAP') echo 'selected'; ?>>AGAP</option>
                                <option value="AGIMAT" <?php if ($row['party'] === 'AGIMAT') echo 'selected'; ?>>AGIMAT</option>
                            </select>
                        </div>

                        <!-- Error container -->
                        <div id="error-container"></div>

                        <div class="form-group text-center custom-padding">
                            <button type="submit" class="btn btn-primary">Update Candidate</button>
                        </div>
                    </form>

                    <!-- Add a back button to return to the main page -->
                    <div class="form-group text-center">
                        <a href="index.php" class="btn btn-secondary">Back to Main Page</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html>