<div class="container mt-5">
    <h2>Beschikbare Tijden voor Film: The Matrix</h2>
    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            Zaal 1
          </div>
          <div class="card-body">
            <p class="card-text">Tijd: 18:00</p>
            <p class="card-text">Beschikbare Stoelen: <span id="availableSeats1">50</span></p>
            <button onclick="showReservationForm(1)" class="btn btn-primary">Reserveer</button>
            <form id="reservationForm1" style="display: none;">
              <h4>Reserveer Stoelen</h4>
              <div id="seats1">
                <!-- Stoelknoppen worden hier weergegeven -->
              </div>
              <button type="submit" class="btn btn-success">Bevestigen</button>
            </form>
          </div>
        </div>
      </div>
      <!-- Voeg meer zaal kaarten toe -->
    </div>
  </div>

  <!-- Footer -->
  <footer class="bg-dark text-white text-center py-3 mt-5">
    <p>&copy; 2024 Cinema Home</p>
  </footer>

  <!-- Bootstrap JS en afhankelijkheden -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <!-- JavaScript code -->
  <script>
    // Functie om het formulier voor het reserveren van stoelen te tonen
    function showReservationForm(roomId) {
      var form = document.getElementById("reservationForm" + roomId);
      form.style.display = "block";

      var availableSeats = parseInt(document.getElementById("availableSeats" + roomId).innerText);
      var seatsDiv = document.getElementById("seats" + roomId);
      seatsDiv.innerHTML = ""; // Leeg de stoelcontainer

      // Voeg stoelen toe
      for (var i = 1; i <= availableSeats; i++) {
        var seatButton = document.createElement("button");
        seatButton.innerText = "Stoel " + i;
        seatButton.setAttribute("class", "btn btn-secondary mr-2 mt-2");
        seatButton.setAttribute("onclick", "reserveSeat(" + roomId + ", " + i + ")");
        seatsDiv.appendChild(seatButton);
      }
    }

    // Functie om een stoel te reserveren
    function reserveSeat(roomId, seatNumber) {
      var availableSeats = parseInt(document.getElementById("availableSeats" + roomId).innerText);
      if (availableSeats > 0) {
        // Verminder het aantal beschikbare stoelen met 1
        document.getElementById("availableSeats" + roomId).innerText = availableSeats - 1;

        // Voeg een bericht toe dat de stoel is gereserveerd
        alert("Stoel " + seatNumber + " in Zaal " + roomId + " is gereserveerd!");
      } else {
        alert("Er zijn geen beschikbare stoelen meer!");
      }
    }
  </script>