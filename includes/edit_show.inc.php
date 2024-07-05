<?php
require './private/conn.php';

if(isset($_GET['film_id']) && filter_var($_GET['film_id'], FILTER_VALIDATE_INT)) {
    $film_id = $_GET['film_id'];

    try {
        $film_query = "SELECT * FROM films WHERE film_id = :film_id";
        $film_statement = $dbh->prepare($film_query);
        $film_statement->bindParam(':film_id', $film_id, PDO::PARAM_INT);
        $film_statement->execute();
        $film_row = $film_statement->fetch(PDO::FETCH_ASSOC);

        if($film_row) {
            $show_datum = $film_row['release_date'];
            $show_time = $film_row['duration'];
?>

<form action="PHP/edit_show.php" method="post">
    <div class="form-group">
        <label for="show_datum">Datum:</label>
        <input type="date" class="form-control" id="show_datum" name="show_datum" placeholder="Enter new datum" value="<?php echo $show_datum; ?>" required>
        <label for="show_time">Time:</label>
        <input type="time" class="form-control" id="show_time" name="show_time" placeholder="Enter new time" value="<?php echo $show_time; ?>" required>

        <input type="hidden" name="film_id" value="<?php echo $film_id; ?>">

        <button type="submit" class="btn btn-success" name="edit">Edit</button>
    </div>
</form>

<?php
      } else {
          echo "Film not found.";
      }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "No valid film selected.";
}
?>