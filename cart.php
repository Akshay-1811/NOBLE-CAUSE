<?php
$servername = "localhost";
$username = "root";
$password = "";
$database_name = "leaf";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database_name);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$response = array("status" => "", "message" => "");

if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO cart_items (product_id, quantity) VALUES (?, ?)");
    $stmt->bind_param("ii", $product_id, $quantity);

    if ($stmt->execute()) {
        $response["status"] = "success";
        $response["message"] = "Item added to cart!";
    } else {
        $response["status"] = "error";
        $response["message"] = "Error: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    $response["status"] = "error";
    $response["message"] = "Invalid request.";
}


echo json_encode($response);
?>

