<div class="jumbotron jumbotron-fluid homeJumbo ">
  <div class="container">
    <div class="abc rechts ">
    <h1 class="display-4 ">Contact</h1>
    <p class="lead ">Vul het formulier en ik neem binnen x werk dagen contact met u op.</p>
    <br>
    <p style="color:white">Zorg voor toegang tot het contact formulier dat u eerst inlogt</p>
</div>
    <!--Section: Contact v.2-->
    <section class="mb-4 ms-auto" >
      <div class="row">
        <!--Grid column-->
        <div class="col-md-9 mb-md-0 mb-5">
          <form id="contact-form" name="contact-form" action="mail.php" method="POST">

            <!--Grid row-->
            <div class="row">

              <!--Grid column-->
              <div class="col-md-6">
                <div class="md-form mb-0">
                  <input type="text" id="name" name="name" class="form-control">
                  <label for="name" class="tekstkleur"> Naam</label>
                </div>
              </div>
              <!--Grid column-->

              <!--Grid column-->
              <div class="col-md-6">
                <div class="md-form mb-0">
                  <input type="text" id="email" name="email" class="form-control">
                  <label for="email" class="tekstkleur">email</label>
                </div>
              </div>
              <!--Grid column-->

            </div>
            <!--Grid row-->

            <!--Grid row-->
            <div class="row">
              <div class="col-md-12">
                <div class="md-form mb-0">
                  <input type="text" id="probleem" name="probleem" class="form-control">
                  <label for="subject" class="tekstkleur">Probleem</label>
                </div>
              </div>
            </div>
            <!--Grid row-->

            <!--Grid row-->
            <div class="row">

              <!--Grid column-->
              <div class="col-md-12">

                <div class="md-form">
                  <textarea type="text" id="message" name="message" rows="2" class="form-control md-textarea"></textarea>
                  <label for="message">
                    <div class="tekstkleur"> Type hier in wat er aan de hand is
                  </label>
                </div>

              </div>
            </div>
            <!--Grid row-->

          </form>

          <div class="text-center text-md-left">
            <a class="btn btn-primary" onclick="document.getElementById('contact-form').submit();">Send</a>
          </div>
          <div class="status"></div>
        </div>
        <!--Grid column-->

        <!--Grid column-->
        <!--Grid column-->

      </div>

    </section>
    <!--Section: Contact v.2-->