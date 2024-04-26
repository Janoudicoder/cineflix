<?php
try {
    require './private/conn.php';

    $film_id = isset($_GET['film_id']) ? $_GET['film_id'] : null;


    if (!$film_id) {
        throw new Exception("Geen film_id opgegeven.");
    }

    $query = "SELECT films.*, 
    GROUP_CONCAT(DISTINCT genre.name SEPARATOR ', ') AS genre_name, 
    pegi_age.age, 
    GROUP_CONCAT(DISTINCT pegi_contents.content SEPARATOR ', ') AS content
    FROM films
    LEFT JOIN pegi_age ON films.pegi_age_id = pegi_age.pegi_age_id
    LEFT JOIN film_content_pegi ON film_content_pegi.film_id = films.film_id
    LEFT JOIN film_genre ON films.film_id = film_genre.film_id
    LEFT JOIN genre ON genre.genre_id = film_genre.genre_id
    LEFT JOIN pegi_contents ON pegi_contents.pegi_content_id = film_content_pegi.pegi_content_id
    WHERE films.film_id = :film_id
    GROUP BY films.film_id";


    $stmt = $dbh->prepare($query);
    $stmt->execute([':film_id' => $film_id]);

    $movie = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$movie) {
        throw new Exception("Film niet gevonden.");
    }

    $movieTitle = $movie['film_title'];
    $description = $movie['description'];
    $genre = $movie['genre_name'];
    $releaseDate = $movie['release_date'];
    $rating = $movie['age'];
    $content = $movie['content'];
    $price = $movie['price'];
    $duration = $movie['duration'];
    $trailerUrl = $movie['trailer'];

    $imageData = base64_encode($movie['photo']);
    $imageSrc = 'data:image/jpeg;base64,' . $imageData;

    // Fetch show_id based on film_id
    $show_query = 'SELECT show_id FROM shows WHERE film_id = :film_id';
    $show_stmt = $dbh->prepare($show_query);
    $show_stmt->execute([':film_id' => $film_id]);
    $show = $show_stmt->fetch(PDO::FETCH_ASSOC);

    if (!$show) {
      header('Location: ./index.php?page=movies');
      $_SESSION['melding'] = 'no evelible times';
      exit();
    }

    $show_id = $show['show_id'];

    ?>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8">
                <h1><?php echo htmlspecialchars($movieTitle); ?></h1>
                <p><?php echo htmlspecialchars($description); ?></p>

                <h3>Trailer</h3>
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" src="<?php echo htmlspecialchars($trailerUrl); ?>" allowfullscreen></iframe>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="<?php echo htmlspecialchars($imageSrc); ?>" class="card-img-top" alt="Movie">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($movieTitle); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($description); ?></p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Genre:</strong> <?php echo htmlspecialchars($genre); ?></li>
                        <li class="list-group-item"><strong>Release Date:</strong> <?php echo htmlspecialchars($releaseDate); ?></li>
                        <li class="list-group-item"><strong>Rating:</strong> PG-<?php echo htmlspecialchars($rating); ?></li>
                        <li class="list-group-item"><strong>pegi:</strong> PG-<?php echo htmlspecialchars($content); ?></li>
                        <li class="list-group-item"><strong>price:</strong> € <?php echo htmlspecialchars($price); ?></li>
                        <li class="list-group-item"><strong>duration:</strong> <?php echo htmlspecialchars($duration); ?> min</li>
                    </ul>
                    <?php
                    if (isset($_SESSION['user']) && $_SESSION['user'] === 'admin') {
                    ?>
                    <div class="card-body">
                            <a href="index.php?page=hall" class="btn btn-warning">chek halls for Available Times</a>
                        </div>
                        
                    <?php
                    } else {

                    ?>
                        <div class="card-body">
                            <a href="index.php?page=chairs&film_id=<?php echo $film_id; ?>&show_id=<?php echo $show_id; ?>" class="btn btn-primary">Reserve a chair</a>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <?php
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
} catch (Exception $e) {
    echo "Fout: " . $e->getMessage();
}
?>