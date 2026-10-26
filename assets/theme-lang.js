// assets/theme-lang.js
// Shared across dashboard.html, invoice-view.html, send-invoice.html, and
// public-invoice.php so the dark mode toggle and language selector behave
// identically everywhere, using the same localStorage keys as index.html.
(function () {
  const KEY_THEME = 'invoicegen-theme';
  const KEY_LANG = 'invoicegen-language';

  function applyTheme(isDark) {
    document.documentElement.classList.toggle('dark', isDark);
    localStorage.setItem(KEY_THEME, isDark ? 'dark' : 'light');
    const sun = document.getElementById('iconSun');
    const moon = document.getElementById('iconMoon');
    if (sun && moon) {
      sun.classList.toggle('hidden', isDark);
      moon.classList.toggle('hidden', !isDark);
    }
  }

  function initTheme() {
    const saved = localStorage.getItem(KEY_THEME);
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    applyTheme(saved ? saved === 'dark' : prefersDark);
    const toggle = document.getElementById('themeToggle');
    if (toggle) {
      toggle.addEventListener('click', () => {
        applyTheme(!document.documentElement.classList.contains('dark'));
      });
    }
  }

  const LANGUAGES = [
    'dansk', 'Deutsch', 'English', 'español', 'français', 'Indonesia',
    'italiano', 'Nederlands', 'norsk', 'polski', 'português', 'română',
    'svenska', 'ไทย', 'Türkçe', 'українська'
  ];

  const BASE = {
    'lang.title': 'Change Language',
    'nav.history': 'History',
    'nav.guides': 'Guides',
    'nav.help': 'Help',
    'nav.myInvoices': 'My Invoices',
    'nav.customers': 'Customers',
    'nav.settings': 'Settings',
    'nav.products': 'Products',
    'nav.upgrade': 'Upgrade',
    'account.myAccount': 'My Account',
    'account.switchAccount': 'Switch Account',
    'account.signOut': 'Sign Out',
    'actions.import': 'Import',
    'actions.export': 'Export',
    'actions.newInvoice': 'New Invoice',
    'actions.invoice': 'Invoice',
    'actions.send': 'Send',
    'actions.download': 'Download',
    'actions.downloadInvoice': 'Download invoice',
    'actions.view': 'View',
    'actions.edit': 'Edit',
    'actions.duplicate': 'Duplicate',
    'actions.delete': 'Delete',
    'actions.markPaid': 'Mark as Paid',
    'actions.restore': 'Restore',
    'actions.deletePermanently': 'Delete Permanently',
    'actions.cancel': 'Cancel',
    'dashboard.title': 'My Invoices',
    'dashboard.deletedSubtitle': 'View Deleted Invoices',
    'dashboard.viewActive': 'View Active Invoices',
    'dashboard.paymentsTitle': 'Get paid faster',
    'dashboard.paymentsText': 'Enable online payments so clients can pay invoices instantly by card or bank transfer.',
    'dashboard.enablePayments': 'Enable payments',
    'dashboard.notNow': 'Not now',
    'dashboard.loading': 'Loading invoices...',
    'dashboard.empty': 'No Invoices found.',
    'dashboard.reference': 'Reference',
    'dashboard.customer': 'Customer',
    'dashboard.date': 'Date',
    'dashboard.dueDate': 'Due Date',
    'dashboard.status': 'Status',
    'dashboard.total': 'Total',
    'dashboard.perPage': 'Per page',
    'dashboard.totalRecords': 'Total {count} records',
    'dashboard.invoiceNumber': 'Invoice #{number}',
    'dashboard.deleted': 'Deleted',
    'dashboard.imported': 'Imported {count} invoice(s).',
    'invoice.loading': 'Loading invoice...',
    'invoice.title': 'INVOICE',
    'invoice.billTo': 'Bill To',
    'invoice.shipTo': 'Ship To',
    'invoice.payment': 'Payment',
    'invoice.paymentTerms': 'Payment Terms',
    'invoice.poNumber': 'PO Number',
    'invoice.details': 'Details',
    'invoice.notes': 'Notes',
    'invoice.terms': 'Terms',
    'invoice.titleNumber': 'Invoice #{number}',
    'invoice.amountDue': 'Amount Due',
    'invoice.dueDate': 'Due Date',
    'invoice.total': 'Total',
    'invoice.collectFaster': 'Collect {amount} faster',
    'invoice.noOnlinePayments': 'This invoice does not accept online payments yet.',
    'invoice.acceptCard': 'Accept card and bank payments',
    'invoice.securePay': 'Give clients a secure way to pay',
    'invoice.trackStatus': 'Track payment status automatically',
    'invoice.payments': 'Payments',
    'invoice.noPayments': 'No Payments found.',
    'invoice.publicFrom': 'Invoice #{number} from {sender}',
    'invoice.publicNoPayment': 'Online payment is not available for this invoice.',
    'table.item': 'Item',
    'table.quantity': 'Quantity',
    'table.rate': 'Rate',
    'table.amount': 'Amount',
    'totals.subtotal': 'Subtotal',
    'totals.tax': 'Tax',
    'totals.discount': 'Discount',
    'totals.shipping': 'Shipping',
    'totals.total': 'Total',
    'totals.amountPaid': 'Amount Paid',
    'totals.balanceDue': 'Balance Due',
    'send.title': 'Send by Email',
    'send.recipientEmail': 'Recipient Email',
    'send.recipientName': 'Recipient Name',
    'send.emailHelp': 'The email address where the document will be sent.',
    'send.message': 'Message',
    'send.messagePlaceholder': 'Add a personal message (optional)',
    'send.messageHelp': 'Add a personal message to include in the email (optional).',
    'send.sendEmail': 'Send Email',
    'send.sending': 'Sending...',
    'send.includes': 'The email will include',
    'send.includeLink': 'Link to view and pay Invoice',
    'send.includePdf': 'Invoice as a PDF attachment',
    'send.includeReply': 'Your email as the reply-to address',
    'send.remaining': 'You have {remaining} of {limit} email sends remaining this month.',
    'alert.loadInvoice': 'Could not load that invoice.',
    'alert.deleteConfirm': 'Move this invoice to Deleted Invoices?',
    'alert.deleteFailed': 'Could not delete the invoice.',
    'alert.restoreFailed': 'Could not restore the invoice.',
    'alert.updateFailed': 'Could not update the invoice.',
    'alert.importFailed': 'Import failed.',
    'alert.sendFailed': 'Could not send the invoice.',
    'alert.sendError': 'Something went wrong while sending. Please try again.',
    'customers.loading': 'Loading customer…',
    'customers.loadingList': 'Loading customers…',
    'customers.noCustomers': "No customers found yet. They'll appear here once you save an invoice.",
    'customers.invoices': 'Invoices',
    'customers.invoicesHeading': 'Invoices',
    'customers.payments': 'Payments',
    'customers.totalInvoiced': 'Total Invoiced',
    'customers.totalPaid': 'Total Paid',
    'customers.details': 'Details',
    'customers.created': 'Created',
    'customers.billTo': 'Bill To',
    'customers.shipTo': 'Ship To',
    'customers.new': 'New',
    'customers.noPayments': 'No Payments found.',
    'customers.newCustomer': 'New Customer',
    'customers.newInvoice': 'New Invoice',
    'customers.deletedSubtitle': 'View Deleted Customers',
    'customers.viewActive': 'View active customers',
    'customers.deleteConfirm': 'Move this customer to Deleted Customers?'
  };

  const WORDS = {
    English: {},
    'español': {
      'lang.title': 'Cambiar idioma', 'nav.myInvoices': 'Mis facturas', 'nav.customers': 'Clientes', 'nav.settings': 'ConfiguraciÃ³n', 'nav.products': 'Productos', 'nav.upgrade': 'Actualizar', 'account.myAccount': 'Mi cuenta', 'account.switchAccount': 'Cambiar cuenta', 'account.signOut': 'Cerrar sesiÃ³n',
      'actions.import': 'Importar', 'actions.export': 'Exportar', 'actions.newInvoice': 'Nueva factura', 'actions.invoice': 'Factura', 'actions.send': 'Enviar', 'actions.download': 'Descargar', 'actions.downloadInvoice': 'Descargar factura', 'actions.view': 'Ver', 'actions.edit': 'Editar', 'actions.duplicate': 'Duplicar', 'actions.delete': 'Eliminar', 'actions.markPaid': 'Marcar como pagada', 'actions.restore': 'Restaurar', 'actions.deletePermanently': 'Eliminar permanentemente', 'actions.cancel': 'Cancelar',
      'dashboard.title': 'Mis facturas', 'dashboard.deletedSubtitle': 'Ver facturas eliminadas', 'dashboard.viewActive': 'Ver facturas activas', 'dashboard.paymentsTitle': 'Cobra mÃ¡s rÃ¡pido', 'dashboard.paymentsText': 'Activa pagos en lÃ­nea para que los clientes paguen facturas al instante con tarjeta o transferencia bancaria.', 'dashboard.enablePayments': 'Activar pagos', 'dashboard.notNow': 'Ahora no', 'dashboard.loading': 'Cargando facturas...', 'dashboard.empty': 'No se encontraron facturas.', 'dashboard.reference': 'Referencia', 'dashboard.customer': 'Cliente', 'dashboard.date': 'Fecha', 'dashboard.dueDate': 'Vencimiento', 'dashboard.status': 'Estado', 'dashboard.total': 'Total', 'dashboard.perPage': 'Por pÃ¡gina', 'dashboard.totalRecords': 'Total {count} registros', 'dashboard.invoiceNumber': 'Factura #{number}', 'dashboard.deleted': 'Eliminada', 'dashboard.imported': '{count} factura(s) importada(s).',
      'invoice.loading': 'Cargando factura...', 'invoice.titleNumber': 'Factura #{number}', 'invoice.amountDue': 'Importe adeudado', 'invoice.dueDate': 'Fecha de vencimiento', 'invoice.total': 'Total', 'invoice.collectFaster': 'Cobra {amount} mÃ¡s rÃ¡pido', 'invoice.noOnlinePayments': 'Esta factura aÃºn no acepta pagos en lÃ­nea.', 'invoice.acceptCard': 'Acepta pagos con tarjeta y banco', 'invoice.securePay': 'Ofrece a los clientes una forma segura de pagar', 'invoice.trackStatus': 'Rastrea el estado del pago automÃ¡ticamente', 'invoice.payments': 'Pagos', 'invoice.noPayments': 'No se encontraron pagos.', 'invoice.publicFrom': 'Factura #{number} de {sender}', 'invoice.publicNoPayment': 'El pago en lÃ­nea no estÃ¡ disponible para esta factura.',
      'send.title': 'Enviar por correo', 'send.recipientEmail': 'Correo del destinatario', 'send.recipientName': 'Nombre del destinatario', 'send.emailHelp': 'La direcciÃ³n de correo donde se enviarÃ¡ el documento.', 'send.message': 'Mensaje', 'send.messagePlaceholder': 'Agrega un mensaje personal (opcional)', 'send.messageHelp': 'Agrega un mensaje personal para incluir en el correo (opcional).', 'send.sendEmail': 'Enviar correo', 'send.sending': 'Enviando...', 'send.includes': 'El correo incluirÃ¡', 'send.includeLink': 'Enlace para ver y pagar la factura', 'send.includePdf': 'Factura como PDF adjunto', 'send.includeReply': 'Tu correo como direcciÃ³n de respuesta', 'send.remaining': 'Te quedan {remaining} de {limit} envÃ­os de correo este mes.'
    },
    'français': { 'lang.title': 'Changer de langue', 'nav.myInvoices': 'Mes factures', 'nav.customers': 'Clients', 'nav.settings': 'ParamÃ¨tres', 'nav.products': 'Produits', 'nav.upgrade': 'Mettre Ã  niveau', 'account.myAccount': 'Mon compte', 'account.switchAccount': 'Changer de compte', 'account.signOut': 'Se dÃ©connecter', 'actions.import': 'Importer', 'actions.export': 'Exporter', 'actions.newInvoice': 'Nouvelle facture', 'actions.invoice': 'Facture', 'actions.send': 'Envoyer', 'actions.download': 'TÃ©lÃ©charger', 'actions.downloadInvoice': 'TÃ©lÃ©charger la facture', 'actions.view': 'Voir', 'actions.edit': 'Modifier', 'actions.duplicate': 'Dupliquer', 'actions.delete': 'Supprimer', 'actions.markPaid': 'Marquer comme payÃ©e', 'actions.restore': 'Restaurer', 'actions.deletePermanently': 'Supprimer dÃ©finitivement', 'actions.cancel': 'Annuler', 'dashboard.title': 'Mes factures', 'dashboard.deletedSubtitle': 'Voir les factures supprimÃ©es', 'dashboard.viewActive': 'Voir les factures actives', 'dashboard.loading': 'Chargement des factures...', 'dashboard.empty': 'Aucune facture trouvÃ©e.', 'dashboard.reference': 'RÃ©fÃ©rence', 'dashboard.customer': 'Client', 'dashboard.date': 'Date', 'dashboard.dueDate': 'Ã‰chÃ©ance', 'dashboard.status': 'Statut', 'dashboard.total': 'Total', 'dashboard.perPage': 'Par page', 'dashboard.deleted': 'SupprimÃ©e', 'invoice.loading': 'Chargement de la facture...', 'invoice.amountDue': 'Montant dÃ»', 'invoice.dueDate': 'Date dâ€™Ã©chÃ©ance', 'invoice.total': 'Total', 'invoice.payments': 'Paiements', 'invoice.noPayments': 'Aucun paiement trouvÃ©.', 'send.title': 'Envoyer par e-mail', 'send.recipientEmail': 'E-mail du destinataire', 'send.recipientName': 'Nom du destinataire', 'send.message': 'Message', 'send.sendEmail': 'Envoyer l’e-mail', 'send.sending': 'Envoi...', 'send.includes': 'L’e-mail inclura' },
    Deutsch: { 'lang.title': 'Sprache Ã¤ndern', 'nav.myInvoices': 'Meine Rechnungen', 'nav.customers': 'Kunden', 'nav.settings': 'Einstellungen', 'nav.products': 'Produkte', 'nav.upgrade': 'Upgrade', 'account.myAccount': 'Mein Konto', 'account.switchAccount': 'Konto wechseln', 'account.signOut': 'Abmelden', 'actions.import': 'Importieren', 'actions.export': 'Exportieren', 'actions.newInvoice': 'Neue Rechnung', 'actions.invoice': 'Rechnung', 'actions.send': 'Senden', 'actions.download': 'Herunterladen', 'actions.downloadInvoice': 'Rechnung herunterladen', 'actions.view': 'Ansehen', 'actions.edit': 'Bearbeiten', 'actions.duplicate': 'Duplizieren', 'actions.delete': 'LÃ¶schen', 'actions.markPaid': 'Als bezahlt markieren', 'actions.restore': 'Wiederherstellen', 'actions.deletePermanently': 'EndgÃ¼ltig lÃ¶schen', 'actions.cancel': 'Abbrechen', 'dashboard.title': 'Meine Rechnungen', 'dashboard.deletedSubtitle': 'GelÃ¶schte Rechnungen anzeigen', 'dashboard.viewActive': 'Aktive Rechnungen anzeigen', 'dashboard.loading': 'Rechnungen werden geladen...', 'dashboard.empty': 'Keine Rechnungen gefunden.', 'dashboard.reference': 'Referenz', 'dashboard.customer': 'Kunde', 'dashboard.date': 'Datum', 'dashboard.dueDate': 'FÃ¤lligkeit', 'dashboard.status': 'Status', 'dashboard.total': 'Gesamt', 'dashboard.perPage': 'Pro Seite', 'dashboard.deleted': 'GelÃ¶scht', 'invoice.loading': 'Rechnung wird geladen...', 'invoice.amountDue': 'FÃ¤lliger Betrag', 'invoice.dueDate': 'FÃ¤lligkeitsdatum', 'invoice.total': 'Gesamt', 'invoice.payments': 'Zahlungen', 'invoice.noPayments': 'Keine Zahlungen gefunden.', 'send.title': 'Per E-Mail senden', 'send.recipientEmail': 'EmpfÃ¤nger-E-Mail', 'send.recipientName': 'EmpfÃ¤ngername', 'send.message': 'Nachricht', 'send.sendEmail': 'E-Mail senden', 'send.sending': 'Wird gesendet...', 'send.includes': 'Die E-Mail enthÃ¤lt' },
    italiano: { 'lang.title': 'Cambia lingua', 'nav.myInvoices': 'Le mie fatture', 'nav.customers': 'Clienti', 'nav.settings': 'Impostazioni', 'nav.products': 'Prodotti', 'nav.upgrade': 'Aggiorna', 'account.myAccount': 'Il mio account', 'account.switchAccount': 'Cambia account', 'account.signOut': 'Esci', 'actions.import': 'Importa', 'actions.export': 'Esporta', 'actions.newInvoice': 'Nuova fattura', 'actions.invoice': 'Fattura', 'actions.send': 'Invia', 'actions.download': 'Scarica', 'actions.downloadInvoice': 'Scarica fattura', 'actions.view': 'Visualizza', 'actions.edit': 'Modifica', 'actions.duplicate': 'Duplica', 'actions.delete': 'Elimina', 'actions.markPaid': 'Segna come pagata', 'actions.restore': 'Ripristina', 'actions.deletePermanently': 'Elimina definitivamente', 'actions.cancel': 'Annulla', 'dashboard.title': 'Le mie fatture', 'dashboard.deletedSubtitle': 'Vedi fatture eliminate', 'dashboard.viewActive': 'Vedi fatture attive', 'dashboard.loading': 'Caricamento fatture...', 'dashboard.empty': 'Nessuna fattura trovata.', 'dashboard.reference': 'Riferimento', 'dashboard.customer': 'Cliente', 'dashboard.date': 'Data', 'dashboard.dueDate': 'Scadenza', 'dashboard.status': 'Stato', 'dashboard.total': 'Totale', 'dashboard.perPage': 'Per pagina', 'dashboard.deleted': 'Eliminata', 'invoice.loading': 'Caricamento fattura...', 'invoice.amountDue': 'Importo dovuto', 'invoice.dueDate': 'Data di scadenza', 'invoice.total': 'Totale', 'invoice.payments': 'Pagamenti', 'invoice.noPayments': 'Nessun pagamento trovato.', 'send.title': 'Invia via email', 'send.recipientEmail': 'Email destinatario', 'send.recipientName': 'Nome destinatario', 'send.message': 'Messaggio', 'send.sendEmail': 'Invia email', 'send.sending': 'Invio...', 'send.includes': 'L’email includerÃ ' }
  };

  const commonByLanguage = {
    dansk: ['Mine fakturaer','Kunder','Indstillinger','Produkter','Importer','Eksporter','Ny faktura','Faktura','Send','Download','Rediger','Slet','Gendan','Annuller','Indlæser fakturaer...','Ingen fakturaer fundet.','Reference','Kunde','Dato','Forfaldsdato','Status','Total','Pr. side','Betalinger','Send via e-mail','Modtagerens e-mail','Modtagerens navn','Besked','Send e-mail'],
    Indonesia: ['Faktur saya','Pelanggan','Pengaturan','Produk','Impor','Ekspor','Faktur baru','Faktur','Kirim','Unduh','Edit','Hapus','Pulihkan','Batal','Memuat faktur...','Tidak ada faktur ditemukan.','Referensi','Pelanggan','Tanggal','Jatuh Tempo','Status','Total','Per halaman','Pembayaran','Kirim lewat email','Email penerima','Nama penerima','Pesan','Kirim Email'],
    Nederlands: ['Mijn facturen','Klanten','Instellingen','Producten','Importeren','Exporteren','Nieuwe factuur','Factuur','Verzenden','Downloaden','Bewerken','Verwijderen','Herstellen','Annuleren','Facturen laden...','Geen facturen gevonden.','Referentie','Klant','Datum','Vervaldatum','Status','Totaal','Per pagina','Betalingen','Per e-mail verzenden','E-mail ontvanger','Naam ontvanger','Bericht','E-mail verzenden'],
    norsk: ['Mine fakturaer','Kunder','Innstillinger','Produkter','Importer','Eksporter','Ny faktura','Faktura','Send','Last ned','Rediger','Slett','Gjenopprett','Avbryt','Laster fakturaer...','Ingen fakturaer funnet.','Referanse','Kunde','Dato','Forfallsdato','Status','Total','Per side','Betalinger','Send via e-post','Mottakers e-post','Mottakers navn','Melding','Send e-post'],
    polski: ['Moje faktury','Klienci','Ustawienia','Produkty','Importuj','Eksportuj','Nowa faktura','Faktura','Wyślij','Pobierz','Edytuj','Usuń','Przywróć','Anuluj','Ładowanie faktur...','Nie znaleziono faktur.','Referencja','Klient','Data','Termin płatności','Status','Razem','Na stronę','Płatności','Wyślij e-mailem','E-mail odbiorcy','Nazwa odbiorcy','Wiadomość','Wyślij e-mail'],
    'português': ['Minhas faturas','Clientes','Configurações','Produtos','Importar','Exportar','Nova fatura','Fatura','Enviar','Baixar','Editar','Excluir','Restaurar','Cancelar','Carregando faturas...','Nenhuma fatura encontrada.','Referência','Cliente','Data','Vencimento','Status','Total','Por página','Pagamentos','Enviar por e-mail','E-mail do destinatário','Nome do destinatário','Mensagem','Enviar e-mail'],
    'română': ['Facturile mele','Clienți','Setări','Produse','Importă','Exportă','Factură nouă','Factură','Trimite','Descarcă','Editează','Șterge','Restaurează','Anulează','Se încarcă facturile...','Nu s-au găsit facturi.','Referință','Client','Data','Scadență','Stare','Total','Pe pagină','Plăți','Trimite prin e-mail','E-mail destinatar','Nume destinatar','Mesaj','Trimite e-mail'],
    svenska: ['Mina fakturor','Kunder','Inställningar','Produkter','Importera','Exportera','Ny faktura','Faktura','Skicka','Ladda ner','Redigera','Ta bort','Återställ','Avbryt','Laddar fakturor...','Inga fakturor hittades.','Referens','Kund','Datum','Förfallodatum','Status','Total','Per sida','Betalningar','Skicka via e-post','Mottagarens e-post','Mottagarens namn','Meddelande','Skicka e-post'],
    'Türkçe': ['Faturalarım','Müşteriler','Ayarlar','Ürünler','İçe aktar','Dışa aktar','Yeni fatura','Fatura','Gönder','İndir','Düzenle','Sil','Geri yükle','İptal','Faturalar yükleniyor...','Fatura bulunamadı.','Referans','Müşteri','Tarih','Vade tarihi','Durum','Toplam','Sayfa başına','Ödemeler','E-posta ile gönder','Alıcı e-postası','Alıcı adı','Mesaj','E-posta gönder'],
    'ไทย': ['ใบแจ้งหนี้ของฉัน','ลูกค้า','การตั้งค่า','สินค้า','นำเข้า','ส่งออก','ใบแจ้งหนี้ใหม่','ใบแจ้งหนี้','ส่ง','ดาวน์โหลด','แก้ไข','ลบ','กู้คืน','ยกเลิก','กำลังโหลดใบแจ้งหนี้...','ไม่พบใบแจ้งหนี้','อ้างอิง','ลูกค้า','วันที่','วันครบกำหนด','สถานะ','รวม','ต่อหน้า','การชำระเงิน','ส่งทางอีเมล','อีเมลผู้รับ','ชื่อผู้รับ','ข้อความ','ส่งอีเมล'],
    'українська': ['Мої рахунки','Клієнти','Налаштування','Продукти','Імпорт','Експорт','Новий рахунок','Рахунок','Надіслати','Завантажити','Редагувати','Видалити','Відновити','Скасувати','Завантаження рахунків...','Рахунків не знайдено.','Посилання','Клієнт','Дата','Термін оплати','Статус','Разом','На сторінку','Платежі','Надіслати email','Email отримувача','Ім’я отримувача','Повідомлення','Надіслати email']
  };

  const commonKeys = ['nav.myInvoices','nav.customers','nav.settings','nav.products','actions.import','actions.export','actions.newInvoice','actions.invoice','actions.send','actions.download','actions.edit','actions.delete','actions.restore','actions.cancel','dashboard.loading','dashboard.empty','dashboard.reference','dashboard.customer','dashboard.date','dashboard.dueDate','dashboard.status','dashboard.total','dashboard.perPage','invoice.payments','send.title','send.recipientEmail','send.recipientName','send.message','send.sendEmail'];
  Object.entries(commonByLanguage).forEach(([lang, values]) => {
    WORDS[lang] = WORDS[lang] || {};
    commonKeys.forEach((key, index) => {
      WORDS[lang][key] = values[index];
    });
    WORDS[lang]['dashboard.title'] = values[0];
    WORDS[lang]['invoice.loading'] = values[14].replace('fakturaer', 'faktura').replace('invoices', 'invoice');
    WORDS[lang]['invoice.amountDue'] = values[22];
    WORDS[lang]['invoice.dueDate'] = values[19];
    WORDS[lang]['invoice.total'] = values[22];
    WORDS[lang]['actions.downloadInvoice'] = `${values[9]} ${values[7]}`;
    WORDS[lang]['actions.duplicate'] = BASE['actions.duplicate'];
    WORDS[lang]['actions.markPaid'] = BASE['actions.markPaid'];
    WORDS[lang]['send.sending'] = `${values[28]}...`;
    WORDS[lang]['send.includes'] = BASE['send.includes'];
  });

  ['dansk', 'Indonesia', 'Nederlands', 'norsk', 'polski', 'português', 'română', 'svenska', 'ไทย', 'Türkçe', 'українська'].forEach(lang => {
    WORDS[lang] = WORDS[lang] || {};
  });

  function currentLang() {
    return localStorage.getItem(KEY_LANG) || 'English';
  }

  function t(key, vars) {
    const lang = currentLang();
    let text = (WORDS[lang] && WORDS[lang][key]) || BASE[key] || key;
    if (vars) {
      Object.keys(vars).forEach(name => {
        text = text.replace(new RegExp(`\\{${name}\\}`, 'g'), vars[name]);
      });
    }
    return text;
  }

  function translatePage() {
    document.querySelectorAll('[data-i18n]').forEach(el => {
      const text = t(el.dataset.i18n);
      if (text) el.textContent = text;
    });
    document.querySelectorAll('[data-i18n-placeholder]').forEach(el => {
      const text = t(el.dataset.i18nPlaceholder);
      if (text) el.placeholder = text;
    });
    document.querySelectorAll('[data-i18n-title]').forEach(el => {
      const text = t(el.dataset.i18nTitle);
      if (text) el.title = text;
    });
    document.documentElement.lang = currentLang() === 'English' ? 'en' : currentLang();
  }

  function buildLangModal() {
    if (document.getElementById('langModal')) return document.getElementById('langModal');
    const modal = document.createElement('div');
    modal.id = 'langModal';
    modal.className = 'fixed inset-0 z-50 hidden items-center justify-center bg-black/40 px-4';
    modal.innerHTML = `
      <div class="bg-white dark:bg-dark-card rounded-md shadow-xl w-full max-w-lg p-6 relative">
        <div class="flex items-center justify-between mb-5">
          <h2 class="text-xl font-bold text-ink dark:text-dark-text" data-i18n="lang.title">${t('lang.title')}</h2>
          <button id="langClose" class="text-gray-400 hover:text-gray-600 dark:text-dark-muted dark:hover:text-dark-text text-2xl leading-none">&times;</button>
        </div>
        <hr class="border-gray-200 dark:border-dark-border mb-5">
        <div id="langGrid" class="grid grid-cols-2 sm:grid-cols-3 gap-x-4 gap-y-4 text-sm"></div>
      </div>`;
    document.body.appendChild(modal);

    const grid = modal.querySelector('#langGrid');
    let selected = currentLang();

    function render() {
      grid.innerHTML = '';
      LANGUAGES.forEach(lang => {
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.textContent = lang;
        const isSelected = lang === selected;
        btn.className = isSelected
          ? 'text-left px-3 py-2 rounded-md bg-brand-greenSoft dark:bg-brand-green/20 text-brand-greenDark dark:text-brand-green font-medium'
          : 'text-left px-3 py-2 rounded-md text-gray-700 dark:text-dark-muted hover:bg-gray-100 dark:hover:bg-dark-field transition';
        btn.addEventListener('click', () => {
          selected = lang;
          localStorage.setItem(KEY_LANG, lang);
          translatePage();
          window.dispatchEvent(new CustomEvent('invoicegen:languagechange', { detail: { language: lang } }));
          render();
          setTimeout(() => modal.classList.add('hidden'), 150);
        });
        grid.appendChild(btn);
      });
    }
    render();

    modal.querySelector('#langClose').addEventListener('click', () => modal.classList.add('hidden'));
    modal.addEventListener('click', (e) => { if (e.target === modal) modal.classList.add('hidden'); });
    return modal;
  }

  function initLanguage() {
    translatePage();
    const btn = document.getElementById('langBtn');
    if (!btn) return;
    btn.addEventListener('click', () => {
      const modal = buildLangModal();
      translatePage();
      modal.classList.remove('hidden');
      modal.classList.add('flex');
    });
  }

  window.InvoiceGenI18n = { t, translatePage, currentLang };

  document.addEventListener('DOMContentLoaded', () => {
    initTheme();
    initLanguage();
  });
})();
