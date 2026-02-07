<h2>Checkout</h2>
<table class="table">
    <thead><tr><th>Produk</th><th>Jumlah</th><th>Subtotal</th></tr></thead>
    <tbody>
        @foreach($items as $item)
        <tr>
            <td>{{ $item->produk->nama_produk }}</td>
            <td>{{ $item->jumlah }}</td>
            <td>Rp {{ number_format($item->jumlah * $item->produk->harga) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
<p><strong>Total: Rp {{ number_format($total) }}</strong></p>
<form method="POST" action="/checkout/process">@csrf
    <button class="btn btn-success">Proses Pesanan</button>
</form>
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>

<button id="pay-button" class="btn btn-success">Bayar Sekarang</button>

<script type="text/javascript">
    document.getElementById('pay-button').addEventListener('click', function () {
        snap.pay("{{ $snapToken }}", {
            onSuccess: function(result){
                window.location.href = '/home?success=1';
            },
            onPending: function(result){
                alert("Menunggu pembayaran.");
            },
            onError: function(result){
                alert("Pembayaran gagal!");
            }
        });
    });
</script>

