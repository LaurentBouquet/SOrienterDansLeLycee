import 'bootstrap/dist/css/bootstrap.min.css';
import '@fortawesome/fontawesome-free/css/all.css';
import './styles/app.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';

import './stimulus_bootstrap.js';

/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */

/* ==========================================================================
   Dark Mode Toggle
   
   Toggles Bootstrap 5.3 theme using data-bs-theme attribute.
   Persists user preference in localStorage.
   Falls back to system preference on first visit.
   ========================================================================== */

(function() {
    'use strict';

    const STORAGE_KEY = 'bs-theme';
    const THEME_LIGHT = 'light';
    const THEME_DARK = 'dark';

    /**
     * Get the user's preferred theme.
     * Priority: localStorage > system preference > light (default)
     * @returns {string} 'light' or 'dark'
     */
    function getPreferredTheme() {
        // Check localStorage first
        const storedTheme = localStorage.getItem(STORAGE_KEY);
        if (storedTheme === THEME_LIGHT || storedTheme === THEME_DARK) {
            return storedTheme;
        }

        // Fall back to system preference
        if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            return THEME_DARK;
        }

        // Default to light
        return THEME_LIGHT;
    }

    /**
     * Apply the theme to the document.
     * @param {string} theme - 'light' or 'dark'
     */
    function applyTheme(theme) {
        document.documentElement.setAttribute('data-bs-theme', theme);
    }

    /**
     * Save the theme preference to localStorage.
     * @param {string} theme - 'light' or 'dark'
     */
    function saveTheme(theme) {
        try {
            localStorage.setItem(STORAGE_KEY, theme);
        } catch (e) {
            // localStorage may be unavailable (private browsing, etc.)
            console.warn('Could not save theme preference:', e);
        }
    }

    /**
     * Update the toggle button icon.
     * Shows moon when light mode is active (click to go dark).
     * Shows sun when dark mode is active (click to go light).
     * @param {string} theme - Current theme
     */
    function updateToggleIcon(theme) {
        const toggleButton = document.getElementById('theme-toggle');
        if (!toggleButton) {
            return;
        }

        const icon = toggleButton.querySelector('i');
        if (!icon) {
            return;
        }

        // Remove existing icon classes
        icon.classList.remove('fa-moon', 'fa-sun');

        // Add appropriate icon
        if (theme === THEME_DARK) {
            icon.classList.add('fa-sun');
            toggleButton.setAttribute('aria-label', 'Basculer en mode clair');
        } else {
            icon.classList.add('fa-moon');
            toggleButton.setAttribute('aria-label', 'Basculer en mode sombre');
        }
    }

    /**
     * Get the current theme from the document.
     * @returns {string} Current theme
     */
    function getCurrentTheme() {
        return document.documentElement.getAttribute('data-bs-theme') || THEME_LIGHT;
    }

    /**
     * Toggle between light and dark themes.
     */
    function toggleTheme() {
        const currentTheme = getCurrentTheme();
        const newTheme = currentTheme === THEME_DARK ? THEME_LIGHT : THEME_DARK;

        applyTheme(newTheme);
        saveTheme(newTheme);
        updateToggleIcon(newTheme);
    }

    /**
     * Initialize the theme system.
     */
    function initTheme() {
        // Apply preferred theme immediately
        const preferredTheme = getPreferredTheme();
        applyTheme(preferredTheme);

        // Update icon once DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function() {
                updateToggleIcon(preferredTheme);
                bindToggleButton();
            });
        } else {
            updateToggleIcon(preferredTheme);
            bindToggleButton();
        }

        // Listen for system theme changes
        if (window.matchMedia) {
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function(e) {
                // Only auto-switch if user hasn't set a preference
                if (!localStorage.getItem(STORAGE_KEY)) {
                    const newTheme = e.matches ? THEME_DARK : THEME_LIGHT;
                    applyTheme(newTheme);
                    updateToggleIcon(newTheme);
                }
            });
        }
    }

    /**
     * Bind click event to the toggle button.
     */
    function bindToggleButton() {
        const toggleButton = document.getElementById('theme-toggle');
        if (toggleButton) {
            toggleButton.addEventListener('click', toggleTheme);
        }
    }

    // Initialize immediately to prevent flash of wrong theme
    initTheme();

})();
