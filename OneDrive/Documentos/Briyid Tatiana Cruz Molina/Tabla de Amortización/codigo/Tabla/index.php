<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simulador de Tabla de Amortización</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h1>Simulador de Tabla de Amortización</h1>

    <form method="POST" class="formulario">
        <label for="monto">Monto de la Deuda:</label>
        <input type="number" id="monto" name="monto" step="0.01" required>

        <label for="interes">Tasa de Interés (% anual):</label>
        <input type="number" id="interes" name="interes" step="0.01" required>

        <label for="plazo">Plazo (meses):</label>
        <input type="number" id="plazo" name="plazo" required>

        <button type="submit">Calcular</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $monto = $_POST['monto'];
        $interesAnual = $_POST['interes'];
        $plazo = $_POST['plazo'];

        if ($monto > 0 && $interesAnual > 0 && $plazo > 0) {
            $interesMensual = $interesAnual / 100 / 12;
            $cuota = $monto * ($interesMensual * pow(1 + $interesMensual, $plazo)) / (pow(1 + $interesMensual, $plazo) - 1);
            $saldo = $monto;

            echo "<h2>Tabla de Amortización</h2>";
            echo "<table class='amort-table'>
                    <thead>
                        <tr>
                            <th>Mes</th>
                            <th>Cuota</th>
                            <th>Interés</th>
                            <th>Capital</th>
                            <th>Saldo</th>
                        </tr>
                    </thead>
                    <tbody>";

            for ($i = 1; $i <= $plazo; $i++) {
                $interes = $saldo * $interesMensual;
                $capital = $cuota - $interes;
                $saldo -= $capital;

                if ($saldo < 0) $saldo = 0;

                echo "<tr>
                        <td>$i</td>
                        <td>" . number_format($cuota, 2) . "</td>
                        <td>" . number_format($interes, 2) . "</td>
                        <td>" . number_format($capital, 2) . "</td>
                        <td>" . number_format($saldo, 2) . "</td>
                      </tr>";
            }

            echo "</tbody></table>";
        } else {
            echo "<p class='error'>⚠️ Por favor ingresa valores válidos.</p>";
        }
    }
    ?>
</div>

</body>
</html>
