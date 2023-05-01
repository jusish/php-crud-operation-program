<?php
$servername = "localhost";
$username = "root";
$password = "Justin";
$database = "shop";

$connection = new mysqli($servername, $username, $password, $database);


$name = "";
$email = "";
$phone = "";
$address = "";

$errMessage = "";
$successMessage = "";

if ( $_SERVER['REQUEST_METHOD'] == 'GET') {
    if(!isset($_GET["id"])) {
        header("location: /index.php");
        exit;
    }
    $id = $_GET["id"];


    $sql = "SELECT * FROM clients WHERE id = $id";
    $result = $connection->query($sql);
    $row = $result->fetch_assoc();

    if(!$row) {
        header("location: /index.php");
        exit;
    }
    $name = $row['name'];
    $email = $row['email'];
    $phone = $row['Phone'];
    $address = $row['address'];
} else {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['Phone'];
    $address = $_POST['address'];

    do {
        if(empty($id) || empty($name) || empty($email) || empty($phone) || empty($address)) {
            $errMessage = "All the fields are required";
            break;
        }
        $sql = "UPDATE clients SET name = '$name', email = '$email', Phone = '$phone', address = '$address' WHERE id = $id;
        ";
        $result = $connection->query($sql);
        if(!$result) {
            $errMessage = "Invalid query: " . $connection->error;
            break;
        }
        $successMessage =  "client updated successfully";
        header("location: /index.php");
        exit;
    } while (true);
}
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container my-5">
        <h2>New client</h2>
        <?php
        if (!empty($errMessage)) {
            echo "
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                        <strong>
                            $errMessage
                        </strong>
                        <button type='button' class='btn-close data-bs-dismiss='alert' aria-lable='close'></button>
                    </div>
            ";
        }
        ?>
        <form method='POST'>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="row mb-3">
                <label>Name</label>
                <input type="text" name="name" value="<?php echo $name; ?>">
                <label>Phone</label>
                <input type="text" name="Phone" value="<?php echo $phone; ?>">
                <label>Email</label>
                <input type="text" name="email" value="<?php echo $email; ?>">
                <label>Address</label>
                <input type="text" name="address" value="<?php echo $address; ?>">
                <?php
                if (!empty($successMessage)) {
                    echo "
                    <div class='alert alert-success alert-dismissible fade show' role='alert'>
                        <strong>
                            $successMessage
                        </strong>
                        <button type='button' class='btn-close data-bs-dismiss='alert' aria-lable='close'></button>
                    </div>
                    ";
                }
                ?>
                <button type="submit" class="btn btn-primary">Submit</button>
                <a class="btn btn-outline-primary" href="/index.php">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>