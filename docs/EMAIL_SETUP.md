# Email Configuration Guide

Complete guide for setting up email notifications for contact form submissions.

## 📧 Email Overview

When someone submits the contact form on your website, the system sends a beautifully formatted HTML email notification to the athlete's email address (set in the profile).

**Email Contents:**
- Sender's name and organization
- Their email address (with reply-to configured)
- Their full message
- Timestamp of submission
- Direct "Reply" button
- Link to admin dashboard

---

## 🎯 Choose Your Email Service

You have several options. Choose based on your needs:

| Service | Best For | Cost | Setup Time |
|---------|----------|------|------------|
| **Mailpit** | Development/Testing | Free | 0 min (included) |
| **Gmail** | Personal use | Free | 10 min |
| **Mailtrap** | Development/Testing | Free | 15 min |
| **Mailgun** | Production | Paid | 20 min |
| **SendGrid** | Production | Paid | 20 min |
| **AWS SES** | High volume | Paid | 30 min |

---

## 🔧 Option 1: Mailpit (Development - Default)

**Best for:** Local development and testing

### Setup

Already configured if using Sail! No additional setup needed.

**.env:**
```env
MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="noreply@athletewebsite.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### Viewing Emails

1. Ensure Sail is running: `sail up -d`
2. Open browser to: **http://localhost:8025**
3. Submit contact form on your site
4. Email appears in Mailpit inbox immediately

### Advantages
- ✅ Zero configuration
- ✅ Instant delivery
- ✅ No external accounts needed
- ✅ See all sent emails
- ✅ Test formatting

### Limitations
- ❌ Emails don't leave your computer
- ❌ Not for production use
- ❌ Requires local server running

---

## 📮 Option 2: Gmail (Production)

**Best for:** Personal use, low-to-medium volume

### Prerequisites

1. **Gmail Account** - Personal Gmail address
2. **2-Factor Authentication** - Must be enabled
3. **App Password** - Special password for applications

### Step 1: Enable 2-Factor Authentication

1. Go to https://myaccount.google.com/security
2. Click "2-Step Verification"
3. Follow prompts to enable
4. Verify with phone number

### Step 2: Generate App Password

1. Still in Google Security settings
2. Click "App passwords" (under 2-Step Verification)
3. Select app: **Mail**
4. Select device: **Other** (type: "Laravel App")
5. Click **Generate**
6. Copy the 16-character password (save it!)

### Step 3: Configure .env

Update your `.env` file:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=youremail@gmail.com
MAIL_PASSWORD=your-16-digit-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=youremail@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

**Important:**
- Use app password, NOT your Gmail password
- No spaces in app password
- Keep TLS encryption

### Step 4: Test

1. Restart Sail (if using): `sail restart`
2. Submit a test contact form
3. Check your Gmail inbox
4. Email should arrive within seconds

### Troubleshooting Gmail

**"Authentication Failed"**
- Verify app password is correct
- Ensure 2FA is enabled
- Try generating new app password

**"Less Secure Apps" Error**
- Google discontinued this
- Must use app password method above

**Emails in Spam**
- Normal for self-sent emails
- Add yourself to contacts
- Mark as "Not Spam"

**Rate Limits**
- Gmail: ~500 emails/day
- For higher volume, use dedicated service

### Advantages
- ✅ Free
- ✅ Reliable delivery
- ✅ Familiar interface
- ✅ Good for personal projects

### Limitations
- ❌ Daily sending limit (~500)
- ❌ May end up in spam
- ❌ Not professional for business

---

## 🧪 Option 3: Mailtrap (Development)

**Best for:** Development and testing before production

### Setup

1. Go to https://mailtrap.io
2. Sign up for free account
3. Create an inbox
4. Get SMTP credentials

### Configure .env

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your-mailtrap-username
MAIL_PASSWORD=your-mailtrap-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@athletewebsite.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### Viewing Emails

1. Log into Mailtrap
2. Open your inbox
3. Submit contact form
4. View email in Mailtrap

### Advantages
- ✅ Free tier generous
- ✅ Great for testing
- ✅ HTML preview
- ✅ Spam testing
- ✅ Multiple inboxes

### Limitations
- ❌ Emails don't reach real recipients
- ❌ Testing only

---

## 🚀 Option 4: Mailgun (Production)

**Best for:** Production websites, medium-to-high volume

### Setup

1. Go to https://mailgun.com
2. Sign up (free tier available)
3. Verify domain (or use sandbox)
4. Get SMTP credentials

### Configure .env

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailgun.org
MAIL_PORT=587
MAIL_USERNAME=postmaster@your-domain.mailgun.org
MAIL_PASSWORD=your-mailgun-smtp-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@yourdomain.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### Advantages
- ✅ Reliable delivery
- ✅ Good free tier (5,000 emails/month)
- ✅ Professional
- ✅ Analytics
- ✅ API access

### Pricing
- Free: 5,000 emails/month
- Paid: $35/month for 50,000 emails

---

## 📨 Option 5: SendGrid (Production)

**Best for:** Production websites, high volume

### Setup

1. Go to https://sendgrid.com
2. Sign up (free tier available)
3. Create API key
4. Configure sender identity

### Configure .env

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=your-sendgrid-api-key
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@yourdomain.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### Advantages
- ✅ Very reliable
- ✅ 100 emails/day free
- ✅ Excellent delivery rates
- ✅ Rich analytics

### Pricing
- Free: 100 emails/day
- Paid: $19.95/month for 50,000 emails

---

## ☁️ Option 6: AWS SES (Production)

**Best for:** High volume, AWS infrastructure

### Setup

1. AWS account required
2. Verify domain/email in SES
3. Request production access
4. Create SMTP credentials

### Configure .env

```env
MAIL_MAILER=smtp
MAIL_HOST=email-smtp.us-east-1.amazonaws.com
MAIL_PORT=587
MAIL_USERNAME=your-ses-smtp-username
MAIL_PASSWORD=your-ses-smtp-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@yourdomain.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### Advantages
- ✅ Very cheap ($0.10 per 1,000 emails)
- ✅ Highly scalable
- ✅ Integrates with AWS

