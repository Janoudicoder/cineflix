<?php
require './private/conn.php';

if (isset($_POST['Edit_Genre']))
{
    $id = $_POST['Edit_Genre'];
    $query = "SELECT * FROM genre WHERE genre_id =:id";
    $statement = $dbh->prepare($query);
    $data = ['id' => $id];
    $statement->execute($data);
    $result = $statement->fetch(PDO::FETCH_ASSOC);
}
?>

<h1>Edit Genre</h1>

<form action="php/edit_genre.php" method="post">
    <div class="form-group">
        <label for="genre_name">Genre Name:</label>
        <input type="hidden" name="id" value="<?= $result['genre_id'] ?>">
        <input type="text" class="form-control" id="genre_name" name="genre_name" value="<?= $result['name'] ?>" placeholder="Enter Genre Name" required>
        <button type="submit" class="btn btn-success" name="edit">Edit </button>
    </div>
</form>
