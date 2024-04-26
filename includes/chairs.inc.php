<?php

require './private/conn.php';
$show_id = $_GET['show_id'];

if(isset($_SESSION['user'])) {
    $logged_in_user_id = $_SESSION['user'];
} else {
    $logged_in_user_id = null;
}

try {
    $selected_seats_query = "SELECT seat_id FROM seat_order WHERE show_id = :show_id";
    $selected_seats_statement = $dbh->prepare($selected_seats_query);
    $selected_seats_statement->bindParam(':show_id', $show_id, PDO::PARAM_INT);
    $selected_seats_statement->execute();
    $selected_seats_data = $selected_seats_statement->fetchAll(PDO::FETCH_COLUMN);

    $selected_seat_ids = $selected_seats_data;
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

try {
    $seats_query = "SELECT seat_id FROM seats";
    $seats_statement = $dbh->query($seats_query);
    $seats_data = $seats_statement->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stoelen pagina</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            background-color: #242333;
            display: flex;
            flex-direction: column;
            color: white;
            align-items: center;
            justify-content: center;
            height: 100vh;
            font-family: 'Lato', 'sans-serif';
        }

        .seat {
            background-color: #444451;
            height: 50px;
            width: 50px;
            margin: 3px;
            border-top-left-radius: 10px;
            border-bottom-right-radius: 70px;
            border-bottom-left-radius: 70px;
        }

        .seat_B {
            background-color: #444451;
            height: 50px;
            width: 50px;
            margin: 3px;
            border-top-left-radius: 10px;
            border-bottom-right-radius: 70px;
            border-bottom-left-radius: 70px;
        }

        .seat_C {
            background-color: #6feaf6;
            height: 50px;
            width: 50px;
            margin: 3px;
            border-top-left-radius: 10px;
            border-bottom-right-radius: 70px;
            border-bottom-left-radius: 70px;
        }
        .seat_D {
            background-color: white;
            height: 50px;
            width: 50px;
            margin: 3px;
            border-top-left-radius: 10px;
            border-bottom-right-radius: 70px;
            border-bottom-left-radius: 70px;
        }
        

        .row {
            display: flex;
        }

        .movie-container {
            margin: 50px 0;
        }

        .movie-container select {
            background-color: #fff;
            border: 0;
            border-radius: 5px;
            font-size: 14px;
            margin-left: 10px;
            padding: 5px 15px 5px 15px;
            -moz-appearance: none;
            -webkit-appearance: none;
            appearance: none;
        }

        .seat.selected {
            background-color: #6feaf6;
        }

        .seat.occupied {
            background-color: #fff;
        }

        .seat:not(.occupied):hover {
            cursor: pointer;
            transform: scale(1.2);
        }

        .showcase .seat:not(.occupied):hover {
            cursor: default;
            transform: scale(1);
        }

        .showcase {
            background-color: rgba(0, 0, 0, 0.1);
            padding: 5px 10px;
            border-radius: 5px;
            color: #777;
            list-style-type: none;
            display: flex;
            justify-content: space-between;
        }

        .showcase li {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 10px;
        }

        .showcase li small {
            margin-left: 10px;
        }

        .screen {
            background-color: #fff;
            height: 70px;
            width: 100%;
            margin: 15px 0;
            transform: rotateX(-45deg);
            box-shadow: 0 3px 10px rgba(255, 255, 255, 0.75);
        }

        .container {
            perspective: 1000px;
            margin-bottom: 30px;
        }

        p.text {
            margin: 5px 0;
        }

        p.text span {
            color: #6feaf6;
        }

        .res {
            background-color: #444451; /* Groene achtergrond */
            border: none; /* Geen rand */
            color: white; /* Witte tekst */
            padding: 15px 32px; /* Binnenmarge */
            text-align: center; /* Gecentreerde tekst */
            text-decoration: none; /* Geen onderstreping */
            display: inline-block; /* Weergave als inline-blok */
            font-size: 16px; /* Lettergrootte */
            margin: 4px 2px; /* Buitenmarge */
            cursor: pointer; /* Aanwijzer veranderen bij hover */
            border-radius: 8px; /* Afgeronde hoeken */
            transition: background-color 0.3s ease; /* Vloeiende overgang van achtergrondkleur bij hover */
        }

        /* Wanneer de muis erover gaat */
        .res:hover {
            background-color: red;
        }

        /* Voeg hier de stijl toe om te voorkomen dat gebruikers op bezette stoelen kunnen klikken */
        .occupied {
            pointer-events: none;
        }
    </style>
</head>
<body>
<ul class="showcase">
    <li>
        <div class="seat_B"></div>
        <small>Niet gereserveerd</small>
    </li>
    <li>
        <div class="seat_D"></div>
        <small>Niet beschikbaar</small>
    </li>
    <li>
        <div class="seat_C"></div>
        <small>Beschikbaar</small>
    </li>
</ul>

<div class="container">
    <div class="screen"></div>
    <div class="row">
        <?php
        foreach ($seats_data as $seat) {
            $seat_id = $seat['seat_id'];
            $seat_class = (in_array($seat_id, $selected_seat_ids)) ? 'selected' : '';
            $is_occupied = (in_array($seat_id, $selected_seat_ids)) ? true : false;
            if ($is_occupied) {
                $seat_class .= ' occupied';
            }
            echo '<button class="seat ' . $seat_class . '" data-seat-id="' . $seat_id . '"></button>';
        }
        if ($logged_in_user_id){
        ?>
    
            <form id="reservation-form" action="index.php?page=confirm_ticket" method="POST">
                <input type="hidden" name="film_id" value="<?php echo htmlspecialchars($_GET['film_id']); ?>">
                <input type="hidden" name="show_id" value="<?php echo htmlspecialchars($show_id); ?>">
                <center><button class="res">Reserveren</button></center>
            </form>
         </div>
         <?php
                }else{
                    $_SESSION['melding'] = 'please login first!*-*';
                    ?>
                      <form id="reservation-form" action="index.php?page=login" method="POST">
                        <br/>
                
                <center><button class="res">Reserveren</button></center>
            </form>
            <?php

                }
        ?>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const seats = document.querySelectorAll('.seat');

    seats.forEach(seat => {
        seat.addEventListener('click', function() {
            if (!this.classList.contains('occupied')) {
                this.classList.toggle('selected');
            }
        });
    });

    const reservationForm = document.getElementById('reservation-form');
    reservationForm.addEventListener('submit', function(event) {
        event.preventDefault();
        const selectedSeats = document.querySelectorAll('.selected:not(.occupied)'); // Alleen geselecteerde, niet-bezette stoelen
        const selectedSeatIds = Array.from(selectedSeats).map(seat => seat.dataset.seatId);

        // Verwijder eerst de eventuele eerder toegevoegde input
        const existingInput = document.querySelector('input[name="selected_seats"]');
        if (existingInput) {
            existingInput.remove();
        }

        // Voeg alleen de geselecteerde stoelen toe aan de factuurinvoer
        const selectedSeatsInput = document.createElement('input');
        selectedSeatsInput.type = 'hidden';
        selectedSeatsInput.name = 'selected_seats';
        selectedSeatsInput.value = JSON.stringify(selectedSeatIds);
        reservationForm.appendChild(selectedSeatsInput);

        this.submit();
    });
});


</script>

</body>
</html>