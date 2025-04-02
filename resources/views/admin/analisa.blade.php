@extends('sidebaradmin')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chart Pelanggaran per Kelas</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div style="width: 80%; margin: auto;">
        <canvas id="pelanggaranChart"></canvas>
    </div>
    

    <script>
        // Data dari controller
        const labels = {!! json_encode($data->pluck('kelas')) !!};
        const dataPelanggaran = {!! json_encode($data->pluck('total_pelanggaran')) !!};

        // Konfigurasi Chart.js
        const ctx = document.getElementById('pelanggaranChart').getContext('2d');
        const pelanggaranChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Pelanggaran',
                    data: dataPelanggaran,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    title: {
                        display: true,
                        text: 'Diagram Pelanggaran Berdasarkan Kelas'
                    }
                }
            }
        });
    </script>
</body>
</html>
@endsection