### Limitations
- ❌ Requires AWS account
- ❌ Complex setup
- ❌ Sandbox mode by default

---

## 🔄 Switching Email Services

### Development → Production

1. Update `.env` with production credentials
2. Clear config cache:
   ```bash
   sail artisan config:clear
   ```
3. Test with real email
4. Monitor delivery

### Testing First

Always test email changes:
1. Update `.env`
2. Clear cache
3. Submit test contact form
4. Verify receipt
5. Check spam folder
6. Verify formatting

---

## ⚙️ Advanced Configuration

### Custom From Name

```env
MAIL_FROM_NAME="John Smith Athletics"
```

### Reply-To Address

The system automatically sets reply-to as the sender's email from the contact form.

### Email Queue (Optional)

For high traffic, queue emails instead of sending immediately:

```env
QUEUE_CONNECTION=database
```

Then run:
```bash
sail artisan queue:table
sail artisan migrate
sail artisan queue:work
```

### Email Testing Command

Test email configuration:
```bash
sail artisan tinker
>>> Mail::raw('Test email', function($msg) { $msg->to('your@email.com')->subject('Test'); });
```

---

## 🐛 Troubleshooting

### Email Not Sending

1. **Check `.env` configuration**
   - No typos
   - Correct credentials
   - Proper encryption

2. **Clear config cache**
   ```bash
   sail artisan config:clear
   ```

3. **Check logs**
   ```
   storage/logs/laravel.log
   ```

4. **Test SMTP connection**
   ```bash
   sail artisan tinker
   >>> config('mail');
   ```

### Emails Going to Spam

**Solutions:**
- Use verified domain
- Configure SPF records
- Configure DKIM signing
- Use reputable mail service
- Avoid spam trigger words

### Connection Timeout

**Common Causes:**
- Wrong SMTP host/port
- Firewall blocking
- Incorrect encryption setting

**Solutions:**
- Verify SMTP settings
- Try port 465 (SSL) or 587 (TLS)
- Check firewall rules

### Authentication Errors

**Check:**
- Username correct
- Password correct (app password for Gmail)
- Credentials not expired
- Service account active

---

## 📋 Email Testing Checklist

Before going live:
- [ ] Email credentials configured
- [ ] `.env` updated
- [ ] Config cache cleared
- [ ] Test email sent
- [ ] Email received successfully
- [ ] Not in spam folder
- [ ] HTML formatting correct
- [ ] Reply-to works
- [ ] Links in email work
- [ ] Sender name correct
- [ ] Athlete profile has email address

---

## 🔐 Security Best Practices

### Protect Credentials

- Never commit `.env` to git
- Use environment variables in production
- Rotate passwords regularly
- Use app-specific passwords

### HTTPS Required

- Email forms require HTTPS in production
- Get free SSL with Let's Encrypt
- Configure properly on server

### Rate Limiting

Contact form has built-in rate limiting (via Laravel defaults).

### Spam Prevention

- Form has CSRF protection
- Monitor for abuse
- Block suspicious senders

---

## 📊 Monitoring Email Delivery

### Check Logs

```bash
tail -f storage/logs/laravel.log | grep Mail
```

### Service Dashboards

Most services provide:
- Delivery rates
- Bounce rates
- Spam reports
- Open rates (if tracking)

### Failed Delivery

If email fails:
1. Check logs for error
2. Verify credentials still valid
3. Check service status
4. Verify recipient email valid

---

## 🎯 Recommended Setup

### Development
**Use Mailpit** (included with Sail)
- Zero config
- Instant testing
- No external dependencies

### Small Personal Site
**Use Gmail**
- Free
- Reliable
- Easy setup

### Production Business Site
**Use Mailgun or SendGrid**
- Professional
- Reliable delivery
- Good free tiers
- Analytics

### High Volume
**Use AWS SES**
- Very cheap
- Scales infinitely
- Reliable

---

## 📞 Quick Reference

### Gmail
```env
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_ENCRYPTION=tls
```

### Mailgun
```env
MAIL_HOST=smtp.mailgun.org
MAIL_PORT=587
MAIL_ENCRYPTION=tls
```

### SendGrid
```env
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_ENCRYPTION=tls
MAIL_USERNAME=apikey
```

### AWS SES
```env
MAIL_HOST=email-smtp.us-east-1.amazonaws.com
MAIL_PORT=587
MAIL_ENCRYPTION=tls
```

---

**Need help?** Check [TROUBLESHOOTING.md](TROUBLESHOOTING.md) for common email issues.
