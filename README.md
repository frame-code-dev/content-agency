<p align="center">
  <h1 align="center">🚀 AI Content Agency Platform</h1>
  <p align="center">
    <strong>SaaS Platform Strategi & Manajemen Konten Media Sosial Berbasis AI dan Decision Engine (SPK SAW)</strong>
  </p>
</p>

---

## 📌 Tentang Platform

**AI Content Agency** adalah platform SaaS (Software-as-a-Service) modern yang dirancang untuk mengotomatisasi alur kerja agensi kreatif dan tim pemasaran digital. Platform ini mengintegrasikan **Meta Graph API (Instagram Business API)** dan **OpenAI API** untuk menganalisis performa konten, mengukur sentimen audiens, melacak kompetitor, serta menghasilkan perencanaan konten teroptimasi dengan Sistem Pendukung Keputusan (SPK) berbasis algoritma **Simple Additive Weighting (SAW)**.

---

## ✨ Fitur-Fitur Utama

### 1. 🔗 Integrasi Direct Instagram & Live Analytics
- **Instagram OAuth Connection**: Menghubungkan akun Instagram Business / Creator secara langsung menggunakan Meta Graph API.
- **Mock / Demo Mode**: Mendukung pengujian lokal tanpa kredensial live API melalui mode *Mock Demo* bawaan.
- **Performa Konten & Audiens**: Visualisasi metrik interaksi (likes, comments, reach, impressions, follower growth).

### 2. 🤖 AI Post Content Analysis Engine
- **Tone & Sentiment Audit**: Menganalisis gaya bahasa (*tone of voice*) dan sentimen postingan menggunakan OpenAI `gpt-4o-mini`.
- **Hashtag Clutter & Reach Evaluation**: Audit kualitas penggunaan hashtag dan jangkauan potensial.
- **Agency Recommendation & Score**: Memberikan nilai agregat agensi (*Agency Score*) dan rekomendasi perbaikan hook, caption, serta CTA.

### 3. 🎯 Content Planner & SPK Decision Engine (Metode SAW)
- **Hermes AI Copywriting Generator**: Pembuatan draf caption dan hook otomatis disesuaikan dengan konsep dan tone (Professional, Casual, Soft Selling, Storytelling, Urgent).
- **SPK Decision Engine (Simple Additive Weighting)**: Penilaian objektif draf konten berdasarkan 4 kriteria terbobot untuk menentukan prioritas rilis (*Star Content*, *Medium Priority*, atau *Needs Refactoring*).

### 4. 📊 Competitor Intelligence & AI Gap Analysis
- **Pelacakan Kompetitor**: Memantau perkembangan followers, engagement rate, dan rata-rata interaksi akun kompetitor industri.
- **AI Gap Analysis**: Mengidentifikasi celah strategi konten yang belum dieksekusi oleh kompetitor untuk dimanfaatkan oleh brand.

### 5. 📈 Executive Dashboard & Campaign Management
- **Dashboard Overview**: Ringkasan performa kampanye, statistik konten unggulan, dan jadwal postingan mendatang.
- **Manajemen Pesan & Komentar**: Monitoring respon audiens secara terpusat.

---

## 📐 Sistem Pendukung Keputusan (SPK) - Metode SAW

Sistem klasifikasi prioritas konten pada modul **Content Planner** menggunakan metode **Simple Additive Weighting (SAW)** dengan pembobotan kriteria sebagai berikut:

| Kode | Kriteria | Sifat Kriteria | Bobot ($W_j$) | Keterangan |
| :--- | :--- | :--- | :--- | :--- |
| **$C_1$** | Potential Engagement Rate | **Benefit** (Semakin tinggi semakin baik) | **35%** ($0.35$) | Potensi interaksi audiens (skala 1-10) |
| **$C_2$** | Production Effort & Cost | **Cost** (Semakin rendah semakin baik) | **20%** ($0.20$) | Tingkat kesulitan & biaya produksi (skala 1-10) |
| **$C_3$** | Trend Alignment | **Benefit** (Semakin tinggi semakin baik) | **25%** ($0.25$) | Kesesuaian dengan tren industri terkini (skala 1-10) |
| **$C_4$** | Brand Voice & Strategy Fit | **Benefit** (Semakin tinggi semakin baik) | **20%** ($0.20$) | Keselarasan dengan identitas brand (skala 1-10) |

### Formula Kalkulasi Final Score:
$$R_{ij} = \begin{cases} \frac{X_{ij}}{\max X_{ij}} & \text{untuk kriteria Benefit } (C_1, C_3, C_4) \\ \frac{\min X_{ij}}{X_{ij}} & \text{untuk kriteria Cost } (C_2) \end{cases}$$

$$\text{Final Score} = \sum_{j=1}^{n} (W_j \times R_{ij}) \times 100$$

### Klasifikasi Prioritas:
- **Score $\ge 80$**: ⭐ **Star Content** (Prioritas Utama Rilis)
- **Score $60 - 79$**: 🔹 **Medium Priority** (Konten Pendukung)
- **Score $< 60$**: ⚠️ **Needs Refactoring** (Perlu Perbaikan Konsep)

---

## 🗄️ Dukungan Migration Database (PostgreSQL & MySQL)

Seluruh migration pada direktori `database/migrations/` dibangun menggunakan builder standar **Laravel Schema Blueprint** yang murni *ANSI-SQL compliant*. Hal ini menjamin migration dapat dijalankan dengan lancar tanpa modifikasi kode pada **PostgreSQL (`pgsql`)** maupun **MySQL (`mysql`)** / MariaDB.

