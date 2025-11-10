# Pandulungan - Night Run Event Registration System 🏃‍♂️🏃‍♀️

```
  _____                    _       _             
 |  __ \                  | |     | |            
 | |__) |__ _ __ _   _  __| |_   _| |_ _   _    
 |  ___/ _ \ '__| | | |/ _` | | | | __| | | |   
 | |  |  __/ |  | |_| | (_| | |_| | |_| |_| |   
 |_|   \___|_|   \__,_|\__,_|\__,_|\__|\__, |   
                                        __/ |   
                                       |___/    
```

Welcome to **Pandulungan** — a modern, robust, and user-friendly event registration platform built for the Night Run 2025! This system is designed to make mass registration, payment, and admin management a breeze, whether you're a participant or an event organizer.

---

## 🌟 What's New (Latest Updates)

### 🎨 Dashboard Design Evolution
```
   ╭─────────────────╮
   │  New Design!    │
   │  ┌─────────┐   │
   │  │  Cards  │   │
   │  └─────────┘   │
   ╰─────────────────╯
```
- **Visual Hierarchy Enhancement:**
  - Elegant decorative elements in top cards
  - Color-coded status indicators
  - Improved card layout with 2-row structure
  - Subtle corner accents for visual interest
  - Modern shadow and border effects

### 📊 Smart Analytics Dashboard
```
   📈  Real-time Stats
   ┌──────────────┐
   │ Participants │
   │    Income    │
   │    Status    │
   └──────────────┘
```
- **Enhanced Statistics Display:**
  - Prominent total participants counter (green theme)
  - Eye-catching total income display (red theme)
  - Real-time status tracking
  - Global statistics independent of search
  - Optimized data visualization

### 🔍 Intelligent Search System
```
   🔎  Search
   ┌──────────────┐
   │  Name        │
   │  Status      │
   │  Order       │
   └──────────────┘
```
- **Multi-dimensional Search:**
  - Cross-field search capabilities
  - Real-time filtering
  - Status-based filtering
  - Participant detail search
  - Order information search

### 🎯 Status Management
```
   ⚡  Status Flow
   ┌──────────────┐
   │ Pending  →   │
   │ Waiting  →   │
   │ Paid         │
   └──────────────┘
```
- **Streamlined Status Control:**
  - Visual status indicators
  - One-click status updates
  - Color-coded status badges
  - Real-time status changes
  - Status history tracking

### 💫 UI/UX Improvements
```
   ✨  Design
   ┌──────────────┐
   │  Modern UI   │
   │  Smooth UX   │
   │  Responsive  │
   └──────────────┘
```
- **Modern Interface Elements:**
  - Decorative corner accents
  - Smooth hover effects
  - Responsive card layouts
  - Improved spacing and alignment
  - Enhanced visual feedback

### 📱 Mobile Optimization
```
   📱  Mobile First
   ┌──────────────┐
   │  Responsive  │
   │  Touch UI    │
   │  Fast Load   │
   └──────────────┘
```
- **Responsive Design:**
  - Fluid card layouts
  - Touch-friendly interfaces
  - Optimized for all screen sizes
  - Improved mobile navigation
  - Better mobile data display

### 🔐 Security & Performance
```
   🛡️  Security
   ┌──────────────┐
   │  Protected   │
   │  Optimized   │
   │  Secure      │
   └──────────────┘
```
- **Enhanced System Stability:**
  - Optimized database queries
  - Improved error handling
  - Better data validation
  - Enhanced security measures
  - Faster page loading

### 📈 Business Intelligence
```
   📊  Analytics
   ┌──────────────┐
   │  Tracking    │
   │  Monitoring  │
   │  Reports     │
   └──────────────┘
```
- **Advanced Analytics:**
  - Real-time participant tracking
  - Revenue monitoring
  - Status distribution analysis
  - Payment verification system
  - Export capabilities

### WhatsApp Integration & Notifications
- **Fonnte Integration:**
  - WhatsApp notifications sent to registrants after successful registration
  - Background processing using Laravel Queues
  - Automatic payment reminders and status updates
  - Admin contact via WhatsApp in footer

### UI/UX Enhancements
- **Modern Design:**
  - Clean, transparent header that changes to solid white on scroll
  - Minimalistic footer with social and WhatsApp links
  - Two-column login layout with admin info
  - Creative 404 page with fallback route
  - Mobile-friendly solid white drawer menu with icons
- **Event Pages:**
  - Redesigned hero section with event theme
  - Modern card layouts for event details
  - Improved spacing and professional styling
  - Consistent theming across all pages

### Admin Dashboard Improvements
- **Enhanced Table Features:**
  - Search functionality for orders
  - Pagination with modern Tailwind styling
  - Excel export with combined data from registrations and checkout_participants
  - Complete participant information including payment proof and status

### SEO & Performance
- **Search Engine Optimization:**
  - Meta tags for better search visibility
  - Open Graph tags for social media sharing
  - Twitter Card support
  - Custom favicon and site icons
- **Performance:**
  - Optimized image loading
  - Efficient queue processing
  - Responsive design for all devices

### Multi-Peserta Registration:
- Form pendaftaran mendukung 1-5 peserta sekaligus
- Validasi lengkap di frontend (HTML5) dan backend (Laravel)
- Input hanya menerima format yang benar
- Data peserta tersimpan rapi di tabel `checkout_participants`

---

## 🚀 Fitur Utama

- **Pendaftaran Multi Peserta:**
  - Satu form, hingga 5 peserta sekaligus
  - Validasi otomatis untuk NIK, email, WhatsApp
  - Background processing untuk notifikasi
- **Checkout & Pembayaran:**
  - Ringkasan pendaftaran
  - Instruksi pembayaran
  - Upload bukti
  - Status pembayaran real-time
- **Dashboard Admin:**
  - Statistik peserta dan pendapatan
  - Manajemen order lengkap
  - Export data ke Excel
  - WhatsApp integration
- **Modern UI:**
  - TailwindCSS
  - Inter font family
  - Responsive design
  - Dark/light mode support
- **Keamanan & Logging:**
  - Validasi ganda
  - Autentikasi admin
  - Error handling
  - Queue monitoring

---

## 🏁 Event Night Run 2025
- **Jalur:** 5km, 3 waterstation
- **Kategori:** Putra & Putri
- **Biaya:** Rp 150.000 (jersey & refreshment)
- **Hadiah:** Total jutaan rupiah & sertifikat untuk 500 finisher pertama
- **Timeline:**
  - Pendaftaran: 1-30 Januari 2025
  - Race Pack: 5 Februari 2025
  - Event: 10 Februari 2025

---

## 📦 Instalasi Cepat

1. **Clone & Install**
   ```bash
   git clone <repository-url>
   cd pandulungan
   composer install
   npm install
   ```
2. **Setup Environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   # Edit .env untuk database dan Fonnte API
   ```
3. **Migrate & Seed**
   ```bash
   php artisan migrate --seed
   ```
4. **Run the App**
   ```bash
   npm run dev
   php artisan serve
   php artisan queue:work
   ```

---

## 🛠️ Struktur & Teknologi
- **Laravel 10** (Backend, Auth, Validation)
- **MySQL** (Database)
- **TailwindCSS** (UI/UX)
- **Alpine.js** (Interaktivitas)
- **Laravel Breeze** (Auth)
- **Laravel Excel** (Data Export)
- **Fonnte** (WhatsApp Integration)
- **Custom Models:**
  - `Checkout`, `CheckoutParticipant`, `User`
  - `WhatsAppNotification` (Queue Jobs)
- **Views:**
  - Modern layouts with SEO optimization
  - Responsive components
  - Error pages
  - Admin dashboard

---

## 👤 Akun Admin Default
- **Email:** admin@example.com
- **Password:** password

---

## 🤝 Kontribusi
1. Fork repo ini
2. Buat branch baru (`git checkout -b fitur-baru`)
3. Commit perubahan (`git commit -m 'Tambah fitur baru'`)
4. Push ke branch (`git push origin fitur-baru`)
5. Buat Pull Request

---

## 📢 Catatan Kreatif
- Sistem ini dirancang untuk event lari malam dengan fokus pada user experience
- Notifikasi WhatsApp otomatis untuk engagement yang lebih baik
- UI modern dan konsisten di semua halaman
- SEO optimized untuk visibilitas yang lebih baik
- Queue system untuk performa yang optimal

---

## 📄 License
[MIT License](LICENSE.md)
