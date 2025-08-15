<div class="page-translator" id="pageTranslator">
    <div class="translator-toggle" onclick="togglePageTranslator()">
        <i class="fas fa-globe"></i>
        <span class="current-lang">EN</span>
        <i class="fas fa-chevron-down"></i>
    </div>
    
    <div class="translator-dropdown" id="translatorDropdown">
        <div class="lang-option" onclick="translatePage('en')" data-lang="en">
            <span class="flag">🇺🇸</span>
            <span class="lang-name">English</span>
            <i class="fas fa-check"></i>
        </div>
        <div class="lang-option" onclick="translatePage('es')" data-lang="es">
            <span class="flag">🇪🇸</span>
            <span class="lang-name">Español</span>
            <i class="fas fa-check" style="display: none;"></i>
        </div>
        <div class="lang-option" onclick="translatePage('fr')" data-lang="fr">
            <span class="flag">🇫🇷</span>
            <span class="lang-name">Français</span>
            <i class="fas fa-check" style="display: none;"></i>
        </div>
        <div class="lang-option" onclick="translatePage('de')" data-lang="de">
            <span class="flag">🇩🇪</span>
            <span class="lang-name">Deutsch</span>
            <i class="fas fa-check" style="display: none;"></i>
        </div>
    </div>
</div>

<style>
.page-translator {
    position: relative;
    display: inline-block;
}

.translator-toggle {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 14px;
    font-weight: 500;
}

.translator-toggle:hover {
    border-color: #f68b1e;
    box-shadow: 0 2px 8px rgba(246, 139, 30, 0.15);
}

.translator-toggle i {
    color: #6b7280;
}

.current-lang {
    color: #374151;
    font-weight: 600;
}

.translator-dropdown {
    position: absolute;
    top: 100%;
    right: 0;
    margin-top: 8px;
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    min-width: 200px;
    z-index: 1000;
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: all 0.3s ease;
}

.translator-dropdown.show {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.lang-option {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    cursor: pointer;
    transition: all 0.2s ease;
    border-bottom: 1px solid #f3f4f6;
}

.lang-option:last-child {
    border-bottom: none;
}

.lang-option:hover {
    background: #f9fafb;
}

.lang-option.active {
    background: #fef3c7;
    color: #92400e;
}

.lang-option .flag {
    font-size: 18px;
}

.lang-option .lang-name {
    flex: 1;
    font-weight: 500;
}

.lang-option .fa-check {
    color: #10b981;
    font-size: 14px;
}

/* Responsive */
@media (max-width: 768px) {
    .translator-dropdown {
        right: auto;
        left: 0;
        min-width: 180px;
    }
}
</style>

<script>
// Translation data - only essential phrases
const pageTranslations = {
    en: {
        'Login': 'Login',
        'Register': 'Register',
        'Get Started': 'Get Started',
        'Dashboard': 'Dashboard',
        'Products': 'Products',
        'Orders': 'Orders',
        'Wallet': 'Wallet',
        'Featured Products': 'Featured Products',
        'View Details': 'View Details',
        'Shop Now': 'Shop Now',
        'Welcome back': 'Welcome back',
        'Home': 'Home',
        'Logout': 'Logout'
    },
    es: {
        'Login': 'Iniciar Sesión',
        'Register': 'Registrarse',
        'Get Started': 'Comenzar',
        'Dashboard': 'Panel',
        'Products': 'Productos',
        'Orders': 'Pedidos',
        'Wallet': 'Billetera',
        'Featured Products': 'Productos Destacados',
        'View Details': 'Ver Detalles',
        'Shop Now': 'Comprar Ahora',
        'Welcome back': 'Bienvenido de vuelta',
        'Home': 'Inicio',
        'Logout': 'Cerrar Sesión'
    },
    fr: {
        'Login': 'Connexion',
        'Register': 'S\'inscrire',
        'Get Started': 'Commencer',
        'Dashboard': 'Tableau de Bord',
        'Products': 'Produits',
        'Orders': 'Commandes',
        'Wallet': 'Portefeuille',
        'Featured Products': 'Produits Vedettes',
        'View Details': 'Voir Détails',
        'Shop Now': 'Acheter Maintenant',
        'Welcome back': 'Bon retour',
        'Home': 'Accueil',
        'Logout': 'Déconnexion'
    },
    de: {
        'Login': 'Anmelden',
        'Register': 'Registrieren',
        'Get Started': 'Loslegen',
        'Dashboard': 'Dashboard',
        'Products': 'Produkte',
        'Orders': 'Bestellungen',
        'Wallet': 'Geldbörse',
        'Featured Products': 'Empfohlene Produkte',
        'View Details': 'Details Anzeigen',
        'Shop Now': 'Jetzt Kaufen',
        'Welcome back': 'Willkommen zurück',
        'Home': 'Startseite',
        'Logout': 'Abmelden'
    }
};

let currentLanguage = 'en';
let isTranslating = false;

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    const savedLang = localStorage.getItem('shopease_page_language');
    if (savedLang && pageTranslations[savedLang]) {
        currentLanguage = savedLang;
        updateLanguageDisplay();
    }
});

