# 🏈 Athlete Recruitment Website

A modern, full-featured recruitment website for high school athletes. Built with Laravel 12, Livewire, and TailwindCSS.

> **⚡ New to the project?** See **[QUICKSTART.md](QUICKSTART.md)** for a 10-minute setup guide!

## ✨ Features

### Frontend
- 🎯 **Dynamic Homepage** - Hero section with athlete stats and photo
- 📊 **Season Statistics** - Interactive stats display with career totals
- 🎥 **Video Highlights** - Embedded YouTube/Hudl/Vimeo videos
- 🏆 **Awards & Honors** - Showcase achievements
- 💬 **Testimonials** - Recommendations from coaches and mentors
- 📞 **Contact Form** - Direct communication with coaches
- 📄 **PDF Resume** - Auto-generated athletic resume
- 📱 **Fully Responsive** - Works perfectly on all devices

### Admin Dashboard
- 👤 **Profile Management** - Edit athlete info, upload photos
- 📈 **Stats CRUD** - Manage season-by-season statistics
- 🎬 **Highlights Manager** - Add/edit video URLs
- 🥇 **Awards Manager** - Track honors and achievements
- 💬 **Testimonials Manager** - Add/edit recommendations
- 📧 **Contact Submissions** - View recruitment inquiries
- 🔐 **Authentication** - Email/password + OAuth (Google, GitHub, etc.)
- 🔗 **OAuth Management** - Link/unlink social accounts

### Technical
- ⚡ **Performance Optimized** - Database indexes, query caching
- 🔍 **SEO Ready** - Meta tags, Open Graph, structured data
- 📮 **Email Notifications** - Beautiful HTML emails
- 🏀 **Multi-Sport Support** - Football, Basketball, Baseball, Track, Soccer
- 🎨 **Modern UI** - TailwindCSS with responsive design
- 🚀 **Production Ready** - Optimization scripts included

## 🛠️ Tech Stack

- **Backend:** Laravel 12.x
- **Frontend:** Livewire 3.x, TailwindCSS
- **Authentication:** Laravel Jetstream
- **Database:** MySQL
- **PDF Generation:** DomPDF
- **Email:** SMTP (configurable)
- **Development:** Laravel Sail (Docker)

## 📋 Requirements

- PHP 8.2+
- Composer
- Docker Desktop (for Sail)
- Node.js & NPM

## 🚀 Quick Start

**Want to get started fast?** See **[QUICKSTART.md](QUICKSTART.md)** for detailed step-by-step instructions!

### **TL;DR Setup:**

```bash
# Clone and setup
git clone <repository-url>
cd zander-website
cp .env.example .env

# Start Docker and install
./vendor/bin/sail up -d
./vendor/bin/sail composer install
./vendor/bin/sail npm install

# Setup database
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan db:seed

# Build assets (keep running)
./vendor/bin/sail npm run dev

# Create admin user
./vendor/bin/sail artisan user:create
```

**Access:** http://localhost (Admin: http://localhost/login)

## 🏀 Multi-Sport Support

This platform supports **5 different sports** with sport-specific profiles and statistics:

### Supported Sports
- 🏈 **Football** - Position, 40-yard dash, bench press, receiving stats
- 🏀 **Basketball** - Position, vertical jump, points/rebounds/assists per game
- ⚾ **Baseball** - Position, batting average, home runs, RBIs, stolen bases
- ⚽ **Soccer** - Position, goals, assists, shots on goal
- 🏃 **Track & Field** - Events, personal records, best times, medals

### How It Works

**Sport-Specific Profiles:**
Each sport has its own profile table with unique metrics:
- Football: 40-yard dash, bench press, squat, vertical jump
- Basketball: Vertical jump, sprint speed, wingspan
- Baseball: 60-yard dash, exit velocity, throwing hand, batting stance
- Soccer: Sprint speed, preferred foot
- Track: Events and personal records

**Dynamic Stats:**
Season statistics are stored in JSON format and adapt to the selected sport:
- Football: Receptions, receiving yards, touchdowns, yards per catch
- Basketball: Points/rebounds/assists per game, field goal percentage
- Baseball: Batting average, home runs, RBIs, stolen bases
- Soccer: Goals, assists, shots, shots on goal
- Track: Best times, personal records, medals

