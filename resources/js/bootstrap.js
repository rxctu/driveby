/**
 * Bootstrap file — sets up CSRF token for fetch and axios requests.
 */

// Read the CSRF token from the meta tag
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

if (csrfToken) {
    // Store on window for easy access in fetch calls
    window.csrfToken = csrfToken;
} else {
    console.warn('CSRF token meta tag not found.');
}

// If axios is loaded, set the default header
import axios from 'axios';

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken ?? '';

window.axios = axios;
