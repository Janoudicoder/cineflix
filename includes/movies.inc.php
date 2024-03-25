<?php
try {
    require './private/conn.php';

    $query = "SELECT films.*, pegi_contents.content, pegi_age.age, genre.name AS genre_name
            FROM films
            LEFT JOIN pegi_contents ON films.pegi_con_id = pegi_contents.pegi_content_id
            LEFT JOIN pegi_age ON films.pegi_age_id = pegi_age.pegi_age_id
            LEFT JOIN film_genre ON films.film_id = film_genre.film_id
            LEFT JOIN genre ON film_genre.genre_id = genre.genre_id";
    $result = $dbh->query($query);

    $moviesByGenre = [];

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $genre = $row['genre_name'];

        if (!isset($moviesByGenre[$genre])) {
            $moviesByGenre[$genre] = [];
        }

        $moviesByGenre[$genre][] = $row;
    }

    foreach ($moviesByGenre as $genre => $movies) {
        echo '<div class="container">';
        echo '<h1 class="display-4 text-center">' . htmlspecialchars($genre) . '</h1>';
        echo '<div class="row row-cols-1 row-cols-md-3 g-4">'; 

        foreach ($movies as $movie) {
            $film_id = $movie['film_id'];
            $movieTitle = $movie['film_title'];
            $description = $movie['description'];
            $age = $movie['age'];
            $content = $movie['content'];
            $imageData = base64_encode($movie['photo']);
            $imageSrc = 'data:image/jpeg;base64,' . $imageData;

            echo '<div class="col">';
            echo '<div class="card h-100">';
            echo '<img src="' . htmlspecialchars($imageSrc) . '" class="card-img-top" alt="Movie Image">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . htmlspecialchars($movieTitle) . '</h5>';
            echo '<p class="card-text">' . htmlspecialchars($description) . '</p>';
            echo '<p class="card-text">Age: PG-' . htmlspecialchars($age) . '</p>';
            echo '<p class="card-text">Content: ' . htmlspecialchars($content) . '</p>';
            echo '<a href="index.php?page=user_filmoverzicht&film_id=' . $film_id . '" class="btn btn-primary">Details</a>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }

        echo '</div>'; 
        echo '</div>'; 
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
