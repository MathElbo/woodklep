<?php
$userrole = [1, 2, 3, 4];
include("./php-scripts/security.php");

// Opvragen van gegevens van de huidige inlogger
include("./php-scripts/connectDB.php");
include("./php-scripts/functions.php");
$id = $_SESSION["id"];
$userrole = $_SESSION["userrole"];

// Get all userinfo
$resultu = getSpecificInfo('woodklep_users', 'userid', $id);
$userinfo = mysqli_fetch_assoc($resultu);

// First get u role from woodklep_users and see if role is student
if ($userinfo["userroleid"] == 1) {
    // Get klas from user_klas_koppel 
    $sql = "SELECT * FROM `user_klas_koppel`
            WHERE userid = '$id'";
    $result = mysqli_query($conn, $sql);
    $userkoppelklas = mysqli_fetch_assoc($result);
    $klas = $userkoppelklas["klas_id"];
    if (isset($klas)) {
        // Get opdrachten from hw_klas_koppel
        $sql = "SELECT * from `hw_klas_koppel`";
        $result = mysqli_query($conn, $sql);
        $rows = mysqli_num_rows($result);

        $opdracht = array();


        for ($i = 1; $i <= $rows; $i++) {
            $sql = "SELECT * FROM `hw_klas_koppel`
                WHERE hwklas_id = '$i'";
            $result = mysqli_query($conn, $sql);
            $klaskoppelhw = mysqli_fetch_assoc($result);
            if ($klaskoppelhw["klas_id"] == $klas) {
                $opdracht[] = $klaskoppelhw["hw_opdracht_id"];
            }
        }
    }
    $sql = "SELECT * FROM `woodklep_user_koppel`
    WHERE user_id = $id";
    $result = mysqli_query($conn, $sql);
    $woodklepid = mysqli_fetch_assoc($result);
}
?>

<div class="jumbotron jumbotron-fluid homeJumbo">
    <div class="container">
        <h1 class="display-4">student</h1>
        <div class="container">
            <div class="row">
                <div class="col-6">
                    <div class="row">
                            </div>
                        </form>';
                            }
                        } else {
                            echo '<form action="index.php?content=script-user-klasselect" method="post">
                                    <div class="form-group">
                                        <select class="form-control" name="klas" id="klas" required>  
                                            <option value="">Selecteer Klas</option>';
                            $sql = "SELECT * FROM `klas`";
                            $result = mysqli_query($conn, $sql);
                            $rows = mysqli_num_rows($result);

                            for ($i = 1; $i <= $rows; $i++) {
                                $sql = "SELECT * FROM `klas`
                                                WHERE klas_id = '$i'";
                                $result = mysqli_query($conn, $sql);
                                $array = mysqli_fetch_assoc($result);
                                echo '<option value="';
                                echo $array["klas_id"];
                                echo '">';
                                echo $array["klasnaam"];
                                echo '</option>';
                            }
                            echo '</select>
                                        <input class="btn btn-dark" type="submit" value="Register">
                                    </div>
                                </form>';
                        }
                        ?>

                    </div>
                </div>
                <div class="col-6">
                    <div class="card" style="width: fit-content;">
                        <img src="./assets/img/nlogo.jpg" class="card-img-top">
                        <div class="card-body">
                            <p class="card-text">
                                Doe "X" om doos te ontgrendellen
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>