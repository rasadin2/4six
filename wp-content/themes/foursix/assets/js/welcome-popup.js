/**
 * Welcome Popup Modal
 * Displays promotional popup on page load with localStorage-based visibility control
 */
(function() {
    'use strict';

    // Configuration
    const CONFIG = {
        popupId: 'welcomePopupModal',
        storageKey: 'foursix_welcome_popup_closed',
        showDelay: typeof foursixPopupSettings !== 'undefined' ? foursixPopupSettings.showDelay : 1500 // Show popup delay from WordPress settings
    };

    /**
     * Get popup close timestamp from localStorage
     */
    function getCloseTimestamp() {
        const stored = localStorage.getItem(CONFIG.storageKey);
        return stored ? parseInt(stored, 10) : null;
    }

    /**
     * Set popup close timestamp to localStorage
     */
    function setCloseTimestamp() {
        localStorage.setItem(CONFIG.storageKey, Date.now().toString());
    }

    /**
     * Check if popup should be shown
     * Only auto-show on first visit (when localStorage key doesn't exist)
     */
    function shouldShowPopup() {
        const lastClosed = getCloseTimestamp();
        return !lastClosed; // Only show if never closed before
    }

    /**
     * Show the popup modal
     */
    function showPopup() {
        const modal = document.querySelector('.welcome-popop-modal');
        const trigger = document.querySelector('.popup-trigger-icon');
        if (!modal) return;

        // Add show class with slight delay for animation
        setTimeout(() => {
            modal.classList.add('show');
            // Hide trigger icon when modal is open
            if (trigger) {
                trigger.classList.remove('visible');
            }
            // Floating modal: background scroll remains active
        }, 100);
    }

    /**
     * Hide the popup modal
     */
    function hidePopup() {
        const modal = document.querySelector('.welcome-popop-modal');
        const trigger = document.querySelector('.popup-trigger-icon');
        if (!modal) return;

        modal.classList.remove('show');
        // Floating modal: no need to restore scroll (it was never disabled)

        // Show trigger icon when modal is closed
        if (trigger) {
            trigger.classList.add('visible');
        }

        // Set close timestamp
        setCloseTimestamp();
    }

    /**
     * Initialize popup event listeners
     */
    function initEventListeners() {
        const modal = document.querySelector('.welcome-popop-modal');
        const trigger = document.querySelector('.popup-trigger-icon');
        if (!modal) return;

        // Close button click
        const closeBtn = modal.querySelector('.close-btn');
        if (closeBtn) {
            closeBtn.addEventListener('click', function(e) {
                e.preventDefault();
                hidePopup();
            });
        }

        // Register button click (you can customize this action)
        const registerBtn = modal.querySelector('.register-btn');
        if (registerBtn) {
            registerBtn.addEventListener('click', function(e) {
                // Add your registration redirect URL here
                // window.location.href = '/register';
                hidePopup();
            });
        }

        // Trigger icon click - reopen modal
        if (trigger) {
            trigger.addEventListener('click', function(e) {
                e.preventDefault();
                showPopup();
            });
        }

        // Optional: Click outside modal to close (disabled for corner popup)
        // Uncomment below if you want click-outside-to-close functionality
        /*
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                hidePopup();
            }
        });
        */

        // ESC key to close
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && modal.classList.contains('show')) {
                hidePopup();
            }
        });
    }

    /**
     * Initialize popup system
     */
    function init() {
        // Wait for DOM to be fully loaded
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', init);
            return;
        }

        const trigger = document.querySelector('.popup-trigger-icon');

        // Initialize event listeners
        initEventListeners();

        // Check if popup should be shown
        if (shouldShowPopup()) {
            // Auto-show popup after delay
            setTimeout(showPopup, CONFIG.showDelay);
        } else {
            // Modal was closed before, show trigger icon immediately
            if (trigger) {
                trigger.classList.add('visible');
            }
        }
    }

    // Start initialization
    init();

    // Public API for manual control (optional)
    window.WelcomePopup = {
        show: showPopup,
        hide: hidePopup,
        reset: function() {
            localStorage.removeItem(CONFIG.storageKey);
        }
    };

})();
