<?php
require '../private/conn.php';

session_start();

try {
    $film_id = isset($_POST['film_id']) ? $_POST['film_id'] : null;
    $show_id = isset($_POST['show_id']) ? $_POST['show_id'] : null;
    $selected_seats = isset($_POST['selected_seats']) ? json_decode($_POST['selected_seats'], true) : [];
    $total_price = isset($_POST['price']) ? $_POST['price'] : null;
    
    if (!$film_id || !$show_id) {
        throw new Exception("Film_id or show_id not provided.");
    }

    if (!isset($_SESSION['user_id'])) {
        throw new Exception("User not logged in.");
    }

    $user_id = $_SESSION['user_id'];

    // Check if total_price is provided
    if ($total_price === null) {
        throw new Exception("Total price not provided.");
    }

    if (!$dbh->inTransaction()) {
        $dbh->beginTransaction();
    }

    // Insert reservation
    $reservation_query = "INSERT INTO reservations (show_id, user_id, pay) VALUES (:show_id, :user_id, :total)";
    $reservation_stmt = $dbh->prepare($reservation_query);
    $reservation_stmt->execute([
        ':show_id' => $show_id,
        ':user_id' => $user_id,
        ':total' => $total_price
    ]);

    $reservering_id = $dbh->lastInsertId();

    // Insert seat orders
    foreach ($selected_seats as $seat_id) {
        $seat_order_query = "INSERT INTO seat_order (seat_id, show_id) VALUES (:seat_id, :show_id)";
        $seat_order_stmt = $dbh->prepare($seat_order_query);
        $seat_order_stmt->execute([
            ':seat_id' => $seat_id,
            ':show_id' => $show_id,
        ]);
    }

    // Insert seat reservations
    foreach ($selected_seats as $seat_id) {
        $seat_res_query = "INSERT INTO seat_res (seat_id, reservations_id) VALUES (:seat_id, :reservering_id)";
        $seat_res_stmt = $dbh->prepare($seat_res_query);
        $seat_res_stmt->execute([
            ':seat_id' => $seat_id,
            ':reservering_id' => $reservering_id,
        ]);
    }

    $dbh->commit();

    $_SESSION['melding'] = 'Reservation successful!';
    header('Location: ../index.php?page=movies');

} catch (Exception $e) {
    if ($dbh->inTransaction()) {
        $dbh->rollBack();
    }
    echo "Error: " . $e->getMessage();
}
?>
