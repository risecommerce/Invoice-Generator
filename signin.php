<?php
$pageTitle = 'Sign In - invoicescheduler.com';
$pageBodyAttributes = ' class="bg-gray-100 dark:bg-dark-bg min-h-screen flex flex-col items-center py-12 px-4 transition-colors duration-200"';
$pageHeader = 'none';
$pageExtraHead = <<<'HTML'
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://accounts.google.com/gsi/client" onload="renderGoogleButton()" async defer></script>
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
  .dark input::placeholder { color: #5b6b8a; }
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
</style>
HTML;
require __DIR__ . '/includes/meta.php';
require __DIR__ . '/includes/header.php';
?>
<button id="themeToggle" class="fixed top-4 right-4 w-9 h-9 flex items-center justify-center bg-white dark:bg-dark-card border border-gray-200 dark:border-dark-border rounded-full text-gray-500 dark:text-dark-muted hover:text-ink dark:hover:text-dark-text shadow-sm transition">
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
    <h1 class="text-2xl font-bold text-ink dark:text-dark-text text-center mb-2">Sign In</h1>
    <p class="text-sm text-gray-500 dark:text-dark-muted text-center mb-6">Welcome back!</p>

    <div id="errorBox" class="hidden mb-5 rounded-md border border-red-200 dark:border-red-800 bg-red-50 dark:bg-red-950/20 text-red-700 dark:text-red-300 text-sm px-4 py-3">
      Incorrect email or password. Please try again.
    </div>

    <form id="signinForm" action="signin_process.php" method="POST" class="space-y-5">
      <div>
        <label for="signinEmail" class="block text-sm text-ink dark:text-dark-text mb-1">Email</label>
        <input id="signinEmail" name="email" type="email" required class="field w-full">
      </div>

      <div>
        <div class="flex items-center justify-between mb-1">
          <label for="signinPassword" class="block text-sm text-ink dark:text-dark-text">Password</label>
          <!-- Placeholder: forgot-password flow not yet built -->
         <a href="#" class="text-md text-[#B12F26] hover:text-[#8F241D]">
  Forgot password?
</a>
        </div>
        <input id="signinPassword" name="password" type="password" required class="field w-full">
      </div>

      <label class="flex items-center gap-2 text-sm text-gray-600 dark:text-dark-muted">
        <input id="keepLoggedIn" name="keepLoggedIn" type="checkbox" checked class="w-4 h-4 rounded border-gray-300 text-brand-green focus:ring-brand-green">
        Keep me logged in
      </label>

      <button type="submit" class="w-full bg-brand-green hover:bg-brand-greenDark text-white font-semibold h-[40px] rounded-md shadow-sm transition">
        Sign In
      </button>

      <div class="flex items-center gap-3 py-1">
        <div class="flex-1 border-t border-gray-200 dark:border-dark-border"></div>
        <span class="text-xs text-gray-400 dark:text-dark-muted">Or continue with</span>
        <div class="flex-1 border-t border-gray-200 dark:border-dark-border"></div>
      </div>

      <div id="googleBtn" class="w-full flex justify-center min-h-[40px]"></div>

      <!-- Placeholder: email-link sign-in not yet built -->

    </form>
  </div>

  <p class="text-sm text-gray-600 dark:text-dark-muted mt-6">
    Don't have an account yet? <a href="signup" class="text-[#B12F26] hover:text-[#B12F26] hover:underline font-medium transition-all duration-200">
  Sign Up.
</a>
  </p>

  <script>
    // Show a friendly error banner if signin.php sent us back with ?error=1
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
      if (!container || !window.google) return;

      google.accounts.id.initialize({
        client_id: "1091542168692-s1qlsl07p6egqo9tin6978ajm97qs08u.apps.googleusercontent.com",
        callback: handleCredentialResponse,
        context: 'signin'
      });

      google.accounts.id.renderButton(container, {
        theme: htmlEl.classList.contains('dark') ? 'filled_black' : 'outline',
        size: 'large',
        shape: 'rectangular',
        text: 'signin_with',
        logo_alignment: 'left',
        width: container.offsetWidth
      });
    }

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
        alert(data.error || 'Google Sign-In failed');
      }
    }

    document.getElementById('emailLinkSignIn').addEventListener('click', () => {
      alert('Email link sign-in is not yet connected.');
    });
  </script>
<?php require __DIR__ . '/includes/footer.php'; ?>
