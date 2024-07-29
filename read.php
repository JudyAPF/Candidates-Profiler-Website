<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Candidate Profile</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
    <script src="https://kit.fontawesome.com/78ae652187.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        .container {
            text-align: center;
            background-color: #f8f9fa;
            padding: 25px;
            border-radius: 25px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .image-cen {
            margin-bottom: 20px;
        }

        .btn-back {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px 20px;
        }

        .btn-back a {
            text-decoration: none;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
    <?php 

    require("config.php");

        if(isset($_GET['id'])){
            $idno = $_GET['id'];
            $query = "SELECT * FROM candidates WHERE idno = $idno";
            $result = $connect->query($query);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo "<div class='image-cen'>";
                echo '<img src="' . $row['picture'] . '" width="250" height="250" alt="Candidate Picture">';
                echo "</div>";  
                echo "<h4>" . $row['firstname'] . " " . $row['mi'] . " " . $row['lastname'] . "</h4>";
                echo "<h5>Sex: " . $row['sex'] . "</h5>";
                echo "<h5>Address: " . $row['address'] . "</h5>";
                echo "<h5>Party: " . $row['party'] . "</h5>";
                echo '<button class="btn btn-back"><a href="index.php">Go Back</a></button>';
            } else {
                echo "No candidate found with that ID.";
            }
        }
    ?>
    </div>

</body>
</html>
