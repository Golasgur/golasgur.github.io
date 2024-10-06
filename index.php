<?php
// Carica il file XML
$xml = simplexml_load_file("data.xml");

// Inizializza array per i dati
$data = [];
foreach ($xml->persona as $persona) {
    $nome = (string)$persona->nome;
    $ritardo = (int)$persona->ritardo;
    $data[$nome] = $ritardo;
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grafico dei Ritardi</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h1>Ritardi delle Persone</h1>
    
    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Ritardo (minuti)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $nome => $ritardo): ?>
                <tr>
                    <td><?php echo $nome; ?></td>
                    <td><?php echo $ritardo; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <canvas id="myChart" width="400" height="200"></canvas>
    
    <script>
        const ctx = document.getElementById('myChart').getContext('2d');
        const labels = <?php echo json_encode(array_keys($data)); ?>;
        const ritardi = <?php echo json_encode(array_values($data)); ?>;

        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Ritardo (minuti)',
                    data: ritardi,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
