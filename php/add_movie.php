<?php
session_start();

require '../private/conn.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $title = $_POST['title'];
    $trailer = $_POST['trailer'];
    $description = $_POST['description'];
    $price = $_POST['price'];   
    $release_date = $_POST['release_date'];
    $pegi_age = $_POST['pegi_age'];
    $photo = file_get_contents($_FILES['photo']['tmp_name']); 
    $duration = $_POST['duration']; 
   // $hours = floor($duration / 60);
    //$minutes = $duration % 60;
   // $durationFormatted = sprintf("%02d:%02d:00", $hours, $minutes); 


    $check_film_query = "SELECT film_id FROM films WHERE film_title = ?";
    $check_film_stmt = $dbh->prepare($check_film_query);
    $check_film_stmt->execute([$title]);
    $existing_film = $check_film_stmt->fetch(PDO::FETCH_ASSOC);

    if ($existing_film) {
        $_SESSION['melding'] = 'Movie already exists';
        header('Location: ../index.php?page=add_movie');
        exit();
    }

    $check_pegi_age_query = "SELECT pegi_age_id FROM pegi_age WHERE age = ?";
    $check_pegi_age_stmt = $dbh->prepare($check_pegi_age_query);
    $check_pegi_age_stmt->execute([$pegi_age]);
    $pegi_age_row = $check_pegi_age_stmt->fetch(PDO::FETCH_ASSOC);
    if ($pegi_age_row) {
        $pegi_age_id = $pegi_age_row['pegi_age_id'];
    } else {
        $insert_pegi_age_query = "INSERT INTO pegi_age (age) VALUES (?)";
        $insert_pegi_age_stmt = $dbh->prepare($insert_pegi_age_query);
        $insert_pegi_age_stmt->execute([$pegi_age]);
        $pegi_age_id = $dbh->lastInsertId();
    }

    $insert_film_query = "INSERT INTO films (film_title, photo, trailer, description, duration, price, release_date, pegi_age_id)
                          VALUES (:title, :photo, :trailer, :description, :duration, :price, :release_date, :pegi_age_id)";
    $insert_film_stmt = $dbh->prepare($insert_film_query);
    $insert_film_stmt->bindParam(':title', $title);
    $insert_film_stmt->bindParam(':photo', $photo);
    $insert_film_stmt->bindParam(':trailer', $trailer);
    $insert_film_stmt->bindParam(':description', $description);
    $insert_film_stmt->bindParam(':duration', $duration);
    $insert_film_stmt->bindParam(':price', $price);
    $insert_film_stmt->bindParam(':release_date', $release_date);
    $insert_film_stmt->bindParam(':pegi_age_id', $pegi_age_id);
    $insert_film_stmt->execute();
    $film_id = $dbh->lastInsertId(); 
    $genres = isset($_POST['genre']) ? $_POST['genre'] : [];
    $insert_genre_query = "INSERT INTO film_genre (film_id, genre_id) VALUES (:film_id, :genre_id)";
    $insert_genre_stmt = $dbh->prepare($insert_genre_query);

    foreach ($genres as $genre_id) {
        $insert_genre_stmt->bindParam(':film_id', $film_id);
        $insert_genre_stmt->bindParam(':genre_id', $genre_id);
        $insert_genre_stmt->execute();
    }

    $pegis = isset($_POST['pegi_content']) ? $_POST['pegi_content'] : [];
    $insert_pegis_query = "INSERT INTO film_content_pegi (film_id, pegi_content_id) VALUES (:film_id, :pegi_content_id)";
    $insert_pegis_stmt = $dbh->prepare($insert_pegis_query);

    foreach ($pegis as $pegi_content_id) {
        $insert_pegis_stmt->bindParam(':film_id', $film_id);
        $insert_pegis_stmt->bindParam(':pegi_content_id', $pegi_content_id);
        $insert_pegis_stmt->execute();
    }

    $_SESSION['melding'] = 'Movie is successfully added';
    header('Location: ../index.php?page=movies');
    exit();
}
?>
