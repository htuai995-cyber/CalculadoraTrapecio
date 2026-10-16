function calcularTrapecio() {
    // 1. Obtener los 5 campos de entrada
    const baseMayorInput = document.getElementById('txtBaseMayor');
    const baseMenorInput = document.getElementById('txtBaseMenor');
    const alturaInput = document.getElementById('txtAltura');
    const lado1Input = document.getElementById('txtLado1');
    const lado2Input = document.getElementById('txtLado2');

    // 2. Obtener los campos de salida (resultado)
    const areaInput = document.getElementById('txtA');
    const perimetroInput = document.getElementById('txtP');

    // Verificar que los elementos existan en la vista
    if (!baseMayorInput || !baseMenorInput || !alturaInput || !lado1Input || !lado2Input || !areaInput || !perimetroInput) {
        return;
    }

    // 3. Convertir los valores a decimales (floats)
    const B = parseFloat(baseMayorInput.value);
    const b = parseFloat(baseMenorInput.value);
    const h = parseFloat(alturaInput.value);
    const l1 = parseFloat(lado1Input.value);
    const l2 = parseFloat(lado2Input.value);

    // 4. Validar que todos los campos tengan valores válidos mayores a cero
    if (isNaN(B) || B <= 0 || isNaN(b) || b <= 0 || isNaN(h) || h <= 0 || isNaN(l1) || l1 <= 0 || isNaN(l2) || l2 <= 0) {
        // Si falta un dato o es inválido, limpiamos los resultados y detenemos la ejecución
        areaInput.value = '';
        perimetroInput.value = '';
        return;
    }

    // 5. Calcular Área y Perímetro
    const area = ((B + b) * h) / 2;
    const perimetro = B + b + l1 + l2;

    // 6. Mostrar resultados con 2 decimales
    areaInput.value = area.toFixed(2);
    perimetroInput.value = perimetro.toFixed(2);
}

document.addEventListener('DOMContentLoaded', function () {
    // Seleccionar todos los inputs involucrados en el cálculo
    const inputs = [
        document.getElementById('txtBaseMayor'),
        document.getElementById('txtBaseMenor'),
        document.getElementById('txtAltura'),
        document.getElementById('txtLado1'),
        document.getElementById('txtLado2')
    ];

    // Asignar el evento 'input' a cada campo para calcular en tiempo real
    inputs.forEach(input => {
        if (input) {
            input.addEventListener('input', calcularTrapecio);
        }
    });
});