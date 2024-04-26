<?php




try {
    require './private/conn.php'; 
    $query = "SELECT * FROM halls"; 
    $result = $dbh->query($query);

    echo '<div class="container mt-5">';
    echo '<h2>Cinema Halls</h2>';
    echo '<a href="index.php?page=add_hall" class="btn btn-primary mb-3">Add New Hall</a>';
    echo '<table class="table">';
    echo '<thead>';
    echo '<tr>';
    echo '<th scope="col">#</th>';
    echo '<th scope="col">Name</th>';
    echo '<th scope="col">Capacity</th>';
    echo '<th scope="col">Actions</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $seatsQuery = "SELECT COUNT(*) as seat_count FROM seats ";
        $seatsStatement = $dbh->prepare($seatsQuery);
        $seatsStatement->execute();
        $seatCount = $seatsStatement->fetch(PDO::FETCH_ASSOC)['seat_count'];

        echo '<tr>';
        echo '<th scope="row">' . htmlspecialchars($row['hall_id']) . '</th>';
        echo '<td>' . htmlspecialchars($row['hall_number']) . '</td>';
        echo '<td>50</td>'; 
        echo '<td>';
        echo '<a href="index.php?page=hall_info&hall_id=' . urlencode($row['hall_id']) . '" class="btn btn-sm btn-success">View</a>';
        echo '<button type="button" class="btn btn-sm btn-primary">Edit</button>';
        echo '<form action="php/delete_hall.php" method="post" style="display:inline;">';
        echo '<input type="hidden" name="hall_id" value="' . $row['hall_id'] . '">';
        echo '<button type="submit" name="delete_hall" class="btn btn-sm btn-danger">Delete</button>';
        echo '</form>';
        echo '</td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
    echo '</div>';
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
