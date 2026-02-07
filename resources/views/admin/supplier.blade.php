@extends('layouts.app') 
@section('content')
<div class="container">
    <h2 class="mb-4">Verifikasi Akun Supplier</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($suppliers->isEmpty())
        <p>Tidak ada supplier yang perlu diverifikasi.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($suppliers as $supplier)
                    <tr>
                        <td>{{ $supplier->nama }}</td>
                        <td>{{ $supplier->email }}</td>
                        <td><span class="badge bg-warning">Pending</span></td>
                        <td>
                            <form method="POST" action="{{ url('/admin/suppliers/'.$supplier->id.'/approve') }}" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Setujui</button>
                            </form>
                            <form method="POST" action="{{ url('/admin/suppliers/'.$supplier->id.'/reject') }}" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Tolak</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
