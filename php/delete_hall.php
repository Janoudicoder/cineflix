<?php
session_start();
try {
    require '../private/conn.php'; 

    if (isset($_POST['delete_hall'])) {
        $hall_id = $_POST['hall_id'];

        $showsQuery = "SELECT COUNT(*) as show_count FROM shows WHERE hall_id = :hall_id";
        $showsStatement = $dbh->prepare($showsQuery);
        $showsStatement->bindParam(':hall_id', $hall_id);
        $showsStatement->execute();
        $showCount = $showsStatement->fetch(PDO::FETCH_ASSOC)['show_count'];

        if ($showCount == 0) {
            $deleteQuery = "DELETE FROM halls WHERE hall_id = :hall_id";
            $deleteStatement = $dbh->prepare($deleteQuery);
            $deleteStatement->bindParam(':hall_id', $hall_id);
            $deleteStatement->execute();

            header('Location: ../index.php?page=hall');
                exit();
        } else {
            $_SESSION['melding'] = 'connot be deleted !';
            header('Location: ../index.php?page=hall');
        }
    } else {
        $_SESSION['melding'] = 'connot be deleted !';
        header('Location: ../index.php?page=hall');
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
