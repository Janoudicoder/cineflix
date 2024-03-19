<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header bg-danger text-white">
          <h3 class="text-center">Film Aanpassen</h3>
        </div>
        <div class="card-body">
          <form>
          <div class="form-group">
              <label for="title">Title:</label>
              <input type="title" class="form-control" id="title" placeholder="Voer film title">
            </div>
            <div class="form-group">
              <label for="photo">Foto:</label>
              <input type="file" class="form-control-file" id="photo">
            </div>
            <div class="form-group">
              <label for="trailer">Trailer:</label>
              <input type="text" class="form-control" id="trailer" placeholder="Voer de URL van de trailer in">
            </div>
            <div class="form-group">
              <label for="genre">Genre:</label>
              <select multiple class="form-control" id="genre">
                <option>Actie</option>
                <option>Drama</option>
                <option>Comedy</option>
              </select>
            </div>
            <div class="form-group">
              <label for="description">Beschrijving:</label>
              <textarea class="form-control" id="description" rows="3" placeholder="Voer de beschrijving van de film in"></textarea>
            </div>
            <div class="form-group">
              <label for="pegi">PEGI:</label>
              <input type="number" class="form-control" id="pegi" placeholder="Voer de PEGI-beoordeling in">
            </div>
         
            <div class="form-group">
              <label for="release">Release Datum:</label>
              <input type="date" class="form-control" id="release" placeholder="Voer de releasedatum van de film in">
            </div>
            <div class="form-group">
              <label for="price">Prijs:</label>
              <input type="text" class="form-control" id="price" placeholder="Voer de prijs van de film in">
            </div>
            <button type="submit" class="btn btn-danger btn-block">Aanpassen</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
