<?php
// Funzione per leggere il file CSV e calcolare il totale dei ritardi per ogni persona
function getDelayData($filename) {
    $data = [];
    if (($handle = fopen($filename, 'r')) !== FALSE) {
        $headers = fgetcsv($handle, 1000, ',');
        while (($row = fgetcsv($handle, 1000, ',')) !== FALSE) {
            for ($i = 1; $i < count($row); $i++) {
                if (!isset($data[$headers[$i]])) {
                    $data[$headers[$i]] = 0;
                }
                $data[$headers[$i]] += $row[$i] ? (int)$row[$i] : 0;
            }
        }
        fclose($handle);
    }
    return $data;
}

$delayData = getDelayData('data.csv');
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
    <div class="container">
        <h1>Grafico dei Ritardi</h1>
        <canvas id="delayChart"></canvas>
    </div>

    <script>
        const ctx = document.getElementById('delayChart').getContext('2d');
        const labels = <?php echo json_encode(array_keys($delayData)); ?>;
        const data = <?php echo json_encode(array_values($delayData)); ?>;

        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Totale Ritardo (minuti)',
                    data: data,
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