**Switching Sports:**
1. Go to Admin → Profile Management
2. Select your sport from the dropdown
3. Fill in sport-specific profile fields
4. Add season stats (form fields adapt to your sport)
5. Frontend and PDF automatically update to show correct stats

### Managing Sport-Specific Stats

**Adding Stats:**
```
Admin Dashboard → Manage Stats → Add Season Stats
- Season year
- Games/Matches/Meets (based on sport)
- Sport-specific statistics (dynamic form)
- Notes
```

**Viewing Stats:**
- Frontend displays only stats matching current sport
- Old stats from previous sports are hidden but preserved
- PDF generates with sport-appropriate columns

## 📚 Documentation

### **Quick Links**
- 🚀 **[QUICKSTART.md](QUICKSTART.md)** - Get running in 10 minutes!

### **User Guides** (in `/docs` directory)
- 🏀 **[MULTI_SPORT_GUIDE.md](docs/MULTI_SPORT_GUIDE.md)** - Complete multi-sport guide
- 🎛️ **[ADMIN_GUIDE.md](docs/ADMIN_GUIDE.md)** - Using the admin dashboard
- 👥 **[USER_MANAGEMENT.md](docs/USER_MANAGEMENT.md)** - Create/manage user accounts
- ✍️ **[CONTENT_GUIDE.md](docs/CONTENT_GUIDE.md)** - Content best practices

### **Technical Reference**
- 🔧 **[TROUBLESHOOTING.md](docs/TROUBLESHOOTING.md)** - Fix common issues
- 📧 **[EMAIL_SETUP.md](docs/EMAIL_SETUP.md)** - Configure email services
- 🔑 **[OAUTH_SETUP.md](docs/OAUTH_SETUP.md)** - OAuth social login setup
- ⚡ **[PERFORMANCE.md](docs/PERFORMANCE.md)** - Optimization guide
- 🧪 **[TESTING.md](docs/TESTING.md)** - Testing guide

## ⚙️ Configuration

### Email Setup

For development, Mailpit is pre-configured. For production, see [EMAIL_SETUP.md](docs/EMAIL_SETUP.md) for:
- Gmail configuration
- Mailgun setup
- SendGrid integration
- AWS SES options

### OAuth Social Login (Optional)

Enable Google, GitHub, Facebook, or other OAuth providers. See [OAUTH_SETUP.md](docs/OAUTH_SETUP.md) for:
- Google OAuth setup (most common)
- Adding multiple providers
- Email/password login toggle
- Profile OAuth management

### Database

Default Sail configuration:
```env
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=sail
DB_PASSWORD=password
```

## 🎯 Key Routes

### Public Routes
- `/` - Homepage (dynamic sport-specific content)
- `/stat-sheet.pdf` - Download PDF stat sheet (sport-specific)
- `/sitemap.xml` - SEO sitemap
- `/robots.txt` - Robots file

### Admin Routes (Authenticated)
- `/dashboard` - Admin dashboard overview
- `/admin/profile` - Manage athlete profile (select sport, add details)
- `/admin/stats` - Manage season statistics (sport-aware forms)
- `/admin/highlights` - Manage video highlights
- `/admin/awards` - Manage awards & honors
- `/admin/testimonials` - Manage testimonials & recommendations
- `/admin/contacts` - View contact submissions
- `/user/profile` - User account settings (OAuth management)

## 🚀 Deployment

### Production Optimization

Run the optimization script before deploying:

**Windows:**
```bash
./optimize.bat
```

**Linux/Mac:**
```bash
bash optimize.sh
```

This caches routes, config, views, and optimizes the autoloader.

### Environment Variables

Key production settings in `.env`:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

