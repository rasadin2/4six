# Welcome Popup Modal Documentation

## Overview
A dynamic welcome popup modal system for the Foursix WordPress theme with localStorage-based visibility control.

## Features
- ✅ Automatic display on page load (1.5 second delay)
- ✅ **Positioned in bottom-right corner**
- ✅ Floating modal (website scroll remains active)
- ✅ Fixed height (70vh) with internal scrollbar
- ✅ Smooth slide-in animation from right
- ✅ **Blinking trigger icon in bottom-right corner**
- ✅ Click trigger icon to reopen modal anytime
- ✅ Custom styled scrollbar
- ✅ localStorage persistence (shows again after 7 days)
- ✅ ESC key to close
- ✅ Responsive design with adaptive height
- ✅ Non-intrusive corner placement

## Files Structure

```
wp-content/themes/foursix/
├── assets/
│   ├── css/
│   │   └── welcome-popup.css        # Functional CSS (animations, visibility)
│   └── js/
│       └── welcome-popup.js         # JavaScript functionality
├── inc/
│   └── welcome-popup.php            # PHP integration & HTML template
└── functions.php                    # Updated to load popup system
```

## Configuration

### Timing Settings
Edit `assets/js/welcome-popup.js`:

```javascript
const CONFIG = {
    popupId: 'welcomePopupModal',
    storageKey: 'foursix_welcome_popup_closed',
    showDelay: 1500,  // Change delay (milliseconds)
    expireDays: 7     // Change expiry days
};
```

### Customization Options

**Change Show Delay:**
```javascript
showDelay: 3000,  // Show after 3 seconds
```

**Change Expiry Period:**
```javascript
expireDays: 1,   // Show daily
expireDays: 30,  // Show monthly
```

**Disable Expiry (Always Show):**
```javascript
function shouldShowPopup() {
    return true; // Always show
}
```

## HTML Structure

The popup HTML is located in `inc/welcome-popup.php` in the `foursix_render_welcome_popup()` function.

### Edit Content

To change the popup content, edit the HTML in `inc/welcome-popup.php`:

```php
function foursix_render_welcome_popup() {
    ?>
    <div class="welcome-popop-modal">
        <!-- Edit content here -->
    </div>
    <?php
}
```

### Change Register Button Action

Edit the register button click handler in `assets/js/welcome-popup.js`:

```javascript
const registerBtn = modal.querySelector('.register-btn');
if (registerBtn) {
    registerBtn.addEventListener('click', function(e) {
        // Add your custom URL
        window.location.href = '/your-registration-page';
        hidePopup();
    });
}
```

## JavaScript API

The popup exposes a global API for manual control:

```javascript
// Show popup manually
WelcomePopup.show();

// Hide popup manually
WelcomePopup.hide();

// Reset localStorage (show popup again)
WelcomePopup.reset();
```

### Usage Examples

**Show popup on button click:**
```javascript
document.querySelector('#my-button').addEventListener('click', function() {
    WelcomePopup.show();
});
```

**Reset popup for testing:**
```javascript
// In browser console
WelcomePopup.reset();
location.reload(); // Reload to see popup again
```

## User Interactions

### Close Methods
1. **Close Button (✕)**: Click the X button
2. **ESC Key**: Press ESC on keyboard
3. **Register Button**: Automatically closes after click

**Note:** Click-outside-to-close is disabled for corner popups to prevent accidental closes.

### Reopen Modal
After closing the modal, a **blinking trigger icon** appears in the **bottom-right corner**. Click this icon to reopen the modal at any time.

### Visibility Logic

**First Visit:**
- Popup shows after 1.5 seconds
- User closes popup
- Timestamp stored in localStorage

**Return Visit:**
- Check localStorage timestamp
- If < 7 days: Don't show
- If ≥ 7 days: Show again

## localStorage Details

**Storage Key:** `foursix_welcome_popup_closed`

**Stored Value:** Unix timestamp (milliseconds)

**Check in Browser Console:**
```javascript
// View stored timestamp
localStorage.getItem('foursix_welcome_popup_closed');

// Clear to test popup again
localStorage.removeItem('foursix_welcome_popup_closed');
```

## Styling

### Design CSS
Your existing design CSS should handle visual styling. The included `welcome-popup.css` only handles:
- Visibility states
- Animations
- Transitions
- Responsive behavior
- Scrollbar styling
- Height constraints

### Height Customization

Change the modal height in `assets/css/welcome-popup.css`:

```css
/* Default: 70% of viewport height */
.wel-offer-modal-box {
    max-height: 70vh;
}

/* Make it shorter */
.wel-offer-modal-box {
    max-height: 50vh;  /* 50% of viewport */
}

/* Make it taller */
.wel-offer-modal-box {
    max-height: 85vh;  /* 85% of viewport */
}

/* Fixed pixel height */
.wel-offer-modal-box {
    max-height: 500px;  /* Fixed 500px */
}
```

