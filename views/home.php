<?php
session_start();
require_once __DIR__ . '/../controller/AuthController.php';
require_once __DIR__ . '/../controller/TrapecioController.php';

AuthController::verificarSesion();

$trapecioController = new TrapecioController();
$mensaje = $_GET['mensaje'] ?? '';
$mensajeFormulario = $trapecioController->procesarFormulario();

if ($mensajeFormulario !== '') {
    $mensaje = $mensajeFormulario;
}

$buscar = trim($_GET['buscar'] ?? '');
$registroEditar = null;

if (isset($_GET['editar'])) {
    $registroEditar = $trapecioController->obtenerParaEditar((int) $_GET['editar']);
}

$registros = $trapecioController->listar($buscar);

$idActual = $registroEditar['id_trapecio'] ?? '';
$baseMayorActual = $registroEditar['base_mayor'] ?? '';
$baseMenorActual = $registroEditar['base_menor'] ?? '';
$alturaActual = $registroEditar['altura'] ?? '';
$lado1Actual = $registroEditar['lado1'] ?? '';
$lado2Actual = $registroEditar['lado2'] ?? '';
$detalleActual = $registroEditar['detalle'] ?? '';
$areaActual = $registroEditar['area'] ?? '';
$perimetroActual = $registroEditar['perimetro'] ?? '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index,follow">
    <meta name="description" content="Calculo del area y perimetro del trapecio">
    <meta name="keywords" content="trapecio, sistema, base de datos, area, perimetro">
    <meta name="author" content="Juan Jonatan">

    <link rel="icon" href="../imagenes/icono.svg">
    <link rel="stylesheet" href="../assetes/css/style_home.css">

    <title>Trapecio - Principal</title>