### Daftar Tabel Database:
1. `users` & `password_reset_tokens` - Autentikasi dan identitas pengguna.
2. `roles` & `permissions` - Manajemen hak akses RBAC via Spatie Permission (`super-admin`, `client`).
3. `instagram_accounts` - Penyimpanan token OAuth dan identitas profil Instagram Business.
4. `content_plans` - Perencanaan konten, draf caption, tanggal rilis, dan hasil skor SPK SAW.
5. `competitors` - Data pelacakan kompetitor, engagement rate, dan catatan gap analysis.
6. `sessions`, `cache`, `jobs` - Penanganan session, caching, dan background queue jobs.

---

## 🛠️ Arsitektur & Technology Stack

- **Framework**: [Laravel 12.x](https://laravel.com) (PHP 8.2+)
- **Frontend Stack**: Blade Template Engine, Tailwind CSS, Vite, Alpine.js
- **Database Engine**: PostgreSQL 16 / MySQL 8.x / SQLite
- **RBAC Engine**: Spatie Laravel Permission (`^8.3`)
- **API Client**: Guzzle HTTP Client / Laravel Http Facade
- **Containerization**: Docker & Docker Compose (`nginx`, `php-fpm`, `postgres`)

---

## ⚙️ Panduan Instalasi & Penggunaan

### 1. Prerequisites (Prasyarat)
- **PHP** $\ge 8.2$ & **Composer**
- **Node.js** $\ge 18$ & **NPM**
- **Docker & Docker Compose** *(Opsional, jika menggunakan lingkungan container)*

---

### 2. Setup Menggunakan Docker (Rekomendasi - PostgreSQL)

```bash
# 1. Clone repository
git clone https://github.com/your-org/ai-content-agency.git
cd ai-content-agency

# 2. Salin file environment
cp .env.example .env

# 3. Jalankan container Docker (App, Nginx, PostgreSQL)
docker compose up -d

# 4. Install dependency composer & npm dalam container
docker compose exec app composer install
docker compose exec app npm install
docker compose exec app npm run build

# 5. Generate Application Key
docker compose exec app php artisan key:generate

# 6. Jalankan migration database dan seeder data awal
docker compose exec app php artisan migrate:fresh --seed
```

Aplikasi dapat diakses melalui browser di `http://localhost:8080`.

---

### 3. Setup Lokal Tanpa Docker (PostgreSQL / MySQL)

#### A. Konfigurasi Environment PostgreSQL
Edit file `.env`:
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=ai_content_agency
DB_USERNAME=postgres
DB_PASSWORD=your_password
```

#### B. Konfigurasi Environment MySQL
Edit file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ai_content_agency
DB_USERNAME=root
DB_PASSWORD=your_password
```

#### C. Jalankan Perintah Setup Lokal
```bash
# Install dependency PHP & JavaScript
composer install
npm install
npm run build

# Generate app key & jalankan migration + seeder
php artisan key:generate
php artisan migrate:fresh --seed

# Jalankan server lokal
php artisan serve
```

Aplikasi dapat diakses di `http://127.0.0.1:8000`.

---

## 🔑 Konfigurasi Environment & AI Provider (`.env`)

Aplikasi ini mendukung dua penyedia AI (**Google Gemini API** & **OpenAI API**). Anda dapat menggunakan **Google Gemini API** secara **gratis** dengan mendapatkan API Key di [Google AI Studio (aistudio.google.com)](https://aistudio.google.com).

Pastikan variabel integrasi berikut dikonfigurasi di file `.env`:

```env
# ------------------------------------------------------------------------------
# Konfigurasi AI Provider (Pilihan: 'gemini' atau 'openai')
# ------------------------------------------------------------------------------
AI_PROVIDER=gemini

# Google Gemini API Key (Dapatkan gratis dari https://aistudio.google.com)
GEMINI_API_KEY=your_gemini_api_key_here
GEMINI_MODEL=gemini-1.5-flash

# OpenAI API Key (Opsional / Alternatif Provider)
OPENAI_API_KEY=your_openai_api_key_here

# ------------------------------------------------------------------------------
# Integrasi Instagram Business (Meta Graph API)
# ------------------------------------------------------------------------------
INSTAGRAM_CLIENT_ID=your_instagram_app_id
INSTAGRAM_CLIENT_SECRET=your_instagram_app_secret
INSTAGRAM_REDIRECT_URI="${APP_URL}/auth/instagram/callback"

# Opsional: Aktifkan Mock Mode jika belum memiliki API Key live
INSTAGRAM_MOCK_MODE=true
```

---

## 🔑 Akun Demo Default (Seeder)

Setelah menjalankan `php artisan migrate:fresh --seed`, Anda dapat menguji login dengan akun berikut:

- **Super Admin**: `admin@agency.com` | Password: `password`
- **Client User**: `client@agency.com` | Password: `password`

---

## 🧪 Pengujian (Testing)

Untuk memastikan seluruh modul, alur autentikasi, integrasi Instagram, serta pembuatan planner berfungsi dengan baik, jalankan test suite PHPUnit:

```bash
# Pengujian di lingkungan Docker
docker compose exec app php artisan test

# Pengujian di lingkungan Lokal
php artisan test
```

---

## 📄 Lisensi

Aplikasi **AI Content Agency** ini dirilis di bawah [MIT License](LICENSE).
