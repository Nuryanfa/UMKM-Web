<h2>Keranjang Belanja</h2>
<form action="/checkout" method="GET">
    <table class="table">
        <thead><tr><th>Produk</th><th>Jumlah</th><th>Subtotal</th><th></th></tr></thead>
        <tbody>
            @foreach($items as $item)
            <tr>
                <td>{{ $item->produk->nama_produk }}</td>
                <td>{{ $item->jumlah }}</td>
                <td>Rp {{ number_format($item->jumlah * $item->produk->harga) }}</td>
                <td>
                    <form method="POST" action="/keranjang/{{ $item->id }}">@csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <button class="btn btn-primary">Checkout</button>
</form>
