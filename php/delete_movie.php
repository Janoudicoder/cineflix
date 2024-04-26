<?php
session_start();

if(isset($_SESSION['user']) && $_SESSION['user'] === 'admin') {
    if(isset($_GET['film_id'])) {
        $film_id = $_GET['film_id'];

        try {
            require '../private/conn.php';

            $show_check_query = "SELECT * FROM `shows` WHERE film_id = :film_id";
            $show_check_statement = $dbh->prepare($show_check_query);
            $show_check_statement->bindParam(':film_id', $film_id);
            $show_check_statement->execute();
            $shows_exist = $show_check_statement->fetch(PDO::FETCH_ASSOC);

            if($shows_exist) {
                
                $_SESSION['melding'] = 'Associated shows exist';

                header('Location: ../index.php?page=movies');
                exit();
            } else {
                $delete_query = "DELETE FROM films WHERE film_id = :film_id";
                $delete_statement = $dbh->prepare($delete_query);
                $delete_statement->bindParam(':film_id', $film_id);
                $delete_statement->execute();

                
                $_SESSION['melding'] = 'Redirect back to the page after successful deletion';
                header('Location: ../index.php?page=movies');
                exit();
            }
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
       
        $_SESSION['melding'] = 'Redirect if film_id is not provided in the request';
        header('Location: ../index.php?page=movies');
        exit();
    }
} else {
    
    $_SESSION['melding'] = 'Redirect if user is not logged in as admin';
    header('Location: ../index.php?page=movies');
    exit();
}
?>
