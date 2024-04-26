
<?php
session_start();

require './private/conn.php';

$query = "SELECT * FROM genre";
$result = $dbh->query($query);
?>

<h1>Genres</h1>

<table class="table">


    <thead>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th><form action="index.php?page=add_genre" method="post">
    <button type="submit" class="btn btn-success">Add Genre</button>
</form></th>
    </tr>
    </thead>
    <tbody>
    <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)) : ?>
        <tr>
            <td><?php echo $row['genre_id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td>
                <form method="post" action="index.php?page=edit_genre">
                    <input type="hidden" name="Edit_Genre" value="<?php echo $row['genre_id']?>">
                        <button type="submit" class="btn btn-primary" value="Edit">Edit</button>

                </form>
                <form action="PHP/delete_genre.php" method="post">
                    <input type="hidden" name="Delete_Genre" value="<?php echo $row['genre_id']?>">
                    <button type="submit" value="Delete" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>

