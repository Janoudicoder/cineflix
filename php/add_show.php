<?php
session_start();
require '../private/conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $hall_id = htmlspecialchars($_POST['hall_id']);
    $film_id = htmlspecialchars($_POST['film_id']);
    $showing_date = htmlspecialchars($_POST['showing_date']);
    $showing_time = htmlspecialchars($_POST['showing_time']);
    
    $date_time = $showing_date . ' ' . $showing_time;

    $check_sql = "SELECT * FROM shows WHERE hall_id = :hall_id AND film_id = :film_id";
    $check_stmt = $dbh->prepare($check_sql);
    $check_stmt->bindParam(':hall_id', $hall_id);
    $check_stmt->bindParam(':film_id', $film_id);
    $check_stmt->execute();

    if ($check_stmt->rowCount() > 0) {
        $_SESSION['melding'] = 'This film is already scheduled for this hall.';
    } else {
        $sql = "INSERT INTO shows (hall_id, film_id, date_time) VALUES (:hall_id, :film_id, :date_time)";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':hall_id', $hall_id);
        $stmt->bindParam(':film_id', $film_id);
        $stmt->bindParam(':date_time', $date_time);

        if ($stmt->execute()) {
            $_SESSION['melding'] = 'Show added successfully.';
        } else {
            $_SESSION['melding'] = 'Show not added.';
        }
    }

    header('Location: ../index.php?page=hall_info&hall_id=' . $hall_id);
    exit;
} else {
    echo "Error: Form data not submitted.";
}
?>
