<?php
require './private/conn.php';

if (isset($_POST['Edit_Pegi']))
{
    $id = $_POST['Edit_Pegi'];
    $query = "SELECT * FROM pegi_contents WHERE pegi_content_id =:id";
    $statement = $dbh->prepare($query);
    $data = ['id' => $id];
    $statement->execute($data);
    $result = $statement->fetch(PDO::FETCH_ASSOC);
}
?>

<h1>Edit PEGI</h1>

<form action="php/edit_pegi.php" method="post">
    <div class="form-group">
        <label for="Pige_name">Pige Name:</label>
        <input type="hidden" name="id" value="<?= $result['pegi_content_id'] ?>">
        <input type="text" class="form-control" id="genre_name" name="Pige_Name" value="<?= $result['content'] ?>" placeholder="Enter Genre Name" required>
        <button type="submit" class="btn btn-success" name="edit">Edit </button>
    </div>
</form>
