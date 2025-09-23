<!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tanggapan untuk Pengaduan Anda</title>
        <style>
            body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px; color: #333; }
            .container { background-color: #ffffff; max-width: 600px; margin: auto; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
            .header { text-align: center; border-bottom: 1px solid #ddd; padding-bottom: 10px; margin-bottom: 20px; }
            .header img { max-width: 100px; }
            .content p { line-height: 1.6; }
            .content .label { font-weight: bold; }
            .button { display: inline-block; background-color: #2563eb; color: #ffffff; padding: 12px 25px; text-decoration: none; border-radius: 5px; margin-top: 20px; }
            .footer { text-align: center; margin-top: 20px; font-size: 12px; color: #777; }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <img src="{{ $message->embed(public_path('images/logo-badung.png')) }}" alt="Logo Kabupaten Badung">
                <h2>Notifikasi Tanggapan Pengaduan</h2>
            </div>
            <div class="content">
                <p>Halo, <strong>{{ $nama_pelapor }}</strong>.</p>
                <p>
                    Laporan Anda dengan judul: <br>
                    <span class="label">"{{ $judul_pengaduan }}"</span>
                </p>
                <p>Telah menerima tanggapan baru dari petugas kami. Silakan masuk ke aplikasi untuk melihat detail tanggapan.</p>
                <p style="text-align: center;">
                    <a href="{{ $url_detail }}" class="button">Lihat Detail Pengaduan</a>
                </p>
            </div>
            <div class="footer">
                <p>Ini adalah email otomatis. Mohon untuk tidak membalas email ini.</p>
                <p>&copy; {{ date('Y') }} Pemerintah Kabupaten Badung. All rights reserved.</p>
            </div>
        </div>
    </body>
    </html>
    
