<?php
require '../private/conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Delete_Pegi'])) {
    $pegicontent_id = $_POST['Delete_Pegi'];

    // Prepare a DELETE statement
    $query = "DELETE FROM pegi_contents WHERE pegi_content_id = :pegicontent_id";
    $stmt = $dbh->prepare($query);

    // Bind parameters
    $stmt->bindParam(':pegicontent_id', $pegicontent_id);

    // Attempt to execute the prepared statement
    try {
        $stmt->execute();
        // Redirect back to the page where the delete button was clicked
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    } catch (PDOException $e) {
        // Handle errors, if any
        echo "Error: " . $e->getMessage();
    }
}
?>
