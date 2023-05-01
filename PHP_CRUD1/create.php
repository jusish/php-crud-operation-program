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

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['Phone'];
    $address = $_POST['address'];
    do {
        if(empty($name) || empty($email) || empty($phone) || empty($address) ){
            $errMessage = "All the fields are required";
            break;
        }
        //insert a new client in database

        $sql = "INSERT INTO clients(name, email, Phone, address)" . "VALUES ('$name', '$email', '$phone', '$address')";
        $result = $connection->query($sql);

        if(!$result) {
            $errMessage = "Invalid query: ". $connection->error;
            break; 
        }

        $name = "";
        $email = "";
        $phone = "";
        $address = "";
        $successMessage = "client successfully created";
        header("location: /index.php");
        exit;
    } while (false);
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
            <div class="row mb-3">
                <label>Name</label>
                <input type="text" name="name" value="<?php echo $name; ?>">
                <label>Phone</label>
                <input type="text" name="phone" value="<?php echo $phone; ?>">
                <label>Email</label>
                <input type="text" name="email" value="<?php echo $email ?>">
                <label>Address</label>
                <input type="text" name="address" value="<?php echo $address ?>">
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