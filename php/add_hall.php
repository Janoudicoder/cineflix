<?php
session_start();

require '../private/conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $hall_number = !empty($_POST['hall_number']) ? trim($_POST['hall_number']) : false;
    

    if (!$hall_number) {
       
        $_SESSION['melding'] = 'Please enter a hall number.';
        header('Location: ../index.php?page=add_hall');
        exit;
    }

    // Prepare SQL statement to check if the hall number already exists
    $sql_check = "SELECT COUNT(*) FROM halls WHERE hall_number = :hall_number";
    $stmt_check = $dbh->prepare($sql_check);
    $stmt_check->bindParam(':hall_number', $hall_number, PDO::PARAM_STR);
    $stmt_check->execute();
    $hall_count = $stmt_check->fetchColumn();

    if ($hall_count > 0) {
        
        $_SESSION['melding'] = 'Hall number already exists.';

        header('Location: ../index.php?page=add_hall');
        exit;
    }

    // Prepare SQL statement to insert the new hall with hall_number
    $sql = "INSERT INTO halls (hall_number) VALUES (:hall_number)";
    try {
        $stmt = $dbh->prepare($sql);
        // Bind parameters
        $stmt->bindParam(':hall_number', $hall_number, PDO::PARAM_STR);
        // Execute the statement
        $stmt->execute();
        
        $_SESSION['melding'] = 'Hall added successfully.';
        header('Location: ../index.php?page=hall');
    } catch (PDOException $e) {
        // Directly inform the user about database errors
        echo "Error adding hall: " . $e->getMessage();
    }
} else {
    $_SESSION['melding'] = 'Please provide a hall name.';
    header('Location: ../index.php?page=add_hall');
}
?>
