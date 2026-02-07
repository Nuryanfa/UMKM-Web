{{-- resources/views/customer/checkout.blade.php --}}
@extends('layouts.app')

@section('title', 'Checkout Pesanan')

@section('content')
<style>
    /* Radio Card Custom Styling */
    .courier-radio {
        display: none;
    }
    .courier-card-label {
        cursor: pointer;
        transition: all 0.2s ease;
        border: 2px solid #eee;
    }
    .courier-radio:checked + .courier-card-label {
        border-color: #198754;
        background-color: #f8fffb;
        box-shadow: 0 4px 12px rgba(25, 135, 84, 0.15);
    }
    .courier-radio:checked + .courier-card-label .check-icon {
        opacity: 1;
        transform: scale(1);
    }
    .check-icon {
        opacity: 0;
        transform: scale(0);
        transition: all 0.2s ease;
    }
</style>

<div class="container py-5">
    <h2 class="mb-5 text-center fw-bold animate__animated animate__fadeInDown">
        📦 Konfirmasi & Pembayaran
    </h2>

    @if (session('success'))
        <script>Swal.fire('Berhasil!', "{{ session('success') }}", 'success');</script>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger rounded-3 shadow-sm mb-4">
            <ul class="mb-0">@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
        </div>
    @endif

    @if ($items->isEmpty())
        <div class="text-center py-5">
            <div class="display-1 text-muted"><i class="bi bi-cart-x"></i></div>
            <h3 class="mt-3">Keranjang Kosong</h3>
            <a href="{{ route('keranjang.index') }}" class="btn btn-primary mt-3 btn-rounded">Kembali</a>
        </div>
    @else
        <form id="payment-form">
            <div class="row g-5">
                {{-- Left Column: Details --}}
                <div class="col-lg-7 animate__animated animate__fadeInLeft">
                    
                    {{-- 1. Alamat Pengiriman --}}
                    <div class="card card-modern p-4 mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-light rounded-circle p-2 me-3"><i class="bi bi-geo-alt fs-4 text-primary"></i></div>
                            <h5 class="fw-bold mb-0">Alamat Pengiriman</h5>
                        </div>
                        <div class="form-group">
                             <label class="form-label text-muted small text-uppercase fw-bold">Alamat Lengkap</label>
                            <textarea class="form-control bg-light border-0 rounded-3 p-3" 
                                      id="delivery_address" name="delivery_address" rows="3" 
                                      placeholder="Contoh: Jl. Merdeka No. 45, Kecamatan Gambir, Jakarta Pusat, 10110" 
                                      required style="resize: none;"></textarea>
                            <div class="form-text text-danger d-none" id="address-error">Alamat wajib diisi (min. 10 karakter).</div>
                        </div>
                         <div class="mt-3 bg-light p-3 rounded-3">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Penerima:</span>
                                <span class="fw-bold">{{ Auth::user()->name }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Email:</span>
                                <span>{{ Auth::user()->email }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- 2. Pilih Pengiriman --}}
                    <div class="card card-modern p-4 mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-light rounded-circle p-2 me-3"><i class="bi bi-truck fs-4 text-warning"></i></div>
                            <h5 class="fw-bold mb-0">Metode Pengiriman</h5>
                        </div>
                        
                        <div class="row g-3">
                            @foreach ($couriers as $index => $courier)
                                <div class="col-md-4 col-sm-6">
                                    <input type="radio" class="courier-radio" name="courier" id="courier{{ $index }}" 
                                           value="{{ $courier['name'] }}" data-cost="{{ $courier['cost'] }}">
                                    <label class="card h-100 p-3 courier-card-label rounded-3 position-relative" for="courier{{ $index }}">
                                        <div class="check-icon position-absolute top-0 end-0 m-2 text-success">
                                            <i class="bi bi-check-circle-fill fs-5"></i>
                                        </div>
                                        <div class="text-center">
                                            <i class="bi bi-box-seam fs-2 text-muted mb-2"></i>
                                            <h6 class="fw-bold mb-1">{{ $courier['name'] }}</h6>
                                            <div class="text-primary fw-bold">Rp{{ number_format($courier['cost'], 0, ',', '.') }}</div>
                                            <small class="text-muted d-block mt-1">Estimasi 2-3 Hari</small>
                                        </div>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <div class="form-text text-danger d-none mt-2" id="courier-error">Silakan pilih kurir pengiriman.</div>
                    </div>

                    {{-- 3. Review Item --}}
                    <div class="card card-modern p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-light rounded-circle p-2 me-3"><i class="bi bi-bag fs-4 text-secondary"></i></div>
                            <h5 class="fw-bold mb-0">Item Pesanan</h5>
                        </div>
                         <ul class="list-group list-group-flush">
                            @foreach ($items as $item)
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3 border-bottom-dashed">
                                    <div class="d-flex align-items-center">
                                        <img src="https://placehold.co/50x50/EFEFEF/666?text={{ substr($item->produk->nama_produk, 0, 1) }}" 
                                             class="rounded-3 me-3 border" width="50" alt="Produk">
                                        <div>
                                            <h6 class="mb-0 fw-bold">{{ $item->produk->nama_produk }}</h6>
                                            <small class="text-muted">{{ $item->jumlah }} x Rp{{ number_format($item->produk->harga, 0, ',', '.') }}</small>
                                        </div>
                                    </div>
                                    <span class="fw-bold">Rp{{ number_format($item->jumlah * $item->produk->harga, 0, ',', '.') }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                {{-- Right Column: Sticky Summary --}}
                <div class="col-lg-5 animate__animated animate__fadeInRight">
                    <div class="card card-modern p-4 sticky-top" style="top: 100px; z-index: 10;">
                        <h5 class="fw-bold mb-4">Ringkasan Pembayaran</h5>
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Subtotal Produk</span>
                            <span class="fw-bold">Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Biaya Pengiriman</span>
                            <span class="fw-bold" id="shipping-display">Rp0</span>
                        </div>
                        
                        <hr class="border-dashed my-3">
                        
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <span class="h5 fw-bold mb-0">Total Bayar</span>
                            <span class="h4 fw-bold text-success mb-0" id="total-display">Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>

                        <button type="button" id="pay-button" class="btn btn-success w-100 btn-lg btn-rounded shadow-lg py-3 mb-3 d-flex justify-content-center align-items-center" disabled>
                            <span class="me-2">Bayar Sekarang</span> <i class="bi bi-shield-lock-fill"></i>
                        </button>
                        
                        <div class="text-center">
                            <small class="text-muted d-flex justify-content-center align-items-center gap-2">
                                <i class="bi bi-shield-check text-success"></i> Pembayaran Aman dengan Midtrans
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endif
</div>

{{-- Processing Modal --}}
<div class="modal fade" id="processingModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg text-center p-4" style="border-radius: 20px;">
            <div class="modal-body">
                <div class="spinner-border text-primary mb-3" role="status" style="width: 3rem; height: 3rem;"></div>
                <h5 class="fw-bold">Memproses Pesanan...</h5>
                <p class="text-muted mb-0">Mohon tunggu sebentar, jangan tutup halaman ini.</p>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const subtotal = {{ $subtotal }};
        const addressInput = document.getElementById('delivery_address');
        const courierRadios = document.querySelectorAll('.courier-radio');
        const payButton = document.getElementById('pay-button');
        const shippingDisplay = document.getElementById('shipping-display');
        const totalDisplay = document.getElementById('total-display');
        const processingModal = new bootstrap.Modal(document.getElementById('processingModal'));

        let selectedShippingCost = 0;
        let selectedCourierName = '';

        // Formatter
        const formatRupiah = (number) => {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);
        };

        // Validation & State Update
        function updateState() {
            const isAddressValid = addressInput.value.trim().length >= 10;
            const isCourierSelected = selectedCourierName !== '';
            
            // Toggle Error Messages
            document.getElementById('address-error').classList.toggle('d-none', isAddressValid || addressInput.value.length === 0);
            
            // Calculate Total
            const total = subtotal + selectedShippingCost;
            shippingDisplay.textContent = formatRupiah(selectedShippingCost);
            totalDisplay.textContent = formatRupiah(total);

            // Button State
            if (isAddressValid && isCourierSelected) {
                payButton.disabled = false;
                payButton.classList.remove('btn-secondary');
                payButton.classList.add('btn-success');
            } else {
                payButton.disabled = true;
                payButton.classList.add('btn-secondary');
                payButton.classList.remove('btn-success');
            }
        }

        // Event Listeners
        addressInput.addEventListener('input', updateState);

        courierRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.checked) {
                    selectedShippingCost = parseFloat(this.dataset.cost);
                    selectedCourierName = this.value;
                    updateState();
                }
            });
        });

        // Payment Process
        payButton.addEventListener('click', function() {
            if (this.disabled) return;

            // Show Loading
            processingModal.show();

            const payload = {
                delivery_address: addressInput.value.trim(),
                courier_name: selectedCourierName,
                shipping_cost: selectedShippingCost
            };

            fetch('{{ route("keranjang.processPayment") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(payload)
            })
            .then(res => res.json())
            .then(data => {
                processingModal.hide(); // Hide loading

                if (data.snap_token) {
                    snap.pay(data.snap_token, {
                        onSuccess: function(result) {
                            window.location.href = `{{ route('keranjang.index') }}?payment_status=success&order_id=${data.order_id}`;
                        },
                        onPending: function(result) {
                            window.location.href = `{{ route('keranjang.index') }}?payment_status=pending&order_id=${data.order_id}`;
                        },
                         onError: function(result) {
                            Swal.fire('Gagal', 'Pembayaran gagal atau dibatalkan.', 'error');
                        },
                        onClose: function() {
                            Swal.fire('Dibatalkan', 'Anda menutup popup pembayaran.', 'info');
                        }
                    });
                } else {
                    Swal.fire('Error', data.error || 'Terjadi kesalahan.', 'error');
                }
            })
            .catch(err => {
                processingModal.hide();
                Swal.fire('Error', 'Gagal menghubungi server.', 'error');
                console.error(err);
            });
        });
    });
</script>
@endpush
