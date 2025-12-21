# Welcome Popup Admin Guide

Complete guide for managing the dynamic popup modal through WordPress admin.

## Admin Access

Navigate to: **WordPress Admin → Welcome Popup** (in sidebar with megaphone icon)

## Settings Tabs

### 1. Content Tab

Control all text and promotional content displayed in the popup.

#### Alert Banner
- **Alert Banner Text**: Top banner text (e.g., "Limited Time Offer")
- Default: "সীমিত সময়ের অফার"

#### Main Title
- **Main Title**: Large headline text with emoji decorations
- Default: "মেগা স্বাগতম অফার"

#### Bonus Section
- **Bonus Label**: Text above bonus amount (e.g., "Up to")
- **Bonus Amount**: Main percentage (e.g., "200%")
- **Bonus Extra**: Additional bonus number (e.g., "100")
- **Bonus Subtitle**: Description below bonus (e.g., "Bonus + Free Spins")
- **Bonus Info**: Additional information (e.g., "Up to 50,000 BDT bonus")

#### Features (3 Feature Items)
Each feature has:
- **Feature Title**: Main feature text (e.g., "200% Deposit Match")
- **Feature Subtitle**: Supporting text (e.g., "On First Deposit")

**Default Features:**
1. Feature 1: "২০০% ডিপোজিট ম্যাচ" - "প্রথম ডিপোজিটে"
2. Feature 2: "১০০ ফ্রি স্পিন" - "জনপ্রিয় স্লটে"
3. Feature 3: "১৫% সাপ্তাহিক ক্যাশব্যাক" - "প্রতি সোমবার"

#### Button
- **Button Text**: Call-to-action text
- **Button URL**: Registration/action page URL
- Default Text: "এখনই রেজিস্টার করুন"
- Default URL: "#" (update to your registration page)

---

### 2. Visual Tab

Customize colors and appearance.

#### Color Settings
- **Background Gradient Start**: Top gradient color
  - Default: #E8F5E8 (light green)

- **Background Gradient End**: Bottom gradient color
  - Default: #FFFFFF (white)

- **Primary Color**: Accent color for icons and highlights
  - Default: #009966 (green)

- **Text Color**: Main text color
  - Default: #002C22 (dark green)

**Note**: Colors use WordPress color picker for easy selection.

---

### 3. Behavior Tab

Control popup display behavior.

#### Timing
- **Show Delay (milliseconds)**: Wait time before showing popup on first visit
  - Range: 0-10000ms (0-10 seconds)
  - Default: 1500ms (1.5 seconds)
  - Example: 3000 = 3 seconds

#### Auto-Show Toggle
- **Enable Auto Show**: Checkbox to enable/disable automatic popup
  - Checked (default): Popup auto-shows on first visit
  - Unchecked: Users must click trigger icon to see popup

---

## How It Works

### First Visit Flow
1. User visits website
2. Wait for configured delay (default 1.5s)
3. Popup slides in from bottom-right (if auto-show enabled)
4. User closes popup
5. Timestamp saved to localStorage
6. Trigger icon appears in bottom-right corner

### Return Visit Flow
1. User returns to website
2. Trigger icon appears immediately (blinking animation)
3. User clicks icon to view popup
4. Modal opens on demand

### Manual Control
If auto-show disabled:
- Only trigger icon shows (no auto-popup)
- Users must click icon to view modal
- Great for less intrusive approach

---

## Dynamic Features

### All Content is Editable
- Title text
- Alert banner
- Bonus amounts and descriptions
- All 3 feature items
- Button text and URL

### All Colors are Customizable
- Background gradient (top and bottom)
- Primary accent color
- Text color

### Behavior is Configurable
- Popup delay timing
- Auto-show on/off toggle

---

## Best Practices

### Content
- Keep titles short and impactful
- Use clear, action-oriented button text
- Update bonus amounts regularly
- Ensure button URL points to actual registration page

### Visual
- Maintain good contrast between text and background
- Use brand colors consistently
- Test color combinations for readability

### Behavior
- 1-3 seconds delay is optimal for user experience
- Consider disabling auto-show for less aggressive marketing
- Too short delay (< 1s) may feel pushy
- Too long delay (> 5s) may be missed

---

## Saving Changes

1. Make your changes in any tab
2. Click **Save Changes** button at bottom of form
3. Visit your website to see updates immediately
4. Clear browser cache if changes don't appear

**Note**: Changes are instant on the frontend. No need to refresh admin page.

---

## Reset to Defaults

To restore original settings:
1. Delete all option values in each tab
2. Leave fields empty
3. Save changes
4. System will use default values automatically

---

## Technical Details

### Storage
- All settings stored in WordPress options table
- Prefix: `foursix_popup_*`
- No database tables created
- Safe to export/import with WordPress tools

### Performance
- Settings cached by WordPress
- Minimal database queries
- No performance impact on frontend

### Compatibility
- Works with all WordPress themes
- Compatible with caching plugins
- Mobile responsive by default

---

## Troubleshooting

### Changes Not Showing
1. Clear browser cache (Ctrl+Shift+R / Cmd+Shift+R)
2. Check if caching plugin active (clear cache)
3. Verify settings saved successfully (check for success message)

### Popup Not Appearing
1. Check "Enable Auto Show" is checked (Behavior tab)
2. Clear localStorage: Browser Console → `localStorage.removeItem('foursix_welcome_popup_closed')`
3. Reload page

### Button Not Working
1. Verify Button URL is set correctly (Content tab)
2. Ensure URL starts with http:// or https://
3. Test URL separately in browser

### Colors Not Changing
1. Clear browser cache
2. Check if custom CSS overriding popup styles
3. Use browser inspector to verify CSS loading

---

## Future Enhancements

Potential additions for future versions:
- Custom coin images upload
- Multiple popup templates
- A/B testing capabilities
- Analytics integration
- Schedule popup display times
- User role targeting
- Page-specific popups

---

## Support

For technical issues:
1. Check browser console for JavaScript errors
2. Verify all files are uploaded correctly
3. Test with WordPress default theme
4. Disable other plugins temporarily

---

## Quick Reference

### Admin Menu Location
WordPress Admin → Welcome Popup

### Settings Organization
- Content Tab: All text and promotional content
- Visual Tab: Colors and appearance
- Behavior Tab: Timing and display rules

### Default Values
- Delay: 1500ms (1.5 seconds)
- Auto-show: Enabled
- All text: Bengali promotional content
- Colors: Green theme (#009966)

### Files Modified by Admin
- `inc/welcome-popup.php` - Reads settings for frontend display
- `assets/js/welcome-popup.js` - Uses delay setting from admin

### Files NOT Modified
- Original design CSS remains unchanged
- Modal structure preserved
- JavaScript functionality intact
