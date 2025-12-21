# Popup Trigger Icon Documentation

## Overview
A blinking trigger icon appears on the right side of the screen after the popup is closed, allowing users to reopen the modal at any time.

## Visual Behavior

### Position
```
┌─────────────────────────────┐
│                             │
│                             │
│     Page Content         [●]│ ← Blinking Icon
│                             │    (Middle-right)
│                             │
└─────────────────────────────┘
```

### States

**1. Initial Load**
- Popup shows automatically after 1.5s
- Trigger icon is hidden

**2. After User Closes Popup**
- Popup hides
- Trigger icon appears with blinking animation

**3. User Clicks Trigger Icon**
- Trigger icon hides
- Popup reopens

**4. Popup Open**
- Trigger icon hidden (not visible while modal is open)

## Design Specifications

### Desktop
```css
Position: Fixed middle-right
Size: 60px × 60px
Right offset: 20px
Vertical: 50% (centered)
Background: Linear gradient (#009966 → #00CC88)
Shadow: 0 4px 20px rgba(0, 153, 102, 0.4)
```

### Tablet (768px - 480px)
```css
Size: 50px × 50px
Right offset: 15px
Icon size: 25px × 25px
```

### Mobile (< 480px)
```css
Size: 45px × 45px
Right offset: 10px
Icon size: 22px × 22px
```

## Animation Details

### Pulse/Blink Effect

```css
@keyframes pulseIcon {
    0%, 100% {
        box-shadow: 0 4px 20px rgba(0, 153, 102, 0.4);
        transform: translateY(-50%) scale(1);
    }
    50% {
        box-shadow: 0 4px 30px rgba(0, 153, 102, 0.8),
                    0 0 0 10px rgba(0, 153, 102, 0.2);
        transform: translateY(-50%) scale(1.05);
    }
}
```

**Animation Duration:** 2s infinite loop

**Effect:**
- Gentle pulse/breathing effect
- Expanding glow at peak
- Slight scale increase (5%)

### Hover Animation

```css
:hover {
    transform: translateY(-50%) scale(1.1);
    box-shadow: 0 6px 30px rgba(0, 153, 102, 0.6);
}
```

**Effect:**
- 10% scale increase
- Enhanced shadow
- Smooth 0.3s transition

## HTML Structure

```html
<div class="popup-trigger-icon" title="View Special Offer">
    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <!-- Gift icon SVG path -->
    </svg>
</div>
```

## CSS Classes

### `.popup-trigger-icon`
Base class for the trigger button

### `.popup-trigger-icon.visible`
Shows the trigger icon (added when popup is closed)

## JavaScript API

### Show Trigger Icon
```javascript
const trigger = document.querySelector('.popup-trigger-icon');
trigger.classList.add('visible');
```

### Hide Trigger Icon
```javascript
const trigger = document.querySelector('.popup-trigger-icon');
trigger.classList.remove('visible');
```

### Manual Control
```javascript
// Show icon
WelcomePopup.showTrigger();

// Hide icon
WelcomePopup.hideTrigger();
```

## User Flow

### First Visit
```
1. Page loads
2. Wait 1.5s
3. Modal slides in from right
4. User closes modal (✕ button or ESC)
5. Modal hides
6. Trigger icon appears (blinking)
```

### Return Visit (< 7 days)
```
1. Page loads
2. Modal doesn't auto-show (localStorage)
3. Trigger icon appears immediately (blinking)
4. User clicks trigger icon
5. Modal slides in from right
```

### Return Visit (≥ 7 days)
```
1. Page loads
2. Wait 1.5s
3. Modal auto-shows again
4. Cycle repeats
```

## Customization

### Change Icon Position

**Bottom-right corner:**
```css
.popup-trigger-icon {
    top: auto;
    bottom: 20px;
    transform: translateY(0);
}

.popup-trigger-icon:hover {
    transform: scale(1.1);
}
```

**Top-right corner:**
```css
.popup-trigger-icon {
    top: 20px;
    transform: translateY(0);
}
```

**Left side (middle-left):**
```css
.popup-trigger-icon {
    left: 20px;
    right: auto;
}
```

### Change Icon Size

```css
.popup-trigger-icon {
    width: 70px;
    height: 70px;
}

.popup-trigger-icon svg {
    width: 35px;
    height: 35px;
}
```

### Change Colors

```css
.popup-trigger-icon {
    background: linear-gradient(135deg, #FF6B6B, #FF8E53);
    box-shadow: 0 4px 20px rgba(255, 107, 107, 0.4);
}

@keyframes pulseIcon {
    50% {
        box-shadow: 0 4px 30px rgba(255, 107, 107, 0.8),
                    0 0 0 10px rgba(255, 107, 107, 0.2);
    }
}
```

### Change Animation Speed

