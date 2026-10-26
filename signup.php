<?php
$pageTitle = 'Sign Up - invoicescheduler.com';
$pageBodyAttributes = ' class="bg-gray-100 dark:bg-dark-bg min-h-screen flex flex-col items-center py-12 px-4 transition-colors duration-200"';
$pageHeader = 'none';
$pageExtraHead = <<<'HTML'
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://accounts.google.com/gsi/client" async defer></script>
<script>
  tailwind.config = {
    darkMode: 'class',
    theme: {
      extend: {
        colors: {
          brand: { green: '#1AA260', greenDark: '#0E8A4E', greenSoft: '#DFF6E7' },
          ink: '#1E2838',
          dark: { bg: '#0B1220', card: '#141d33', field: '#1c2740', border: '#2a3650', text: '#e7ebf3', muted: '#8492ac' },
        }
      }
    }
  }
</script>
<style>
  body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif; }
  input::placeholder { color: #9CA3AF; }
  select { -webkit-appearance: none; -moz-appearance: none; appearance: none; }
  .field {
    border: 1px solid #D1D5DB;
    border-radius: 4px;
    padding: 0.65rem 0.85rem;
    font-size: 0.9rem;
    background-color: #fff;
    color: #1E2838;
  }
  .field:focus {
    outline: none;
    box-shadow: 0 0 0 1px #1AA260;
    border-color: #1AA260;
  }
  .dark .field { background-color: #1c2740; border-color: #2a3650; color: #e7ebf3; }
  .dark select.field option { background-color: #1c2740; color: #e7ebf3; }
  .dark input::placeholder { color: #5b6b8a; }
</style>
HTML;
require __DIR__ . '/includes/meta.php';
require __DIR__ . '/includes/header.php';
?>
<button id="themeToggle" class="fixed top-6 right-6 w-9 h-9 flex items-center justify-center bg-white dark:bg-dark-card border border-gray-200 dark:border-dark-border rounded-full text-gray-500 dark:text-dark-muted hover:text-ink dark:hover:text-dark-text transition shadow-sm">
    <svg id="iconSun" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1.5M12 19.5V21M4.22 4.22l1.06 1.06M18.72 18.72l1.06 1.06M3 12h1.5M19.5 12H21M4.22 19.78l1.06-1.06M18.72 5.28l1.06-1.06M12 7.5a4.5 4.5 0 100 9 4.5 4.5 0 000-9z"/></svg>
    <svg id="iconMoon" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/></svg>
  </button>

  <a href="./" class="flex items-center gap-2 mb-8">
     <span class="w-9 h-9 inline-block">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 117.59 100" class="w-full h-full">
              <g><rect x="37.62" y="45.29" fill="#B12F26" width="18.82" height="9.41"/><rect x="37.62" y="23.51" fill="#B12F26" width="28.22" height="9.41"/><rect x="37.62" y="67.07" fill="#B12F26" width="56.46" height="9.41"/><polygon fill="#B12F26" points="94.08,0 94.08,23.51 117.59,23.51 "/><polygon fill="#B12F26" points="84.67,0 37.62,0 37.62,23.51 65.84,23.51 65.84,32.93 37.62,32.93 37.62,45.29 56.44,45.29 56.44,54.71 37.62,54.71 37.62,67.07 94.08,67.07 94.08,76.49 37.62,76.49 37.62,100 117.59,100 117.59,32.93 84.67,32.93 "/><rect x="18.81" y="23.51" fill="#B12F26" width="18.81" height="9.41"/><rect y="45.29" fill="#B12F26" width="37.62" height="9.41"/><rect x="9.41" y="67.07" fill="#B12F26" width="28.21" height="9.41"/></g>
            </svg>
          </span>
    <span class="text-2xl text-ink dark:text-dark-text"><span class="font-bold">invoicescheduler</span><span class="font-normal">.com</span></span>
  </a>

  <div class="w-full max-w-md bg-white dark:bg-dark-card rounded-lg shadow-sm border border-gray-200 dark:border-dark-border p-8">
    <h1 class="text-2xl font-bold text-ink dark:text-dark-text text-center mb-2">Create a free account</h1>
    <p class="text-sm text-gray-500 dark:text-dark-muted text-center mb-6">Gain access to more features with an invoicescheduler.com account.</p>

    <div id="errorBox" class="hidden mb-5 rounded-md border border-red-200 dark:border-red-800 bg-red-50 dark:bg-red-950/20 text-red-700 dark:text-red-300 text-sm px-4 py-3">
      Something went wrong. Please check your details and try again — the email may already be registered, or a required field is missing.
    </div>

    <form id="signupForm" action="signup_process.php" method="POST" class="space-y-5">
      <div class="grid grid-cols-2 gap-4">
        <div>
          <label for="firstName" class="block text-sm text-ink dark:text-dark-text mb-1">First Name</label>
          <input id="firstName" name="firstName" type="text" required class="field w-full">
        </div>
        <div>
          <label for="lastName" class="block text-sm text-ink dark:text-dark-text mb-1">Last Name</label>
          <input id="lastName" name="lastName" type="text" required class="field w-full">
        </div>
      </div>

      <div>
        <label for="signupEmail" class="block text-sm text-ink dark:text-dark-text mb-1">Email</label>
        <input id="signupEmail" name="email" type="email" required class="field w-full">
      </div>

      <div>
        <label for="signupPassword" class="block text-sm text-ink dark:text-dark-text mb-1">Password</label>
        <input id="signupPassword" name="password" type="password" minlength="8" required class="field w-full">
      </div>

      <div>
        <label for="country" class="block text-sm text-ink dark:text-dark-text mb-1">Country</label>
        <select id="country" name="country" required class="field w-full">
          <option value="" selected disabled>Select Country</option>
          <option>Afghanistan</option>
          <option>Åland Islands</option>
          <option>Albania</option>
          <option>Algeria</option>
          <option>American Samoa</option>
          <option>Andorra</option>
          <option>Angola</option>
          <option>Anguilla</option>
          <option>Antarctica</option>
          <option>Antigua &amp; Barbuda</option>
          <option>Argentina</option>
          <option>Armenia</option>
          <option>Aruba</option>
          <option>Ascension Island</option>
          <option>Australia</option>
          <option>Austria</option>
          <option>Azerbaijan</option>
          <option>Bahamas</option>
          <option>Bahrain</option>
          <option>Bangladesh</option>
          <option>Barbados</option>
          <option>Belarus</option>
          <option>Belgium</option>
          <option>Belize</option>
          <option>Benin</option>
          <option>Bermuda</option>
          <option>Bhutan</option>
          <option>Bolivia</option>
          <option>Bosnia &amp; Herzegovina</option>
          <option>Botswana</option>
          <option>Bouvet Island</option>
          <option>Brazil</option>
          <option>British Indian Ocean Territory</option>
          <option>British Virgin Islands</option>
          <option>Brunei</option>
          <option>Bulgaria</option>
          <option>Burkina Faso</option>
          <option>Burundi</option>
          <option>Cambodia</option>
          <option>Cameroon</option>
          <option>Canada</option>
          <option>Canary Islands</option>
          <option>Cape Verde</option>
          <option>Caribbean Netherlands</option>
          <option>Cayman Islands</option>
          <option>Central African Republic</option>
          <option>Ceuta &amp; Melilla</option>
          <option>Chad</option>
          <option>Chile</option>
          <option>China</option>
          <option>Christmas Island</option>
          <option>Clipperton Island</option>
          <option>Cocos (Keeling) Islands</option>
          <option>Colombia</option>
          <option>Comoros</option>
          <option>Congo - Brazzaville</option>
          <option>Congo - Kinshasa</option>
          <option>Cook Islands</option>
          <option>Costa Rica</option>
          <option>Côte d’Ivoire</option>
          <option>Croatia</option>
          <option>Cuba</option>
          <option>Curaçao</option>
          <option>Cyprus</option>
          <option>Czechia</option>
          <option>Denmark</option>
          <option>Diego Garcia</option>
          <option>Djibouti</option>
          <option>Dominica</option>
          <option>Dominican Republic</option>
          <option>Ecuador</option>
          <option>Egypt</option>
          <option>El Salvador</option>
          <option>Equatorial Guinea</option>
          <option>Eritrea</option>
          <option>Estonia</option>
          <option>Eswatini</option>
          <option>Ethiopia</option>
          <option>Falkland Islands</option>
          <option>Faroe Islands</option>
          <option>Fiji</option>
          <option>Finland</option>
          <option>France</option>
          <option>French Guiana</option>
          <option>French Polynesia</option>
          <option>French Southern Territories</option>
          <option>Gabon</option>
          <option>Gambia</option>
          <option>Georgia</option>
          <option>Germany</option>
          <option>Ghana</option>
          <option>Gibraltar</option>
          <option>Greece</option>
          <option>Greenland</option>
          <option>Grenada</option>
          <option>Guadeloupe</option>
          <option>Guam</option>
          <option>Guatemala</option>
          <option>Guernsey</option>
          <option>Guinea</option>
          <option>Guinea-Bissau</option>
          <option>Guyana</option>
          <option>Haiti</option>
          <option>Heard &amp; McDonald Islands</option>
          <option>Honduras</option>
          <option>Hong Kong SAR China</option>
          <option>Hungary</option>
          <option>Iceland</option>
          <option>India</option>
          <option>Indonesia</option>
          <option>Iran</option>
          <option>Iraq</option>
          <option>Ireland</option>
          <option>Isle of Man</option>
          <option>Israel</option>
          <option>Italy</option>
          <option>Jamaica</option>
          <option>Japan</option>
          <option>Jersey</option>
          <option>Jordan</option>
          <option>Kazakhstan</option>
          <option>Kenya</option>
          <option>Kiribati</option>
          <option>Kosovo</option>
          <option>Kuwait</option>
          <option>Kyrgyzstan</option>
          <option>Laos</option>
          <option>Latvia</option>
          <option>Lebanon</option>
          <option>Lesotho</option>
          <option>Liberia</option>
          <option>Libya</option>
          <option>Liechtenstein</option>
          <option>Lithuania</option>
          <option>Luxembourg</option>
          <option>Macao SAR China</option>
          <option>Madagascar</option>
          <option>Malawi</option>
          <option>Malaysia</option>
          <option>Maldives</option>
          <option>Mali</option>
          <option>Malta</option>
          <option>Marshall Islands</option>
          <option>Martinique</option>
          <option>Mauritania</option>
          <option>Mauritius</option>
          <option>Mayotte</option>
          <option>Mexico</option>
          <option>Micronesia</option>
          <option>Moldova</option>
          <option>Monaco</option>
          <option>Mongolia</option>
          <option>Montenegro</option>
          <option>Montserrat</option>
          <option>Morocco</option>
          <option>Mozambique</option>
          <option>Myanmar (Burma)</option>
          <option>Namibia</option>
          <option>Nauru</option>
          <option>Nepal</option>
          <option>Netherlands</option>
          <option>New Caledonia</option>
          <option>New Zealand</option>
          <option>Nicaragua</option>
          <option>Niger</option>
          <option>Nigeria</option>
          <option>Niue</option>
          <option>Norfolk Island</option>
          <option>North Korea</option>
          <option>North Macedonia</option>
          <option>Northern Mariana Islands</option>
          <option>Norway</option>
          <option>Oman</option>
          <option>Pakistan</option>
          <option>Palau</option>
          <option>Palestinian Territories</option>
          <option>Panama</option>
          <option>Papua New Guinea</option>
          <option>Paraguay</option>
          <option>Peru</option>
          <option>Philippines</option>
          <option>Pitcairn Islands</option>
          <option>Poland</option>
          <option>Portugal</option>
          <option>Puerto Rico</option>
          <option>Qatar</option>
          <option>Réunion</option>
          <option>Romania</option>
          <option>Russia</option>
          <option>Rwanda</option>
          <option>Samoa</option>
          <option>San Marino</option>
          <option>São Tomé &amp; Príncipe</option>
          <option>Saudi Arabia</option>
          <option>Senegal</option>
          <option>Serbia</option>
          <option>Seychelles</option>
          <option>Sierra Leone</option>
          <option>Singapore</option>
          <option>Sint Maarten</option>
          <option>Slovakia</option>
          <option>Slovenia</option>
          <option>Solomon Islands</option>
          <option>Somalia</option>
          <option>South Africa</option>
          <option>South Georgia &amp; South Sandwich Islands</option>
          <option>South Korea</option>
          <option>South Sudan</option>
          <option>Spain</option>
          <option>Sri Lanka</option>
          <option>St Barthélemy</option>
          <option>St Helena</option>
          <option>St Kitts &amp; Nevis</option>
          <option>St Lucia</option>
          <option>St Martin</option>
          <option>St Pierre &amp; Miquelon</option>
          <option>St Vincent &amp; the Grenadines</option>
          <option>Sudan</option>
          <option>Suriname</option>
          <option>Svalbard &amp; Jan Mayen</option>
          <option>Sweden</option>
          <option>Switzerland</option>
          <option>Syria</option>
          <option>Taiwan</option>
          <option>Tajikistan</option>
          <option>Tanzania</option>
          <option>Thailand</option>
          <option>Timor-Leste</option>
          <option>Togo</option>
          <option>Tokelau</option>
          <option>Tonga</option>
          <option>Trinidad &amp; Tobago</option>
          <option>Tristan da Cunha</option>
          <option>Tunisia</option>
          <option>Türkiye</option>
          <option>Turkmenistan</option>
          <option>Turks &amp; Caicos Islands</option>
          <option>Tuvalu</option>
          <option>Uganda</option>
          <option>Ukraine</option>
          <option>United Arab Emirates</option>
          <option>United Kingdom</option>
          <option>United States</option>
          <option>Uruguay</option>
          <option>US Outlying Islands</option>
          <option>US Virgin Islands</option>
          <option>Uzbekistan</option>
          <option>Vanuatu</option>
          <option>Vatican City</option>
          <option>Venezuela</option>
          <option>Vietnam</option>
          <option>Wallis &amp; Futuna</option>
          <option>Western Sahara</option>
          <option>Yemen</option>
          <option>Zambia</option>
          <option>Zimbabwe</option>
          <option>Other</option>
        </select>
      </div>

      <label class="flex items-center gap-2 text-sm text-gray-600 dark:text-dark-muted">
        <input id="agreeTerms" type="checkbox" required class="w-4 h-4 rounded border-gray-300 text-brand-green focus:ring-brand-green">
        I agree to the Terms of Service
      </label>

      <button type="submit" class="w-full bg-brand-green hover:bg-brand-greenDark text-white font-semibold h-[40px] rounded-md shadow-sm transition">
        Sign Up
      </button>

      <div class="flex items-center gap-3 py-1">
        <div class="flex-1 border-t border-gray-200 dark:border-dark-border"></div>
        <span class="text-xs text-gray-400 dark:text-dark-muted">Or continue with</span>
        <div class="flex-1 border-t border-gray-200 dark:border-dark-border"></div>
      </div>

      <div id="googleBtn" class="w-full flex justify-center min-h-[40px]"></div>
    </form>
  </div>

  <p class="text-sm text-gray-600 dark:text-dark-muted mt-6">
    Already have an account? <a href="signin" class="text-[#B12F26] hover:text-[#8F241D] font-medium transition-colors duration-200">
  Sign In.
</a>
  </p>

  <script>
    // Show a friendly error banner if signup.php sent us back with ?error=1
    if (new URLSearchParams(window.location.search).get('error') === '1') {
      document.getElementById('errorBox').classList.remove('hidden');
    }

    // Dark mode toggle (shared preference with the rest of the app)
    const htmlEl = document.documentElement;
    const iconSun = document.getElementById('iconSun');
    const iconMoon = document.getElementById('iconMoon');
    function applyTheme(isDark) {
      htmlEl.classList.toggle('dark', isDark);
      iconSun.classList.toggle('hidden', isDark);
      iconMoon.classList.toggle('hidden', !isDark);
      localStorage.setItem('invoicegen-theme', isDark ? 'dark' : 'light');
      renderGoogleButton();
    }
    const savedTheme = localStorage.getItem('invoicegen-theme');
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    applyTheme(savedTheme ? savedTheme === 'dark' : prefersDark);
    document.getElementById('themeToggle').addEventListener('click', () => {
      applyTheme(!htmlEl.classList.contains('dark'));
    });

function renderGoogleButton() {
    const container = document.getElementById('googleBtn');

    if (!container) return;

    if (!window.google || !window.google.accounts) {
        return;
    }

    container.innerHTML = '';

    google.accounts.id.initialize({
        client_id: '1091542168692-s1qlsl07p6egqo9tin6978ajm97qs08u.apps.googleusercontent.com',
        callback: handleCredentialResponse,
        context: 'signup'
    });

    google.accounts.id.renderButton(container, {
        theme: htmlEl.classList.contains('dark') ? 'filled_black' : 'outline',
        size: 'large',
        shape: 'rectangular',
        text: 'signup_with',
        logo_alignment: 'left',
        width: Math.max(container.offsetWidth, 300)
    });
}

function waitForGoogle() {
    if (window.google && window.google.accounts) {
        renderGoogleButton();
    } else {
        setTimeout(waitForGoogle, 100);
    }
}

waitForGoogle();

    // Re-render on window resize to keep it full width
    window.addEventListener('resize', renderGoogleButton);

    async function handleCredentialResponse(response) {
      const res = await fetch('api/google_login.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ credential: response.credential })
      });
      if (res.ok) {
        window.location.href = 'dashboard';
      } else {
        const data = await res.json();
        alert(data.error || 'Google Sign-Up failed');
      }
    }
  </script>
<?php require __DIR__ . '/includes/footer.php'; ?>
