# 🚀 API Studio - API Testing Suite by Aguphia

![PHP Version](https://img.shields.io/badge/PHP-7.4%2B-777BB4?style=flat-square&logo=php&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-v3.0-38B2AC?style=flat-square&logo=tailwind-css&logoColor=white)
![jQuery](https://img.shields.io/badge/jQuery-3.7.1-0769AD?style=flat-square&logo=jquery&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-Supported-4479A1?style=flat-square&logo=mysql&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green?style=flat-square)

**API Studio** (API Testing Suite by Aguphia) adalah aplikasi pengujian API berbasis web (*lightweight API Client*) yang ringan, intuitif, dan independen. Dirancang dengan antarmuka modern berkonsep *Glassmorphism*, platform ini memungkinkan pengembang untuk menguji *endpoint* HTTP, mengelola *header*, mendokumentasikan *payload*, serta membuat *code snippet* secara instan tanpa ketergantungan pada *software* pihak ketiga seperti Postman.

---

## 🌟 Fitur Utama

- **🎨 Modern Glassmorphic UI & Dual Theme:** Tampilan antarmuka yang bersih berbasis Tailwind CSS dengan dukungan penuh untuk **Day/Light Mode** (default) dan **Dark Mode**.
- **🔄 Pengujian HTTP Methods Lengkap:** Mendukung eksekusi method `GET`, `POST`, `PUT`, `PATCH`, dan `DELETE`.
- **🔑 Dynamic HTTP Headers & Payload:** Kemudahan menambah/menghapus *Custom Headers* dan *JSON Body Payload* secara dinamis.
- **🛡️ Embedded PHP Proxy Server:** Dilengkapi dengan *backend proxy* untuk mem-bypass kendala **CORS** (*Cross-Origin Resource Sharing*) serta proteksi **SSRF** (*Server-Side Request Forgery*).
- **⚡ Code Snippet Generator Automatic:** Menggenerasi kode permintaan secara otomatis ke dalam berbagai bahasa pemrograman (`cURL`, `JavaScript Fetch`, `Python Requests`, dan `PHP cURL`).
- **📂 Persistent History (MySQL Integration):** Menyimpan riwayat dan parameter *request* ke basis data MySQL untuk dipanggil kembali kapan saja hanya dengan satu klik.

---

## 🛠️ Persyaratan Sistem

Pastikan lingkungan server Anda memenuhi persyaratan berikut:

* **Web Server:** Apache / Nginx / LiteSpeed
* **PHP:** Versi 7.4 atau yang lebih baru (Membutuhkan ekstensi `cURL` dan `PDO_MySQL`)
* **Database:** MySQL / MariaDB

---

## 🚀 Panduan Instalasi & Penggunaan

### 1. Kloning Repositori
```bash
git clone https://github.com/agungsetiady/api-studio.git
cd api-studio
