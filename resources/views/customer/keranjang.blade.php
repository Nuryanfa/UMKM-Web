{{-- resources/views/customer/keranjang.blade.php --}}
@extends('layouts.app')

@section('title', 'Keranjang Belanja Anda')

@section('content')
<div class="container py-5">
    <h2 class="mb-5 text-center fw-bold animate__animated animate__fadeInDown">
        🛒 Keranjang Belanja Anda
    </h2>

    {{-- Alert Container for JS --}}
    <div id="alert-container">
        @if (session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: "{{ session('success') }}",
                        timer: 2000,
                        showConfirmButton: false
                    });
                });
            </script>
        @endif
        @if ($errors->any())
             <script>
                document.addEventListener('DOMContentLoaded', () => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        html: '<ul class="text-start">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
                    });
                });
            </script>
        @endif
    </div>

    {{-- Pesan Status Pembayaran (Midtrans Feedback) --}}
    @if ($paymentStatus)
        <div class="card card-modern mb-4 text-center p-4 border-radius-xl">
            @if ($paymentStatus == 'success')
                <div class="text-success mb-2"><i class="bi bi-check-circle-fill" style="font-size: 3rem;"></i></div>
                <h3 class="fw-bold text-success">Pembayaran Berhasil!</h3>
                <p class="text-muted">Terima kasih! Pesanan ID <span class="fw-bold">{{ $orderId }}</span> telah diverifikasi.</p>
                <div class="d-flex justify-content-center gap-3 mt-3">
                    @if ($latestTransaction)
                         <a href="{{ route('keranjang.invoice', $orderId) }}" class="btn btn-primary btn-rounded shadow-sm">
                            <i class="bi bi-receipt me-2"></i> Lihat Invoice
                        </a>
                    @endif
                    <a href="{{ route('produk.publik') }}" class="btn btn-outline-success btn-rounded">
                        <i class="bi bi-bag-plus me-2"></i> Belanja Lagi
                    </a>
                </div>
            @elseif ($paymentStatus == 'pending')
                <div class="text-warning mb-2"><i class="bi bi-hourglass-split" style="font-size: 3rem;"></i></div>
                <h3 class="fw-bold text-warning">Menunggu Pembayaran</h3>
                <p class="text-muted">Selesaikan pembayaran untuk pesanan ID <span class="fw-bold">{{ $orderId }}</span>.</p>
                <a href="{{ route('produk.publik') }}" class="btn btn-outline-secondary btn-rounded mt-2">Lanjutkan Belanja</a>
            @else
                <div class="text-danger mb-2"><i class="bi bi-x-circle-fill" style="font-size: 3rem;"></i></div>
                 <h3 class="fw-bold text-danger">Pembayaran Gagal</h3>
                <p class="text-muted">Transaksi untuk ID <span class="fw-bold">{{ $orderId }}</span> gagal atau dibatalkan.</p>
                <a href="{{ route('keranjang.index') }}" class="btn btn-danger btn-rounded mt-2">Coba Lagi</a>
            @endif
        </div>
    @endif

    @if ($items->isEmpty() && !$paymentStatus)
        {{-- Empty State --}}
        <div class="text-center py-5 animate__animated animate__fadeIn">
            <img src="https://cdn-icons-png.flaticon.com/512/11329/11329060.png" alt="Empty Cart" style="width: 200px; opacity: 0.7;">
            <h3 class="mt-4 fw-bold text-muted">Keranjang Anda Kosong</h3>
            <p class="text-muted">Sepertinya Anda belum memilih sayuran segar hari ini.</p>
            <a href="{{ route('produk.publik') }}" class="btn btn-success btn-lg btn-rounded shadow mt-3 px-5">
                <i class="bi bi-cart-plus me-2"></i> Mulai Belanja
            </a>
        </div>
    @elseif (!$items->isEmpty())
        <div class="row g-4">
            {{-- Cart Items --}}
            <div class="col-lg-8 animate__animated animate__fadeInLeft">
                <div class="card card-modern overflow-hidden">
                    <div class="card-body p-0">
                        {{-- Desktop Table --}}
                        <div class="table-responsive d-none d-md-block">
                            <table class="table align-middle mb-0 table-hover">
                                <thead class="bg-light text-uppercase text-muted small">
                                    <tr>
                                        <th class="ps-4 py-3">Produk</th>
                                        <th class="text-center">Harga</th>
                                        <th class="text-center">Jumlah</th>
                                        <th class="text-end pe-4">Subtotal</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($items as $item)
                                        <tr id="row-{{ $item->id }}">
                                            <td class="ps-4 py-3">
                                                <div class="d-flex align-items-center">
                                                    <img src="https://placehold.co/80x80/EFEFEF/666?text={{ substr($item->produk->nama_produk, 0, 2) }}" 
                                                         class="rounded-3 me-3 border" width="60" alt="{{ $item->produk->nama_produk }}">
                                                    <div>
                                                        <h6 class="mb-0 fw-bold text-dark">{{ $item->produk->nama_produk }}</h6>
                                                        <small class="text-muted">{{ $item->produk->kategori ?? 'Sayuran' }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">Rp{{ number_format($item->produk->harga, 0, ',', '.') }}</td>
                                            <td class="text-center">
                                                <div class="input-group input-group-sm d-inline-flex w-auto bg-light rounded-pill border">
                                                    <button class="btn btn-link link-dark text-decoration-none border-0 px-2 py-1 qty-btn" 
                                                            data-action="decrease" data-id="{{ $item->id }}">
                                                        <i class="bi bi-dash"></i>
                                                    </button>
                                                    <input type="text" class="form-control form-control-sm border-0 bg-transparent text-center p-0 fw-bold qty-input" 
                                                           id="qty-{{ $item->id }}" value="{{ $item->jumlah }}" readonly style="width: 40px;">
                                                    <button class="btn btn-link link-dark text-decoration-none border-0 px-2 py-1 qty-btn" 
                                                            data-action="increase" data-id="{{ $item->id }}">
                                                        <i class="bi bi-plus"></i>
                                                    </button>
                                                </div>
                                            </td>
                                            <td class="text-end pe-4 fw-bold text-primary" id="subtotal-{{ $item->id }}">
                                                Rp{{ number_format($item->jumlah * $item->produk->harga, 0, ',', '.') }}
                                            </td>
                                            <td class="text-end pe-3">
                                                <button onclick="confirmDelete('{{ $item->id }}')" class="btn btn-link text-danger p-0" title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                                <form id="delete-form-{{ $item->id }}" action="{{ route('keranjang.hapus', $item->id) }}" method="POST" class="d-none">
                                                    @csrf @method('DELETE')
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Mobile Cards --}}
                        <div class="d-md-none">
                            @foreach ($items as $item)
                                <div class="p-3 border-bottom position-relative" id="mobile-card-{{ $item->id }}">
                                    <div class="d-flex mb-3">
                                        <img src="https://placehold.co/100x100/EFEFEF/666?text={{ substr($item->produk->nama_produk, 0, 2) }}" 
                                             class="rounded-3 me-3 border" width="80" height="80" style="object-fit: cover;">
                                        <div class="flex-grow-1">
                                            <h6 class="fw-bold mb-1">{{ $item->produk->nama_produk }}</h6>
                                            <div class="text-muted small mb-2">Rp{{ number_format($item->produk->harga, 0, ',', '.') }} / item</div>
                                            <div class="fw-bold text-primary" id="mobile-subtotal-{{ $item->id }}">
                                                Rp{{ number_format($item->jumlah * $item->produk->harga, 0, ',', '.') }}
                                            </div>
                                        </div>
                                        <button onclick="confirmDelete('{{ $item->id }}')" class="btn btn-sm btn-light text-danger position-absolute top-0 end-0 m-3 rounded-circle shadow-sm" style="width: 30px; height: 30px; padding: 0;">
                                            <i class="bi bi-trash small"></i>
                                        </button>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-muted small">Jumlah:</span>
                                        <div class="input-group input-group-sm w-auto bg-light rounded-pill border">
                                            <button class="btn btn-link link-dark text-decoration-none border-0 px-3 qty-btn" 
                                                    data-action="decrease" data-id="{{ $item->id }}">
                                                <i class="bi bi-dash"></i>
                                            </button>
                                            <input type="text" class="form-control border-0 bg-transparent text-center p-0 fw-bold qty-input" 
                                                   id="mobile-qty-{{ $item->id }}" value="{{ $item->jumlah }}" readonly style="width: 40px;">
                                            <button class="btn btn-link link-dark text-decoration-none border-0 px-3 qty-btn" 
                                                    data-action="increase" data-id="{{ $item->id }}">
                                                <i class="bi bi-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- Summary Sidebar --}}
            <div class="col-lg-4 animate__animated animate__fadeInRight">
                <div class="card card-modern p-4 sticky-top" style="top: 100px; z-index: 1;">
                    <h5 class="fw-bold mb-4">Ringkasan Belanja</h5>
                    <div class="d-flex justify-content-between mb-2 text-muted">
                        <span>Total Item</span>
                        <span id="total-qty">{{ $items->sum('jumlah') }} Barang</span>
                    </div>
                    <hr class="my-3">
                    <div class="d-flex justify-content-between mb-4">
                        <span class="h5 fw-bold mb-0">Total Harga</span>
                        <span class="h5 fw-bold text-primary mb-0" id="grand-total">Rp{{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    
                    <a href="{{ route('keranjang.checkout') }}" class="btn btn-success w-100 btn-rounded shadow-lg py-2 mb-3 transform-hover">
                        Lanjut ke Pembayaran <i class="bi bi-arrow-right-short fs-5 align-middle"></i>
                    </a>
                    <a href="{{ route('produk.publik') }}" class="btn btn-light w-100 btn-rounded border text-muted">
                        Kembali Belanja
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>

{{-- Overlay Loading --}}
<div id="loading-overlay" class="position-fixed top-0 start-0 w-100 h-100 bg-white bg-opacity-75 d-none justify-content-center align-items-center" style="z-index: 9999;">
    <div class="spinner-border text-success" role="status" style="width: 3rem; height: 3rem;"></div>
</div>

@endsection

@push('scripts')
<script>
    // Konfigurasi Toast
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: true
    });

    // Formatting Currency JS
    const formatter = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    });

    // Handle Delete
    function confirmDelete(id) {
        Swal.fire({
            title: 'Hapus produk?',
            text: "Produk akan dihapus dari keranjang Anda.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal',
            customClass: {
                popup: 'card-modern'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }

    // Handle AJAX Quantity Update
    document.addEventListener('DOMContentLoaded', function() {
        const qtyButtons = document.querySelectorAll('.qty-btn');
        const overlay = document.getElementById('loading-overlay');

        qtyButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                const action = this.dataset.action;
                const inputDesktop = document.getElementById(`qty-${id}`);
                const inputMobile = document.getElementById(`mobile-qty-${id}`);
                let currentQty = parseInt(inputDesktop ? inputDesktop.value : inputMobile.value);

                if (action === 'decrease' && currentQty <= 1) return; // Min 1

                let newQty = action === 'increase' ? currentQty + 1 : currentQty - 1;

                // Show Loading
                overlay.classList.remove('d-none');
                overlay.classList.add('d-flex');

                // Fetch Request
                fetch(`/keranjang/${id}`, {
                    method: 'POST', // Laravel using method spoofing
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        _method: 'PATCH',
                        jumlah: newQty
                    })
                })
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    // Reload page to refresh data robustly, or update DOM manually
                    // For simplicity and correctness with stock checks, we reload, 
                    // BUT for better UX we could update DOM. Let's reloading for now to ensure consistency with backend validation
                    // OR better: update DOM if successful. 
                    window.location.reload(); 
                })
                .catch(error => {
                    overlay.classList.remove('d-flex');
                    overlay.classList.add('d-none');
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Terjadi kesalahan saat mengupdate keranjang.',
                    });
                });
            });
        });
    });
</script>
@endpush
