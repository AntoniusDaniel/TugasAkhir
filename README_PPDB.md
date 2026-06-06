# Aplikasi PPDB SD Negeri Semayu

Program ini dibuat dari isi skripsi "Aplikasi Penerimaan Peserta Didik Baru (PPDB) Berbasis Laravel di SD Negeri Semayu".

## Fitur

- Portal publik PPDB.
- Registrasi akun pendaftar sebelum mengisi form.
- Login pendaftar dan admin dalam satu halaman masuk.
- Form pendaftaran calon peserta didik.
- Unggah berkas akta kelahiran, kartu keluarga, dan foto.
- Cek status memakai nomor pendaftaran dan tanggal lahir.
- Pengumuman hasil seleksi diterima/cadangan.
- Login admin panitia.
- Dashboard rekap pendaftar, verifikasi berkas, penetapan hasil seleksi, pengaturan kuota dan jadwal.
- Export data pendaftar ke CSV.

## Akun Admin Demo

- Email: `admin@sdnsemayu.sch.id`
- Password: `password`

## Akun Pendaftar Demo

- Email: `orangtua@example.com`
- Password: `password`

## Menjalankan Aplikasi

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
npm run build
php artisan serve --host=127.0.0.1 --port=8000
```

Buka `http://127.0.0.1:8000`.

## Database

Konfigurasi demo memakai SQLite agar langsung bisa dijalankan. Jika ingin memakai MySQL seperti rancangan skripsi, ubah `.env` menjadi:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ppdb_semayu
DB_USERNAME=root
DB_PASSWORD=
```

Setelah database MySQL dibuat, jalankan:

```bash
php artisan migrate:fresh --seed
```

Alternatif lain, import file SQL siap pakai:

```text
database/ppdb_semayu.sql
```

File tersebut sudah berisi struktur tabel, akun admin demo, akun pendaftar demo, pengaturan PPDB, dan satu data pendaftar contoh.

Untuk membuat atau mereset akun admin saja, import:

```text
database/admin_user.sql
```

Untuk membuat atau mereset profil sekolah default, import:

```text
database/school_profile.sql
```

Jika memakai MySQL/XAMPP, contoh konfigurasi `.env` tersedia di:

```text
.env.mysql.example
```

## Pengujian

```bash
php artisan test
```
