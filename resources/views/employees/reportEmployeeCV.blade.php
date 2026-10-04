<html>
<head>
  <meta charset="utf-8">
  <style>
    body {
      font-family: sans-serif;
      font-size: 12px;
      margin: 20px;
    }

    h2 {
      text-align: center;
    }

    .section h3 {
      margin: 0 0 8px 0;
      font-size: 12px;
      border-bottom: 1px solid #ddd;
      padding-bottom: 4px;
    }

    .field {
      margin: 3px 0;
    }

    .label {
      display: inline-block;
      width: 140px;
      font-weight: bold;
    }

    .profile-container {
      display: flex;
    }

    .photo-container {
      flex: 0 0 auto;
    }

    .personal-data {
      flex: 1;
      margin-left: 10rem;
      margin-bottom: -7rem;
    }

    .header {
        display: flex;
    }

    .img-header {
        flex: 0 0 auto;
    }

    .dtl-header {
        flex: 1;
        font-size: 10px;
        margin-left: 5rem;
    }
  </style>
</head>
<body>
  <div class="header">
    <div class="img-header">
        <img src="{{ asset('images/ramayana/logo/ramayana.jpg') }}" width="40" height="40">
    </div>

    <div class="dtl-header">
        <span>PT Ramayana Lestari Sentosa, Tbk</span><br>
        <span>Jl. KH. Wahid Hasyim No.220 AB, RT.9/RW.7, Kampung Bali, Tanah Abang</span><br>
        <span>Central Jakarta City, Jakarta 10250 (Head Office)</span>
    </div>
  </div>

  <h2>Curriculum Vitae</h2>

  @foreach($datapdf as $item)
  <div class="profile-container">
    <div class="photo-container">
        @if ($item->image_employee != '')
            <img src="{{ asset($item->image_employee) }}" width="140" height="160">
        @else
            <img src="{{ asset('images/AsetManagement/Logo/ramayana.jpg') }}" width="140" height="160">
        @endif
    </div>
    
    <div class="personal-data">
        <div class="section">
          <h3>Data Pribadi</h3>
          <div class="field"><span class="label">ID Employee</span>: {{ $item->id_employee }}</div>
          <div class="field"><span class="label">Nama</span>: {{ $item->nama }}</div>
          <div class="field"><span class="label">Alamat</span>: {{ $item->alamat }}</div>
          <div class="field"><span class="label">Tanggal Lahir</span>: {{ date('d-m-Y', strtotime($item->tanggal_lahir)) }}</div>
          <div class="field"><span class="label">Jenis Kelamin</span>: {{ $item->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }}</div>
          <div class="field"><span class="label">Status</span>: 
            {{ $item->status == 1 ? 'Belum Menikah' : ($item->status == 2 ? 'Menikah' : ($item->status == 3 ? 'Duda' : 'Janda')) }}
          </div>
        </div>
    </div>
  </div>

  <div class="section">
    <h3>Data Pekerjaan</h3>
    <div class="field"><span class="label">Tanggal Masuk</span>: {{ date('d-m-Y', strtotime($item->tanggal_masuk)) }}</div>
    <div class="field"><span class="label">Jabatan</span>: {{ $item->kategori_karyawan }}</div>
    <div class="field"><span class="label">Kode Toko</span>: {{ $item->kode_toko }}</div>
    <div class="field"><span class="label">MD</span>: {{ $item->md_emp }}</div>
    <div class="field"><span class="label">Brand</span>: {{ $item->brand_emp }}</div>
    <div class="field"><span class="label">Perusahaan</span>: {{ $item->supplier }}</div>
  </div>

  <div class="section" style="margin-top: 12px;">
    <h3>Kontak</h3>
    <div class="field"><span class="label">No Handphone</span>: {{ $item->no_handphone }}</div>
    <div class="field"><span class="label">No Kartu Keluarga</span>: {{ $item->no_kk }}</div>
    <div class="field"><span class="label">No KTP</span>: {{ $item->no_ktp }}</div>
  </div>
  @endforeach

</body>
</html>