# 🎓 Madrasah Aliyah Nusantara

Modern responsive website built with Laravel & Bootstrap 5

## 🌟 Features

- ✅ **Modern Contact Page** - Teal gradient design with interactive form
- ✅ **Password Verification** - 6-digit code with countdown timer  
- ✅ **Fully Responsive** - Mobile-first Bootstrap 5 design
- ✅ **Security Features** - 2FA, rate limiting, audit logging
- ✅ **Admin Panel** - Organization & user management

## 🎨 Design Highlights

- **Primary Gradient**: `linear-gradient(135deg, #009688 0%, #00796B 100%)`
- **Accent Color**: `#00BFA5`
- **Typography**: Poppins font with fluid scaling
- **Icons**: Font Awesome 6.4.0

## 📱 Responsive Breakpoints

- Mobile: 320px+
- Tablet: 768px+  
- Desktop: 1200px+

## 🚀 Quick Start

```bash
git clone https://github.com/username/madrasah-nusantara
cd madrasah-nusantara
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

## 🔗 Live Demo

**Website**: [madrasah-nusantara.vercel.app](https://madrasah-nusantara.vercel.app)
**Admin**: [madrasah-nusantara.vercel.app/admin](https://madrasah-nusantara.vercel.app/admin)

## 📸 Screenshots

### Desktop
![Contact Page]
![Password Verification]

### Mobile
![Contact Mobile]
![Password Mobile]

## 🛠️ Tech Stack

- **Backend**: Laravel 11
- **Frontend**: Bootstrap 5, Font Awesome
- **Database**: SQLite/MySQL
- **Deployment**: Vercel/Netlify ready

## 📝 Updates & Fixes

- **Bugfix**: Resolved error `View [pages.fasilitas-detail] not found`.
  - Added view file: `resources/views/pages/fasilitas-detail.blade.php` used by `FacilityController@show()`.
  - The page shows facility details (image, category, capacity, status, location, description) and related facilities.
- **Added**: Facilities detail UI with related items list and back navigation to `route('fasilitas')`.
- **Migration filenames updated**: Renamed all `database/migrations/` files starting with `2024_` to `2025_` to align the migration timeline. No PHP class contents changed.
- **Post-update note**: If needed, run `php artisan migrate` (or `php artisan migrate:refresh` if you want to re-run all migrations in a dev environment).

## 📧 Contact

Built for Madrasah Aliyah Nusantara - Modern Islamic Education