<?php
    $ruta = '';
    require("php/encabezado.php");
?>
<main class="d-flex justify-content-center align-items-center login">
        <section class="text-center">
            <header>
                <h1 class="mb-4">Login</h1>
            </header>

            <form action="php/logueo.php" method="POST" class="p-4 rounded">
                <label for="username" class="form-label">Username</label>
                <input type="text" id="username" name="username" class="form-control mb-3" required>

                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control mb-4" required>

                <button type="submit" class="btn btn-primary w-100">Enter</button>
            </form>
        </section>
    </main>
<?php
    require("php/pie.php");
?>