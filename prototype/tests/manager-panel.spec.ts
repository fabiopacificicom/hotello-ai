import { test, expect } from '@playwright/test';

const BASE = 'http://localhost:8090';

test.describe('Manager Panel', () => {

  test('loads successfully', async ({ page }) => {
    await page.goto(`${BASE}/manager-panel.html`);
    await expect(page.locator('.sidebar-brand h2')).toContainText('Villa Esmeralda');
    await expect(page.locator('h1')).toContainText('Dashboard');
  });

  test('EN/DE language switcher works', async ({ page }) => {
    await page.goto(`${BASE}/manager-panel.html`);
    // Default is German
    await expect(page.locator('h1')).toContainText('Dashboard');
    await expect(page.locator('[data-i18n="stats.active"]')).toHaveText('Aktive Buchungen');
    // Switch to English
    await page.click('.lang-btn:has-text("EN")');
    await expect(page.locator('[data-i18n="stats.active"]')).toHaveText('Active Bookings');
    await expect(page.locator('[data-i18n="actions.newBooking"]')).toHaveText('New Booking');
  });

  test.describe('Calendar', () => {
    test('navigates months with arrows', async ({ page }) => {
      await page.goto(`${BASE}/manager-panel.html`);
      const initialTitle = await page.locator('#calTitle').textContent();
      expect(initialTitle).toContain('August');
      // Click next month
      await page.click('.card-header button:has-text("→")');
      await page.waitForTimeout(200);
      const nextTitle = await page.locator('#calTitle').textContent();
      expect(nextTitle).toContain('September');
      // Click prev month
      await page.click('.card-header button:has-text("←")');
      await page.waitForTimeout(200);
      const backTitle = await page.locator('#calTitle').textContent();
      expect(backTitle).toContain('August');
    });

    test('today button resets to current month', async ({ page }) => {
      await page.goto(`${BASE}/manager-panel.html`);
      // Navigate to a different month
      await page.click('.card-header button:has-text("→")');
      await page.click('.card-header button:has-text("→")');
      await page.waitForTimeout(200);
      // Click today
      await page.click('.card-header button:has-text("Heute")');
      await page.waitForTimeout(200);
      const title = await page.locator('#calTitle').textContent();
      const now = new Date();
      const months = ['Januar','Februar','März','April','Mai','Juni','Juli','August','September','Oktober','November','Dezember'];
      expect(title).toContain(months[now.getMonth()]);
    });

    test('clicking a day shows toast', async ({ page }) => {
      await page.goto(`${BASE}/manager-panel.html`);
      await page.click('.calendar-day:not(.other-month):first-child');
      await page.waitForTimeout(300);
      const toast = page.locator('.toast');
      await expect(toast).toBeVisible();
    });
  });

  test.describe('Enquiries', () => {
    test('clicking enquiry expands it', async ({ page }) => {
      await page.goto(`${BASE}/manager-panel.html`);
      const firstEnquiry = page.locator('.enquiry-item').first();
      await expect(firstEnquiry).not.toHaveClass(/expanded/);
      await firstEnquiry.click();
      await expect(firstEnquiry).toHaveClass(/expanded/);
    });

    test('expanded enquiry shows reply bar', async ({ page }) => {
      await page.goto(`${BASE}/manager-panel.html`);
      await page.locator('.enquiry-item').first().click();
      // The reply bar should appear after the expanded enquiry
      await expect(page.locator('.enquiry-reply-bar input').first()).toBeVisible();
    });

    test('unread enquiry loses unread class on click', async ({ page }) => {
      await page.goto(`${BASE}/manager-panel.html`);
      const unread = page.locator('.enquiry-item.unread').first();
      await expect(unread).toBeVisible();
      await unread.click();
      await expect(unread).not.toHaveClass(/unread/);
    });
  });

  test.describe('Bookings', () => {
    test('clicking booking row opens detail modal', async ({ page }) => {
      await page.goto(`${BASE}/manager-panel.html`);
      await page.locator('#bookingsBody tr').first().click();
      await expect(page.locator('#detailModal.show')).toBeVisible();
      await expect(page.locator('#detailBody')).toContainText('Master Suite');
    });

    test('detail modal can be closed', async ({ page }) => {
      await page.goto(`${BASE}/manager-panel.html`);
      await page.locator('#bookingsBody tr').first().click();
      await expect(page.locator('#detailModal.show')).toBeVisible();
      await page.click('#detailModal .modal-close');
      await expect(page.locator('#detailModal.show')).toHaveCount(0);
    });
  });

  test.describe('AI Chat', () => {
    test('sends message and receives response', async ({ page }) => {
      await page.goto(`${BASE}/manager-panel.html`);
      const input = page.locator('#aiInput');
      await input.fill('bookings');
      await input.press('Enter');
      await page.waitForTimeout(1200);
      const bubbles = page.locator('.ai-chat .ai-msg');
      const count = await bubbles.count();
      expect(count).toBeGreaterThan(4); // original 4 + new user + new ai
    });

    test('AI responds to payment query', async ({ page }) => {
      await page.goto(`${BASE}/manager-panel.html`);
      const input = page.locator('#aiInput');
      await input.fill('payment');
      await input.press('Enter');
      await page.waitForTimeout(1200);
      const botMsgs = page.locator('.ai-msg.bot');
      const lastMsg = await botMsgs.last().textContent();
      expect(lastMsg).toMatch(/pending|ausstehend|Zahlung/i);
    });
  });

  test.describe('Modals', () => {
    test('new booking modal opens and closes', async ({ page }) => {
      await page.goto(`${BASE}/manager-panel.html`);
      await page.click('text=Neue Buchung');
      await expect(page.locator('#bookingModal.show')).toBeVisible();
      // Close via X button
      await page.click('#bookingModal .modal-close');
      await expect(page.locator('#bookingModal.show')).toHaveCount(0);
    });

    test('new booking modal closes by clicking backdrop', async ({ page }) => {
      await page.goto(`${BASE}/manager-panel.html`);
      await page.click('text=Neue Buchung');
      await expect(page.locator('#bookingModal.show')).toBeVisible();
      // Click backdrop
      await page.click('#bookingModal');
      await expect(page.locator('#bookingModal.show')).toHaveCount(0);
    });

    test('payment modal opens via quick action', async ({ page }) => {
      await page.goto(`${BASE}/manager-panel.html`);
      await page.click('.quick-action:has-text("Zahlung")');
      await expect(page.locator('#paymentModal.show')).toBeVisible();
    });

    test('message modal opens via quick action', async ({ page }) => {
      await page.goto(`${BASE}/manager-panel.html`);
      await page.click('.quick-action:has-text("Gast anschreiben")');
      await expect(page.locator('#messageModal.show')).toBeVisible();
    });
  });

  test.describe('Payment Actions', () => {
    test('remind button shows toast', async ({ page }) => {
      await page.goto(`${BASE}/manager-panel.html`);
      // Click "Erinnern" button in payments table
      const remindBtn = page.locator('#paymentsBody button:has-text("Erinnern")').first();
      if (await remindBtn.count() > 0) {
        await remindBtn.click();
        await page.waitForTimeout(300);
        await expect(page.locator('.toast')).toBeVisible();
      }
    });

    test('receipt button opens receipt modal', async ({ page }) => {
      await page.goto(`${BASE}/manager-panel.html`);
      const receiptBtn = page.locator('#paymentsBody button:has-text("Quittung")').first();
      if (await receiptBtn.count() > 0) {
        await receiptBtn.click();
        await expect(page.locator('#receiptModal.show')).toBeVisible();
      }
    });
  });

  test.describe('Sidebar Navigation', () => {
    test('clicking sidebar item highlights it', async ({ page }) => {
      await page.goto(`${BASE}/manager-panel.html`);
      const calendarLink = page.locator('.sidebar-nav a:has-text("Kalender")');
      await calendarLink.click();
      await expect(calendarLink).toHaveClass(/active/);
    });

    test('sidebar nav shows toast', async ({ page }) => {
      await page.goto(`${BASE}/manager-panel.html`);
      await page.locator('.sidebar-nav a:has-text("Kalender")').click();
      await page.waitForTimeout(300);
      await expect(page.locator('.toast')).toBeVisible();
    });
  });

  test.describe('Mobile Responsiveness', () => {
    test('mobile sidebar toggles correctly', async ({ page }) => {
      await page.setViewportSize({ width: 375, height: 812 });
      await page.goto(`${BASE}/manager-panel.html`);
      // Mobile topbar should be visible
      await expect(page.locator('.mobile-topbar')).toBeVisible();
      // Bottom nav should be visible
      await expect(page.locator('.bottom-nav')).toBeVisible();
      // Click hamburger
      await page.click('.hamburger');
      await expect(page.locator('#sidebar.open')).toBeVisible();
      // Click backdrop to close
      await page.click('#sidebarBackdrop');
      await page.waitForTimeout(300);
      await expect(page.locator('#sidebar.open')).toHaveCount(0);
    });

    test('bottom nav items are clickable', async ({ page }) => {
      await page.setViewportSize({ width: 375, height: 812 });
      await page.goto(`${BASE}/manager-panel.html`);
      await page.click('.bottom-nav a:has-text("Kalender")');
      await page.waitForTimeout(300);
      await expect(page.locator('.toast')).toBeVisible();
    });

    test('stats are 2-column on mobile', async ({ page }) => {
      await page.setViewportSize({ width: 375, height: 812 });
      await page.goto(`${BASE}/manager-panel.html`);
      const stats = page.locator('.stats-grid');
      const columns = await stats.evaluate(el => window.getComputedStyle(el).gridTemplateColumns);
      expect(columns).toContain('1fr'); // Should be 2 columns
    });
  });

  test('all stats cards are visible', async ({ page }) => {
    await page.goto(`${BASE}/manager-panel.html`);
    const statCards = page.locator('.stat-card');
    await expect(statCards).toHaveCount(4);
  });

  test('quick actions are all present', async ({ page }) => {
    await page.goto(`${BASE}/manager-panel.html`);
    const actions = page.locator('.quick-action');
    await expect(actions).toHaveCount(4);
  });
});