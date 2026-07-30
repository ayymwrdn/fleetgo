# 🚗 FleetGo - Vehicle Booking System

Sistem manajemen pemesanan kendaraan untuk perusahaan tambang nikel dengan sistem approval 2 level.

---

## 📋 Daftar Isi
- [Tech Stack](#tech-stack)
- [Default Login](#default-login)
- [Fitur](#fitur)
- [Instalasi](#instalasi)
- [Panduan Penggunaan](#panduan-penggunaan)
- [Database Schema](#database-schema)
- [Activity Diagram](#activity-diagram)
- [Troubleshooting](#troubleshooting)
- [Lisensi](#lisensi)

---

## 🛠️ Tech Stack

| Komponen | Teknologi | Versi |
|:---|:---|:---|
| **Backend** | PHP | 8.1.10 |
| **Framework** | Laravel | 10.50.2 |
| **Database** | PostgreSQL (Railway) / MySQL | 15 / 8.0 |
| **Frontend** | Blade + TailwindCSS + Alpine.js | - |
| **Chart** | Chart.js | 4.x |
| **Export Excel** | Laravel Excel (maatwebsite/excel) | 3.1 |
| **Hosting** | Railway | - |

---

## 🔑 Default Login

| Role | Nama | Email | Password |
|:---|:---|:---|:---|
| **Admin** | Administrator | admin@fleetgo.com | password |
| **Approver Level 1** | Sissy Nuraini | sissy@fleetgo.com | password |
| **Approver Level 2** | Ayudya Kusumawardani | ayudya@fleetgo.com | password |
| **Manager Pool** | Manager Operasional | manager@fleetgo.com | password |
| **Direktur Utama** | Direktur Utama | direktur@fleetgo.com | password |

---

## ✨ Fitur

### Fitur Wajib (Sesuai Soal)
- ✅ 2 Role (Admin & Approver)
- ✅ Admin input pemesanan + tentukan driver & approver
- ✅ Approval berjenjang 2 level
- ✅ Approver setujui via aplikasi
- ✅ Dashboard grafik pemakaian
- ✅ Export laporan ke Excel

### Fitur Tambahan (Nilai Plus)
- ✅ Activity Log (setiap proses tercatat)
- ✅ UI/UX Responsive + Dark/Light Mode
- ✅ Monitoring Kendaraan (BBM, Service, Riwayat)
- ✅ CRUD Kendaraan (Tambah, Edit, Hapus)
- ✅ Physical Data Model
- ✅ Activity Diagram

---

## 📦 Instalasi

### 1. Clone Repository
```bash
git clone https://github.com/ayymwrdn/fleetgo.git
cd fleetgo
