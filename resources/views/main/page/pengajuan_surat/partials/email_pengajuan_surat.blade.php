<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <p class="">
        ✅ Pengajuan Berhasil <br>
        Terima kasih! Pengajuan surat pengantar Anda telah <strong>berhasil diterima</strong>. <br><br>
        Simpan <strong>Nomor Token</strong> berikut untuk melacak status pengajuan: <br>
        {{ $trackingToken ?? 'ABC123XYZ' }} <br>
        <a href="{{ url('/pelayanan/lacak-pengajuan?token=' . $trackingToken) }}">
            🔍 Lacak Pengajuan
        </a> <br><br>
        <strong>Catatan:</strong> Pengajuan Anda akan diverifikasi terlebih dahulu oleh RT (jika diperlukan)
        kemudian oleh RW. Setelah disetujui, surat akan diteruskan ke kelurahan.
    </p>
</body>

</html>
