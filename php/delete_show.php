<?php
session_start();
require '../private/conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['deleteShow'])) {
    $film_id = $_POST['film_id'];
    $show_id = $_POST['show_id'];
   
    

    try {
        $dbh->beginTransaction();

        $delete_seat_orders = "DELETE FROM seat_order WHERE show_id IN (SELECT show_id FROM shows WHERE film_id = :film_id)";
        $stmt = $dbh->prepare($delete_seat_orders);
        $stmt->bindParam(':film_id', $film_id, PDO::PARAM_INT);
        $stmt->execute();

        $delete_query = "DELETE FROM shows WHERE film_id = :film_id AND show_id = :show_id";
        $stmt = $dbh->prepare($delete_query);
        $stmt->bindParam(':film_id', $film_id, PDO::PARAM_INT);
        $stmt->bindParam(':show_id', $show_id, PDO::PARAM_INT);
        $stmt->execute();

        $dbh->commit();

        $_SESSION['melding'] = 'Show is deleted.';
        header('Location: ../index.php?page=movies');
        exit;
    } catch (Exception $e) {
        $dbh->rollBack();
        header("Location: index.php?page=shows&status=error&message=" . urlencode($e->getMessage()));
    }
} else {
    $_SESSION['melding'] = 'Show not deleted.';
    header('Location: ../index.php?page=hall');
    exit;
}
?>
