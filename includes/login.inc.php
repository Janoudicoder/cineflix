
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
              <input type="text" name="email" class="form-control" id="username" placeholder="Voer uw gebruikersnaam in">
            </div>
            <div class="form-group">
              <label for="password">Wachtwoord:</label>
              <input type="password" name="password" class="form-control" id="password" placeholder="Voer uw wachtwoord in">
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
