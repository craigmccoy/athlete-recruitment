# Troubleshooting Guide

Common issues and solutions for the athlete recruitment website.

## 🔐 Login & Authentication Issues

### Can't Log In

**Symptoms:** "Invalid credentials" or "These credentials do not match our records"

**Solutions:**
1. **Check Email Address**
   - Verify correct email (no typos)
   - Check for extra spaces
   - Ensure lowercase

2. **Reset Password**
   - Click "Forgot your password?"
   - Check email for reset link
   - Check spam folder
   - Use a strong new password

3. **Clear Browser Cache**
   ```
   Chrome: Ctrl+Shift+Delete
   Firefox: Ctrl+Shift+Delete
   Safari: Cmd+Option+E
   ```

4. **Try Incognito/Private Mode**
   - Rules out cache/cookie issues
   - If it works, clear regular browser data

### Logged Out Automatically

**Cause:** Session expired (security feature)

**Solution:**
- Log in again
- Check "Remember me" for longer sessions
- Don't close browser with active session

### "Too Many Attempts" Error

**Cause:** Multiple failed login attempts (security)

**Solution:**
- Wait 1 hour
- Use password reset instead
- Clear cookies and try again

---

## 📸 Image Upload Problems

### Image Won't Upload

**Check:**
1. **File Size** - Max 5MB
   - Compress large images
   - Use online tools: tinypng.com, compressor.io
   
2. **File Format** - JPG, PNG, WebP only
   - Convert other formats
   - Avoid GIF, BMP, TIFF

3. **File Name** - Avoid special characters
   - Use: `profile-photo.jpg`
   - Avoid: `photo!@#$.jpg`

4. **Browser Issues**
   - Try different browser
   - Clear cache
   - Disable browser extensions

### Image Uploads But Doesn't Display

**Symptoms:** Placeholder or broken image icon

**Solutions:**
1. **Wait for Processing**
   - Large images take time
   - Refresh after 30 seconds

2. **Check Storage Symlink**
   ```bash
   sail artisan storage:link
   ```

3. **Verify File Permissions**
   - Files should be readable
   - Check server logs

4. **Clear Cache**
   ```bash
   sail artisan cache:clear
   ```

### Image Quality is Poor

**Cause:** Browser resizing or compression

**Solutions:**
- Upload higher resolution image
- Minimum 800x800px recommended
- Use 1200x1200px or higher for best quality
- Save as high-quality JPG (85-95% quality)

### Old Image Still Showing

**Cause:** Browser cache

**Solutions:**
1. **Hard Refresh**
   - Windows: Ctrl+F5
   - Mac: Cmd+Shift+R

2. **Clear Browser Cache**

3. **Wait for CDN Refresh** (if using CDN)
   - Can take 5-15 minutes

---

## 🎥 Video Embed Issues

### Video Not Displaying

