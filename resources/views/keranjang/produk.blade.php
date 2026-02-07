<h2>Daftar Produk</h2>
@foreach($produk as $p)
    <div>
        <strong>{{ $p->nama_produk }}</strong> - Rp {{ number_format($p->harga) }} <br>
        <form action="/keranjang/tambah/{{ $p->id }}" method="POST">@csrf
            <button class="btn btn-success btn-sm">Tambah ke Keranjang</button>
        </form>
        <hr>
    </div>
@endforeach