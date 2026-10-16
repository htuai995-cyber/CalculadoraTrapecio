<?php
require_once __DIR__ . '/../config/Database.php';

class Trapecio
{
    private PDO $pdo;

    public function __construct()
    {
        $database = new Database();
        $this->pdo = $database->conectar();
    }

    public function listar(string $buscar = ''): array
    {
        if ($buscar !== '') {
            // Buscamos usando un solo parámetro :buscar repetido, es más limpio
            $sql = "SELECT * FROM trapecio
                    WHERE detalle LIKE :buscar
                       OR CAST(base_mayor AS CHAR) LIKE :buscar
                       OR CAST(base_menor AS CHAR) LIKE :buscar
                       OR CAST(altura AS CHAR) LIKE :buscar
                       OR CAST(area AS CHAR) LIKE :buscar
                       OR CAST(perimetro AS CHAR) LIKE :buscar
                    ORDER BY id_trapecio DESC";
            
            $stmt = $this->pdo->prepare($sql);
            $valorBuscar = '%' . $buscar . '%';
            
            $stmt->execute(['buscar' => $valorBuscar]);
            return $stmt->fetchAll();
        }

        $sql = "SELECT * FROM trapecio ORDER BY id_trapecio DESC";
        return $this->pdo->query($sql)->fetchAll();
    }

    public function obtenerPorId(int $id): ?array
    {
        $sql = "SELECT * FROM trapecio WHERE id_trapecio = :id LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        $registro = $stmt->fetch();

        return $registro ?: null;
    }

    public function guardar(string $detalle, float $base_mayor, float $base_menor, float $altura, float $lado1, float $lado2): bool
    {
        // Fórmulas matemáticas
        $area = (($base_mayor + $base_menor) * $altura) / 2;
        $perimetro = $base_mayor + $base_menor + $lado1 + $lado2;

        $sql = "INSERT INTO trapecio(detalle, base_mayor, base_menor, altura, lado1, lado2, area, perimetro)
                VALUES(:detalle, :base_mayor, :base_menor, :altura, :lado1, :lado2, :area, :perimetro)";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'detalle' => $detalle,
            'base_mayor' => $base_mayor,
            'base_menor' => $base_menor,
            'altura' => $altura,
            'lado1' => $lado1,
            'lado2' => $lado2,
            'area' => $area,
            'perimetro' => $perimetro,
        ]);
    }

    public function actualizar(int $id, string $detalle, float $base_mayor, float $base_menor, float $altura, float $lado1, float $lado2): bool
    {
        // Fórmulas matemáticas
        $area = (($base_mayor + $base_menor) * $altura) / 2;
        $perimetro = $base_mayor + $base_menor + $lado1 + $lado2;

        $sql = "UPDATE trapecio
                SET detalle = :detalle,
                    base_mayor = :base_mayor,
                    base_menor = :base_menor,
                    altura = :altura,
                    lado1 = :lado1,
                    lado2 = :lado2,
                    area = :area,
                    perimetro = :perimetro
                WHERE id_trapecio = :id";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'id' => $id,
            'detalle' => $detalle,
            'base_mayor' => $base_mayor,
            'base_menor' => $base_menor,
            'altura' => $altura,
            'lado1' => $lado1,
            'lado2' => $lado2,
            'area' => $area,
            'perimetro' => $perimetro,
        ]);
    }

    public function eliminar(int $id): bool
    {
        $sql = "DELETE FROM trapecio WHERE id_trapecio = :id";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute(['id' => $id]);
    }
}