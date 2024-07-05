<?php
require '../private/conn.php';

if (isset($_POST['Delete_Genre'])) {
    $id = $_POST['Delete_Genre'];

    // Perform the database deletion
    $query = 'DELETE FROM genre WHERE genre_id = :id';
    $statement = $dbh->prepare($query);
    $data = [':id' => $id];

    try {
        if ($statement->execute($data)) {

            header('Location: ../index.php?page=genre');
            exit;
        } else {

            $_SESSION['melding'] = "Error deleting the genre.";
        }
    } catch (PDOException $e) {

        echo "Error: " . $e->getMessage();
    }
}
?>
