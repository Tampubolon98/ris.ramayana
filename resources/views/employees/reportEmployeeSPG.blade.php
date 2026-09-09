<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <style>
    @page {
      margin: 0.3cm;
    }

    body {
      margin-top: 10px;
      margin-left: 10px;
      margin-right: 10px;
      margin-bottom: 10px;
    }

    table {
      font-family: sans-serif;
      color: #232323;
      border-collapse: collapse;
      border: 1px solid #AAAAAA;
      width: 100%;
    }

    td {
      border: 1px solid #AAAAAA;
      padding: 2px 6px;
      font-size: 12px;
      white-space: normal;
      word-wrap: break-word;
    }

    th {
      border: 1px solid #AAAAAA;
      padding: 2px 4px;
      font-size: 12px;
    }

    tr.no-border td {
      border: 5px solid rgba(255, 255, 255, .5);
    }

    .text-center {
      text-align: center;
    }
    
    .text-right {
      text-align: right;
    }
    
    .footer-total {
      font-weight: bold;
      background-color: #f2f2f2;
    }
  </style>
</head>

<body>
  <center><label style="font-size:110%;"><b>Report Karyawan</b></label></center>
  <br>
  <br>
  <table style="width: 100%; table-layout: fixed;">
    <thead>
      <tr>
        <th class='text-center' style="background-color:#EA5B6F; color:#fff;">ID Employee</th>
        <th class='text-center' style="background-color:#EA5B6F; color:#fff">Nama Karyawan</th>
        <th class='text-center' style="background-color:#EA5B6F; color:#fff">Alamat</th>
        <th class='text-center' style="background-color:#EA5B6F; color:#fff">Tanggal Lahir</th>
        <th class='text-center' style="background-color:#EA5B6F; color:#fff">Tanggal Masuk</th>
        <th class='text-center' style="background-color:#EA5B6F; color:#fff">No Handphone</th>
        <th class='text-center' style="background-color:#EA5B6F; color:#fff">Kategori</th>
        <th class='text-center' style="background-color:#EA5B6F; color:#fff">Status</th>
        <th class='text-center' style="background-color:#EA5B6F; color:#fff;">Kode Toko</th>
        <th class='text-center' style="background-color:#EA5B6F; color:#fff;">No KK</th>
        <th class='text-center' style="background-color:#EA5B6F; color:#fff;">No KTP</th>
        <th class='text-center' style="background-color:#EA5B6F; color:#fff;">MD</th>
        <th class='text-center' style="background-color:#EA5B6F; color:#fff;">Brand</th>
        <th class='text-center' style="background-color:#EA5B6F; color:#fff;">Nama Supplier</th>
        <th class='text-center' style="background-color:#EA5B6F; color:#fff;">Jenis Kelamin</th>
      </tr>
    </thead>
    <tbody class="detail">
      @foreach($datapdf as $item)
      <tr>
        <td class="text-left">{{ $item->id_employee }}</td>
        <td class="text-left">{{ $item->nama }}</td>
        <td class="text-left">{{ $item->alamat }}</td>
        <td class="text-left">{{ $item->tanggal_lahir }}</td>
        <td class="text-left">{{ $item->tanggal_masuk }}</td>
        <td class="text-left">{{ $item->no_handphone }}</td>
        <td class="text-left">{{ $item->kategori_karyawan }}</td>
        <td class="text-left">{{ $item->status == 1 ? 'Belum Menikah' : ($item->status == 2 ? 'Menikah' : ($item->status == 3 ? 'Duda' : 'Janda')) }}</td>
        <td class="text-left">{{ $item->kode_toko }}</td>
        <td class="text-left">{{ $item->no_kk }}</td>
        <td class="text-left">{{ $item->no_ktp }}</td>
        <td class="text-left">{{ $item->md_emp }}</td>
        <td class="text-left">{{ $item->brand_emp }}</td>
        <td class="text-left">{{ $item->supplier }}</td>
        <td class="text-left">{{ $item->jenis_kelamin }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</body>

</html>