### Scrollbar Customization

Customize scrollbar appearance:

```css
/* Scrollbar width */
.wel-offer-modal-box::-webkit-scrollbar {
    width: 12px;  /* Wider scrollbar */
}

/* Scrollbar track color */
.wel-offer-modal-box::-webkit-scrollbar-track {
    background: #f1f1f1;
}

/* Scrollbar thumb color */
.wel-offer-modal-box::-webkit-scrollbar-thumb {
    background: #888;
}

/* Hide scrollbar (not recommended for accessibility) */
.wel-offer-modal-box {
    scrollbar-width: none;  /* Firefox */
}
.wel-offer-modal-box::-webkit-scrollbar {
    display: none;  /* Chrome, Safari */
}
```

### Position Customization

The popup is positioned in the **right corner**. To change position:

**Bottom Right Corner:**
```css
.welcome-popop-modal {
    align-items: flex-end;
    justify-content: flex-end;
}
```

**Bottom Left Corner:**
```css
.welcome-popop-modal {
    align-items: flex-end;
    justify-content: flex-start;
}
```

**Top Left Corner:**
```css
.welcome-popop-modal {
    align-items: flex-start;
    justify-content: flex-start;
}

.welcome-popop-modal .wel-offer-modal-box {
    transform: translateX(-100%) translateY(0);
}
```

**Center (Original):**
```css
.welcome-popop-modal {
    align-items: center;
    justify-content: center;
    pointer-events: all;
}

.welcome-popop-modal .wel-offer-modal-box {
    transform: translateY(20px) scale(0.95);
}

.welcome-popop-modal.show .wel-offer-modal-box {
    transform: translateY(0) scale(1);
}
```

## Troubleshooting

### Popup Not Showing

1. **Check localStorage:**
   ```javascript
   localStorage.removeItem('foursix_welcome_popup_closed');
   ```

2. **Check browser console for errors**

3. **Verify files are loaded:**
   - View page source
   - Look for `welcome-popup.js` and `welcome-popup.css`

4. **Clear cache:**
   - Hard reload: Ctrl+Shift+R (Windows) or Cmd+Shift+R (Mac)

### Popup Shows Every Time

Check if `shouldShowPopup()` function is working:
```javascript
// Should return false if recently closed
console.log(WelcomePopup.shouldShowPopup());
```

### Animation Not Smooth

The popup slides in from the right. If animation is choppy:
1. Check for CSS conflicts
2. Verify no other animations are running
3. Clear browser cache
4. Check browser performance (GPU acceleration)

### Enable Click Outside to Close

Edit `assets/js/welcome-popup.js` and uncomment:
```javascript
// Line ~102
modal.addEventListener('click', function(e) {
    if (e.target === modal) {
        hidePopup();
    }
});
```

## Performance Optimization

### Lazy Loading
Currently loads on all pages. To load only on specific pages:

Edit `inc/welcome-popup.php`:
```php
function foursix_welcome_popup_scripts() {
    // Only on homepage
    if ( is_front_page() ) {
        wp_enqueue_style('foursix-welcome-popup', ...);
        wp_enqueue_script('foursix-welcome-popup', ...);
    }
}
```

### Conditional Display

Show only to non-logged-in users:
```php
function foursix_render_welcome_popup() {
    // Only show to guests
    if ( is_user_logged_in() ) {
        return;
    }
    ?>
    <div class="welcome-popop-modal">
    ...
```

## Browser Support

- ✅ Chrome/Edge (latest)
- ✅ Firefox (latest)
- ✅ Safari (latest)
- ✅ Mobile browsers
- ⚠️ IE11 (requires polyfills)

## Accessibility

- ESC key to close
- Focus management (optional enhancement)
- ARIA labels (optional enhancement)

### Recommended Enhancements

Add ARIA attributes:
```html
<div class="welcome-popop-modal" role="dialog" aria-modal="true" aria-labelledby="popup-title">
    <div class="title" id="popup-title">
        মেগা স্বাগতম অফার
    </div>
</div>
```

## Security Notes

- No user data is sent to server
- Only localStorage timestamp is stored
- No cookies used
- No external dependencies

## Version History

**v1.0.0** (2025-12-20)
- Initial release
- localStorage-based visibility control
- 7-day expiry mechanism
- Smooth animations
- Multiple close methods

## Support

For customization assistance or issues, check:
1. Browser console for JavaScript errors
2. localStorage values
3. File loading in network tab
4. CSS conflicts with existing styles
