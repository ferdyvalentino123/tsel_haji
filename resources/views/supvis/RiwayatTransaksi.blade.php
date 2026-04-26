@php
    $layout = Auth::user()->hasRole('kasir') ? 'Kasir.KasirLayouts' : 'Supvis.SupvisLayouts';
@endphp
<x-dynamic-component :component="$layout">

    <link href="//cdn.datatables.net/2.2.2/css/dataTables.dataTables.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #43e97b, #2575FC);
            color: #333;
            margin: 0;
            padding: 0;
            height: 100vh;
        }

        h1 {
            color: rgb(0, 0, 0);
            font-size: 2.5rem;
            margin: 40px 0 20px;
            text-align: center;
        }

        .dashboard {
            padding: 20px;
            font-family: Arial, sans-serif;
        }

        .search-container {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 9px;
            background-color: #f8f9fa;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 50%;
            margin: 9px auto;
        }

        .filter-box {
            flex: 1;
            margin-right: 5px;
        }

        .filter-box select {
            width: 100%;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 12px;
            background-color: #fff;
            cursor: pointer;
        }

        .search-box {
            display: flex;
            align-items: center;
            position: relative;
            flex: 2;
        }

        .search-box input {
            width: 100%;
            padding: 5px 30px 5px 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 12px;
        }

        .search-box i {
            position: absolute;
            right: 8px;
            color: #888;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        .table-responsive-scroll {
            overflow-x: auto;
            width: 100%;
        }

        th,
        td {
            padding: 9px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .insentif th {
            padding: 9px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .penjualan {
            background: #23a0b0;
            color: white;
            font-weight: bold;
        }

        thead tr {
            background: #23a0b0;
            color: white;
            font-weight: bold;
        }

        th {
            color: white;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #1c828f;
        }

        @media screen and (max-width: 600px) {
            table {
                border: 0;
                width: 100%;
            }

            thead {
                display: none;
            }

            tr {
                display: block;
                margin-bottom: 25px;
                background-color: #fff;
                border-radius: 8px;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            }

            td {
                display: flex;
                justify-content: space-between;
                padding: 12px 15px;
                border-bottom: 1px solid #ddd;
            }

            td::before {
                content: attr(data-label);
                font-weight: bold;
                background: linear-gradient(135deg, #2575FC, #43e97b);
                -webkit-background-clip: text;
                color: transparent;
                text-align: left;
                padding: 5px;
            }

        }

        @media (max-width: 768px) {
            .search-container {
                width: 90%;
                margin: 20px auto;
            }

            .filter-box,
            .search-box {
                flex: 1;
            }

            .search-box input {
                font-size: 14px;
                padding: 5px 20px 5px 8px;
            }

            .search-box i {
                font-size: 16px;
            }
        }
    </style>

    <body>
        <h1><b>Riwayat Transaksi</b></h1>

        @if (session('success'))
            <p style="color: green;">{{ session('success') }}</p>
        @elseif(session('error'))
            <p style="color: red;">{{ session('error') }}</p>
        @endif

        <form method="GET" class="search-container">
            <div class="filter-box">
                <input type="date" name="tanggal_transaksi" value="{{ request('tanggal_transaksi') }}">
            </div>
        
            @php
                $user = auth()->user();
                $isKasir = $user->hasRole('kasir'); // Assuming you use Spatie or similar
            @endphp
            
            <div class="filter-box">
                <select name="id_kasir" {{ $isKasir ? 'disabled' : '' }}>
                    <option value="">Semua Kasir</option>
                    @foreach($transaksi->pluck('Kasir')->filter()->unique('id')->sortBy('name') as $Kasir)
                        <option value="{{ $Kasir->id }}"
                            {{ (request('id_kasir') ?? ($isKasir ? $user->id : null)) == $Kasir->id ? 'selected' : '' }}>
                            {{ $Kasir->name }}
                        </option>
                    @endforeach
                </select>
            
                @if($isKasir)
                    <input type="hidden" name="id_kasir" value="{{ $user->id }}">
                @endif
            </div>
        
            <div class="filter-box">
                <select name="metode_pembayaran">
                    <option value="">Semua Metode</option>
                    @foreach($transaksi->pluck('metode_pembayaran')->unique() as $metode)
                        <option value="{{ $metode }}" {{ request('metode_pembayaran') == $metode ? 'selected' : '' }}>
                            {{ $metode }}
                        </option>
                    @endforeach
                </select>
            </div>
        
            <div class="filter-box">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </form>


        <div class="container d-flex justify-content-center align-items-center mt-3">
            <div class="row w-100">

                <div class="col-md-6">
                    <div class="card text-center shadow-sm">
                        <div class="card-body">
                            <h3 class="card-title text-success">Total Penjualan</h3>
                            <p class="card-text fw-bold">Rp {{ number_format($totalPenjualan, 0, ',', '.') }},-</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card text-center shadow-sm">
                        <div class="card-body">
                            <h3 class="card-title text-primary">Mandiri</h3>
                            <p class="card-text fw-bold">Rp {{ number_format($paymentSums['Mandiri'] ?? 0, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="container d-flex justify-content-center align-items-center mt-3">
            <div class="row w-100">

                <div class="col-md-6">
                    <div class="card text-center shadow-sm">
                        <div class="card-body">
                            <h3 class="card-title text-success">BNI</h3>
                            <p class="card-text fw-bold">Rp {{ number_format($paymentSums['BNI'] ?? 0, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card text-center shadow-sm">
                        <div class="card-body">
                            <h3 class="card-title text-primary">Tunai</h3>
                            <p class="card-text fw-bold">Rp {{ number_format($paymentSums['Tunai'] ?? 0, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="container d-flex justify-content-center align-items-center mt-3">
            <div class="row w-100">

                <div class="col-md-6">
                    <div class="card text-center shadow-sm">
                        <div class="card-body">
                            <h3 class="card-title text-success">BCA</h3>
                            <p class="card-text fw-bold">Rp {{ number_format($paymentSums['BCA'] ?? 0, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card text-center shadow-sm">
                        <div class="card-body">
                            <h3 class="card-title text-primary">Others</h3>
                            <p class="card-text fw-bold">Rp {{ number_format($paymentSums['Others'] ?? 0, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="container mt-4">
            <div class="table-responsive-scroll">
                <table class="data-table" id="transactionTable">
                    <thead>
                        <tr>
                            <th>ID Transaksi</th>
                            <th>Kasir</th>
                            <th>Tanggal Transaksi</th>
                            <th>Nama Sales</th>
                            <th>No. Tlp Sales</th>
                            <th>Tempat Bertugas</th>
                            <th>Bertugas</th>
                            <th>Nama Pelanggan</th>
                            <th>No. Tlp Pelanggan</th>
                            <th>Nomor Injeksi</th>
                            <th>Addon Perdana</th>
                            <th>Aktivasi Tanggal</th>
                            <th>Jenis Paket</th>
                            <th>Merchandise</th>
                            <th>Metode Pembayaran</th>
                            <th>Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transaksi as $transaction)
                            <tr>
                                <td data-label="ID Transaksi">{{ $transaction->id_transaksi }}</td>
                                <td data-label="Kasir">{{ $transaction->Kasir?->name }}</td>
                                <td data-label="Tanggal Transaksi">{{ $transaction->tanggal_transaksi }}</td>
                                <td data-label="Nama Sales">{{ $transaction->nama_sales }}</td>
                                <td data-label="No. Tlp Sales">{{ $transaction->nomor_telepon }}</td>
                                <td data-label="Tempat Bertugas">
                                    {{ optional($transaction->sales)->tempat_tugas ?? '-' }}
                                </td>
                                <td data-label="Bertugas">
                                    {{ optional($transaction->sales)->bertugas ? 'Ya' : 'Tidak' }}
                                </td>
                                <td data-label="Nama Pelanggan">{{ $transaction->nama_pelanggan }}</td>
                                <td data-label="No. Tlp Pelanggan">{{ $transaction->telepon_pelanggan }}</td>
                                <td data-label="Nomor Injeksi">{{ $transaction->nomor_injeksi }}</td>
                                <td data-label="Addon Perdana"> {{ $transaction->addon_perdana ? '✓' : '✗' }} </td>
                                <td data-label="Aktivasi Tanggal">{{ $transaction->aktivasi_tanggal }}</td>
                                <td data-label="Jenis Paket">
                                    {{ optional($transaction->produk)->produk_nama ?? 'Produk tidak ditemukan' }}
                                </td>
                                <td data-label="Merchandise">{{ $transaction->merchandise }}</td>
                                <td data-label="Metode Pembayaran">{{ $transaction->metode_pembayaran }}</td>
                                <td data-label="Harga Akhir">Rp
                                    {{ number_format(optional($transaction->produk)->produk_harga_akhir ?? 0, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
        @php
            $queryParams = request()->query();
        
            // Force id_kasir into export URL if role is kasir
            if ($isKasir) {
                $queryParams['id_kasir'] = auth()->user()->id;
            }
        @endphp

        <div class="container text-center mt-3">
            <a href="{{ route('export.excel',  $queryParams) }}" class="btn btn-success">Export ke Excel</a>
        </div>

        <script src="//cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#transactionTable').DataTable({
                    paging: true,
                    searching: true,
                    ordering: true,
                    order: [
                        [0, "asc"]
                    ],
                    language: {
                        lengthMenu: "Tampilkan _MENU_ data per halaman",
                        zeroRecords: "Tidak ada data ditemukan",
                        info: "Menampilkan _PAGE_ dari _PAGES_ halaman",
                        infoEmpty: "Tidak ada data tersedia",
                        infoFiltered: "(difilter dari total _MAX_ data)"
                    }
                });
            });

            function filterByDateRange(days) {
                const table = document.getElementById('transactionTable');
                const rows = table.getElementsByTagName('tr');
                const now = new Date();

                for (let i = 1; i < rows.length; i++) {
                    const cell = rows[i].getElementsByTagName('td')[1]; // index 1 = tanggal transaksi
                    if (!cell) continue;

                    const rowDate = new Date(cell.textContent);
                    const timeDiff = Math.floor((now - rowDate) / (1000 * 60 * 60 * 24));

                    if (days === 'all' || timeDiff <= days) {
                        rows[i].style.display = '';
                    } else {
                        rows[i].style.display = 'none';
                    }
                }
            }
        </script>
    </body>
</x-dynamic-component>
