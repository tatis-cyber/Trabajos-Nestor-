<?php
session_start();
class Persona {
    private $nombre;
    private $apellido;
    private $fechaNacimiento;

    private $edad;
    private $email;
    private $telefono;
    private $genero;

    public function __construct($nombre, $apellido, $fechaNacimiento, $edad, $email, $telefono, $genero) {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->fechaNacimiento = $fechaNacimiento;
        $this->edad = $edad;
        $this->email = $email;
        $this->telefono = $telefono;
        $this->genero = $genero;
    }

    // Getters
        public function getNombre(): string {
            return $this->nombre;
        }

        public function getApellido(): string {
            return $this->apellido;
        }

        public function getNombreCompleto(): string {
            return $this->nombre . " " . $this->apellido;
        }

        public function getFechaDeNacimiento(): string {
            return $this->fechaNacimiento;
        }

        public function getEdad(): int {
            return $this->edad;
        }

        public function getEmail(): string {
            return $this->email;
        }

        public function getTelefono(): string {
            return $this->telefono;
        }

        public function getGenero(): ?string {
            return $this->genero;
        }

    // Setters
        public function setNombre($nombre) {
            $this->nombre = $nombre;
        }

        public function setApellido($apellido) {
            $this->apellido = $apellido;
        }

        public function setFechaNacimiento($fechaNacimiento) {
            $this->fechaNacimiento = $fechaNacimiento;
        }

        public function setEdad($edad) {
            $this->edad = $edad;
        }

        public function setEmail($email) {
            $this->email = $email;
        }

        public function setTelefono($telefono) {
            $this->telefono = $telefono;
        }

        public function setGenero($genero) {
            $this->genero = $genero;
        }

    //Metodos principales
        public static function calcularEdad($anio, $mes, $dia) {

                 $anio_nac = $anio;
                 $mes_nac = $mes;
                 $dia_nac = $dia;

                 $anio_actual = date("Y");
                 $mes_actual = date("m");
                 $dia_actual = date("d");

                 $edad = $anio_actual - $anio_nac;

                if ($mes_actual < $mes_nac || ($mes_actual == $mes_nac && $dia_actual < $dia_nac)) {
                        $edad--;
                    }

                return $edad;
    
        }

        public function comer()
        {
            return $this->getNombreCompleto() . " esta comiendo lasaña, le encanta la pasta" ;
        }
        public function caminar()
        {
            return $this->getNombreCompleto() . " esta caminando por la playa" ;
        }
        public function hablar()
        {
            return $this->getNombreCompleto() . " esta hablando en ingles con sus amigos" ;
        }
        public function dormir()
        {
            return $this->getNombreCompleto() . " esta durmiendo profundo" ;
        }
        public function estudiar()
        {
            return $this->getNombreCompleto() . " esta estudiando programacion de software" ;
        }
}



if(!isset($_SESSION["personas"])) {
    $_SESSION["personas"] = [];
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["button__eliminar"])) {
    $indice = $_POST["indice"];

    unset($_SESSION["personas"][$indice]);

    $_SESSION["personas"] = array_values($_SESSION["personas"]);

    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["agregar"])) {

    $nombre = $_POST["name"];
    $apellido = $_POST["surname"];
    $fechaNacimiento = $_POST["date"];
    $email = $_POST["correo"];
    $telefono = $_POST["phone"];
    $genero = $_POST["genero"];

    //ejemplo fecha 2006/12/26

    $anio = intval(substr($fechaNacimiento,0, 4));
    $mes = intval(substr($fechaNacimiento,5, 2));
    $dia = intval(substr($fechaNacimiento,8, 2));

    $edad = Persona::calcularEdad($anio, $mes, $dia);


    $persona = new Persona ($nombre, $apellido, $fechaNacimiento, $edad, $email, $telefono, $genero );

    $_SESSION["personas"][] = $persona;

    header("Location: index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SG Persona</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time();?>"> 
</head>
<body>
    <header class="header">
        <h1>SG Persona</h1>
    </header>

    <div class="section">
       <form class="form" action="index.php" method="post">

            <div class="form__input__container">
                <label for="name">Nombre:</label>
                <input type="text" name="name" class="form__input" id="name" required>
            </div>

            <div class="form__input__container">
                <label for="surname">Apellido:</label>
                <input type="text" name="surname" class="form__input" id="surname" required>
            </div>

            <div class="form__input__container">
                <label for="date">Fecha de nacimiento:</label>
                <input type="date" name="date" class="form__input" id="date" required>
            </div>

            <div class="form__input__container">
                <label for="correo">Email:</label>
                <input type="email" name="correo" class="form__input" id="correo" required>
            </div>

            <div class="form__input__container">
                <label for="phone">Telefono:</label>
                <input type="text" name="phone" class="form__input" id="phone" required>
            </div>

            <div class="form__input__container">
                <label for="genero">Genero:</label>
                <select class="form__input" name="genero" id="genero">
                    <option value="">seleccionar...</option>
                    <option value="Femenino">Femenino</option>
                    <option value="Masculino">Masculino</option>
                    <option value="Prefiero_no_decirlo">Prefiero no decirlo</option>
                </select>
                
            </div>

            <div class="form__input__container">
                <button type="submit" id="agregar" name="agregar">Agregar</button>
            </div>

       </form>

    </div>

    <div class="contenido">
        <table>

            <thead>

                <th>Nombre Completo</th>
                <th>Edad</th>
                <th>Email</th>
                <th>Telefono</th>
                <th>Genero</th>

            </thead>

                <tbody>

                <?php
                if (isset($_SESSION["personas"]) && count($_SESSION["personas"]) > 0) {
                    foreach ($_SESSION["personas"] as $indice => $p) {
                        echo "
                            <tr>
                                <td>{$p->getNombreCompleto()}</td>
                                <td>{$p->getEdad()}</td>
                                <td>{$p->getEmail()}</td>
                                <td>{$p->getTelefono()}</td>
                                <td>{$p->getGenero()}</td>
                                <td>

                                    <button type='button' class='btn-comer' onclick=\"alert('{$p->comer()} ');\">🍔</button>
                                    <button type='button' class='btn-caminar' onclick=\"alert('{$p->caminar()} ');\">🚶‍♂️</button>
                                    <button type='button' class='btn-hablar' onclick=\"alert('{$p->hablar()} ');\">🗣️</button>
                                    <button type='button' class='btn-dormir' onclick=\"alert('{$p->dormir()} ');\">😴</button>
                                    <button type='button' class='btn-estudiar' onclick=\"alert('{$p->estudiar()} ');\">📚</button>
                                    

                                    <form method='POST' action='index.php' style='display:inline;'>
                                        <input type='hidden' name='indice' value='{$indice}'>
                                        <button type='submit' name='button__eliminar' class='btn-eliminar' onclick='return confirm(\"¿Estás seguro de eliminar esta persona?\")'>Eliminar</button>
                                    </form>


                                </td>
                            </tr>
                        ";
                    }
                } else {
                    echo "<tr><td colspan='6' style='text-align:center;'>No hay personas registradas</td></tr>";
                }
                ?>
                </tbody>
        </table>

    </div>
</body>
</html>