</head>
<body>
    <header class="headeerHome">
        <div class="lineaSup">
            <div class="logo-links">
                <div class="logo">
                    <img src="../imagenes/logo.svg" alt="">
                    <h1>Matemáticas</h1>
                </div>               
                <a href="">Quienes somos</a>
            </div>
            <div class="buscarHeader" >
                <form class="form1">
                    <img src="../imagenes/logo.svg" alt="imagen de buscar">
                    <button type="submit">Buscar</button>
                    <input type="text"  name="buscar" id="txtBuscar" placeholder="BUSCAR"
                    value="<?php echo htmlspecialchars($buscar); ?>">
                </form>
            </div>
        </div>
        <div class="lineaInf">
            <nav class="menu">
                <li>
                    <a href="#">Inicio</a>
                </li>
                <li>
                    <a href="">Nuestra historia</a>
                </li>
                <li>
                    <a href="logout.php" onclick="return confirm('¿Desea salir?');">Cerrar sesion</a>
                </li>
            </nav>
        </div>
    </header>

    
    <main>
        <div class="datos">
            <div class="titulo">
                <h1>Cálculo del área y perímetro del Trapecio</h1>
                <p>Usuario: <?php echo htmlspecialchars($_SESSION['usuario']['nombre'] ?? $_SESSION['usuario']); ?></p>
            </div>

            <?php if ($mensaje !== '') : ?>
                <p class="mensaje">
                    <?php echo htmlspecialchars(ucfirst($mensaje)); ?>
                </p>
            <?php endif; ?>


            <form action="" method="post" class="form2" id="frmFormulario">
                <input type="hidden" name="id_trapecio" value="<?php echo htmlspecialchars($idActual); ?>">

                <div class="inputs">
                    <label for="txtBaseMayor">Base Mayor (B)</label>
                    <input class="inputHome" type="number" step="0.01" name="txtBaseMayor" id="txtBaseMayor" placeholder="Ej: 10"
                     value="<?php echo htmlspecialchars($baseMayorActual); ?>" required>
                </div>
                
                <div class="inputs">
                    <label for="txtBaseMenor">Base Menor (b)</label>
                    <input class="inputHome" type="number" step="0.01" name="txtBaseMenor" id="txtBaseMenor" placeholder="Ej: 6"
                     value="<?php echo htmlspecialchars($baseMenorActual); ?>" required>
                </div>

                <div class="inputs">
                    <label for="txtAltura">Altura (h)</label>
                    <input class="inputHome" type="number" step="0.01" name="txtAltura" id="txtAltura" placeholder="Ej: 5"
                     value="<?php echo htmlspecialchars($alturaActual); ?>" required>
                </div>

                <div class="inputs">
                    <label for="txtLado1">Lado Lateral 1</label>
                    <input class="inputHome" type="number" step="0.01" name="txtLado1" id="txtLado1" placeholder="Ej: 5.3"
                     value="<?php echo htmlspecialchars($lado1Actual); ?>" required>
                </div>

                <div class="inputs">
                    <label for="txtLado2">Lado Lateral 2</label>
                    <input class="inputHome" type="number" step="0.01" name="txtLado2" id="txtLado2" placeholder="Ej: 5.3"
                     value="<?php echo htmlspecialchars($lado2Actual); ?>" required>
                </div>

                <div class="inputs">
                    <label for="txtDetalle">Comentario</label>
                    <input class="inputHome" type="text" placeholder="Opcional: Un comentario"
                    name="txtDetalle" id="txtDetalle" value="<?php echo htmlspecialchars($detalleActual); ?>">
                </div>
                
                <div class="inputs">
                    <label for="txtA">Área</label>
                    <input class="inputHome" type="text" name="txtA" id="txtA" readonly placeholder="Área calculada"
                     value="<?php echo htmlspecialchars($areaActual); ?>">
                </div>
                <div class="inputs">
                    <label for="txtP">Perímetro</label>
                    <input class="inputHome" type="text" name="txtP" id="txtP" readonly placeholder="Perímetro calculado"
                     value="<?php echo htmlspecialchars($perimetroActual); ?>">
                </div>
                <div class="botones">
                    <button type="button" onclick="calcularTrapecio();">Calcular</button>
                    <a class="btn-link cancelar" href="home.php">Cancelar</a>
                    <button type="submit" name="accion" value="guardar">
                        <?php echo $idActual !== '' ? 'Actualizar' : 'Guardar'; ?>
                    </button>
                </div>
            </form>
        </div>
        <div class="buscar">
            <form action="home.php" method="get" id="frmBuscar">
                <img src="../imagenes/logo.svg" alt="imagen de buscar">
                <button type="submit">Buscar</button>
                <input type="text" name="buscar" id="txtBuscar" placeholder="Buscar por medida o detalle"
                 value="<?php echo htmlspecialchars($buscar); ?>">
                <a class="btn-link limpiar" href="home.php">Limpiar</a>
            </form>
        </div>

        <div class="tabla">
            <h1>Historial de los cálculos</h1>
            <div style="overflow-x: auto;">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>B. Mayor</th>
                            <th>B. Menor</th>
                            <th>Altura</th>
                            <th>Lado 1</th>
                            <th>Lado 2</th>
                            <th>Detalle</th>
                            <th>Área</th>
                            <th>Perímetro</th>
                            <th>Fecha y hora</th>
                            <th>Botones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($registros) > 0) : ?>
                            <?php foreach ($registros as $fila) : ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($fila['id_trapecio']); ?></td>
                                    <td><?php echo htmlspecialchars($fila['base_mayor']); ?></td>
                                    <td><?php echo htmlspecialchars($fila['base_menor']); ?></td>
                                    <td><?php echo htmlspecialchars($fila['altura']); ?></td>
                                    <td><?php echo htmlspecialchars($fila['lado1']); ?></td>
                                    <td><?php echo htmlspecialchars($fila['lado2']); ?></td>
                                    <td><?php echo htmlspecialchars($fila['detalle']); ?></td>
                                    <td><?php echo htmlspecialchars($fila['area']); ?></td>
                                    <td><?php echo htmlspecialchars($fila['perimetro']); ?></td>
                                    <td><?php echo htmlspecialchars($fila['fecha_registro']); ?></td>
                                    <td class="acciones">
                                        <a class="btn-tabla editar" href="home.php?editar=<?php echo (int) $fila['id_trapecio']; ?>">Editar</a>

                                        <form action="" method="post" onsubmit="return confirm('¿Desea eliminar este registro?');" style="display:inline;">
                                            <input type="hidden" name="id_trapecio" value="<?php echo (int) $fila['id_trapecio']; ?>">
                                            <button class="btn-tabla eliminar" type="submit" name="accion" value="eliminar">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="11">No hay registros para mostrar.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script src="../assetes/js/app.js?v=3"></script>
</body>
</html>