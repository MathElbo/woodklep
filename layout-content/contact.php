<div class="jumbotron jumbotron-fluid homeJumbo">
    <div class="container">
        <h1 class="display-4">Contact</h1>
        <p class="lead">Vul het formulier en ik neem binnen x werk dagen contact met u op.</p>
        <br>
        <p>Onze denkbeeldige contact gegevens:</p>
        <form action="index.php?content=script-contact" method="post">
          <div class="form-group">
            <input class="form-control" type="name" name="name" id="name" placeholder="Name" required>
            <input class="form-control" type="email" name="email" id="email" placeholder="E-mail" required>
            <textarea class="form-control" type="bericht" name="bericht" id="bericht" placeholder="Bericht" rows="5" cols="40" required></textarea>
            <input class="btn btn-dark" type="submit" value="Verstuur">
          </div>
        </form>
    </div>
</div>