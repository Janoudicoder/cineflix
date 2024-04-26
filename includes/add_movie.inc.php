<?php
require './private/conn.php';

$genres_query = "SELECT * FROM genre";
$genres_result = $dbh->query($genres_query);

$pegi_contents_query = "SELECT * FROM pegi_contents";
$pegi_contents_result = $dbh->query($pegi_contents_query);

$pegi_ages_query = "SELECT * FROM pegi_age";
$pegi_ages_result = $dbh->query($pegi_ages_query);
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h3 class="text-center">Add Movie</h3>
                </div>
                <div class="card-body">
                    <form action="php/add_movie.php" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input type="title" class="form-control" id="title" name="title" placeholder="Enter movie title" required>
                        </div>
                        <div class="form-group">
                            <label for="photo">Photo:</label>
                            <input type="file" class="form-control-file" id="photo" name="photo" required>
                        </div>
                        <div class="form-group">
                            <label for="trailer">Trailer:</label>
                            <input type="text" class="form-control" id="trailer" name="trailer" placeholder="Enter the URL of the trailer" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description:</label>
                            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter movie description" required></textarea>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="genreDropdownButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Add Genres
                            </button>
                            <div class="dropdown-menu" aria-labelledby="genreDropdownButton">
                                <?php foreach ($genres_result as $genre) : ?>
                                    <div class="dropdown-item">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="<?php echo $genre['genre_id']; ?>" name="genre[]" id="genreCheckbox<?php echo $genre['genre_id']; ?>">
                                            <label class="form-check-label" for="genreCheckbox<?php echo $genre['genre_id']; ?>"><?php echo $genre['name']; ?></label>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <label for="pegiContent">PEGI (contents):</label>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="pegiContentDropdownButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Add PEGI content
                                </button>
                                <div class="dropdown-menu" aria-labelledby="pegiContentDropdownButton">
                                    <?php foreach ($pegi_contents_result as $pegi_content) : ?>
                                        <div class="dropdown-item">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="<?php echo $pegi_content['pegi_content_id']; ?>" name="pegi_content[]" id="pegiContentCheckbox<?php echo $pegi_content['pegi_content_id']; ?>">
                                                <label class="form-check-label" for="pegiContentCheckbox<?php echo $pegi_content['pegi_content_id']; ?>"><?php echo $pegi_content['content']; ?></label>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="duration">Duration (in minutes):</label>
                            <input type="time" class="form-control" id="duration" name="duration" placeholder="Enter duration" required>
                        </div>
                        <div class="form-group">
                            <label for="releaseDate">Release Date:</label>
                            <input type="date" class="form-control" id="releaseDate" name="release_date" required>
                        </div>
                        <div class="form-group">

                        <div class="form-group">
                            <label for="pegiAge">PEGI (age):</label>
                            <select class="form-control" id="pegiAge" name="pegi_age" required>
                                <option value="">Select PEGI age</option> <!-- Add a default empty option -->
                                <?php foreach ($pegi_ages_result as $row) { ?>
                                    <option value="<?php echo $row['pegi_age_id']; ?>"><?php echo $row['age']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="price">Price:</label>
                            <input type="text" class="form-control" id="price" name="price" placeholder="Enter price" required>
                        </div>
                        <button type="submit" class="btn btn-danger btn-block" name="add_movie">Add Movie</button>
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