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
              </div>
              <button type="submit" class="btn btn-success">Bevestigen</button>
            </form>
          </div>
        </div>
      </div>
    
    </div>
  </div>

 

  <script>
    var reservedSeats = [];

    function showReservationForm(roomId) {
      var form = document.getElementById("reservationForm" + roomId);
      form.style.display = "block";

      var availableSeats = parseInt(document.getElementById("availableSeats" + roomId).innerText);
      var seatsDiv = document.getElementById("seats" + roomId);
      seatsDiv.innerHTML = ""; /

      for (var i = 1; i <= availableSeats; i++) {
        var seatButton = document.createElement("button");
        seatButton.innerText = "Stoel " + i;
        seatButton.setAttribute("class", "btn btn-secondary mr-2 mt-2");
        seatButton.setAttribute("onclick", "reserveSeat(" + roomId + ", " + i + ")");
        seatsDiv.appendChild(seatButton);
      }
    }

    function reserveSeat(roomId, seatNumber) {
      var seatIndex = reservedSeats.indexOf(seatNumber);
      if (seatIndex === -1) {
        reservedSeats.push(seatNumber);
      } else {
        reservedSeats.splice(seatIndex, 1);
      }

      var seatButton = document.getElementById("seats" + roomId).querySelectorAll("button")[seatNumber - 1];
      if (reservedSeats.includes(seatNumber)) {
        seatButton.classList.add("reserved");
      } else {
        seatButton.classList.remove("reserved");
      }
    }
  </script>