# Popup Positioning Guide

## Current Position: Top Right Corner

```
┌─────────────────────────────────────────────┐
│                                    ┌────────┤
│                                    │ POPUP  │
│                                    │        │
│         Website Content            │ MODAL  │
│                                    │        │
│                                    └────────┤
│                                             │
│                                             │
└─────────────────────────────────────────────┘
```

## Animation Behavior

**Slide-in from Right:**
```
Before:                  After:
┌───────────┐           ┌───────────┐
│           │→→→        │      ┌────┤
│           │   →→→     │      │POP │
│           │      →→→  │      └────┤
└───────────┘           └───────────┘
```

## CSS Properties

```css
/* Container */
.welcome-popop-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 9999;

    /* Position in top-right corner */
    display: flex;
    align-items: flex-start;      /* Top alignment */
    justify-content: flex-end;    /* Right alignment */
    padding: 20px;                /* Space from edges */
}

/* Modal Box */
.wel-offer-modal-box {
    max-width: 420px;

    /* Slide from right */
    transform: translateX(100%);  /* Hidden state: 100% to the right */
}

/* Visible State */
.show .wel-offer-modal-box {
    transform: translateX(0);     /* Visible state: normal position */
}
```

## Alternative Positions

### Bottom Right
```
┌─────────────────────────────────────────────┐
│                                             │
│         Website Content                     │
│                                             │
│                                    ┌────────┤
│                                    │ POPUP  │
└────────────────────────────────────┴────────┘
```
**CSS:**
```css
.welcome-popop-modal {
    align-items: flex-end;      /* Bottom */
    justify-content: flex-end;  /* Right */
}
```

### Top Left
```
┌─────────────────────────────────────────────┐
│────────┐                                    │
│ POPUP  │                                    │
│        │     Website Content                │
│────────┘                                    │
│                                             │
└─────────────────────────────────────────────┘
```
**CSS:**
```css
.welcome-popop-modal {
    align-items: flex-start;    /* Top */
    justify-content: flex-start; /* Left */
}

.wel-offer-modal-box {
    transform: translateX(-100%); /* Slide from left */
}
```

### Bottom Left
```
┌─────────────────────────────────────────────┐
│                                             │
│         Website Content                     │
│                                             │
│────────┐                                    │
│ POPUP  │                                    │
└────────┴────────────────────────────────────┘
```
**CSS:**
```css
.welcome-popop-modal {
    align-items: flex-end;       /* Bottom */
    justify-content: flex-start; /* Left */
}

.wel-offer-modal-box {
    transform: translateX(-100%); /* Slide from left */
}
```

### Center (Original)
```
┌─────────────────────────────────────────────┐
│                                             │
│              ┌────────────┐                 │
│              │   POPUP    │                 │
│              └────────────┘                 │
│                                             │
└─────────────────────────────────────────────┘
```
**CSS:**
```css
.welcome-popop-modal {
    align-items: center;        /* Center vertically */
    justify-content: center;    /* Center horizontally */
    pointer-events: all;        /* Enable backdrop click */
}

.wel-offer-modal-box {
    transform: translateY(20px) scale(0.95); /* Scale + slide up */
}
```

## Responsive Behavior

### Desktop (> 768px)
- **Position:** Top right corner
- **Width:** Max 420px
- **Padding:** 20px from edges
- **Animation:** Slide from right

### Tablet (768px - 480px)
- **Position:** Top right corner
- **Width:** Full width minus padding
- **Padding:** 10px from edges
- **Animation:** Slide from right

### Mobile (< 480px)
- **Position:** Top right corner
- **Width:** Full width
- **Padding:** 5px from edges
- **Animation:** Slide from right (minimal)

## Z-Index Hierarchy

```
9999 - Popup Modal (highest)
----
Your existing elements
----
0 - Base layer
```

Ensure no other elements have `z-index > 9999` that might overlap the popup.

## Animation Timing

```
Timeline:
0ms    ├─ Page Load
       │
1500ms ├─ Popup Appears (showDelay)
       │  └─ Opacity: 0 → 1 (300ms)
       │  └─ Transform: translateX(100%) → 0 (400ms)
       │
       │  User sees popup
       │
       ├─ User Clicks Close
       │  └─ Opacity: 1 → 0 (300ms)
       │  └─ Transform: 0 → translateX(100%) (400ms)
       │
       └─ Popup Hidden
          └─ localStorage timestamp saved
```

## Pointer Events

```css
/* Container doesn't block clicks */
.welcome-popop-modal {
    pointer-events: none;  /* Background is clickable */
}

/* Only modal box receives clicks */
.wel-offer-modal-box {
    pointer-events: auto;  /* Modal is clickable */
}
```

This allows users to interact with the page while the popup is visible (but only the modal box itself is interactive).
