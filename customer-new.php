<?php
$pageTitle = 'Customer - invoicescheduler.com';
$pageBodyAttributes = ' class="bg-gray-100 dark:bg-dark-bg min-h-screen transition-colors duration-200"';
$pageHeader = 'customer-new';
$pageExtraHead = <<<'HTML'
<script src="https://cdn.tailwindcss.com"></script>
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
  .field {
    border: 1px solid #D1D5DB; border-radius: 4px; padding: 0.6rem 0.85rem;
    font-size: 0.9rem; background-color: #fff; color: #1E2838;
  }
  .field:focus { outline: none; box-shadow: 0 0 0 1px #1AA260; border-color: #1AA260; }
  .dark .field { background-color: #1c2740; border-color: #2a3650; color: #e7ebf3; }
</style>
HTML;
require __DIR__ . '/includes/meta.php';
require __DIR__ . '/includes/header.php';
?>
<main class="max-w-[900px] mx-auto px-6 py-8">
    <div class="bg-white dark:bg-dark-card border border-gray-200 dark:border-dark-border rounded-lg shadow-sm p-8">
      <h1 id="formTitle" class="text-2xl font-bold text-ink dark:text-dark-text" data-i18n="customers.newCustomer">New Customer</h1>
      <p id="formSubtitle" class="hidden text-sm text-gray-500 dark:text-dark-muted mt-1 mb-4"></p>
      <hr class="border-gray-200 dark:border-dark-border my-4">

      <div id="errorBox" class="hidden mb-5 rounded-md border border-red-200 dark:border-red-800 bg-red-50 dark:bg-red-950/20 text-red-700 dark:text-red-300 text-sm px-4 py-3"></div>

      <form id="customerForm" class="space-y-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
          <div>
            <label for="customerNameInput" class="block text-sm text-ink dark:text-dark-text mb-1">Name</label>
            <input id="customerNameInput" type="text" required class="field w-full">
          </div>
          <div>
            <label for="customerEmailInput" class="block text-sm text-ink dark:text-dark-text mb-1">Email</label>
            <input id="customerEmailInput" type="email" class="field w-full">
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
          <div>
            <label for="billToInput" class="block text-sm text-ink dark:text-dark-text mb-1" data-i18n="customers.billTo">Bill To</label>
            <textarea id="billToInput" rows="5" class="field w-full resize-none"></textarea>
          </div>
          <div>
            <label for="shipToInput" class="block text-sm text-ink dark:text-dark-text mb-1" data-i18n="customers.shipTo">Ship To</label>
            <textarea id="shipToInput" rows="5" class="field w-full resize-none"></textarea>
          </div>
        </div>

        <hr class="border-gray-200 dark:border-dark-border">

        <div class="flex gap-3">
          <button type="submit" id="saveBtn" class="bg-brand-green hover:bg-brand-greenDark text-white font-semibold px-5 py-2.5 rounded-md">Save</button>
          <a id="cancelBtn" href="customers" class="border border-gray-300 dark:border-dark-border text-ink dark:text-dark-text px-5 py-2.5 rounded-md hover:bg-gray-50 dark:hover:bg-dark-border" data-i18n="actions.cancel">Cancel</a>
        </div>
      </form>
    </div>
  </main>

  <script src="assets/theme-lang.js"></script>
  <script>
    const params = new URLSearchParams(window.location.search);
    const editId = params.get('id');

    if (editId) {
      document.getElementById('formTitle').textContent = 'Edit';
      document.getElementById('formTitle').removeAttribute('data-i18n');
      document.getElementById('cancelBtn').href = `customer-view?id=${editId}`;
      fetch(`api/get_customer.php?id=${editId}`).then(r => r.json()).then(data => {
        document.getElementById('customerNameInput').value = data.name || '';
        document.getElementById('customerEmailInput').value = data.email || '';
        document.getElementById('billToInput').value = data.billTo || '';
        document.getElementById('shipToInput').value = data.shipTo || '';
        const subtitle = document.getElementById('formSubtitle');
        subtitle.textContent = data.name || '';
        subtitle.classList.remove('hidden');
      });
    }

    document.getElementById('customerForm').addEventListener('submit', async (e) => {
      e.preventDefault();
      const errorBox = document.getElementById('errorBox');
      errorBox.classList.add('hidden');

      const payload = {
        name: document.getElementById('customerNameInput').value.trim(),
        email: document.getElementById('customerEmailInput').value.trim(),
        billTo: document.getElementById('billToInput').value,
        shipTo: document.getElementById('shipToInput').value,
      };
      if (editId) payload.id = editId;

      const res = await fetch(editId ? 'api/update_customer.php' : 'api/save_customer.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload)
      });
      const data = await res.json();

      if (!res.ok) {
        errorBox.textContent = data.error || 'Something went wrong.';
        errorBox.classList.remove('hidden');
        return;
      }

      window.location.href = `customer-view?id=${editId || data.id}`;
    });
  </script>
<?php require __DIR__ . '/includes/footer.php'; ?>
