# 🏀 Multi-Sport Guide

Complete guide to using the multi-sport features of the Athlete Recruitment Platform.

## Overview

This platform supports **5 different sports**, each with unique profile fields and statistics. The system automatically adapts the frontend, admin forms, and PDF generation based on the selected sport.

---

## Supported Sports

### 🏈 Football
**Profile Fields:**
- Position (e.g., Wide Receiver, Quarterback)
- Jersey Number
- 40-Yard Dash Time
- Bench Press (lbs)
- Squat (lbs)
- Vertical Jump (inches)
- Skills: Speed & Agility, Route Running, Hands & Catching, Football IQ, Leadership

**Season Stats:**
- Receptions
- Receiving Yards
- Yards Per Catch (auto-calculated)
- Touchdowns

---

### 🏀 Basketball
**Profile Fields:**
- Position (e.g., Point Guard, Center)
- Jersey Number
- Vertical Jump (inches)
- Sprint Speed (seconds)
- Wingspan (inches)
- Skills: Ball Handling, Shooting, Defense, Basketball IQ, Leadership

**Season Stats:**
- Points Per Game
- Rebounds Per Game
- Assists Per Game
- Field Goal Percentage

---

### ⚾ Baseball
**Profile Fields:**
- Position (e.g., Pitcher, Shortstop)
- Jersey Number
- 60-Yard Dash Time
- Exit Velocity (mph)
- Throwing Hand (Right/Left)
- Batting Stance (Right/Left/Switch)
- Skills: Hitting, Fielding, Arm Strength, Baseball IQ, Leadership

**Season Stats:**
- Batting Average
- Home Runs
- RBIs (Runs Batted In)
- Stolen Bases

---

### ⚽ Soccer
**Profile Fields:**
- Position (e.g., Forward, Midfielder)
- Jersey Number
- Sprint Speed (seconds)
- Preferred Foot (Right/Left/Both)
- Skills: Dribbling, Passing, Shooting, Soccer IQ, Leadership

**Season Stats:**
- Goals
- Assists
- Shots
- Shots on Goal

---

### 🏃 Track & Field
**Profile Fields:**
- Events (e.g., 100m, 400m, Long Jump)
- Personal Records (array of PRs)
- Skills: Speed, Endurance, Technique, Mental Toughness, Coachability

**Season Stats:**
- Best Time
- Personal Record
- Medals

---

## Getting Started

### 1. Select Your Sport

Navigate to **Admin → Profile Management** and select your sport from the dropdown:

```
Sport Selection:
┌─────────────────┐
│ Football        │
│ Basketball      │
│ Baseball        │
│ Soccer          │
│ Track & Field   │
└─────────────────┘
```

Once selected, the form will dynamically show sport-specific fields.

### 2. Fill Sport-Specific Profile

Complete the fields specific to your sport:
- Position (for team sports)
- Physical metrics (40-yard dash, vertical jump, etc.)
- Skills ratings (1-100 scale)

**Example - Basketball:**
```
Position: Point Guard
Jersey Number: 23
Vertical Jump: 32.5 inches
Sprint Speed: 3.2 seconds
Wingspan: 6'4"

Skills:
- Ball Handling: 92
- Shooting: 88
- Defense: 85
- Basketball IQ: 90
- Leadership: 95
```

### 3. Add Season Statistics

Go to **Admin → Manage Stats → Add Season Stats**

The form automatically adapts to your sport:

**Basketball Example:**
```
Season Year: 2024
Games: 28
Points Per Game: 18.5
Rebounds Per Game: 7.2
Assists Per Game: 5.3
Field Goal %: 48.5
```

**Football Example:**
```
Season Year: 2024
Games: 10
Receptions: 58
Receiving Yards: 982
Touchdowns: 14
(Yards Per Catch auto-calculated)
```

---

## Switching Sports

### Can I Switch Sports?

Yes! You can switch sports at any time:

1. Go to **Admin → Profile Management**
2. Select new sport from dropdown
3. Fill in new sport-specific fields
4. Save profile

### What Happens to Old Stats?

- **Old stats are preserved** in the database
- **Only stats matching current sport** are displayed on frontend
- **PDF generates** with current sport's stats
- **Old stats can be accessed** by switching back

**Example:**
```
If you played Football (2022-2023) then Basketball (2024):
- Switch to Football → See football stats
- Switch to Basketball → See basketball stats
- Each sport keeps its own stats history
```

---

## Frontend Display

The homepage automatically updates based on your selected sport:

### Hero Section
Shows sport name in title:
```
John Smith - Wide Receiver (Football) | Class of 2026
```

### Highlight Stats Cards
Display top 4 stats for your sport:

**Football:**
- Receiving Yards: 982
- Touchdowns: 14
- Receptions: 58
- Yards Per Catch: 16.9

**Basketball:**
- Points Per Game: 18.5
- Rebounds Per Game: 7.2
- Assists Per Game: 5.3
- Field Goal %: 48.5%

### Stats Table
Season-by-season breakdown with sport-appropriate columns:

**Football Table:**
| Season | Games | Rec | Yards | YPC | TD |
|--------|-------|-----|-------|-----|----|
| 2024   | 10    | 58  | 982   | 16.9| 14 |

