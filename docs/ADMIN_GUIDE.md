# Admin Dashboard Guide

Quick reference guide for managing your athlete recruitment website.

## 🚪 **Accessing the Admin Panel**

1. Navigate to: `http://localhost/login` (or your domain)
2. Enter your email and password
3. Click **Dashboard** after logging in

---

## 📋 **Dashboard Overview**

The dashboard provides quick access to all management features:

- **Athlete Profile** - Edit basic info, upload photos
- **Season Stats** - Add/edit season statistics
- **Highlights** - Manage video highlights
- **Awards** - Track achievements and honors
- **Testimonials** - Manage recommendations
- **Contact Messages** - View inquiries from coaches
- **View Website** - Preview your live site
- **Download Resume** - Get PDF athletic resume

---

## 👤 **Managing Athlete Profile**

### **Edit Profile Information**
1. Click **Athlete Profile** card
2. Update fields (name, position, school, etc.)
3. Click **Save**

### **Upload Profile Photo**
1. In the profile editor
2. Click **Upload Image** or drag & drop
3. Supported formats: JPG, PNG, WebP (max 5MB)
4. Image auto-optimizes for web

### **Key Fields:**
- **Name** (required)
- **Sport** - Football, Basketball, Baseball, etc.
- **Position** (required)
- **Jersey Number**
- **Graduation Year** (required)
- **School Name** (required)
- **Height, Weight, GPA**
- **40-Yard Dash Time**
- **Bio/Story** - Tell your athletic journey
- **Social Media** - Twitter, Instagram, Hudl

---

## 📊 **Managing Season Statistics**

### **Add Season Stats**
1. Click **Season Stats** card
2. Click **+ Add Season**
3. Fill in stats (games, receptions, yards, TDs)
4. Click **Save**

### **Edit/Delete Stats**
- Click pencil icon to edit
- Click trash icon to delete
- Stats auto-calculate Yards Per Catch

### **Tip:** Stats display in chronological order on homepage

---

## 🎥 **Managing Highlights**

### **Add Video Highlight**
1. Click **Highlights** card
2. Click **+ Add Highlight**
3. Enter video URL (YouTube, Hudl, or Vimeo)
4. Add title and description
5. Click **Save**

### **Supported Platforms:**
- ✅ YouTube (youtube.com/watch?v=...)
- ✅ Hudl (hudl.com/video/...)
- ✅ Vimeo (vimeo.com/...)

### **Tip:** Videos auto-embed on homepage

---

## 🏆 **Managing Awards**

### **Add Award/Honor**
1. Click **Awards** card
2. Click **+ Add Award**
3. Fill in title, year, description
4. Optionally add icon and color
5. Set display order
6. Click **Save**

### **Tips:**
- Lower order numbers appear first
- Awards display in order on homepage and PDF

---

## 💬 **Managing Testimonials**

### **Add Testimonial**
1. Click **Testimonials** card
2. Click **+ Add Testimonial**
3. Enter author name, title, organization
4. Add testimonial content
5. Select relationship type (Coach, Teammate, etc.)
6. Optionally add star rating (1-5)
7. Mark as **Featured** for special highlighting
8. Click **Save**

### **Quick Actions:**
- ⭐ Click star icon to toggle Featured
- 👁️ Click eye icon to toggle Active/Inactive
- ✏️ Click pencil to edit
- 🗑️ Click trash to delete

### **Tip:** Featured testimonials appear in special callout box on homepage

---

## 📧 **Viewing Contact Messages**

### **Check Messages**
1. Click **Contact Messages** card
2. View list of all inquiries
3. Click message to view full details
4. Delete after responding (optional)

### **Message Details Include:**
- Sender name, email, organization
- Message content
- Date submitted
- Read/Unread status

### **Note:** Email notifications are sent automatically when messages arrive

---

## 📄 **PDF Athletic Resume**

### **Download Resume**
1. Click **Download Resume** on dashboard
2. PDF generates automatically with latest data
3. Share PDF with coaches and recruiters

### **Resume Includes:**
- Contact information
- Physical profile
- Season statistics (with career totals)
- Awards and honors
- Top 3 testimonials
- Bio/story

---

## 🔐 **Account Management**

### **Change Password**
1. Click your name (top right)
2. Select **Profile**
3. Update password
4. Save changes

### **Two-Factor Authentication (Optional)**
1. Go to Profile
2. Enable 2FA for extra security

---

## 🛠️ **Tips & Best Practices**

### **Profile Photos**
- Use high-quality action shots
- Recommended size: 1200x1200px or larger
- JPEG format for best compatibility

### **Videos**
- Keep highlight videos 2-5 minutes
- Use clear, descriptive titles
- Most recent highlights first

### **Statistics**
- Keep stats up-to-date after each game/season
- Double-check numbers for accuracy
- Include all available stats

### **Testimonials**
- Request testimonials from coaches, teachers
- 2-3 strong testimonials better than many weak ones
- Keep content focused on athletic/academic abilities

### **Contact Messages**
- Check daily during recruiting season
- Respond promptly (within 24-48 hours)
- Keep coach interested and engaged

---

## ❓ **Common Questions**

### **How do I add a new user?**
See [USER_MANAGEMENT.md](USER_MANAGEMENT.md) for secure user creation commands.

### **How do I backup my data?**
All data is stored in the MySQL database. Use standard database backup tools.

### **Can I manage multiple athletes?**
Currently designed for single athlete. For multiple athletes, deploy separate instances.

### **How do I customize the website design?**
Requires technical knowledge. Modify TailwindCSS classes in view files.

### **What if I encounter errors?**
See [TROUBLESHOOTING.md](TROUBLESHOOTING.md) for common issues and solutions.

---

## 📚 **Related Documentation**

- [USER_MANAGEMENT.md](USER_MANAGEMENT.md) - Create and manage user accounts
- [CONTENT_GUIDE.md](CONTENT_GUIDE.md) - Best practices for content
- [TROUBLESHOOTING.md](TROUBLESHOOTING.md) - Fix common issues
- [EMAIL_SETUP.md](EMAIL_SETUP.md) - Configure email notifications

---

**Need Help?** Check the full documentation in the `/docs` folder or review the README.md file.