```css
/* Faster pulse */
.popup-trigger-icon {
    animation: pulseIcon 1s infinite;
}

/* Slower pulse */
.popup-trigger-icon {
    animation: pulseIcon 3s infinite;
}

/* No animation */
.popup-trigger-icon {
    animation: none;
}
```

### Custom Icon

Replace the SVG in `inc/welcome-popup.php`:

```html
<div class="popup-trigger-icon" title="View Special Offer">
    <!-- Your custom SVG or icon -->
    <i class="fas fa-gift"></i>
    <!-- Or use an image -->
    <img src="/path/to/icon.png" alt="Offer">
</div>
```

### Add Badge/Notification Count

```html
<div class="popup-trigger-icon" title="View Special Offer">
    <svg>...</svg>
    <span class="notification-badge">1</span>
</div>
```

```css
.notification-badge {
    position: absolute;
    top: -5px;
    right: -5px;
    background: #FF4444;
    color: white;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: bold;
}
```

## Accessibility

### Current Features
- **Title attribute:** Provides tooltip on hover
- **Clickable area:** Large enough for easy clicking (60px)
- **Visual feedback:** Hover and pulse animations

### Recommended Enhancements

```html
<button
    class="popup-trigger-icon"
    aria-label="View special offer"
    title="View Special Offer"
    role="button"
    tabindex="0">
    <svg aria-hidden="true">...</svg>
</button>
```

### Keyboard Support

Add to JavaScript:

```javascript
trigger.addEventListener('keydown', function(e) {
    if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        showPopup();
    }
});
```

## Performance Considerations

### Animation Performance
- Uses GPU-accelerated properties (`transform`, `opacity`)
- Single animation loop (no multiple animations)
- Minimal repaints

### Memory Usage
- No additional event listeners per animation frame
- CSS animations (hardware accelerated)
- Single DOM element

## Browser Support

- ✅ Chrome/Edge: Full support
- ✅ Firefox: Full support
- ✅ Safari: Full support (including iOS)
- ✅ Mobile browsers: Full support
- ⚠️ IE11: Basic support (may lack smooth animations)

## Troubleshooting

### Icon Not Appearing

**Check localStorage:**
```javascript
// Icon should appear if modal was previously closed
localStorage.getItem('foursix_welcome_popup_closed')
```

**Manually show icon:**
```javascript
document.querySelector('.popup-trigger-icon').classList.add('visible');
```

### Icon Not Blinking

**Check animation:**
```javascript
const icon = document.querySelector('.popup-trigger-icon');
console.log(getComputedStyle(icon).animation);
// Should show: pulseIcon 2s infinite
```

### Icon Click Not Working

**Check event listener:**
```javascript
// In browser console
document.querySelector('.popup-trigger-icon').onclick = function() {
    console.log('Icon clicked!');
};
```

### Z-Index Issues

Ensure icon is above other elements:
```css
.popup-trigger-icon {
    z-index: 9998; /* Below modal (9999) but above page content */
}
```

## Testing Checklist

- [ ] Icon appears after closing popup
- [ ] Icon blinks/pulses continuously
- [ ] Icon click reopens popup
- [ ] Icon hides when popup opens
- [ ] Hover effect works
- [ ] Responsive sizing on mobile
- [ ] Positioned correctly on all screen sizes
- [ ] Accessible via keyboard (if implemented)
- [ ] Tooltip shows on hover
- [ ] Animation smooth on all browsers

## Integration with Other Features

### With localStorage
```javascript
// Icon only shows if popup was previously closed
if (getCloseTimestamp()) {
    trigger.classList.add('visible');
}
```

### With Auto-Show Logic
```javascript
// If popup should auto-show, hide trigger
if (shouldShowPopup()) {
    trigger.classList.remove('visible');
} else {
    trigger.classList.add('visible');
}
```

### With Registration Flow
```javascript
// Hide trigger after successful registration
registerBtn.addEventListener('click', function() {
    localStorage.setItem('registered', 'true');
    trigger.remove(); // Permanently remove trigger
});
```

## Advanced Customization

### Conditional Display

Show trigger only on specific pages:
```php
function foursix_render_welcome_popup() {
    // Only show trigger on homepage
    $show_trigger = is_front_page();
    ?>
    <?php if ($show_trigger): ?>
    <div class="popup-trigger-icon" title="View Special Offer">
        ...
    </div>
    <?php endif; ?>
    <?php
}
```

### Multiple States

```css
/* Default state - blinking */
.popup-trigger-icon { animation: pulseIcon 2s infinite; }

/* Urgent state - faster blink */
.popup-trigger-icon.urgent { animation: pulseIcon 0.8s infinite; }

/* Subtle state - no blink */
.popup-trigger-icon.subtle { animation: none; opacity: 0.7; }
```

### Time-based Visibility

```javascript
// Show trigger only after 30 seconds on page
setTimeout(function() {
    document.querySelector('.popup-trigger-icon').classList.add('visible');
}, 30000);
```
