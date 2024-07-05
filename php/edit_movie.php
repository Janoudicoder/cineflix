<?php
session_start();
require '../private/conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editMovie'])) {
    $film_id = $_POST['film_id'];
    $title = $_POST['title'];
    $trailer = $_POST['trailer'];
    $description = $_POST['description'];
    $duration = $_POST['duration'];
    $price = $_POST['price'];
    $release_date = $_POST['release_date'];
    $pegi_age = $_POST['pegi_age'];

    // Check if a new photo was uploaded
    $photo = null;
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == UPLOAD_ERR_OK) {
        $photo = file_get_contents($_FILES['photo']['tmp_name']);
    }

    // Retrieve selected genres
    $selected_genres = $_POST['genre'] ?? [];

    // Retrieve selected PEGI content
    $selected_pegi_contents = $_POST['pegi_content'] ?? [];

    // Update movie details
    $update_film_query = "UPDATE films SET film_title = ?, trailer = ?, description = ?, duration = ?, price = ?, release_date = ?, pegi_age_id = ? WHERE film_id = ?";
    $update_film_stmt = $dbh->prepare($update_film_query);
    $update_film_stmt->execute([$title, $trailer, $description, $duration, $price, $release_date, $pegi_age, $film_id]);

    // Update photo if a new photo was uploaded
    if ($photo !== null) {
        $update_photo_query = "UPDATE films SET photo = ? WHERE film_id = ?";
        $update_photo_stmt = $dbh->prepare($update_photo_query);
        $update_photo_stmt->execute([$photo, $film_id]);
    }

    // Update movie-genre associations
    $delete_genre_query = "DELETE FROM film_genre WHERE film_id = ?";
    $delete_genre_stmt = $dbh->prepare($delete_genre_query);
    $delete_genre_stmt->execute([$film_id]);

    foreach ($selected_genres as $genre_id) {
        $insert_genre_query = "INSERT INTO film_genre (film_id, genre_id) VALUES (?, ?)";
        $insert_genre_stmt = $dbh->prepare($insert_genre_query);
        $insert_genre_stmt->execute([$film_id, $genre_id]);
    }

    // Update movie-PEGI content associations
    $delete_pegi_content_query = "DELETE FROM film_content_pegi WHERE film_id = ?";
    $delete_pegi_content_stmt = $dbh->prepare($delete_pegi_content_query);
    $delete_pegi_content_stmt->execute([$film_id]);

    foreach ($selected_pegi_contents as $pegi_content_id) {
        $insert_pegi_content_query = "INSERT INTO film_content_pegi (film_id, pegi_content_id) VALUES (?, ?)";
        $insert_pegi_content_stmt = $dbh->prepare($insert_pegi_content_query);
        $insert_pegi_content_stmt->execute([$film_id, $pegi_content_id]);
    }

    $_SESSION['melding'] = 'Movie is successfully updated';
    header('Location: ../index.php?page=movies');
    exit();
} else {
    $_SESSION['melding'] = 'Invalid request';
    header('Location: ../index.php?page=movies');
    exit();
}
?>
