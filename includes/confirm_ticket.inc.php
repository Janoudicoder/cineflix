<?php
// Include the connection file
require './private/conn.php';

try {
    $film_id = isset($_POST['film_id']) ? $_POST['film_id'] : null;
    $show_id = isset($_POST['show_id']) ? $_POST['show_id'] : null;

    if (!$film_id || !$show_id) {
        throw new Exception("Film_id or show_id not provided.");
    }

    $query = "SELECT films.*, 
              pegi_age.age,
              films.price
              FROM films
              LEFT JOIN pegi_age ON films.pegi_age_id = pegi_age.pegi_age_id
              WHERE films.film_id = :film_id";


    $stmt = $dbh->prepare($query);
    $stmt->execute([':film_id' => $film_id]);
    $movie = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$movie) {
        throw new Exception("Film not found.");
    }

    $movieTitle = $movie['film_title'];
    $releaseDate = $movie['release_date'];
    $rating = $movie['age'];

    $price = $movie['price']; 


    $show_query = "SELECT date_time, hall_id FROM shows WHERE show_id = :show_id";
    $show_stmt = $dbh->prepare($show_query);
    $show_stmt->execute([':show_id' => $show_id]);
    $show = $show_stmt->fetch(PDO::FETCH_ASSOC);

    if (!$show)
    {
        throw new Exception("Show not found.");
    }

    $showTime = $show['date_time'];
    $hall = $show['hall_id'];

    $selected_seats = isset($_POST['selected_seats']) ? json_decode($_POST['selected_seats'], true) : [];
    $numberOfSeats = count($selected_seats);

    $totalPrice = $numberOfSeats * $price; 

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>

<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title text-center">Confirm Ticket</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <img src="<?php echo 'data:image/jpeg;base64,' . base64_encode($movie['photo']); ?>" class="img-fluid" alt="Film Image">
                    </div>
                    <div class="col-md-8">
                        <h5 class="card-title">Film Name: <?php echo htmlspecialchars($movieTitle ?? ''); ?></h5>
                        <p class="card-text"><strong>Date:</strong> <?php echo htmlspecialchars($releaseDate ?? ''); ?></p>
                        <p class="card-text"><strong>Time:</strong> <?php echo htmlspecialchars($showTime ?? ''); ?></p>
                        <p class="card-text"><strong>Hall:</strong> <?php echo htmlspecialchars($hall ?? ''); ?></p>
                        <p class="card-text"><strong>Seats:</strong> <?php echo isset($selected_seats) ? htmlspecialchars(implode(',', $selected_seats)) : ''; ?></p>
                        <p class="card-text"><strong>Price per seat:</strong> <?php echo isset($price) ? htmlspecialchars($price) : ''; ?>$</p>
                        <h5 class="card-title">Total: <?php echo isset($totalPrice) ? htmlspecialchars($totalPrice) : '0'; ?>$</h5>
                    </div>
                </div>
            </div>

            <div class="card-footer text-muted">
                <div class="text-center">
                    <form action="php/confirm_ticket.php" method="POST">
                        <input type="hidden" name="film_id" value="<?php echo htmlspecialchars($film_id); ?>">
                        <input type="hidden" name="hall_id" value="<?php echo htmlspecialchars($hall); ?>">
                        <input type="hidden" name="date" value="<?php echo htmlspecialchars($releaseDate); ?>">
                        <input type="hidden" name="time" value="<?php echo htmlspecialchars($showTime); ?>">
                        <input type="hidden" name="show_id" value="<?php echo htmlspecialchars($show_id); ?>">
                        <input type="hidden" name="price" value="<?php echo htmlspecialchars($totalPrice); ?>">
                        <input type="hidden" name="selected_seats" value="<?php echo htmlspecialchars(json_encode($selected_seats)); ?>">

                        <button type="submit" class="btn btn-primary">Confirm Ticket</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body> 