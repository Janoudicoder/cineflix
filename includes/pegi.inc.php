<?php
require './private/conn.php';

$query = "SELECT * FROM pegi_contents";
$result = $dbh->query($query);
?>

<h1>pegis</h1>

<table class="table">


    <thead>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th><form action="index.php?page=add_pegi" method="post">
                <button type="submit" class="btn btn-success">Add pegi</button>
            </form> 
        </th>
    </tr>
    </thead>
    <tbody>
    <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)) : ?>
        <tr>
            <td><?php echo $row['pegi_content_id']; ?></td>
            <td><?php echo $row['content']; ?></td>
            <td>
                <form method="post" action="index.php?page=edit_pegi">
                    <input type="hidden" name="Edit_Pegi" value="<?php echo $row['pegi_content_id']?>">
                    <button type="submit" class="btn btn-primary" value="Edit">Edit</button>

                </form>
                <form action="PHP/delete_pegi.php" method="post">
                    <input type="hidden" name="Delete_Pegi" value="<?php echo $row['pegi_content_id']?>">
                    <button type="submit" name="Delete_Pige" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>