# Configure production mail service
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailgun.org
# ... (see EMAIL_SETUP.md)
```

### Performance Tips

1. Enable OPcache in PHP
2. Use Redis for caching (optional)
3. Configure CDN for assets
4. Enable gzip compression
5. Set up SSL certificate

See [PERFORMANCE.md](docs/PERFORMANCE.md) for detailed optimization guide.

## 📊 Database Structure

### Main Models
- **AthleteProfile** - Core athlete information (name, school, grad year, sport)
- **FootballProfile** - Football-specific metrics (40-yard dash, bench press, etc.)
- **BasketballProfile** - Basketball-specific metrics (vertical jump, wingspan, etc.)
- **BaseballProfile** - Baseball-specific metrics (60-yard dash, exit velocity, etc.)
- **SoccerProfile** - Soccer-specific metrics (sprint speed, preferred foot, etc.)
- **TrackProfile** - Track & field-specific metrics (events, personal records, etc.)
- **SeasonStat** - Season statistics with JSON stats column (sport-agnostic)
- **Highlight** - Video highlights and media
- **Award** - Honors and achievements
- **Testimonial** - Recommendations from coaches/mentors
- **ContactSubmission** - Recruitment inquiries

### Relationships
- AthleteProfile → has one → FootballProfile (polymorphic based on sport)
- AthleteProfile → has one → BasketballProfile
- AthleteProfile → has one → BaseballProfile
- AthleteProfile → has one → SoccerProfile
- AthleteProfile → has one → TrackProfile
- AthleteProfile → has many → SeasonStats (filtered by sport)
- AthleteProfile → has many → Highlights
- AthleteProfile → has many → Awards
- AthleteProfile → has many → Testimonials

### Season Stats Structure
Stats are stored in JSON format for flexibility:
```json
{
  "sport": "basketball",
  "season_year": 2024,
  "competitions": 25,
  "stats": {
    "points_per_game": 18.5,
    "rebounds_per_game": 7.2,
    "assists_per_game": 4.1,
    "field_goal_percentage": 48.5
  }
}
```

### Caching Strategy
Two main cache keys with 1-hour TTL:
- `active_athlete_profile` - Profile with sport profiles
- `athlete_with_stats` - Profile with stats/awards (filtered by sport)

Cache automatically cleared when:
- Athlete profile updated
- Sport-specific profile updated
- Season stats added/modified
- Awards/highlights/testimonials changed

## 🧪 Testing

### Run All Tests
```bash
./vendor/bin/sail artisan test
```

**Test Coverage:** 128+ comprehensive tests
- Feature tests (end-to-end functionality)
- Unit tests (models and helpers)
- Livewire component tests
- SEO and PDF generation tests
- Testimonial management tests
- User management command tests

See **[TESTING.md](docs/TESTING.md)** for complete guide or **[TEST_SUMMARY.md](TEST_SUMMARY.md)** for coverage overview.

### Run Specific Tests
```bash
# Feature tests only
./vendor/bin/sail artisan test --testsuite=Feature

# Unit tests only
./vendor/bin/sail artisan test --testsuite=Unit

# With coverage report
./vendor/bin/sail artisan test --coverage
```

### Test Email
```bash
./vendor/bin/sail artisan tinker
>>> Mail::raw('Test', fn($msg) => $msg->to('test@example.com')->subject('Test'));
```

### Clear Caches
```bash
./vendor/bin/sail artisan optimize:clear
```

## 🐛 Troubleshooting

Common issues and solutions are documented in [TROUBLESHOOTING.md](docs/TROUBLESHOOTING.md).

Quick fixes:
```bash
# Clear all caches
./vendor/bin/sail artisan cache:clear
./vendor/bin/sail artisan config:clear
./vendor/bin/sail artisan route:clear
./vendor/bin/sail artisan view:clear

# Fix storage symlink
./vendor/bin/sail artisan storage:link

# Restart Sail
./vendor/bin/sail down
./vendor/bin/sail up -d
```

## 📦 Key Dependencies

- `laravel/framework` - Core framework
- `laravel/jetstream` - Authentication scaffolding
- `livewire/livewire` - Dynamic components
- `barryvdh/laravel-dompdf` - PDF generation
- `tailwindcss` - Utility-first CSS

## 🔐 Security

- CSRF protection enabled
- SQL injection protection via Eloquent
- XSS protection in Blade templates
- Rate limiting on contact form
- Secure session management
- Password hashing with bcrypt

## 📈 Performance

Optimizations implemented:
- Query result caching (1 hour)
- Database indexes on frequently queried columns
- Eager loading to prevent N+1 queries
- Route/config/view caching
- Optimized autoloader

**Performance Metrics:**
- Homepage load: ~50-100ms (80% faster with cache)
- Database queries: 1-2 per page (90% reduction)
- Cache hit rate: 90-95%

## 🤝 Contributing

This is a custom project. For feature requests, see [ENHANCEMENTS.md](docs/ENHANCEMENTS.md).

## 📄 License

This project is proprietary software.

Built with [Laravel](https://laravel.com) and [Livewire](https://livewire.laravel.com).
