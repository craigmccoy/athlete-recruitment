<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            color: white;
            padding: 30px;
            border-radius: 8px 8px 0 0;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            background: #f9fafb;
            padding: 30px;
            border: 1px solid #e5e7eb;
            border-top: none;
        }
        .field {
            margin-bottom: 20px;
        }
        .label {
            font-weight: 600;
            color: #4b5563;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }
        .value {
            background: white;
            padding: 12px;
            border-radius: 6px;
            border: 1px solid #e5e7eb;
        }
        .message-box {
            background: white;
            padding: 15px;
            border-radius: 6px;
            border: 1px solid #e5e7eb;
            white-space: pre-wrap;
            font-family: inherit;
        }
        .footer {
            background: #f3f4f6;
            padding: 20px;
            border-radius: 0 0 8px 8px;
            text-align: center;
            font-size: 12px;
            color: #6b7280;
        }
        .button {
            display: inline-block;
            background: #2563eb;
            color: white;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 6px;
            margin-top: 20px;
            font-weight: 600;
        }
        .timestamp {
            color: #9ca3af;
            font-size: 12px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🏈 New Recruitment Inquiry</h1>
    </div>

    <div class="content">
        <div class="field">
            <div class="label">From</div>
            <div class="value">
                <strong>{{ $submission->name }}</strong>
                @if($submission->organization)
                    <br>{{ $submission->organization }}
                @endif
            </div>
        </div>

        <div class="field">
            <div class="label">Contact Email</div>
            <div class="value">
                <a href="mailto:{{ $submission->email }}">{{ $submission->email }}</a>
            </div>
        </div>

        <div class="field">
            <div class="label">Message</div>
            <div class="message-box">{{ $submission->message }}</div>
        </div>

        <div class="timestamp">
            Submitted on {{ $submission->created_at->format('F j, Y \a\t g:i A') }}
        </div>

        <center>
            <a href="mailto:{{ $submission->email }}" class="button">Reply to {{ $submission->name }}</a>
        </center>
    </div>

    <div class="footer">
        <p>You received this notification because a new contact form was submitted on your athlete recruitment website.</p>
        <p>To manage submissions, <a href="{{ url('/admin/contacts') }}">visit your admin dashboard</a>.</p>
    </div>
</body>
</html>
