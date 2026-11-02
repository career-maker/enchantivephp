# Enchantive Asia – PHP website (PHP + Sass)

Implementation of the approved homepage design (`Design.pdf`) plus inner pages. Pages are PHP files that share header/footer/CTA includes; page URLs stay `*.html` (rewritten to the `.php` files).

## Install / build / run
```bash
npm install            # sass + font packages (build-time only)
npm run build          # sass -> css/main.css + css/main.min.css
npm run sass:watch     # recompile CSS on change
npm run serve          # php -S localhost:8000 router.php  (needs PHP 8.1+ on PATH)
npm run check          # verifies local links, anchors and duplicate ids
```
On Apache (XAMPP/Laragon/production) the `.htaccess` provides the same URL rewriting as `router.php`; `mod_rewrite` and `mod_headers` must be enabled.

## Structure
- `*.php` (root) – one file per page. Each starts with a `$page = [title, desc, nav, og]` array, then `require includes/header.php`, the page body, `require includes/footer.php`. Page links stay `about.html`; `.htaccess` / `router.php` map them to `about.php`.
- `includes/` – `config.php` (site constants, mail mode), `header.php` / `footer.php` (document shell), `partials/` (`header`, `footer`, `cta` (exact supplied copy), `sprite` (SVG icons), `preloader`). Blocked from the web.
- `contact-submit.php` – enquiry form handler (JSON). `MAIL_MODE = 'log'` saves to `storage/enquiries.log` (git-ignored); set `'mail'` (and SMTP/`mail()` on the host) for production. Put overrides in `includes/config.local.php` (git-ignored).
- `router.php` – local dev router only.
- `scss/` – abstracts, base, layout, components, pages; `main.scss` is the entry point. Pages load `css/main.min.css`.
- `js/` – Classic scripts: `navigation.js`, `forms.js`, `animation.js`, `gallery.js`, `carousel.js` (no third-party libraries).
- `assets/` – optimised WebP images, logos, self-hosted fonts.
- `sitemap.xml`, `robots.txt` – static; update when pages are added.

## Before production
1. **Indexing**: pages ship with `<meta name="robots" content="noindex, nofollow">` (staging). Set `STAGING = false` in `includes/config.php` and confirm the canonical base `SITE` is correct.
2. **Contact form** (`contact.php` -> `contact-submit.php`): validates server-side (honeypot, same-origin check, length caps). Set `MAIL_MODE = 'mail'` in `includes/config.local.php` and make sure the host can send mail (or swap `mail()` for SMTP) before launch.
3. **Server headers** (must be set on the host; not verifiable locally): `Content-Security-Policy` (`default-src 'self'; img-src 'self' data:; style-src 'self'; script-src 'self'; font-src 'self'`), `Strict-Transport-Security`, `X-Content-Type-Options: nosniff`, `X-Frame-Options: DENY`. The site uses no inline scripts/styles beyond a one-line `no-js` class toggle in `<head>` – add its hash to the CSP or move it to a file.
4. Replace draft copy, placeholder testimonials/stats, social icon links, founder section (see `docs/content-notes.md`).
5. Run PageSpeed Insights against the staging URL (see `docs/qa-report.md`).

## Beta status
The site is in beta: every page has `noindex, nofollow`, `robots.txt` disallows all crawling and `.htaccess` sends `X-Robots-Tag`. To launch: set `STAGING = false` in `includes/config.php`, replace `robots.txt` with `docs/robots.production.txt`, remove the X-Robots-Tag lines from `.htaccess`. Legal pages (`privacy.html`, `terms.html`) are drafts needing legal review.

Git push details are kept locally in `.deploy/` (git-ignored): `.deploy/push.ps1 "message"` or `bash .deploy/push.sh "message"`.