**Check:**
1. **URL Format**
   - ✅ `https://youtube.com/watch?v=VIDEO_ID`
   - ✅ `https://youtu.be/VIDEO_ID`
   - ❌ `youtube.com/VIDEO_ID` (missing https://)

2. **Video Privacy**
   - YouTube: Must be "Public" or "Unlisted"
   - Hudl: Check sharing settings
   - Private videos won't embed

3. **Is Active Checked?**
   - Video must be marked "Active"
   - Featured checkbox for hero video

### Video Shows But Won't Play

**Common Causes:**
1. **Copyright Strike** - Video removed by platform
2. **Embedding Disabled** - Check video settings
3. **Geographic Restrictions** - Some videos blocked by region

**Solutions:**
- Re-upload video
- Check platform restrictions
- Enable embedding in video settings

### Wrong Video Displays

**Cause:** Video ID incorrect or changed

**Solution:**
- Get fresh URL from platform
- Update in admin panel
- Clear cache: `sail artisan cache:clear`

### YouTube Shorts Not Working

**Solution:**
- Use standard format: `https://youtube.com/shorts/SHORT_ID`
- System auto-converts to embeddable format

---

## 📊 Stats & Data Issues

### Changes Not Appearing on Website

**Most Common Cause:** Cache

**Solutions:**
1. **Wait 5 Minutes**
   - Cache refreshes automatically
   - Changes appear after expiry

2. **Clear Application Cache**
   ```bash
   sail artisan cache:clear
   ```

3. **Clear Browser Cache**
   - Hard refresh (Ctrl+F5)
   - Clear site data

4. **Check in Incognito**
   - Opens fresh session
   - Bypasses local cache

### Stats Calculating Incorrectly

**Example:** Yards per catch shows wrong number

**Causes:**
1. **Manual Entry Error**
   - Recalculate: Yards ÷ Receptions
   - Update field

2. **Decimal Precision**
   - System rounds to 1 decimal
   - Normal behavior

**Solution:**
- Verify source data
- Re-enter if needed
- Calculations update on save

### Can't Delete Season/Award/Highlight

**Symptoms:** Delete button doesn't work or error appears

**Solutions:**
1. **Check Relationships**
   - Some items may be referenced elsewhere
   - Remove references first

2. **Try Again**
   - Refresh page
   - Attempt delete again

3. **Database Issue**
   ```bash
   sail artisan migrate:fresh
   sail artisan db:seed
   ```
   ⚠️ **Warning:** Loses all data - backup first!

---

## 📧 Email Notification Problems

### Not Receiving Contact Form Emails

**Check:**
1. **Email in Profile**
   - Go to Athlete Profile
   - Verify email address is correct
   - Save profile

2. **Mail Configuration**
   - See [EMAIL_SETUP.md](EMAIL_SETUP.md) for details
   - Check `.env` settings

3. **Spam Folder**
   - Emails might be filtered
   - Add sender to safe list
   - Check junk/promotions

4. **Mailpit (Development)**
   - Check http://localhost:8025
   - Emails show there in development

### Emails Sending But Not Received

**For Gmail:**
1. **Check App Password**
   - Needs 2FA enabled
   - Generate new app password
   - Update `.env`

2. **"Less Secure Apps"**
   - Not supported anymore
   - Must use app password

**For Production:**
- Verify SMTP credentials
- Check mail service status
- Review error logs

### Email Looks Broken

**Symptoms:** Poor formatting, missing styles

**Solutions:**
- Email HTML tested for Gmail, Outlook, Apple Mail
- Some clients strip styles (normal)
- Content still readable

---

## 💾 Database Issues

### "Database Connection Failed"

**Symptoms:** 500 error or "Could not connect"

**Solutions:**
1. **Check Sail is Running**
   ```bash
   sail ps
   ```

2. **Start Services**
   ```bash
   sail up -d
   ```

3. **Check .env Settings**
   ```env
   DB_CONNECTION=mysql
   DB_HOST=mysql
   DB_PORT=3306
   DB_DATABASE=laravel
   DB_USERNAME=sail
   DB_PASSWORD=password
   ```

4. **Recreate Database**
   ```bash
   sail artisan migrate:fresh
   sail artisan db:seed
   ```

### "Table Not Found" Error

**Cause:** Migrations not run

**Solution:**
```bash
sail artisan migrate
```

### Data Disappeared

**Common Causes:**
1. **`migrate:fresh` Run** - Deletes all data
2. **Database Reset** - Drops tables
3. **Seeder Run** - May replace data

**Prevention:**
- Backup database regularly
- Be careful with migration commands
- Test on development first

**Recovery:**
- Restore from backup
- Recreate manually
- Check database backups

---

## 🎨 Display & Layout Issues

### Mobile View Broken

**Check:**
1. **Viewport Meta Tag** - Already included
2. **Browser Cache** - Clear and retry
3. **Specific Device** - Test on multiple devices

**Debug:**
- Use browser DevTools mobile view
- Test on real devices
- Check console for errors

### Images Not Responsive

**Solution:**
- Already built with responsive design
- Should scale automatically
- Report specific issue if persists

### Text Overlapping or Cut Off

**Causes:**
- Very long words without spaces
- Unusual characters
- Browser zoom

**Solutions:**
- Edit content to add spaces
- Use shorter text
- Reset browser zoom (Ctrl+0)

---

## 📱 PDF Resume Problems

### PDF Won't Generate

**Symptoms:** 500 error or blank page

**Check:**
1. **DomPDF Installed**
   ```bash
   sail composer require barryvdh/laravel-dompdf
   ```

2. **Cache**
   ```bash
   sail artisan config:clear
   ```

3. **Error Logs**
   - Check `storage/logs/laravel.log`
   - Look for DomPDF errors

### PDF Missing Content

**Cause:** No data in database

**Solution:**
- Add athlete profile data
- Add stats, awards, etc.
- Refresh PDF generation

### PDF Formatting Broken

**Known Issues:**
- Complex CSS may not render
- Some fonts may substitute
- This is normal PDF behavior

**Solutions:**
- Content is still readable
- Print from browser as alternative
- Styles optimized for PDF

### PDF Downloads Blank File

**Cause:** Server error during generation

**Solutions:**
1. Check logs
2. Verify all data is valid
3. Try incognito mode
4. Clear application cache

---

## ⚡ Performance Issues

### Website Loading Slowly

**Check:**
1. **Run Optimization**
   ```bash
   ./optimize.bat
   ```
   Or Linux/Mac:
   ```bash
   bash optimize.sh
   ```

2. **Clear Old Cache**
   ```bash
   sail artisan cache:clear
   sail artisan view:clear
   ```

3. **Database Queries**
   - Should be 1-2 per page
   - More indicates cache not working

4. **Image Sizes**
   - Compress large images
   - Use appropriate dimensions

### Admin Panel Slow

**Normal Behavior:**
- Admin intentionally skips some caching
- Ensures real-time data
- Slightly slower is expected

**If Very Slow:**
- Check database indexes ran
- Verify migration completed
- Review server resources

---

## 🔍 Debugging Tools

### Enable Debug Mode (Development Only)

**.env:**
```env
APP_DEBUG=true
APP_ENV=local
```

⚠️ **Never enable in production!**

### View Laravel Logs

```bash
tail -f storage/logs/laravel.log
```

### Clear Everything (Nuclear Option)

```bash
sail artisan cache:clear
sail artisan config:clear
sail artisan route:clear
sail artisan view:clear
sail composer dump-autoload
```

### Check Sail Status

```bash
sail ps
```

### Restart Sail

```bash
sail down
sail up -d
```

### Database Console

```bash
sail artisan tinker
>>> App\Models\AthleteProfile::first();
>>> Cache::get('active_athlete_profile');
```

---

## 🆘 Getting Help

### Information to Provide

When seeking help, include:
1. **What were you trying to do?**
2. **What happened instead?**
3. **Error messages** (exact text)
4. **Steps to reproduce**
5. **Browser and version**
6. **Screenshots if helpful**

### Checking Error Logs

**Laravel Log:**
```
storage/logs/laravel.log
```

**What to Look For:**
- Recent errors (check timestamps)
- Stack traces
- Database errors
- File permission issues

### Safe Mode Testing

1. Disable customizations
2. Test with fresh data
3. Try different browser
4. Test incognito mode
5. Compare to development

---

## 🛠️ Common Fixes

### "Fix Everything" Checklist

Run these commands to resolve most issues:

```bash
# Clear all caches
sail artisan cache:clear
sail artisan config:clear
sail artisan route:clear
sail artisan view:clear

# Rebuild autoloader
sail composer dump-autoload

# Re-run migrations (if safe)
sail artisan migrate

# Fix storage symlink
sail artisan storage:link

# Restart services
sail down
sail up -d
```

### Browser "Fix Everything"

1. Clear cache and cookies
2. Hard refresh (Ctrl+F5)
3. Close and reopen browser
4. Try incognito mode
5. Try different browser

---

**Need more help?** Check [ADMIN_GUIDE.md](ADMIN_GUIDE.md) and [CONTENT_GUIDE.md](CONTENT_GUIDE.md) for detailed instructions.
