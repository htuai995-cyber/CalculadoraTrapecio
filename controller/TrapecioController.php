<?php
require_once __DIR__ . '/../model/Trapecio.php';

class TrapecioController
{
    private Trapecio $modelo;

    public function __construct()
    {
        $this->modelo = new Trapecio();
    }

    public function procesarFormulario(): string
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return '';
        }

        $accion = $_POST['accion'] ?? '';

        if ($accion === 'guardar') {
            return $this->guardarOActualizar();
        }

        if ($accion === 'eliminar') {
            return $this->eliminar();
        }

        return '';
    }

    private function guardarOActualizar(): string
    {
        $id = (int) ($_POST['id_trapecio'] ?? 0);
        $detalle = trim($_POST['txtDetalle'] ?? '');
        
        // Recibimos las 5 medidas del trapecio
        $base_mayor = trim($_POST['txtBaseMayor'] ?? '');
        $base_menor = trim($_POST['txtBaseMenor'] ?? '');
        $altura = trim($_POST['txtAltura'] ?? '');
        $lado1 = trim($_POST['txtLado1'] ?? '');
        $lado2 = trim($_POST['txtLado2'] ?? '');

        // Validar que todos sean números válidos mayores a cero
        if (!is_numeric($base_mayor) || (float) $base_mayor <= 0 ||
            !is_numeric($base_menor) || (float) $base_menor <= 0 ||
            !is_numeric($altura) || (float) $altura <= 0 ||
            !is_numeric($lado1) || (float) $lado1 <= 0 ||
            !is_numeric($lado2) || (float) $lado2 <= 0) {
            return 'Ingrese valores válidos mayores a cero para todas las medidas del trapecio.';
        }

        if ($id > 0) {
            $this->modelo->actualizar($id, $detalle, (float)$base_mayor, (float)$base_menor, (float)$altura, (float)$lado1, (float)$lado2);
            header('Location: home.php?mensaje=actualizado');
            exit;
        }

        $this->modelo->guardar($detalle, (float)$base_mayor, (float)$base_menor, (float)$altura, (float)$lado1, (float)$lado2);
        header('Location: home.php?mensaje=guardado');
        exit;
    }

    private function eliminar(): string
    {
        $id = (int) ($_POST['id_trapecio'] ?? 0);

        if ($id <= 0) {
            return 'No se pudo eliminar el registro';
        }

        $this->modelo->eliminar($id);
        header('Location: home.php?mensaje=eliminado');
        exit;
    }

    public function listar(string $buscar = ''): array
    {
        return $this->modelo->listar($buscar);
    }

    public function obtenerParaEditar(int $id): ?array
    {
        if ($id <= 0) {
            return null;
        }

        return $this->modelo->obtenerPorId($id);
    }
}