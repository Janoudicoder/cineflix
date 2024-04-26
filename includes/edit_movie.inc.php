<?php
require './private/conn.php';

// Initialize $selected_pegi_contents as an empty array
$selected_pegi_contents = [];

$id = $_GET['film_id'] ?? null; // Using null coalescing operator to avoid undefined index notice
if($id) {
    $query = 'SELECT * FROM films WHERE film_id = :id';
    $statement = $dbh->prepare($query);
    $statement->bindParam(':id', $id); 
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);

    if($result) {
        // Now that $result is fetched, you can safely access $result['film_id'] and other properties
        $film_id = $result['film_id'];
        $query = 'SELECT genre_id FROM film_genre WHERE film_id = :film_id';
        $statement = $dbh->prepare($query);
        $statement->bindParam(':film_id', $film_id);
        $statement->execute();
        $selected_genres = $statement->fetchAll(PDO::FETCH_COLUMN);

        $query_pegi_con = 'SELECT film_content_id FROM film_content_pegi WHERE film_id = :film_id';
        $statement = $dbh->prepare($query_pegi_con);
        $statement->bindParam(':film_id', $film_id);
        $statement->execute();
        $selected_pegis = $statement->fetchAll(PDO::FETCH_COLUMN);

        // Fetch selected PEGI content IDs
        $query_pegi_content = 'SELECT pegi_content_id FROM film_content_pegi WHERE film_id = :film_id';
        $statement = $dbh->prepare($query_pegi_content);
        $statement->bindParam(':film_id', $film_id);
        $statement->execute();
        $selected_pegi_contents = $statement->fetchAll(PDO::FETCH_COLUMN);
    } else {
        echo "Film not found";
        // Handle the case where no film is found
    }
} else {
    echo "No film ID provided";
    // Handle the case where no film ID is provided in the URL
}

$genres_query = "SELECT * FROM genre";
$genres_result = $dbh->query($genres_query);

$pegi_contents_query = "SELECT * FROM pegi_contents";
$pegi_contents_result = $dbh->query($pegi_contents_query);

$pegi_ages_query = "SELECT * FROM pegi_age";
$pegi_ages_result = $dbh->query($pegi_ages_query);

// Retrieve selected PEGI age
$selected_pegi_age = $result['pegi_age_id'] ?? null;

?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h3 class="text-center">Film Aanpassen</h3>
                </div>
                <div class="card-body">
                    <form method="post" action="php/edit_movie.php" enctype="multipart/form-data"> <!-- Added enctype for file upload -->
                        <input type="hidden" value="<?=$result['film_id']?>" name="film_id">
                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input type="text" name="title" value="<?=$result['film_title']?>" class="form-control" id="title" placeholder="Voer film title">
                        </div>

                        <div class="form-group">
                            <label for="currentPhoto">Huidige Foto:</label>
                            <?php if(!empty($result['photo'])): ?>
                                <img src="data:image/jpeg;base64,<?=base64_encode($result['photo'])?>" alt="Film Photo" class="img-thumbnail">
                            <?php else: ?>
                                <p>Geen foto beschikbaar.</p>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="photo">Photo:</label>
                            <input type="file" class="form-control-file" id="photo" name="photo"> <!-- Removed "required" as it might not always be needed -->
                        </div>

                        <div class="form-group">
                            <label for="trailer">Trailer:</label>
                            <input type="text" name="trailer" value="<?=$result['trailer']?>" class="form-control" id="trailer" placeholder="Voer de URL van de trailer in">
                        </div>
                        <div class="form-group">
                            <label for="description">Beschrijving:</label>
                            <textarea class="form-control" name="description" id="description" rows="3" placeholder="Voer de beschrijving van de film in"><?=$result['description']?></textarea>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="genreDropdownButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Select Genres
                            </button>
                            <div class="dropdown-menu" aria-labelledby="genreDropdownButton">
                                <?php foreach ($genres_result as $genre) : ?>
                                    <div class="dropdown-item">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="<?php echo $genre['genre_id']; ?>" name="genre[]" id="genreCheckbox<?php echo $genre['genre_id']; ?>" <?php echo in_array($genre['genre_id'], $selected_genres) ? 'checked' : ''; ?>>
                                            <label class="form-check-label" for="genreCheckbox<?php echo $genre['genre_id']; ?>"><?php echo $genre['name']; ?></label>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pegi_content">PEGI Inhoud:</label>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="pegiContentDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Select PEGI Content
                                </button>
                                <div class="dropdown-menu" aria-labelledby="pegiContentDropdown">
                                    <?php foreach ($pegi_contents_result as $pegi_content) : ?>
                                        <div class="dropdown-item">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="<?php echo $pegi_content['pegi_content_id']; ?>" name="pegi_content[]" id="pegiContentCheckbox<?php echo $pegi_content['pegi_content_id']; ?>" <?php echo in_array($pegi_content['pegi_content_id'], $selected_pegi_contents) ? 'checked' : ''; ?>>
                                                <label class="form-check-label" for="pegiContentCheckbox<?php echo $pegi_content['pegi_content_id']; ?>"><?php echo $pegi_content['content']; ?></label>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="release_date">Release Datum:</label>
                            <input type="date" name="release_date" value="<?=$result['release_date']?>" class="form-control" id="release_date" placeholder="Voer de releasedatum van de film in">
                        </div>
                        <div class="form-group">
                            <label for="price">Prijs:</label>
                            <input type="text" name="price" value="<?=$result['price']?>" class="form-control" id="price" placeholder="Voer de prijs van de film in">
                        </div>
                       
                        <div class="form-group">
                            <label for="pegiAge">PEGI (age):</label>
                            <select class="form-control" id="pegiAge" name="pegi_age" required>
                                <option value="">Select PEGI age</option> <!-- Add a default empty option -->
                                <?php foreach ($pegi_ages_result as $row) { ?>
                                    <option value="<?php echo $row['pegi_age_id']; ?>" <?php echo ($selected_pegi_age == $row['pegi_age_id']) ? 'selected' : ''; ?>><?php echo $row['age']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="duration">Duur (in minuten):</label>
                            <input type="time" name="duration" value="<?=$result['duration']?>" class="form-control" id="duration" placeholder="Voer de duur van de film in (minuten)">
                        </div>

                        <button type="submit" name="editMovie" class="btn btn-danger btn-block">Aanpassen</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        // Initialize Bootstrap dropdown
        $('.dropdown-toggle').dropdown();
    });
</script>
