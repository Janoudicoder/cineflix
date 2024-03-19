<?php

if (isset($_SESSION['melding'])) {
    echo '<p style="color: red;">' . $_SESSION['melding'] . '</p>';
    unset($_SESSION['melding']);
}



?>
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-header bg-danger text-white">
          <h3 class="text-center">Login</h3>
        </div>
        <div class="card-body">
          <form action="php/login.php" method="post">
            <div class="form-group">
              <label for="username">Email:</label>
              <input type="text" class="form-control" id="username" placeholder="Voer uw gebruikersnaam in" name="email">
            </div>
            <div class="form-group">
              <label for="password">Wachtwoord:</label>
              <input type="password" class="form-control" id="password" placeholder="Voer uw wachtwoord in" name="password">
            </div>
            <button type="submit" class="btn btn-danger btn-block">Login</button>


          </form>
          <div class="text-center mt-3">
              <p>Heb je geen account? <a href="./index.php?page=signup">Registreer hier</a></p>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
