<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? ('Laporan Pengunjung ' . $year) }}</title>
    <style>
        body { font-family: Arial, Helvetica, sans-serif; font-size: 12px; }
        .title { font-size: 16px; font-weight: bold; margin-bottom: 6px; }
        .meta { margin-bottom: 12px; }
        .chart { margin: 10px 0 14px; }
        .chart img { max-width: 100%; height: auto; border: 1px solid #ddd; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #333; padding: 6px 8px; }
        th { background: #f2f2f2; text-align: left; }
        td.num { text-align: right; }
        tfoot td { font-weight: bold; }
    </style>
</head>
<body>
    <div class="title">{{ $title ?? ('Pengunjung Website Perpustakaan PPI Curug Tahun ' . $year) }}</div>
    <div class="meta">Dibuat pada: {{ $generated_at->format('d-m-Y H:i') }}</div>

    @if(!empty($chart_base64_png))
        <div class="chart">
            <img alt="Grafik pengunjung" src="data:image/png;base64,{{ $chart_base64_png }}" />
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th style="width: 40px;">No</th>
                <th>Bulan</th>
                <th style="width: 140px;">Jumlah Pengunjung</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rows as $idx => $row)
                <tr>
                    <td class="num">{{ $idx + 1 }}</td>
                    <td>{{ $row['month'] }}</td>
                    <td class="num">{{ $row['visitors'] }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">Total</td>
                <td class="num">{{ $total }}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
