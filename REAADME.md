# To-do List dengan Popup CRUD

Aplikasi To-do List sederhana yang dibangun menggunakan PHP, HTML, dan Tailwind CSS dengan fitur untuk menambah, mengedit, menghapus, dan menyelesaikan tugas. Proyek ini menggunakan sesi (session) untuk menyimpan tugas tanpa memerlukan basis data.

## Fitur

- **Tambah Tugas**: Memungkinkan pengguna untuk menambahkan tugas baru menggunakan popup modal.
- **Edit Tugas**: Pengguna dapat mengedit nama tugas yang sudah ada melalui popup modal.
- **Hapus Tugas**: Pengguna dapat menghapus tugas melalui popup konfirmasi.
- **Selesaikan Tugas**: Pengguna dapat menandai tugas sebagai selesai dengan mengklik ikon centang.
- **Cari Tugas**: Memungkinkan pengguna untuk mencari tugas tertentu secara real-time.

## Teknologi yang Digunakan

- **PHP**: Logika backend untuk menangani manajemen sesi dan operasi CRUD tugas.
- **HTML**: Struktur markup untuk antarmuka to-do list.
- **Tailwind CSS**: Untuk desain UI yang responsif dan modern.
- **Font Awesome**: Digunakan untuk ikon centang.
- **jQuery**: Menangani permintaan AJAX untuk menyelesaikan tugas dan fungsi pencarian.

## Cara Menggunakan

### Instalasi

1. Clone repository atau unduh kode sumber.

   ```bash
   git clone https://github.com/Lynnn17/tugas-studpen-2.git
   ```

2. Letakkan proyek ini di lingkungan server lokal kamu (misalnya, XAMPP, WAMP, dll.).

3. Mulai server lokal kamu dan pastikan PHP berjalan.

4. Akses folder proyek melalui browser, misalnya:
   ```
   http://localhost/tugas-studpen-2
   ```

### Penggunaan

- **Menambah Tugas**: Klik tombol "Tambah", masukkan teks tugas dalam popup, lalu submit. Tugas akan muncul di daftar tugas.
- **Mengedit Tugas**: Klik tombol "Edit" di sebelah tugas mana pun, perbarui teks, lalu submit.
- **Menghapus Tugas**: Klik tombol "Hapus" untuk menghapus tugas. Sebuah modal konfirmasi akan muncul sebelum penghapusan.
- **Menyelesaikan Tugas**: Klik lingkaran centang di sebelah tugas untuk menandai tugas sebagai selesai atau belum selesai. Tugas yang selesai akan diberi garis coret.
- **Mencari Tugas**: Gunakan kolom pencarian di bagian atas untuk memfilter tugas berdasarkan nama.
