<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-header bg-danger text-white">
          <h3 class="text-center">Registreren</h3>
        </div>
        <div class="card-body">
          <form action="php/signup.php" method="post">
            <div class="form-group">
              <label for="firstName">Voornaam:</label>
              <input type="text" class="form-control" id="firstName" placeholder="Voer uw voornaam in" name="first_name">
            </div>
            <div class="form-group">
              <label for="lastName">Achternaam:</label>
              <input type="text" class="form-control" id="lastName" placeholder="Voer uw achternaam in" name="last_name">
            </div>
            <div class="form-group">
              <label for="email">Email:</label>
              <input type="email" class="form-control" id="email" placeholder="Voer uw emailadres in" name="email">
            </div>
            <div class="form-group">
              <label for="password">Wachtwoord:</label>
              <input type="password" class="form-control" id="password" placeholder="Voer uw wachtwoord in" name="password">
            </div>
              <div class="form-group">
                  <label for="confirmPassword">Bevestig Wachtwoord:</label>
                  <input type="password" class="form-control" id="confirmPassword" placeholder="Bevestig uw wachtwoord" name="confirm_password">
              </div>
            <div class="form-group">
              <label for="birthdate">Geboortedatum:</label>
              <input type="date" class="form-control" id="birthdate" placeholder="Voer uw geboortedatum in" name="birth_date">
            </div>
            <button type="submit" class="btn btn-danger btn-block" name="register">Registreren</button>
          </form>
          <div class="text-center mt-3">
              <p>Heb je wel account? <a href="./index.php?page=login">login hier</a></p>
            </div>
        </div>
        </div>
      </div>
    </div>
  </div>
</div>