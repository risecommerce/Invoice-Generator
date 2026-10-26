// assets/invoice-pdf.js
// Requires html2pdf.js to already be loaded on the page, and a hidden
// container element (e.g. <div id="printInvoice" style="position:absolute; left:-9999px; width:210mm;"></div>)
// This mirrors index.html's renderPrintableInvoice()/download logic exactly,
// so PDFs generated from the dashboard/view/send/public pages look identical
// to the ones generated on the invoice editor.

const InvoicePdf = (() => {
  function parseNum(v) {
    if (v === null || v === undefined) return 0;
    v = String(v).replace(/[^0-9.\-]/g, '');
    const n = parseFloat(v);
    return isNaN(n) ? 0 : n;
  }

  function getCurrencyCode(currencyString) {
    return String(currencyString || 'USD').split(' ')[0];
  }

  function escapeHtml(str) {
    return String(str || '').replace(/[&<>"']/g, (c) => ({
      '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
    }[c]));
  }

  function t(key, vars) {
    return window.InvoiceGenI18n?.t(key, vars) || key;
  }

  function linkifyText(rawLine) {
    const line = String(rawLine || '');
    const urlRegex = /(https?:\/\/[^\s]+)|(www\.[^\s]+)/gi;
    let result = '';
    let lastIndex = 0;
    let match;
    while ((match = urlRegex.exec(line)) !== null) {
      const matchedText = match[0].replace(/[.,;:)]+$/, '');
      const start = match.index;
      result += escapeHtml(line.slice(lastIndex, start));
      const href = /^https?:\/\//i.test(matchedText) ? matchedText : `https://${matchedText}`;
      result += `<a href="${escapeHtml(href)}" style="color:#1AA260;" target="_blank" rel="noopener">${escapeHtml(matchedText)}</a>`;
      lastIndex = start + matchedText.length;
    }
    result += escapeHtml(line.slice(lastIndex));
    return result;
  }

  function themeColors(theme) {
    if (theme === 'dark') {
      return {
        pageBg: '#141d33', headerRule: '#3a4763', border: '#2a3650',
        textPrimary: '#e7ebf3', textSecondary: '#b9c2d6', textMuted: '#8492ac',
        link: '#44d98a',
      };
    }
    return {
      pageBg: '#ffffff', headerRule: '#6B7280', border: '#E5E7EB',
      textPrimary: '#111827', textSecondary: '#374151', textMuted: '#6B7280',
      link: '#1AA260',
    };
  }

  function renderHtml(data, theme) {
    const c = themeColors(theme);
    const lineRows = (data.lineItems || []).map(item => {
      const descriptionLines = String(item.description || '').split('\n').map((line, idx) => {
        const content = linkifyText(line);
        return idx === 0
          ? `<div style="font-weight:700; color:${c.textPrimary};">${content}</div>`
          : `<div>${content}</div>`;
      }).join('');
      return `
      <tr>
        <td style="padding:10px 12px; border-bottom:1px solid ${c.border}; font-size:13px; color:${c.textSecondary}; text-align:left;">${descriptionLines}</td>
        <td style="padding:10px 12px; border-bottom:1px solid ${c.border}; font-size:13px; color:${c.textSecondary}; text-align:right;">${escapeHtml(item.quantity)}</td>
        <td style="padding:10px 12px; border-bottom:1px solid ${c.border}; font-size:13px; color:${c.textSecondary}; text-align:right;">${getCurrencyCode(data.currency)} ${parseNum(item.rate).toFixed(2)}</td>
        <td style="padding:10px 12px; border-bottom:1px solid ${c.border}; font-size:13px; color:${c.textSecondary}; text-align:right;">${escapeHtml(item.amount)}</td>
      </tr>`;
    }).join('');

    const logoHtml = data.uploadedLogoData
      ? `<img src="${data.uploadedLogoData}" alt="Logo" style="max-width:140px; max-height:90px; object-fit:contain;"/>`
      : '';

    const totalsRow = (label, value, bold) => `
      <div style="display:flex; justify-content:space-between; padding:6px 0; font-size:13px; ${bold ? 'font-weight:700;' : ''} color:${c.textPrimary};">
        <span>${label}</span><span>${value}</span>
      </div>`;

    return `
      <div style="width:100%; box-sizing:border-box; padding:32px; background:${c.pageBg}; color:${c.textPrimary}; font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Helvetica, Arial, sans-serif; font-size:13px;">
        <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:24px;">
          <div style="display:flex; align-items:center; gap:16px;">
            ${logoHtml}
            <div style="font-size:13px; color:${c.textSecondary}; line-height:1.5; min-width:0;">
              ${String(data.billFrom || '').split('\n').map((line, idx) => {
                const content = linkifyText(line);
                return idx === 0
                  ? `<div style="font-weight:700; color:${c.textPrimary}; font-size:14px; white-space:wrap;">${content}</div>`
                  : `<div>${content}</div>`;
              }).join('')}
            </div>
          </div>
          <div style="text-align:right; white-space:nowrap;">
            <span style="font-size:16px; font-weight:700; color:${c.textPrimary};">#</span>
            <span style="font-size:16px; font-weight:700; color:${c.textPrimary}; margin-left:4px;">${escapeHtml(data.invoiceNumber || data.poNumber || 'INV-0001')}</span>
            <p style="margin:4px 0 0; font-size:13px; color:${c.textMuted};">${escapeHtml(data.invoiceDate)}</p>
          </div>
        </div>
        <div style="border-top:3px solid ${c.headerRule}; margin-bottom:24px;"></div>
        <h1 style="font-size:32px; font-weight:700; color:${c.textPrimary}; margin:0 0 24px;">${escapeHtml(t('invoice.title'))}</h1>
        <div style="display:flex; gap:32px; margin-bottom:24px; font-size:13px; color:${c.textSecondary};">
          <div style="flex:1; min-width:0;">
            <p style="margin:0 0 6px; font-weight:700; color:${c.textMuted}; font-size:11px; text-transform:uppercase; letter-spacing:0.05em;">${escapeHtml(t('invoice.billTo'))}</p>
            <p style="margin:0; line-height:1.5;">${escapeHtml(data.billTo).replace(/\n/g, '<br>')}</p>
          </div>
          <div style="flex:1; min-width:0;">
            <p style="margin:0 0 6px; font-weight:700; color:${c.textMuted}; font-size:11px; text-transform:uppercase; letter-spacing:0.05em;">${escapeHtml(t('invoice.shipTo'))}</p>
            <p style="margin:0; line-height:1.5;">${escapeHtml(data.shipTo).replace(/\n/g, '<br>')}</p>
          </div>
          <div style="flex:0 0 260px; text-align:right; min-width:260px;">
            <p style="margin:0 0 6px; font-weight:700; color:${c.textMuted}; font-size:11px; text-transform:uppercase; letter-spacing:0.05em;">${escapeHtml(t('invoice.payment'))}</p>
            <p style="margin:0; line-height:1.6;">${escapeHtml(t('invoice.dueDate'))}: ${escapeHtml(data.dueDate)}</p>
            <p style="margin:0; line-height:1.6;">${escapeHtml(t('invoice.paymentTerms'))}: ${escapeHtml(data.paymentTerms)}</p>
            <p style="margin:18px 0 6px; font-weight:700; color:${c.textMuted}; font-size:11px; text-transform:uppercase; letter-spacing:0.05em;">${escapeHtml(t('invoice.details'))}</p>
            <p style="margin:0; line-height:1.6;">${escapeHtml(t('invoice.poNumber'))}: ${escapeHtml(data.poNumber)}</p>
          </div>
        </div>
        <table style="width:100%; border-collapse:collapse; margin-bottom:20px;">
          <thead>
            <tr>
              <th style="text-align:left; padding:10px 12px; border-bottom:2px solid ${c.border}; font-size:11px; text-transform:uppercase; letter-spacing:0.05em; color:${c.textMuted};">${escapeHtml(t('table.item'))}</th>
              <th style="text-align:right; padding:10px 12px; border-bottom:2px solid ${c.border}; font-size:11px; text-transform:uppercase; letter-spacing:0.05em; color:${c.textMuted};">${escapeHtml(t('table.quantity'))}</th>
              <th style="text-align:right; padding:10px 12px; border-bottom:2px solid ${c.border}; font-size:11px; text-transform:uppercase; letter-spacing:0.05em; color:${c.textMuted};">${escapeHtml(t('table.rate'))}</th>
              <th style="text-align:right; padding:10px 12px; border-bottom:2px solid ${c.border}; font-size:11px; text-transform:uppercase; letter-spacing:0.05em; color:${c.textMuted};">${escapeHtml(t('table.amount'))}</th>
            </tr>
          </thead>
          <tbody>${lineRows}</tbody>
        </table>
        <div style="display:flex; justify-content:flex-end; margin-bottom:24px;">
          <div style="width:280px;">
            ${totalsRow(t('totals.subtotal'), data.subtotal)}
            ${totalsRow(`${t('totals.discount')}${data.discountType === 'percent' ? ` (${data.discountValue}%)` : ''}`, data.discountType === 'percent' ? data.discountValue + '%' : getCurrencyCode(data.currency) + ' ' + parseNum(data.discountValue).toFixed(2))}
            ${totalsRow(`${t('totals.tax')}${data.taxType === 'percent' ? ` (${data.taxValue}%)` : ''}`, data.taxType === 'percent' ? data.taxValue + '%' : getCurrencyCode(data.currency) + ' ' + parseNum(data.taxValue).toFixed(2))}
            ${totalsRow(t('totals.shipping'), data.shippingType === 'percent' ? data.shippingValue + '%' : getCurrencyCode(data.currency) + ' ' + parseNum(data.shippingValue).toFixed(2))}
            <div style="border-top:1px solid ${c.border}; margin:6px 0;"></div>
            ${totalsRow(t('totals.total'), data.total, true)}
            ${totalsRow(t('totals.amountPaid'), getCurrencyCode(data.currency) + ' ' + parseNum(data.amountPaid).toFixed(2))}
            <div style="border-top:1px solid ${c.border}; margin:6px 0;"></div>
            ${totalsRow(t('totals.balanceDue'), data.balance, true)}
          </div>
        </div>
        <div style="font-size:13px; color:${c.textSecondary};">
          <p style="margin:0 0 4px; font-weight:700; color:${c.textMuted}; font-size:11px; text-transform:uppercase; letter-spacing:0.05em;">${escapeHtml(data.notesHeading || t('invoice.notes'))}</p>
          <p style="margin:0 0 16px; line-height:1.5;">${escapeHtml(data.notes).replace(/\n/g, '<br>')}</p>
          <p style="margin:0 0 4px; font-weight:700; color:${c.textMuted}; font-size:11px; text-transform:uppercase; letter-spacing:0.05em;">${escapeHtml(data.termsHeading || t('invoice.terms'))}</p>
          <p style="margin:0; line-height:1.5;">${escapeHtml(data.terms).replace(/\n/g, '<br>')}</p>
        </div>
      </div>
    `;
  }

  async function prepareClone(data, container) {
    // PDFs/downloads always render in the light theme, regardless of the
    // site's current dark mode, so printed invoices stay consistent and
    // printer-friendly no matter how the user is browsing.
    container.innerHTML = renderHtml(data, 'light');
    const clone = container.cloneNode(true);
    clone.style.position = 'static';
    clone.style.width = '210mm';
    clone.style.maxWidth = 'none';
    clone.style.opacity = '1';
    clone.style.pointerEvents = 'none';
    clone.style.display = 'block';
    clone.style.background = '#ffffff';
    document.body.appendChild(clone);

    try { if (document.fonts && document.fonts.ready) await document.fonts.ready; } catch (e) {}
    const imgs = Array.from(clone.querySelectorAll('img'));
    if (imgs.length) {
      await Promise.all(imgs.map(img => new Promise((resolve) => {
        if (img.complete) return resolve();
        img.onload = img.onerror = () => resolve();
      })));
    }
    await new Promise((resolve) => requestAnimationFrame(() => requestAnimationFrame(() => setTimeout(resolve, 140))));
    return clone;
  }

  async function download(data, container, filename) {
    const clone = await prepareClone(data, container);
    try {
      await html2pdf().set({
        margin: 0,
        filename: filename || `invoice-${Date.now()}.pdf`,
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2, useCORS: true, backgroundColor: '#ffffff', allowTaint: false },
        jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' }
      }).from(clone).save();
    } finally {
      if (clone.parentNode) clone.parentNode.removeChild(clone);
    }
  }

  async function getBase64(data, container) {
    const clone = await prepareClone(data, container);
    try {
      const dataUri = await html2pdf().set({
        margin: 0,
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2, useCORS: true, backgroundColor: '#ffffff', allowTaint: false },
        jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' }
      }).from(clone).outputPdf('datauristring');
      return dataUri;
    } finally {
      if (clone.parentNode) clone.parentNode.removeChild(clone);
    }
  }

  return { renderHtml, download, getBase64, getCurrencyCode, parseNum };
})();
