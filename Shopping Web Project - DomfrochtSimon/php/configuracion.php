<?php
    $ruta = '../';
    require("encabezado.php");
	
?>

<main class="container py-3">
        <section class="d-flex justify-content-center">
            <form class="p-4 border rounded w-50" action="configuracion_ok.php" method="POST">
                <fieldset>
                    <legend class="text-center mb-4">Theme Selection</legend>

                    <section class="form-check">
                        <input class="form-check-input" type="radio" name="tema" id="tema_claro" value="claro" checked>
                        <label class="form-check-label" for="tema_claro">Light Theme</label>
                    </section>
                    <section class="form-check">
                        <input class="form-check-input" type="radio" name="tema" id="tema_oscuro" value="oscuro">
                        <label class="form-check-label" for="tema_oscuro">Dark Theme</label>
                    </section>

                    <button type="submit" class="btn btn-primary w-100 mt-4">Confirm</button>
                </fieldset>
            </form>
        </section>
    </main>

<?php
    require("pie.php");
?>