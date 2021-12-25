<?php
$userrole = [3,4];
include("./php-scripts/security.php");
?>

<div class="jumbotron jumbotron-fluid homeJumbo">
    <div class="container">
        <h1 class="display-4">Docent</h1>
        <div class="container">
            <div class="row">
                <div class="col-6">
                    <div class="row">

                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Mijn Leerlingen</h5>
                                    <p class="card-text">Zie hier leerlingenoverzicht.</p>
                                    <a href="./index.php?content=docentgroepen" class="btn btn-dark">Ga naar mijn leerlingen</a>
                                </div>
                            </div>
                            <br>
                        </div>
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Mijn Opdrachten</h5>
                                    <p class="card-text">Zie hier opdrachtenoverzicht</p>
                                    <a href="./index.php?content=docentopdrachten" class="btn btn-dark">Ga naar mijn opdrachten</a>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
                <div class="col-6">
                    <div class="card" style="width: fit-content;">
                        <img src="./assets/img/nlogo.jpg" class="card-img-top">
                        <div class="card-body">
                            <p class="card-text">
                                De woodklep heeft mystische schatten die jij kunt ontgrendellen!
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>