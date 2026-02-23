# 🏗️ TokoBangunPOS

**Sistem Point of Sale (POS) untuk Toko Bangunan** — Aplikasi kasir berbasis web yang lengkap dengan manajemen stok, pembelian, dan laporan keuangan.

---

## 📋 Daftar Isi

- [Tech Stack](#-tech-stack)
- [Instalasi](#-instalasi)
- [Akun Default](#-akun-default)
- [Hak Akses (Role)](#-hak-akses-role)
- [Alur Aplikasi](#-alur-aplikasi)
    - [1. Dashboard](#1-dashboard)
    - [2. Master Data](#2-master-data)
    - [3. Manajemen Stok](#3-manajemen-stok)
    - [4. Supplier & Pembelian](#4-supplier--pembelian)
    - [5. Point of Sale (POS)](#5-point-of-sale-pos)
    - [6. Penjualan](#6-penjualan)
    - [7. Laporan](#7-laporan)
- [Struktur Database](#-struktur-database)
- [API & Routes](#-api--routes)

---

## 🛠️ Tech Stack

| Komponen   | Teknologi                |
| ---------- | ------------------------ |
| Framework  | Laravel 12               |
| PHP        | >= 8.2                   |
| Auth       | Laravel Breeze           |
| Frontend   | Blade + Tailwind CSS     |
| JS         | Alpine.js                |
| Build Tool | Vite                     |
| Database   | SQLite (default) / MySQL |

---

## 🚀 Instalasi

```bash
# 1. Clone & masuk direktori
git clone <repo-url> tokobangunan
cd tokobangunan

# 2. Install dependencies
composer install
npm install

# 3. Konfigurasi environment
cp .env.example .env
php artisan key:generate

# 4. Migrasi & seeder
php artisan migrate
php artisan db:seed --class=DefaultUsersSeeder

# 5. Build frontend
npm run build

# 6. Jalankan server
php artisan serve
```

Atau cukup jalankan:

```bash
composer setup
php artisan db:seed --class=DefaultUsersSeeder
php artisan serve
```

---

## 👤 Akun Default

| Role  | Email           | Password     |
| ----- | --------------- | ------------ |
| Owner | owner@demo.test | Password!123 |
| Admin | admin@demo.test | Password!123 |
| Kasir | kasir@demo.test | Password!123 |

---

## 🔐 Hak Akses (Role)

```
┌─────────────────────────────────┬───────┬───────┬───────┐
│ Fitur                           │ Owner │ Admin │ Kasir │
├─────────────────────────────────┼───────┼───────┼───────┤
│ Dashboard                       │  ✅   │  ✅   │  ✅   │
│ POS (Transaksi Kasir)           │  ✅   │  ✅   │  ✅   │
│ Master Data (Barang/Kategori)   │  ✅   │  ✅   │  ❌   │
│ Supplier & Pembelian            │  ✅   │  ✅   │  ❌   │
│ Manajemen Stok                  │  ✅   │  ✅   │  ❌   │
│ Riwayat & Detail Penjualan      │  ✅   │  ✅   │  ❌   │
│ Void Transaksi                  │  ✅   │  ✅   │  ❌   │
│ Laporan & Export                │  ✅   │  ✅   │  ❌   │
│ Profil Pengguna                 │  ✅   │  ✅   │  ✅   │
└─────────────────────────────────┴───────┴───────┴───────┘
```

---

## 📱 Alur Aplikasi

### 1. Dashboard

```
URL: /dashboard
```

Halaman utama setelah login. Menampilkan ringkasan bisnis:

- **Pendapatan Hari Ini** — Total penjualan hari ini (status PAID)
- **Pendapatan Bulan Ini** — Total penjualan bulan berjalan
- **Jumlah Transaksi Hari Ini** — Berapa kali kasir melakukan checkout
- **Stok Menipis** — Jumlah barang dengan stok ≤ 10
- **5 Transaksi Terakhir** — Daftar penjualan terbaru

---

### 2. Master Data

#### 2a. Kategori Barang

```
URL: /categories
Akses: Owner, Admin
```

CRUD kategori untuk mengelompokkan barang (misal: Semen, Cat, Besi, dll).

**Alur:**

```
Lihat Daftar → Tambah Kategori → Edit → Hapus
```

#### 2b. Satuan Barang

```
URL: /units
Akses: Owner, Admin
```

CRUD satuan ukuran barang (misal: Kg, Sak, Batang, Liter, dll).

**Alur:**

```
Lihat Daftar → Tambah Satuan → Edit → Hapus
```

#### 2c. Barang / Produk

```
URL: /products
Akses: Owner, Admin
```

Manajemen data barang dagangan.

**Data Barang:**

- Kode barang (unik)
- Nama barang
- Kategori & Satuan
- Harga beli (cost_price)
- Harga jual (sell_price)
- Stok minimum (untuk peringatan stok menipis)
- Status aktif/nonaktif

**Alur:**

```
Lihat Daftar → Tambah Barang → Edit → Lihat Detail → Hapus
                                         │
                                         └→ Lihat Kartu Stok
```

---

### 3. Manajemen Stok

Semua pergerakan stok tercatat di tabel `stock_movements` untuk auditabilitas penuh.

#### 3a. Stok Awal

```
URL: /stock/opening
```

Input stok pertama kali untuk barang baru. Hanya boleh dilakukan 1× per barang (jika belum ada pergerakan stok sebelumnya).

**Alur:**

```
Pilih Barang → Input Qty → Catatan (opsional) → Simpan
                                                    │
                                      stock_movements: type=OPENING
```

#### 3b. Stok Masuk (Manual)

```
URL: /stock/in
```

Menambah stok secara manual (di luar pembelian dari supplier).

**Alur:**

```
Pilih Barang → Input Qty → Catatan → Simpan
                                        │
                          stock_movements: type=IN, ref_type=MANUAL
                          product.current_stock += qty
```

#### 3c. Stok Keluar (Manual)

```
URL: /stock/out
```

Mengurangi stok secara manual (di luar penjualan POS). Contoh: barang rusak, hilang, dll.

**Alur:**

```
Pilih Barang → Input Qty → Catatan → Simpan
                                        │
                          stock_movements: type=OUT, ref_type=MANUAL
                          product.current_stock -= qty
```

#### 3d. Stock Opname

```
URL: /stock/opname
```

Penyesuaian stok berdasarkan penghitungan fisik. Sistem akan menghitung selisih antara stok di sistem dengan stok aktual.

**Alur:**

```
Pilih Barang → Input Stok Aktual → Catatan → Simpan
                                                │
                                  Hitung selisih (actual - current)
                                  stock_movements: type=IN/OUT (sesuai selisih)
                                  product.current_stock = actual
```

#### 3e. Kartu Stok

```
URL: /stock/card/{product}
```

Riwayat lengkap pergerakan stok per barang. Bisa difilter berdasarkan tanggal.

**Kolom:**

```
Tanggal | Tipe (IN/OUT) | Referensi | Qty Masuk | Qty Keluar | Saldo | User | Catatan
```

---

### 4. Supplier & Pembelian

#### 4a. Supplier

```
URL: /suppliers
Akses: Owner, Admin
```

Manajemen data pemasok barang.

**Data:** Nama, Telepon, Alamat.

**Alur:**

```
Lihat Daftar → Tambah Supplier → Edit → Hapus
```

#### 4b. Pembelian (Purchase)

```
URL: /purchases
Akses: Owner, Admin
```

Pencatatan pembelian barang dari supplier.

**Alur Pembelian:**

```
┌─────────────────────────────────────────────────┐
│  1. Buat Purchase Baru (/purchases/create)      │
│     ├─ Pilih Supplier                           │
│     ├─ Pilih Tanggal                            │
│     ├─ Tambahkan Item:                          │
│     │   ├─ Pilih Barang                         │
│     │   ├─ Input Qty                            │
│     │   └─ Input Harga Satuan                   │
│     └─ Simpan                                   │
│                                                 │
│  2. Otomatis:                                   │
│     ├─ Generate nomor invoice (PUR-YYYYMMDD-XX) │
│     ├─ Hitung subtotal & grand_total            │
│     ├─ Tambah stok barang via stock_movements   │
│     │   (type=IN, ref_type=PURCHASE)            │
│     └─ Status = RECEIVED                        │
│                                                 │
│  3. Detail (/purchases/{id})                    │
│     └─ Void transaksi (batalkan + kembalikan    │
│        stok)                                    │
└─────────────────────────────────────────────────┘
```

---

### 5. Point of Sale (POS)

```
URL: /pos
Akses: Owner, Admin, Kasir
```

Halaman kasir untuk melakukan transaksi penjualan.

**Layout:**

```
┌──────────────────────────────────┬──────────────────────┐
│        CARI BARANG (2/3)         │   KERANJANG (1/3)    │
│                                  │                      │
│  [🔍 Ketik nama/kode barang]    │  ┌─────────────────┐ │
│                                  │  │ Item 1    Rp X  │ │
│  Kode │ Nama  │ Harga │ Stok │ +│  │ Qty: [3]  = Rp Y│ │
│  ─────┼───────┼───────┼──────┼──│  ├─────────────────┤ │
│  B001 │ Semen │ 65rb  │  50  │⊕ │  │ Item 2    Rp X  │ │
│  B002 │ Cat   │ 85rb  │   0  │🚫│  │ Qty: [1]  = Rp Y│ │
│  B003 │ Paku  │ 15rb  │  200 │⊕ │  └─────────────────┘ │
│                                  │                      │
│                                  │  Subtotal:    Rp XXX │
│                                  │  Diskon:      Rp XXX │
│                                  │  Grand Total: Rp XXX │
│                                  │                      │
│                                  │  Metode: [Cash ▼]    │
│                                  │  Bayar:  [8.000.000] │
│                                  │  Kembali: Rp XXX     │
│                                  │                      │
│                                  │  [✅ Checkout & Simpan]│
└──────────────────────────────────┴──────────────────────┘
```

**Alur Checkout:**

```
1. Cari barang (autocomplete via API /pos/search?q=...)
2. Klik "Tambah" → masuk ke keranjang
   ├─ Stok 0 → Tombol "Habis" (disabled, abu-abu)
   ├─ Qty di keranjang tidak boleh melebihi stok
   └─ Jika sudah max stok → alert peringatan
3. Atur qty, diskon, metode bayar
4. Input nominal uang dibayar (format: 8.000.000)
5. Klik "Checkout & Simpan"
   ├─ Validasi: keranjang tidak kosong
   ├─ Validasi: uang dibayar >= grand total
   │   └─ Jika kurang → notifikasi error (keranjang TIDAK dihapus)
   └─ Submit ke server
6. Server:
   ├─ Generate invoice (SAL-YYYYMMDD-XX)
   ├─ Cek stok per item (lock row untuk concurrency)
   ├─ Hitung tax (jika aktif di StoreSetting)
   ├─ Simpan Sale + SaleItems
   ├─ Kurangi stok via stock_movements (type=OUT, ref_type=SALE)
   ├─ Audit log
   └─ Redirect ke detail → cetak nota
```

**Metode Pembayaran:**

- 💵 Cash
- 🏦 Transfer Bank
- 📱 QRIS

---

### 6. Penjualan

#### 6a. Riwayat Penjualan

```
URL: /sales
Akses: Owner, Admin
```

Daftar semua transaksi penjualan dengan filter.

**Kolom:** Tanggal | No. Invoice | Grand Total | Metode Bayar | Status | Kasir

#### 6b. Detail Penjualan

```
URL: /sales/{id}
```

Informasi lengkap 1 transaksi: header, daftar item, info pembayaran.

#### 6c. Cetak Nota

```
URL: /sales/{id}/print
```

Halaman khusus cetak (print-friendly) untuk struk/nota penjualan.

#### 6d. Void Transaksi

```
URL: POST /sales/{id}/void
```

Membatalkan transaksi dan mengembalikan stok barang.

```
Void → status = VOID
     → stock_movements: type=IN (mengembalikan stok)
```

---

### 7. Laporan

```
URL: /reports
Akses: Owner, Admin
```

#### 7a. Dashboard Laporan

Ringkasan semua laporan yang tersedia.

#### 7b. Ringkasan Penjualan Harian

```
URL: /reports/sales-summary
```

Tabel penjualan per hari: Tanggal | Jumlah Transaksi | Total Pendapatan.
Filter berdasarkan rentang tanggal.

#### 7c. Barang Terlaris

```
URL: /reports/best-sellers
```

Ranking barang berdasarkan qty terjual dan total revenue.

#### 7d. Laba Sederhana

```
URL: /reports/profit
```

Perhitungan laba kotor: `Revenue - COGS (Cost of Goods Sold)`.

#### 7e. Stok Menipis

```
URL: /reports/low-stock
```

Daftar barang dengan stok di bawah minimum.

**Level:**

- 🔴 **Kritis** — Stok ≤ 10
- 🟡 **Rendah** — Stok ≤ 50
- ⚪ **Low** — Stok di bawah minimum

#### 7f. Export CSV

```
GET /reports/export/sales         → Download CSV penjualan
GET /reports/export/low-stock     → Download CSV stok menipis
```

---

## 🗄️ Struktur Database

```
┌──────────────────────────────────────────────────────────┐
│                     DATABASE SCHEMA                      │
└──────────────────────────────────────────────────────────┘

users                    categories              units
├─ id                    ├─ id                   ├─ id
├─ name                  ├─ name                 ├─ name
├─ email                 └─ timestamps           └─ timestamps
├─ password
├─ role (owner/admin/cashier)
└─ timestamps

products                              suppliers
├─ id                                 ├─ id
├─ code (unique)                      ├─ name
├─ name                               ├─ phone
├─ category_id → categories           ├─ address
├─ unit_id → units                    └─ timestamps
├─ cost_price
├─ sell_price
├─ current_stock
├─ stock_minimum
├─ is_active
└─ timestamps

stock_movements                       store_settings
├─ id                                 ├─ id
├─ product_id → products              ├─ store_name
├─ type (IN/OUT)                      ├─ tax_enabled
├─ ref_type (MANUAL/SALE/PURCHASE/    ├─ tax_percent
│            OPENING/OPNAME/VOID)     └─ timestamps
├─ ref_id
├─ qty_in
├─ qty_out
├─ balance_after
├─ notes
├─ created_by → users
└─ timestamps

sales                                 sale_items
├─ id                                 ├─ id
├─ invoice_no (unique)                ├─ sale_id → sales
├─ date                               ├─ product_id → products
├─ subtotal                           ├─ qty
├─ discount_total                     ├─ price
├─ tax_amount                         ├─ cost
├─ grand_total                        ├─ subtotal
├─ payment_method (cash/transfer/qris)└─ timestamps
├─ paid_amount
├─ change_amount
├─ status (PAID/VOID)
├─ created_by → users
└─ timestamps

purchases                             purchase_items
├─ id                                 ├─ id
├─ invoice_no (unique)                ├─ purchase_id → purchases
├─ supplier_id → suppliers            ├─ product_id → products
├─ date                               ├─ qty
├─ grand_total                        ├─ price
├─ status (RECEIVED/VOID)             ├─ subtotal
├─ created_by → users                 └─ timestamps
└─ timestamps

audit_logs
├─ id
├─ action
├─ auditable_type
├─ auditable_id
├─ user_id → users
├─ payload (JSON)
└─ timestamps
```

---

## 🛣️ API & Routes

### Autentikasi

| Method | URL       | Deskripsi        |
| ------ | --------- | ---------------- |
| GET    | /login    | Halaman login    |
| POST   | /login    | Proses login     |
| GET    | /register | Halaman register |
| POST   | /register | Proses register  |
| POST   | /logout   | Logout           |

### Dashboard

| Method | URL        | Deskripsi     |
| ------ | ---------- | ------------- |
| GET    | /dashboard | Halaman utama |

### Master Data

| Method | URL                   | Deskripsi            |
| ------ | --------------------- | -------------------- |
| GET    | /categories           | Daftar kategori      |
| POST   | /categories           | Simpan kategori baru |
| GET    | /categories/{id}/edit | Form edit kategori   |
| PUT    | /categories/{id}      | Update kategori      |
| DELETE | /categories/{id}      | Hapus kategori       |
| GET    | /units                | Daftar satuan        |
| POST   | /units                | Simpan satuan baru   |
| GET    | /units/{id}/edit      | Form edit satuan     |
| PUT    | /units/{id}           | Update satuan        |
| DELETE | /units/{id}           | Hapus satuan         |
| GET    | /products             | Daftar barang        |
| POST   | /products             | Simpan barang baru   |
| GET    | /products/{id}        | Detail barang        |
| GET    | /products/{id}/edit   | Form edit barang     |
| PUT    | /products/{id}        | Update barang        |
| DELETE | /products/{id}        | Hapus barang         |

### Stok

| Method | URL                   | Deskripsi          |
| ------ | --------------------- | ------------------ |
| GET    | /stock/opening        | Form stok awal     |
| POST   | /stock/opening        | Simpan stok awal   |
| GET    | /stock/in             | Form stok masuk    |
| POST   | /stock/in             | Simpan stok masuk  |
| GET    | /stock/out            | Form stok keluar   |
| POST   | /stock/out            | Simpan stok keluar |
| GET    | /stock/opname         | Form stock opname  |
| POST   | /stock/opname         | Simpan opname      |
| GET    | /stock/card/{product} | Kartu stok barang  |

### Supplier & Pembelian

| Method | URL                  | Deskripsi           |
| ------ | -------------------- | ------------------- |
| GET    | /suppliers           | Daftar supplier     |
| POST   | /suppliers           | Simpan supplier     |
| GET    | /suppliers/{id}/edit | Form edit supplier  |
| PUT    | /suppliers/{id}      | Update supplier     |
| DELETE | /suppliers/{id}      | Hapus supplier      |
| GET    | /purchases           | Daftar pembelian    |
| GET    | /purchases/create    | Form pembelian baru |
| POST   | /purchases           | Simpan pembelian    |
| GET    | /purchases/{id}      | Detail pembelian    |
| POST   | /purchases/{id}/void | Void pembelian      |

### POS & Penjualan

| Method | URL               | Deskripsi            |
| ------ | ----------------- | -------------------- |
| GET    | /pos              | Halaman kasir        |
| GET    | /pos/search?q=... | API pencarian barang |
| POST   | /sales/checkout   | Proses checkout      |
| GET    | /sales            | Riwayat penjualan    |
| GET    | /sales/{id}       | Detail penjualan     |
| GET    | /sales/{id}/print | Cetak nota           |
| POST   | /sales/{id}/void  | Void penjualan       |

### Laporan

| Method | URL                       | Deskripsi               |
| ------ | ------------------------- | ----------------------- |
| GET    | /reports                  | Dashboard laporan       |
| GET    | /reports/sales-summary    | Ringkasan penjualan     |
| GET    | /reports/best-sellers     | Barang terlaris         |
| GET    | /reports/profit           | Laba sederhana          |
| GET    | /reports/low-stock        | Stok menipis            |
| GET    | /reports/export/sales     | Export CSV penjualan    |
| GET    | /reports/export/low-stock | Export CSV stok menipis |

---

## 📊 Diagram Alur Utama

```
                    ┌─────────────┐
                    │    LOGIN    │
                    └──────┬──────┘
                           │
                    ┌──────▼──────┐
                    │  DASHBOARD  │
                    └──────┬──────┘
                           │
          ┌────────────────┼────────────────┐
          │                │                │
    ┌─────▼─────┐   ┌─────▼─────┐   ┌─────▼─────┐
    │  MASTER   │   │    POS    │   │  LAPORAN  │
    │   DATA    │   │  (KASIR)  │   │           │
    └─────┬─────┘   └─────┬─────┘   └─────┬─────┘
          │               │               │
   ┌──────┼──────┐        │        ┌──────┼──────┐
   │      │      │        │        │      │      │
Kategori Satuan Barang    │     Sales  Best   Low
                 │        │     Summary Seller Stock
                 │        │
           ┌─────▼────┐   │
           │   STOK    │  │
           │ MGMT      │  │
           └─────┬─────┘  │
                 │        │
        ┌────────┼────────┼────────┐
        │        │        │        │
    Opening    In/Out   Opname  Kartu Stok
                          │
                    ┌─────▼──────┐
                    │  SUPPLIER  │
                    │ & PURCHASE │
                    └────────────┘

Alur Stok:
  Purchase → stock_movements (IN) → +current_stock
  POS Sale → stock_movements (OUT) → -current_stock
  Manual   → stock_movements (IN/OUT) → ±current_stock
  Void     → stock_movements (reverse) → ±current_stock
```

---

## 📄 Lisensi

MIT License

---

> **TokoBangunPOS** — Dibangun dengan ❤️ menggunakan Laravel 12
