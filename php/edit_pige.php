<?php
require '../private/conn.php';

if (isset($_POST['id']) && isset($_POST['Pige_Name'])) {
    $pegi_content_id = $_POST['id'];
    $pegi_name = $_POST['Pige_Name'];

    try {

        $sql = "UPDATE pegi_contents SET content = :pegi_name WHERE pegi_content_id = :pegi_content_id";
        $stmt = $dbh->prepare($sql);

        $stmt->bindParam(':pegi_name', $pegi_name);
        $stmt->bindParam(':pegi_content_id', $pegi_content_id);


        $stmt->execute();


        header('Location: ../index.php?page=pegi_content');
        exit();
    } catch (PDOException $e) {

        echo "Error: " . $e->getMessage();
    }
} else {

    echo "Error: PEGI Content ID or PEGI Content Name is missing.";

    header('Location: ../index.php?page=pegi_content');
    exit();
}
?>
