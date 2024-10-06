<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grafico dei Ritardi</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.3.0/papaparse.min.js"></script>
</head>
<body>
    <div class="container">
        <h1>Grafico dei Ritardi</h1>
        <canvas id="delayChart"></canvas>
    </div>

    <script>
        // Funzione per caricare il CSV e generare il grafico
        //hhhhhh
        function loadCSV() {
            Papa.parse('data.csv', {
                download: true,
                header: true,
                complete: function(results) {
                    const delayData = {};
                    const headers = results.meta.fields.slice(1); // Ignora la colonna Data

                    // Calcola il totale dei ritardi per ogni persona
                    results.data.forEach(row => {
                        headers.forEach(header => {
                            if (!delayData[header]) {
                                delayData[header] = 0;
                            }
                            delayData[header] += row[header] ? parseInt(row[header]) : 0;
                        });
                    });

                    // Genera il grafico
                    createChart(delayData);
                }
            });
        }

        // Funzione per creare il grafico
        function createChart(data) {
            const ctx = document.getElementById('delayChart').getContext('2d');
            const labels = Object.keys(data);
            const values = Object.values(data);

            const myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Totale Ritardo (minuti)',
                        data: values,
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
        }

        // Carica il CSV al caricamento della pagina
        window.onload = loadCSV;
    </script>
</body>
</html>
