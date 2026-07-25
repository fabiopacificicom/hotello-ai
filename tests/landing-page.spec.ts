import { test, expect } from '@playwright/test';

const BASE = 'http://localhost:8090';

test.describe('Landing Page', () => {

  test('loads successfully', async ({ page }) => {
    await page.goto(`${BASE}/landing-page.html`);
    await expect(page.locator('.nav-logo')).toHaveText('Villa Esmeralda');
    await expect(page.locator('h1')).toBeVisible();
  });

  test('EN/DE language switcher works', async ({ page }) => {
    await page.goto(`${BASE}/landing-page.html`);
    // Default is German
    await expect(page.locator('[data-i18n="hero.title"]')).toContainText('Paradies');
    // Switch to English
    await page.click('.lang-btn:has-text("EN")');
    await expect(page.locator('[data-i18n="hero.title"]')).toContainText('Paradise');
    await expect(page.locator('[data-i18n="nav.bookNow"]')).toHaveText('Book Now');
    // Switch back to German
    await page.click('.lang-btn:has-text("DE")');
    await expect(page.locator('[data-i18n="nav.bookNow"]')).toHaveText('Jetzt Buchen');
  });

  test('gallery lightbox opens and closes', async ({ page }) => {
    await page.goto(`${BASE}/landing-page.html`);
    // Click first gallery card
    await page.click('.gallery-card:first-child');
    await expect(page.locator('#lightbox.show')).toBeVisible();
    await expect(page.locator('#lbImg')).toBeVisible();
    // Close lightbox
    await page.click('.lb-close');
    await expect(page.locator('#lightbox.show')).toHaveCount(0);
  });

  test('gallery lightbox navigates between images', async ({ page }) => {
    await page.goto(`${BASE}/landing-page.html`);
    await page.click('.gallery-card:first-child');
    const firstSrc = await page.locator('#lbImg').getAttribute('src');
    // Click next
    await page.click('.lb-next');
    const secondSrc = await page.locator('#lbImg').getAttribute('src');
    expect(secondSrc).not.toBe(firstSrc);
    // Click prev
    await page.click('.lb-prev');
    const backSrc = await page.locator('#lbImg').getAttribute('src');
    expect(backSrc).toBe(firstSrc);
  });

  test('booking form validates dates', async ({ page }) => {
    await page.goto(`${BASE}/landing-page.html`);
    // Set checkout before checkin
    await page.locator('.booking-card input[type="date"]').first().fill('2026-08-10');
    await page.locator('.booking-card input[type="date"]').last().fill('2026-08-05');
    await page.click('#bookingBtn');
    // Should show error
    const msg = page.locator('#bookingMsg');
    await expect(msg).toBeVisible();
    await expect(msg).toContainText(/nach|after/i);
  });

  test('booking form shows success for valid dates', async ({ page }) => {
    await page.goto(`${BASE}/landing-page.html`);
    await page.locator('.booking-card input[type="date"]').first().fill('2026-08-05');
    await page.locator('.booking-card input[type="date"]').last().fill('2026-08-10');
    await page.click('#bookingBtn');
    await expect(page.locator('#bookingMsg')).toBeVisible();
    await expect(page.locator('#bookingMsg')).toContainText(/✅/);
  });

  test('AI chat responds to questions', async ({ page }) => {
    await page.goto(`${BASE}/landing-page.html`);
    const input = page.locator('#aiLandingInput');
    await input.fill('restaurant');
    await input.press('Enter');
    // Wait for response
    await page.waitForTimeout(1200);
    const bubbles = page.locator('#aiChatMsgs .chat-bubble');
    const count = await bubbles.count();
    expect(count).toBeGreaterThan(5); // original 5 + new user + new ai
  });

  test('mobile menu toggles on small viewport', async ({ page }) => {
    await page.setViewportSize({ width: 375, height: 812 });
    await page.goto(`${BASE}/landing-page.html`);
    // Hamburger should be visible on mobile
    await expect(page.locator('#hamburger')).toBeVisible();
    // Mobile nav should be hidden initially
    await expect(page.locator('#mobileNav.show')).toHaveCount(0);
    // Click hamburger
    await page.click('#hamburger');
    await expect(page.locator('#mobileNav.show')).toBeVisible();
    // Click a nav link to close
    await page.click('#mobileNav a:first-child');
    await expect(page.locator('#mobileNav.show')).toHaveCount(0);
  });

  test('smooth scroll navigation works', async ({ page }) => {
    await page.goto(`${BASE}/landing-page.html`);
    // Click gallery link
    await page.click('a[href="#gallery"]');
    // Should scroll to gallery section
    await page.waitForTimeout(500);
    const gallerySection = page.locator('#gallery');
    const box = await gallerySection.boundingBox();
    expect(box).not.toBeNull();
    expect(box!.y).toBeLessThan(100);
  });

  test('all sections are present', async ({ page }) => {
    await page.goto(`${BASE}/landing-page.html`);
    const sections = ['#gallery', '#rooms', '#features', '#surroundings', '#booking', '#contact'];
    for (const sel of sections) {
      await expect(page.locator(sel)).toBeVisible();
    }
  });
});