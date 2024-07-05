<?php
require '../private/conn.php';

if (isset($_POST["add"])) {
    try {
        $pegi_content = $_POST['pegi_name'];

        $sql = "INSERT INTO pegi_contents (content) VALUES (:pegi_name)";
        $stmt = $dbh->prepare($sql);
        $stmt->execute(array(':pegi_name' => $pegi_content));

        if ($stmt->rowCount() > 0) {
            // Insertion successful
            header('Location: ../index.php?page=pegi');
            exit();
        } else {
            // Insertion failed
            echo "Error: Failed to insert data into database.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

?>
