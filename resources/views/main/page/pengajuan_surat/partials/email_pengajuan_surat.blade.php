<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    @if ($status === 'diajukan')
        <p>
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
    @elseif ($status === 'ditolak_rw' || $status === "ditolak_rt")
        <p>
            ❌ <strong>Pengajuan Ditolak</strong> <br>
            Mohon maaf, pengajuan surat pengantar Anda <strong>tidak dapat diproses</strong>. <br><br>
            Alasan penolakan: <br>
            <em>{{ $keterangan ?? 'Tidak memenuhi persyaratan yang berlaku.' }}</em> <br><br>
            Jika masih diperlukan, Anda dapat melakukan pengajuan ulang dengan melengkapi persyaratan sesuai ketentuan.
        </p>
    @elseif ($status === 'selesai')
        <p>
            ✅ <strong>Pengajuan Selesai</strong> <br>
            Selamat! Surat pengantar Anda telah <strong>disetujui</strong> dan <strong>dikirim ke kelurahan</strong>
            untuk diproses lebih lanjut. <br><br>
            Nomor Token Pengajuan: <br>
            {{ $trackingToken ?? 'ABC123XYZ' }} <br>
            <a href="{{ url('/pelayanan/lacak-pengajuan?token=' . $trackingToken) }}">
                🔍 Lacak Pengajuan
            </a> <br><br>
            Silakan hubungi kelurahan apabila membutuhkan informasi lebih lanjut mengenai proses selanjutnya.
        </p>
    @endif
</body>

</html>
