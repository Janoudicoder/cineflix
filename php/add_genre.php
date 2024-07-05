<?php
session_start();
require '../private/conn.php';

if (isset($_POST["add"])) {
    try {
        $genre_name = $_POST['genre_name'];

        $check_sql = "SELECT COUNT(*) FROM genre WHERE name = :genre_name";
        $check_stmt = $dbh->prepare($check_sql);
        $check_stmt->execute(array(':genre_name' => $genre_name));
        $count = $check_stmt->fetchColumn();

        if ($count > 0) {
            
            header('Location: ../index.php?page=add_genre');
            $_SESSION['melding'] = 'Genre already exists in the database.';

            exit();
        } else {
            $insert_sql = "INSERT INTO genre (name) VALUES (:genre_name)";
            $insert_stmt = $dbh->prepare($insert_sql);
            $insert_stmt->execute(array(':genre_name' => $genre_name));
            

            if ($insert_stmt->rowCount() > 0) {
                header('Location: ../index.php?page=genre');
                $_SESSION['melding'] = 'Movie toegevoegd';
                exit();
            } else {
                $_SESSION['melding'] = 'Movie already exists';

            }
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
