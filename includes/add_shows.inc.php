<?php
require './private/conn.php'; // Assuming you have a connection file

if(isset($_GET['hall_id'])) {
    $hall_id = htmlspecialchars($_GET['hall_id']);
} else {
    echo "Hall ID is not provided in the URL.";
}

// Fetch films from the database
$films_query = "SELECT * FROM films";
$films_result = $dbh->query($films_query);
?>

<div class="container mt-5">
    <h2>Add Film to Hall</h2>
    <form id="addFilmForm" action="php/add_show.php" method="POST">
        <input type="hidden" name="hall_id" value="<?php echo $hall_id; ?>">
        
        <div class="form-group">
            <label for="film">Select Film:</label>
            <select class="form-control" id="film" name="film_id">
                <?php foreach ($films_result as $film) : ?>
                    <option value="<?php echo $film['film_id']; ?>"><?php echo $film['film_title']; ?></option>
                <?php endforeach; ?>
            </select>   
        </div>

        <div class="form-group">
            <label for="showing_date">Showing Date:</label>
            <input type="date" class="form-control" id="showing_date" name="showing_date" required>
        </div>

        <div class="form-group">
            <label for="showing_time">Showing Time:</label>
            <input type="time" class="form-control" id="showing_time" name="showing_time" required>
        </div>
        <button type="button" class="btn btn-primary" onclick="submitForm()">Add Film to Hall</button>
    </form>
</div>

<script>
function submitForm() {
    document.getElementById("addFilmForm").submit();
}
</script>
