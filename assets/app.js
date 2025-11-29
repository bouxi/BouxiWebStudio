/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
// assets/app.js

// ✅ CSS Bootstrap (vient de l'importmap)
import 'bootstrap/dist/css/bootstrap.min.css';

// ✅ JS Bootstrap (dropdown, modals, etc.)
import 'bootstrap';

// ✅ ton CSS perso
import './styles/app.css';

