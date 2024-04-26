<?php
require '../private/conn.php';

if(isset($_POST['edit'])) {
    // Haal de ingediende gegevens op
    $show_datum = $_POST['show_datum'];
    $show_time = $_POST['show_time'];
    $film_id = $_POST['film_id'];

    try {
        // Update de filmgegevens in de database
        $update_query = "UPDATE films SET release_date = :show_datum, duration = :show_time WHERE film_id = :film_id";
        $update_statement = $dbh->prepare($update_query);
        $update_statement->bindParam(':show_datum', $show_datum); // Fixed placeholder name
        $update_statement->bindParam(':show_time', $show_time);   // Fixed placeholder name
        $update_statement->bindParam(':film_id', $film_id);
        $update_statement->execute();

        // Redirect naar een andere pagina na de update
        header('Location: ../index.php?page=hall');
        exit();
    } catch (Exception $e) {
        // Handle any exceptions such as database connection errors
        echo "Error: " . $e->getMessage();
    }
}
?>