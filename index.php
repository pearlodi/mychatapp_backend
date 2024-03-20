<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

include 'DbConnect.php';
$objDb = new DbConnect;
$conn = $objDb->connect();

 print_r(file_get_contents('php://input'));
 $method = $_SERVER['REQUEST_METHOD'];
 $response = [];
 switch($method)
{
  case "GET":
    $sql = "SELECT * FROM users";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($result);
    break;


  case 'POST':
    $data = json_decode(file_get_contents('php://input'), true);
    $createdAt = date('Y-m-d H:i:s');
    $sql = "INSERT INTO users(first_name, last_name, email, password, user_name, created_at) VALUES(:firstName, :lastName, :email, :password, :userName, :createdAt)";

    $conn->prepare($sql);
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':firstName', $data['firstName']);
    $stmt->bindParam(':lastName',$data['lastName']);
    $stmt->bindParam(':email', $data['email']); 
    $stmt->bindParam(':password', $data['password']);
    $stmt->bindParam(':userName', $data['userName']);
    $stmt->bindParam(':createdAt', $createdAt);
    
    $stmt->execute();
    if ($stmt->execute()) {
      $response = ['status' => 1, 'message' => 'Record successfully created.'];
    }else{
      $response = ['status' => 0, 'error' => $stmt->errorInfo()];
    }
    echo json_encode($response);  


     case 'POST':
    $data = json_decode(file_get_contents('php://input'), true);
    $createdAt = date('Y-m-d H:i:s');
    $sql = "INSERT INTO users(first_name, last_name, email, password, user_name, created_at) VALUES(:firstName, :lastName, :email, :password, :userName, :createdAt)";

    $conn->prepare($sql);
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':firstName', $data['firstName']);
    $stmt->bindParam(':lastName',$data['lastName']);
    $stmt->bindParam(':email', $data['email']); 
    $stmt->bindParam(':password', $data['password']);
    $stmt->bindParam(':userName', $data['userName']);
    $stmt->bindParam(':createdAt', $createdAt);
    
    $stmt->execute();
    if ($stmt->execute()) {
      $response = ['status' => 1, 'message' => 'Record successfully created.'];
    }else{
      $response = ['status' => 0, 'error' => $stmt->errorInfo()];
    }
    echo json_encode($response); 

    break;
}
?>
