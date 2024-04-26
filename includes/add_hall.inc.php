<?php
if (isset($_SESSION['melding'])) {
    echo '<p style="color: red;">' . $_SESSION['melding'] . '</p>';
    unset($_SESSION['melding']);
  }




if (isset($_SESSION['melding'])) {
    echo '<p style="color: red;">' . $_SESSION['melding'] . '</p>';
    unset($_SESSION['melding']);
  }


?>
<div class="container mt-3">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Add New Hall</h5>
                    <form action="php/add_hall.php" method="POST">
                        <div class="form-group">
                            <label for="hall_number">Hall Number</label>
                            <input type="number" class="form-control" id="hall_number" name="hall_number" required>
                        </div>
                      
                        <button type="submit" name="add_hall" class="btn btn-primary">Add Hall</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
