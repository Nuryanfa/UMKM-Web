<h2>Daftar Pesanan</h2>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <thead><tr>
        <th>Kode</th><th>Pelanggan</th><th>Status</th><th>Total</th><th>Aksi</th>
    </tr></thead>
    <tbody>
        @foreach($pesanan as $p)
        <tr>
            <td>{{ $p->kode_pesanan }}</td>
            <td>{{ $p->user->nama }}</td>
            <td><span class="badge bg-info">{{ $p->status }}</span></td>
            <td>Rp {{ number_format($p->total_harga) }}</td>
            <td>
                <form method="POST" action="/admin/pesanan/{{ $p->id }}/status">
                    @csrf
                    <select name="status" class="form-select" onchange="this.form.submit()">
                        <option disabled selected>Ubah Status</option>
                        <option value="diproses">Diproses</option>
                        <option value="dikirim">Dikirim</option>
                        <option value="selesai">Selesai</option>
                        <option value="dibatalkan">Dibatalkan</option>
                    </select>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
