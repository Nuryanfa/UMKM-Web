<h2>Riwayat Pesanan</h2>

<table class="table table-striped">
    <thead><tr>
        <th>Kode</th><th>Status</th><th>Total</th><th>Tanggal</th>
    </tr></thead>
    <tbody>
        @foreach($pesanan as $p)
        <tr>
            <td>{{ $p->kode_pesanan }}</td>
            <td><span class="badge bg-secondary">{{ $p->status }}</span></td>
            <td>Rp {{ number_format($p->total_harga) }}</td>
            <td>{{ $p->tanggal_pesanan }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
