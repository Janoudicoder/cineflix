<?php
session_start();
require '../private/conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['deleteshow']) && filter_var($_POST['deleteshow'], FILTER_VALIDATE_INT)) {
    $film_id = $_POST['deleteshow'];
   // $show_id =$_POST['show_id'];
    
    try {
        $dbh->beginTransaction();
        
        $delete_seat_orders = "DELETE FROM seat_order WHERE show_id IN (SELECT show_id FROM shows WHERE film_id = :film_id)";
        $stmt = $dbh->prepare($delete_seat_orders);
        $stmt->bindParam(':film_id', $film_id, PDO::PARAM_INT);
        $stmt->execute();
        echo ['show_id'];
        exit();
        $delete_query = "DELETE FROM shows WHERE film_id = :film_id ";
        $stmt = $dbh->prepare($delete_query);
        $stmt->bindParam(':film_id', $film_id, PDO::PARAM_INT);
        $stmt->execute();

        $dbh->commit();

        $_SESSION['melding'] = 'Show is deleted .';

        header('Location: ../index.php?page=hall');
        exit;    } catch (Exception $e) {
        $dbh->rollBack();
        $_SESSION['melding'] = 'Show is not deleted .';

        header('Location: ../index.php?page=hall');    }
} else {
    header("Location: index.php?page=shows&status=error&message=Invalid Request");
}
?>
