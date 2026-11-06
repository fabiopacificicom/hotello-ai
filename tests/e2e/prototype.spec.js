import { expect, test } from '@playwright/test';

test('guest page preserves the prototype and clearly labels mocked availability', async ({ page }) => {
    await page.goto('/');
    await expect(page.getByRole('heading', { level: 1 })).toBeVisible();
    await expect(page.locator('#gallery')).toBeVisible();
    await page.locator('.gallery-card').first().click();
    await expect(page.locator('#lightbox.show')).toBeVisible();
    await page.locator('.lb-close').click();
    await expect(page.locator('#lightbox.show')).toHaveCount(0);

    await page.locator('.nav .lang-btn').filter({ hasText: 'EN' }).click();
    await expect(page.locator('h1')).toContainText('Paradise');
    await page.locator('.booking-card input[type=date]').first().fill('2027-01-01');
    await page.locator('.booking-card input[type=date]').last().fill('2027-01-03');
    await page.locator('#bookingBtn').click();
    await expect(page.locator('#bookingMsg')).toContainText('availability is not checked');
});

test('registration, protected dashboard, logout and login work', async ({ page }) => {
    await page.goto('/dashboard');
    await expect(page).toHaveURL(/\/login$/);
    await page.goto('/register');
    const email = `manager-${Date.now()}@example.test`;
    await page.locator('#name').fill('Demo Manager');
    await page.locator('#email').fill(email);
    await page.locator('#password').fill('password123');
    await page.locator('#password_confirmation').fill('password123');
    await page.getByRole('button', { name: 'Register' }).click();
    await expect(page).toHaveURL(/\/dashboard$/);
    await expect(page.getByText('Sample data; no real actions.')).toBeVisible();

    await page.getByRole('button', { name: /New Booking|Neue Buchung/ }).first().click();
    await expect(page.locator('#bookingModal.show')).toBeVisible();
    await page.locator('#bookingModal button').filter({ hasText: /Create Booking|Buchung anlegen/ }).click();
    await expect(page.locator('.toast')).toContainText(/Demo/);

    await page.locator('.sidebar-footer').getByRole('button', { name: 'Logout' }).click();
    await expect(page).toHaveURL(/\/$/);
    await page.goto('/dashboard');
    await expect(page).toHaveURL(/\/login$/);
    await page.locator('#email').fill(email);
    await page.locator('#password').fill('password123');
    await page.getByRole('button', { name: 'Log in' }).click();
    await expect(page).toHaveURL(/\/dashboard$/);
    await page.setViewportSize({ width: 375, height: 812 });
    await page.locator('.mobile-topbar').getByRole('button', { name: 'Logout' }).click();
    await expect(page).toHaveURL(/\/$/);
});

test('prototype navigation remains available on mobile', async ({ page }) => {
    await page.setViewportSize({ width: 375, height: 812 });
    await page.goto('/');
    await page.locator('#hamburger').click();
    await expect(page.locator('#mobileNav.show')).toBeVisible();
    await expect(page.locator('#mobileNav').getByRole('link', { name: 'Manager Login' })).toBeVisible();
});
