# ⚡ Quick Start Guide

Get your athlete recruitment website running in 10 minutes!

---

## 📋 **Prerequisites**

- Docker Desktop installed and running
- Git installed
- Basic command line knowledge

---

## 🚀 **Installation (5 Steps)**

### **1. Clone & Setup**
```bash
git clone <repository-url>
cd zander-website
cp .env.example .env
```

### **2. Start Docker**
```bash
docker compose up -d
```

Wait 30-60 seconds for containers to start.

### **3. Install Dependencies**
```bash
./vendor/bin/sail composer install
./vendor/bin/sail npm install
```

### **4. Setup Database**
```bash
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan db:seed
```

### **5. Build Assets**
```bash
./vendor/bin/sail npm run dev
```

Keep this running in the terminal.

---

## 👤 **Create Your Admin Account**

In a new terminal window:

```bash
./vendor/bin/sail artisan user:create
```

Follow the prompts:
- **Name:** Your Name
- **Email:** your@email.com
- **Password:** (min 8 characters, hidden)
- **Confirm:** (re-enter password)
- **Confirm creation:** yes

---

## 🎉 **You're Ready!**

### **Access Your Website:**
- 🌐 **Website:** http://localhost
- 🔐 **Admin Login:** http://localhost/login
- 📧 **Email Testing:** http://localhost:8025

### **First Steps:**
1. Login at http://localhost/login
2. Click **Athlete Profile** and fill in your info
3. Upload a profile photo
4. Add your season statistics
5. Add video highlights
6. Add awards and testimonials

---

## 📊 **Quick Admin Tasks**

### **Update Profile**
Dashboard → Athlete Profile → Edit → Save

### **Add Season Stats**
Dashboard → Season Stats → + Add Season → Fill in stats → Save

### **Add Video Highlights**
Dashboard → Highlights → + Add Highlight → Paste YouTube/Hudl URL → Save

### **Add Testimonials**
Dashboard → Testimonials → + Add Testimonial → Fill in details → Save

### **View Messages**
Dashboard → Contact Messages → Click to view

### **Download PDF Resume**
Dashboard → Download Resume → PDF downloads automatically

---

## 🛑 **Stop/Start the Application**

### **Stop Everything:**
```bash
./vendor/bin/sail down
```

### **Start Again:**
```bash
./vendor/bin/sail up -d
./vendor/bin/sail npm run dev
```

---

## 🧪 **Run Tests**

Verify everything works:

```bash
./vendor/bin/sail artisan test
```

Should see: **128 tests passing** ✅

---

## ❓ **Quick Troubleshooting**

### **Port 80 already in use?**
Edit `compose.yaml`, change `80:80` to `8000:80`, then access at http://localhost:8000

### **Database connection error?**
Wait 30 seconds for MySQL to start, then retry migration.

### **npm run dev fails?**
```bash
./vendor/bin/sail npm install
./vendor/bin/sail npm run dev
```

### **Can't login after creating user?**
Verify email/password are correct. Use password reset if needed:
```bash
./vendor/bin/sail artisan user:reset-password your@email.com
```

---

## 📚 **Next Steps**

### **Learn More:**
- **[README.md](README.md)** - Full project documentation
- **[docs/ADMIN_GUIDE.md](docs/ADMIN_GUIDE.md)** - Complete admin manual
- **[docs/USER_MANAGEMENT.md](docs/USER_MANAGEMENT.md)** - User commands
- **[docs/TROUBLESHOOTING.md](docs/TROUBLESHOOTING.md)** - Fix common issues

### **Customize Content:**
- Add your personal story to bio
- Upload action photos
- Get testimonials from coaches
- Keep stats updated throughout season

### **Deploy to Production:**
- See [docs/PERFORMANCE.md](docs/PERFORMANCE.md) for optimization
- Run `./optimize.sh` before deploying
- Set up real email service (see [docs/EMAIL_SETUP.md](docs/EMAIL_SETUP.md))

---

## 💡 **Pro Tips**

✅ **Upload high-quality photos** (1200x1200px recommended)  
✅ **Keep video highlights 2-5 minutes** for best engagement  
✅ **Update stats after every game** to stay current  
✅ **Get 2-3 strong testimonials** from coaches/mentors  
✅ **Check contact messages daily** during recruiting season  
✅ **Share your PDF resume** with college coaches  

---

## 🆘 **Need Help?**

1. Check [docs/TROUBLESHOOTING.md](docs/TROUBLESHOOTING.md)
2. Review [docs/ADMIN_GUIDE.md](docs/ADMIN_GUIDE.md)
3. Run tests: `./vendor/bin/sail artisan test`
4. Check logs: `./vendor/bin/sail artisan log:tail`

---

**🎯 You're all set! Start building your recruitment profile now!**
