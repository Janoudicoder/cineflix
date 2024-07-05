<?php
require '../private/conn.php';

if (isset($_POST['Delete_Pige'])) {
    $id = $_POST['Delete_Pegi'];

    // Perform the database deletion
    $query = 'DELETE FROM pegi_contents WHERE pegi_content_id = :id';
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
