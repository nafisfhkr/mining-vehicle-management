# Mining Vehicle Management System

Aplikasi web untuk memonitoring dan menjadwalkan pemakaian kendaraan tambang. Aplikasi ini mencakup fitur pemesanan kendaraan, persetujuan berjenjang (Approval Layering), grafik monitoring real-time, dan export laporan.

Dibuat sebagai bagian dari Technical Test Fullstack Developer (Intern).

## 🛠 Teknologi yang Digunakan

* **PHP:** 8.2
* **Framework:** Laravel 12
* **Database:** MySQL / MariaDB
* **Frontend:** Blade Templates + Tailwind CSS (Custom Modern UI)
* **Library Tambahan:**
    * `Chart.js` (Untuk grafik monitoring)
    * Native PHP CSV Stream (Untuk export Excel tanpa bloatware)

## 🚀 Fitur Unggulan (Plus Points)

1.  **Persetujuan Berjenjang (Multi-level Approval):** Sistem memastikan setiap pesanan disetujui oleh Atasan Langsung (Level 1) dan Manajer (Level 2) sebelum status menjadi Final.
2.  **Validasi Lokasi Kendaraan:** Dropdown pemilihan kendaraan menampilkan lokasi fisik kendaraan (Kantor Pusat/Tambang A/dll) untuk mencegah kesalahan penugasan.
3.  **Real-time Dashboard:** Grafik statistik pemakaian kendaraan yang dinamis berdasarkan data aktual.
4.  **Activity Logging:** Setiap aksi (Create, Approve, Reject) tercatat dalam Log Aktivitas di database.
5.  **Export Excel/CSV:** Fitur unduh laporan pemakaian kendaraan.
6.  **UI/UX Modern:** Antarmuka yang bersih, responsif, dan kontras tinggi (High Contrast) untuk kemudahan penggunaan.

## 📋 Akun Pengguna (Credentials)

Berikut adalah akun yang disiapkan melalui Database Seeder untuk pengujian:

| Role | Nama User | Email | Password |
| :--- | :--- | :--- | :--- |
| **Admin** | Admin Tambang | `admin@mining.com` | `password` |
| **Approver (Lvl 1)** | Pak Budi (Kepala) | `budi@mining.com` | `password` |
| **Approver (Lvl 2)** | Pak Joko (Manajer) | `joko@mining.com` | `password` |

> **Catatan:** Password untuk semua akun default adalah `password`.

## ⚙️ Cara Instalasi (Local)

Ikuti langkah berikut untuk menjalankan aplikasi di komputer lokal:

1.  **Clone Repository**
    ```bash
    git clone [https://github.com/nafisfhkr/mining-vehicle-management]
    cd nama-repo
    ```

2.  **Install Dependency**
    ```bash
    composer install
    npm install && npm run build
    ```

3.  **Konfigurasi Environment**
    * Copy file `.env.example` menjadi `.env`.
    * Sesuaikan konfigurasi database (DB_DATABASE, DB_USERNAME, dll).

4.  **Generate Key & Migrasi Database**
    Langkah ini penting untuk membuat tabel dan mengisi data dummy (Seeder).
    ```bash
    php artisan key:generate
    php artisan migrate:fresh --seed
    ```

5.  **Jalankan Aplikasi**
    ```bash
    php artisan serve
    ```
    Buka browser dan akses: `http://127.0.0.1:8000`

## 📖 Panduan Penggunaan Singkat

1.  **Login sebagai Admin:** Buat pesanan baru melalui menu "Buat Pesanan". Pilih kendaraan, driver, dan tentukan 2 orang penyetuju yang berbeda.
2.  **Login sebagai Approver 1 (Pak Budi):** Di Dashboard, klik tombol **"Setuju"** pada pesanan yang masuk. Status berubah menjadi *Menunggu Level 2*.
3.  **Login sebagai Approver 2 (Pak Joko):** Klik tombol **"Setuju"**. Status berubah menjadi *Disetujui*.
4.  **Monitoring:** Lihat grafik pemakaian di Dashboard yang otomatis terupdate.
5.  **Laporan:** Klik tombol "Export Excel" untuk mengunduh data.

## 📊 Diagrams (Physical Data Model & Activity Diagram)

### 1. Physical Data Model (PDM)

### 2. Activity Diagram - Alur Pemesanan

---
**Author:** M Nafis Fakhrudin