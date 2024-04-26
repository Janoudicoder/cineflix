<?php


try {
    require './private/conn.php';

    $query = "SELECT films.*, pegi_age.age, genre.name AS genre_name, 
    GROUP_CONCAT(pegi_contents.content SEPARATOR ', ') AS content
    FROM films
    LEFT JOIN pegi_age ON films.pegi_age_id = pegi_age.pegi_age_id
    LEFT JOIN film_content_pegi ON film_content_pegi.film_id = films.film_id
    LEFT JOIN film_genre ON films.film_id = film_genre.film_id
    LEFT JOIN genre ON film_genre.genre_id = genre.genre_id
    LEFT JOIN pegi_contents ON pegi_contents.pegi_content_id = film_content_pegi.pegi_content_id
    GROUP BY films.film_id, pegi_age.age, genre_name"; 

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
            $price = $movie['price'];
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
            if (isset($_SESSION['user']) && $_SESSION['user'] === 'admin') {
                echo '<a href="index.php?page=edit_movie&film_id=' . $film_id . '" class="btn btn-warning">edit</a>';
                echo '<a href="php/delete_movie.php?film_id=' . htmlspecialchars($film_id) . '" name="delete" class="btn btn-danger" onclick="return confirm(\'Are you sure you want to delete this movie?\');">Delete</a>';
            }
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

<script>
    function editFilm(filmId) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "edit_movie.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                console.log(xhr.responseText);
            }
        };
        xhr.send("film_id=" + filmId);
    }
</script>