function togglePageTranslator() {
    const dropdown = document.getElementById('translatorDropdown');
    dropdown.classList.toggle('show');
    
    // Close when clicking outside
    document.addEventListener('click', function closeDropdown(e) {
        if (!document.getElementById('pageTranslator').contains(e.target)) {
            dropdown.classList.remove('show');
            document.removeEventListener('click', closeDropdown);
        }
    });
}

function translatePage(lang) {
    if (isTranslating || lang === currentLanguage) return;
    
    isTranslating = true;
    
    try {
        if (lang === 'en') {
            resetToEnglish();
        } else {
            const translations = pageTranslations[lang];
            if (translations) {
                Object.keys(translations).forEach(englishText => {
                    const translatedText = translations[englishText];
                    findAndReplaceText(englishText, translatedText);
                });
            }
        }
        
        currentLanguage = lang;
        localStorage.setItem('shopease_page_language', lang);
        updateLanguageDisplay();
        showTranslationMessage(lang);
        
        // Close dropdown
        document.getElementById('translatorDropdown').classList.remove('show');
        
    } catch (error) {
        console.error('Translation error:', error);
    } finally {
        isTranslating = false;
    }
}

function findAndReplaceText(englishText, translatedText) {
    // Find text nodes
    const walker = document.createTreeWalker(
        document.body,
        NodeFilter.SHOW_TEXT,
        null,
        false
    );
    
    let node;
    while (node = walker.nextNode()) {
        if (node.textContent.trim() === englishText) {
            // Store original text if not already stored
            if (!node.hasAttribute('data-original-text')) {
                node.setAttribute('data-original-text', englishText);
            }
            node.textContent = translatedText;
        }
    }
    
    // Find button text and placeholders
    document.querySelectorAll('button, input, a, span, div').forEach(element => {
        if (element.textContent.trim() === englishText && !element.hasAttribute('data-original-text')) {
            element.setAttribute('data-original-text', englishText);
            element.textContent = translatedText;
        }
        
        if (element.placeholder === englishText && !element.hasAttribute('data-original-placeholder')) {
            element.setAttribute('data-original-placeholder', englishText);
            element.placeholder = translatedText;
        }
    });
}

function resetToEnglish() {
    // Restore original text
    document.querySelectorAll('[data-original-text]').forEach(element => {
        element.textContent = element.getAttribute('data-original-text');
        element.removeAttribute('data-original-text');
    });
    
    // Restore original placeholders
    document.querySelectorAll('[data-original-placeholder]').forEach(element => {
        element.placeholder = element.getAttribute('data-original-placeholder');
        element.removeAttribute('data-original-placeholder');
    });
}

function updateLanguageDisplay() {
    // Update current language display
    document.querySelector('.current-lang').textContent = currentLanguage.toUpperCase();
    
    // Update active state in dropdown
    document.querySelectorAll('.lang-option').forEach(option => {
        const lang = option.getAttribute('data-lang');
        const checkIcon = option.querySelector('.fa-check');
        
        if (lang === currentLanguage) {
            option.classList.add('active');
            checkIcon.style.display = 'inline-block';
        } else {
            option.classList.remove('active');
            checkIcon.style.display = 'none';
        }
    });
}

function showTranslationMessage(lang) {
    const messages = {
        'en': 'Page reset to English',
        'es': 'Página traducida al español',
        'fr': 'Page traduite en français',
        'de': 'Seite ins Deutsche übersetzt'
    };
    
    // Create toast message
    const toast = document.createElement('div');
    toast.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: #10b981;
        color: white;
        padding: 12px 20px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        z-index: 10000;
        font-weight: 500;
        transform: translateX(100%);
        transition: transform 0.3s ease;
    `;
    toast.textContent = messages[lang] || 'Translation complete';
    
    document.body.appendChild(toast);
    
    // Show toast
    setTimeout(() => toast.style.transform = 'translateX(0)', 100);
    
    // Hide toast
    setTimeout(() => {
        toast.style.transform = 'translateX(100%)';
        setTimeout(() => document.body.removeChild(toast), 300);
    }, 3000);
}
</script>
