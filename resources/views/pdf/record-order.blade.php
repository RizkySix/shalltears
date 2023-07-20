<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan Shalltears</title>
   
<style>
    @page { size: 20cm 35cm landscape; }

body{
    font-family: 'arial';
}

#customers {
  border-collapse: collapse;
  width: 100%;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #3F72AF;
  color: white;
 
}
</style>
</head>
<body>

<div style="text-align: center">
    <h1>Shalltears Clothing Store</h1>
    <img src="{{ public_path('imgs/shalltears.png') }}" alt="rusak" width="200" height="100" style="object-fit: cover">

    @if ($tanggal_selesai == 'null')
    <h3 style="font-weight: lighter;  opacity: 0.5;">{{ $tanggal_mulai }}</h3>
    @else
    <h3 style="font-weight: lighter;  opacity: 0.5;">{{ $tanggal_mulai }} ~ {{ $tanggal_selesai }}</h3>
    @endif
<hr>


<table id="customers">
    <thead>
        <tr>
            <th scope="col">No</th>
            <th scope="col">Tanggal Pembelian</th>
            <th scope="col">Nama Produk</th>
            <th scope="col">Qty</th>
            <th scope="col">Harga Satuan</th>
            <th scope="col">Harga Total</th>
            <th scope="col">Status Pesanan</th>
          </tr>
      </thead>
      @if ($records->count())
      <tbody>

     @foreach ($records as $record)
           
              <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                @php
                    $tanggal_pembelian = Carbon\Carbon::parse($record->tanggal_pembelian)->format('Y-M-d');
                    $harga_satuan = number_format($record->harga_satuan);
                    $harga_total = number_format($record->harga_total);
                @endphp
                <th scope="row">{{ $tanggal_pembelian }}</th>
                <th scope="row">{{ $record->nama_produk }}</th>
                <th scope="row">{{ $record->qty }}</th>
                <th scope="row">Rp. {{ $harga_satuan }}</th>
                <th scope="row">Rp. {{ $harga_total }}</th>
                <th scope="row"><span style="text-transform:capitalize;">{{ $record->transaction_status }}</span></th>
              
              </tr>
             
          
            @endforeach
         <tr>
            <td colspan="6" style="font-size: 21px; font-weight: bold">Total Uang Masuk</td>
            <td colspan="1" style="font-size: 21px; font-weight: bold">Rp {{ number_format($records->sum('harga_total')) }}</td>
         </tr>
         @else
         <tr>
            <td colspan="7" style="font-size: 21px; font-weight: bold; text-align:center">Tidak ada data pesanan.</td>
         </tr>
      </tbody>
   
  @endif
</table>
<h3 style="font-weight :lighter;">
    <span>Laporan uang masuk Shalltears Clothing Store *(<span class="span" style="font-style: italic">Hanya Admin yang dapat mengakses dan mengenerate laporan PDF ini</span>) </span>
 </h3>

 
</body>
</html>


