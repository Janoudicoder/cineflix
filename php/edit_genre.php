<?php
require '../private/conn.php';

if (isset($_POST['id']) && isset($_POST['genre_name'])) {
    $genre_id = $_POST['id'];
    $genre_name = $_POST['genre_name'];

    try {
        // Check if the genre name already exists
        $check_sql = "SELECT COUNT(*) FROM genre WHERE name = :genre_name AND genre_id != :genre_id";
        $check_stmt = $dbh->prepare($check_sql);
        $check_stmt->execute(array(':genre_name' => $genre_name, ':genre_id' => $genre_id));
        $count = $check_stmt->fetchColumn();

        if ($count > 0) {
            header('Location: ../index.php?page=genre');
            $_SESSION['melding'] = "Error: Genre name already exists in the database.";


        } else {
            $sql = "UPDATE genre SET name = :genre_name WHERE genre_id = :genre_id";
            $stmt = $dbh->prepare($sql);

            // Bind parameters
            $stmt->bindParam(':genre_name', $genre_name);
            $stmt->bindParam(':genre_id', $genre_id);

            // Execute the statement
            $stmt->execute();

            $_SESSION['melding'] = "Error deleting the genre.";
            header('Location: ../index.php?page=genre');
            exit();
        }
    } catch (PDOException $e) {
        // Handle database errors
        echo "Error: " . $e->getMessage();
    }
} else {
    // Handle missing genre ID or genre name
    $_SESSION['melding'] = " Handle missing genre ID or genre name";
    // Redirect to the page where the edit was initiated if form is not submitted
    header('Location: ../index.php?page=genre');
    exit();
}
?>
