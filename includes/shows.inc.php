<?php
require './private/conn.php';

if(isset($_GET['film_id']) && filter_var($_GET['film_id'], FILTER_VALIDATE_INT)) {
    $selected_hall_id = $_GET['film_id'];

    try {
        $total_seats_query = "SELECT COUNT(*) AS total_seats FROM seats ";
        $total_seats_statement = $dbh->prepare($total_seats_query);
        $total_seats_statement->execute();
        $total_seats_row = $total_seats_statement->fetch(PDO::FETCH_ASSOC);
        $total_seats = $total_seats_row['total_seats'];

        $mapping_query = "SELECT film_id, hall_id FROM `shows` WHERE film_id = :film_id";
        $mapping_statement = $dbh->prepare($mapping_query);
        $mapping_statement->bindParam(':hall_id', $selected_hall_id, PDO::PARAM_INT);
        $mapping_statement->execute();
        $mapping_rows = $mapping_statement->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <div class="container mt-3">
            <div class="row justify-content-end">
                <div class="col-auto">
                    <form action="index.php?page=add_shows" method="POST">
                        <input type="hidden" name="hall_id" value="<?php echo htmlspecialchars($selected_hall_id); ?>">
                        <button type="submit" class="btn btn-success">Add new film +</button>
                    </form>
                </div>
            </div>
        </div>

        <?php
        foreach ($mapping_rows as $mapping_row) {
            $film_id = $mapping_row['film_id'];

            $film_query = "SELECT * FROM films WHERE film_id = :film_id";
            $film_statement = $dbh->prepare($film_query);
            $film_statement->bindParam(':film_id', $film_id, PDO::PARAM_INT);
            $film_statement->execute();
            $film_row = $film_statement->fetch(PDO::FETCH_ASSOC);

            $reserved_seats_query = "SELECT COUNT(*) AS reserved_seats FROM seat_order WHERE show_id IN (SELECT show_id FROM shows WHERE film_id = :film_id AND hall_id = :hall_id)";
            $reserved_seats_statement = $dbh->prepare($reserved_seats_query);
            $reserved_seats_statement->bindParam(':film_id', $film_id, PDO::PARAM_INT);
            $reserved_seats_statement->bindParam(':hall_id', $selected_hall_id, PDO::PARAM_INT);
            $reserved_seats_statement->execute();
            $reserved_seats_row = $reserved_seats_statement->fetch(PDO::FETCH_ASSOC);
            $reserved_seats = $reserved_seats_row['reserved_seats'];
            $available_seats = $total_seats - $reserved_seats;

            if (!empty($film_row['photo'])) {
                $base64Image = base64_encode($film_row['photo']);
                $imageDataUrl = "data:image/jpeg;base64,$base64Image";
            } else {
                $imageDataUrl = ""; 
            }
            ?>
            <div class="container mt-5">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="row no-gutters">
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title"> <?php echo htmlspecialchars($film_row['film_title'], ENT_QUOTES, 'UTF-8'); ?></h5>
                                        <p class="card-text">Datum: <?php echo htmlspecialchars($film_row['release_date'], ENT_QUOTES, 'UTF-8'); ?></p>
                                        <p class="card-text">duration: <?php echo htmlspecialchars($film_row['duration'], ENT_QUOTES, 'UTF-8'); ?></p>
                                        <p class="card-text">hall: <?php echo htmlspecialchars($film_row['hall'], ENT_QUOTES, 'UTF-8'); ?></p>

                                        <p class="card-text">Beschikbare Stoelen: <?php echo $available_seats; ?></p>
                                        <?php
                                        echo '<a href="index.php?page=user_filmoverzicht&film_id=' . $film_id . '" class="btn btn-primary">Details</a>';
                                        ?>
                                        <form action="php/delete_show.php" method="post">
                                            <input type="hidden" name="deleteshow" value="<?php echo $film_id; ?>">
                                            <button type="submit" name="DeleteShow" class="btn btn-danger">Delete</button>
                                        </form>

                                        <?php
                                        echo '<button type="button" class="btn btn-warning">Edit</button>';
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <img src="<?php echo $imageDataUrl; ?>" class="card-img" alt="<?php echo htmlspecialchars($film_row['film_title'], ENT_QUOTES, 'UTF-8'); ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "No valid hall selected.";
}
?>