<?php
try {
    require './private/conn.php';

    // Controleer of er een film_id is meegegeven
    $film_id = isset($_GET['film_id']) ? $_GET['film_id'] : null;

    if (!$film_id) {
        throw new Exception("Geen film_id opgegeven.");
    }

    // Query om de details van de film op te halen op basis van film_id
    $query = "SELECT films.*, pegi_contents.content, pegi_age.age, genre.name AS genre_name
            FROM films
            LEFT JOIN pegi_contents ON films.pegi_con_id = pegi_contents.pegi_content_id
            LEFT JOIN pegi_age ON films.pegi_age_id = pegi_age.pegi_age_id
            LEFT JOIN film_genre ON films.film_id = film_genre.film_id
            LEFT JOIN genre ON film_genre.genre_id = genre.genre_id
            WHERE films.film_id = :film_id";
    $stmt = $dbh->prepare($query);
    $stmt->bindParam(':film_id', $film_id);
    $stmt->execute();
    $movie = $stmt->fetch(PDO::FETCH_ASSOC);

    // Controleer of de film is gevonden
    if (!$movie) {
        throw new Exception("Film niet gevonden.");
    }

    // Filmgegevens ophalen
    $movieTitle = $movie['film_title'];
    $description = $movie['description'];
    $genre = $movie['genre_name'];
    $releaseDate = $movie['release_date'];
    $rating = $movie['age'];
    $trailerUrl = $movie['trailer']; // URL van de trailer
   // echo $rating;
   // exit();

    // Convert BLOB image to base64
    $imageData = base64_encode($movie['photo']);
    $imageSrc = 'data:image/jpeg;base64,' . $imageData;
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
          </ul>
          <div class="card-body">
            <a href="#" class="btn btn-primary btn-block">beschikbare tijden </a>
          </div>
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