**Basketball Table:**
| Season | Games | PPG | RPG | APG | FG% |
|--------|-------|-----|-----|-----|-----|
| 2024   | 28    | 18.5| 7.2 | 5.3 | 48.5|

---

## PDF Stat Sheet

The PDF automatically generates with sport-specific content:

### Header
```
JOHN SMITH
Wide Receiver (Football) | Class of 2026
```

### Physical Profile
Two-column layout with sport-specific metrics:
- Football: 40-yard dash, bench press, vertical jump
- Basketball: Vertical jump, sprint speed, wingspan
- Baseball: 60-yard dash, exit velocity, throwing hand/batting stance
- Soccer: Sprint speed, preferred foot
- Track: Events, personal records

### Career Statistics
Table adapts to sport with correct columns and totals.

### Order of Sections
1. Header
2. About/Story
3. Physical Profile
4. Career Statistics
5. Awards & Honors
6. Testimonials (featured only)
7. QR Code

---

## Admin Interface

### Stats Management Page

The stats table shows:
- Season Year
- **Sport Badge** (Football, Basketball, etc.)
- Games/Matches/Meets
- Stats Summary (first 3 stats)
- Actions (Edit/Delete)

**Filter by Sport:**
Stats are automatically filtered by your current sport. To see old stats from a different sport:
1. Switch sport in Profile Management
2. Go to Manage Stats
3. See stats for that sport

### Form Behavior

Forms dynamically update based on sport:

**Adding Stats:**
1. Click "Add Season Stats"
2. Form shows fields for current sport
3. Fill in season year and games/matches/meets
4. Enter sport-specific statistics
5. Save

**Editing Stats:**
1. Click "Edit" on any stat
2. Form loads with current values
3. Modify as needed
4. Save (sport cannot be changed after creation)

---

## Technical Details

### Database Structure

**AthleteProfile Table:**
```sql
- id
- name
- sport (football/basketball/baseball/soccer/track)
- graduation_year
- school_name
- location
- is_active
```

**Sport-Specific Profile Tables:**
```sql
football_profiles (position, 40_yard_dash, bench_press, etc.)
basketball_profiles (position, vertical_jump, wingspan, etc.)
baseball_profiles (position, 60_yard_dash, exit_velocity, etc.)
soccer_profiles (position, sprint_speed, preferred_foot, etc.)
track_profiles (events, personal_records, etc.)
```

**SeasonStats Table:**
```sql
- id
- athlete_profile_id
- sport (football/basketball/etc.)
- season_year
- competitions (games/matches/meets)
- stats (JSON column - sport-specific data)
- notes
```

### JSON Stats Format

**Football:**
```json
{
  "receptions": 58,
  "receiving_yards": 982,
  "yards_per_catch": 16.9,
  "touchdowns": 14
}
```

**Basketball:**
```json
{
  "points_per_game": 18.5,
  "rebounds_per_game": 7.2,
  "assists_per_game": 5.3,
  "field_goal_percentage": 48.5
}
```

### Accessor Pattern

The `SeasonStat` model uses a magic accessor to read from JSON:
```php
// You can access like normal properties
$stat->receptions  // Reads from $stat->stats['receptions']
$stat->points_per_game  // Reads from $stat->stats['points_per_game']
```

### Caching

Two cache keys with automatic clearing:
```php
'active_athlete_profile'  // Profile with sport profiles
'athlete_with_stats'      // Profile with filtered stats
```

Cache clears when:
- Athlete profile updated
- Any sport profile updated
- Stats added/modified/deleted

---

## Best Practices

### 1. Complete Profile Before Adding Stats
Fill out all sport-specific profile fields before adding season statistics.

### 2. Use Featured Testimonials
Only featured testimonials appear in the PDF to keep it concise.

### 3. Keep Stats Current
Update stats at the end of each season for accurate recruitment information.

### 4. Verify PDF Output
After adding stats, download the PDF to verify everything looks correct.

### 5. Jersey Number Consistency
If you don't have a jersey number, leave it blank - it won't display.

---

## FAQ

**Q: Can I have stats from multiple sports?**
A: Yes! Each sport's stats are stored separately. Switch sports to view different stats.

**Q: What happens to my football stats if I switch to basketball?**
A: They're preserved but hidden. Switch back to football to see them again.

**Q: Can I delete stats from an old sport?**
A: Yes. Switch to that sport, go to Manage Stats, and delete individual seasons.

**Q: Does the PDF show all sports?**
A: No, it shows only the currently selected sport's stats.

**Q: Can I customize the stat categories?**
A: The categories are fixed per sport for consistency, but you can add notes to any season.

**Q: What if I play multiple sports in the same year?**
A: Add stats for each sport separately. Only the current sport's stats display on the frontend.

---

## Support

For issues or questions:
1. Check the main [README.md](../README.md)
2. See [TROUBLESHOOTING.md](TROUBLESHOOTING.md)
3. Review [PROJECT_REVIEW.md](../PROJECT_REVIEW.md) for technical details

---

**Last Updated:** November 12, 2025
