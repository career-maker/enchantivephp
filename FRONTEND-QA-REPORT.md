# Frontend QA Report — Enchantive Asia

Date: 2026-11-05 · Branch: `dev-vishal`

## 1. Executive summary

**Verdict: PASS WITH WARNINGS.**

- Project: static PHP pages + Sass (`npm run build`), vanilla JS, no framework. Served locally with `php -S localhost:8000 router.php`.
- Routes identified: 30 (29 pages + 404). Routes tested: 29 pages + 404 (console/network/axe/overflow); Lighthouse on 4 representative pages.
- Issues found: 5 · Fixed and verified: 4 · Open/accepted: 1 + notes in §9.
- Highest outstanding: index Lighthouse Performance 72 (mobile, simulated slow-4G; LCP delayed by the intentional 1.6 s preloader) and mice 84, below the ≥85 goal.

## 2. Environment and coverage

- Windows 11, Node v26.11.1, PHP 8.2.26, Google Chrome (system) via Playwright-core, Lighthouse 13.6.0 (mobile, simulated throttling), axe-core (WCAG 2.0–2.2 A/AA + best-practice).
- Build mode: production (`css/main.min.css`), local PHP dev server (no gzip/cache headers, no `.htaccess`).
- Viewports (overflow sweep, all 29 pages): 320, 360, 375, 390, 430, 576, 768, 1024, 1280, 1440, 1600, 1920 → **0 horizontal overflow**.
- Visual regression: 29 pages × 1440/768/375, pixel compare vs pre-change baseline → identical (`qa-screenshots/`).
- **Not performed:** Firefox/Safari/Edge cross-browser (Chrome only); W3C Nu validator (no Java; replaced by custom DOM checks); keyboard/screen-reader manual pass beyond axe; real-device touch; the 40 px overlap-detector sweep of §I-2 (not automated here); HTTP security headers (set in `.htaccess`, not served by `php -S`).

## 3. Scorecard

| Category | Status | Found | Fixed | Outstanding |
|---|---|---:|---:|---:|
| Code review | PARTIAL | 0 | 0 | 0 |
| Build / links | PASS | 0 | 0 | 0 |
| Robots & indexing | PASS | 0 | 0 | 0 (notes) |
| Performance | PARTIAL | 1 | 0 | 1 |
| Console & network | PASS | 0 | 0 | 0 |
| HTML validation (custom checks) | PASS | 1 (P3) | 0 | 1 |
| Security | PASS | 0 | 0 | 0 |
| Accessibility | PASS | 3 | 3 | 0 |
| Responsive | PASS | 0 | 0 | 0 |
| Visual alignment | PARTIAL | 0 | 0 | 0 |
| Functional | PARTIAL | 1 (P3) | 0 | 1 |
| SEO / metadata | PASS | 0 | 0 | 0 |
| Cross-browser | NOT TESTED | – | – | – |

## 4. Performance (Lighthouse, mobile, simulated throttling, local server)

| Route | Perf | A11y | Best Practices | SEO |
|---|--:|--:|--:|--:|
| `/` (index) | 72 | 100 (was 95) | 100 | 69* |
| `/about` | 87 | 100 | 100 | 69* |
| `/contact` | 96 | 100 (was 96) | 100 | 69* |
| `/mice` | 84 | 100 | 100 | 69* |

\*SEO 69 = only `is-crawlable` fails, which is the intentional `noindex` (accepted). Index SEO was 61 until the `link-text` fix.

Index lab metrics: FCP 1.5 s, LCP 8.5 s, CLS 0, TBT ~10 ms, Speed Index 4.5 s. LCP element = hero image; unthrottled breakdown shows ~1.1 s render delay, caused by the preloader (`js/main.js`, minimum 1.6 s by design). Other measured opportunities: render-blocking `main.min.css` (138 KB), hero served at 1920 px to phones (no `srcset`), no cache headers on the dev server. Lab data only; no field data.

## 5. Issue register

| ID | Sev | Category | Route | Description | Status |
|---|---|---|---|---|---|
| QA-01 | P2 | A11y | `/` (≤767 px) | `role=tabpanel` photo is moved inside `role=tablist` (axe `aria-required-children`) | Fixed and verified (Lighthouse a11y 100) |
| QA-02 | P2 | A11y | `/contact` | Eyebrow `#a8793a` on white = 3.84:1 (< 4.5) | Fixed and verified (now `#946a2c`, 4.82:1) |
| QA-03 | P3 | A11y/SEO | `/` | Two links with the text "Read More" (`link-text`) | Fixed and verified |
| QA-04 | P2 | Performance | `/`, `/mice` | Lighthouse Performance 72 / 84 (< 85 goal) | Open: preloader is a design decision; responsive hero `srcset` and CSS inlining recommended |
| QA-05 | P3 | Functional | `/` (phone) | Tapping a destination navigates immediately (focus selects it before click); same on pre-change code | Open (not a regression) |
| QA-06 | P3 | HTML | `/gallery` | Lightbox placeholder `<img src="" alt="">` has no width/height | Open, minor |

### Fix details
- **QA-01** `js/components/animation.js`: on phones the list becomes `role=group`, the tabs plain buttons with `aria-current`, the photo `role=none`; desktop keeps tablist/tab/tabpanel. `scss/pages/_home.scss` styles both `aria-selected` and `aria-current`.
- **QA-02** `scss/pages/_contact.scss`: eyebrow text colour only (decorative rules unchanged).
- **QA-03** `index.php`: visually-hidden suffix inside the link text.
- axe contrast hits on celebrations/destinations/leisure headings were mid-reveal-animation artefacts: clean once animations settle (verified).

## 6. Security

No confirmed findings. `npm audit`: 0 vulnerabilities. No secrets/tokens/`.env`/source maps tracked. `innerHTML` uses are static strings (carousel scaffold copies an authored `aria-label`; pager labels are constants). All `target=_blank` links carry `rel=noopener`. No `eval`/`document.write`/`javascript:`. `.htaccess` defines CSP, X-Frame-Options, nosniff, Referrer-Policy, Permissions-Policy, X-Robots-Tag, but these could not be verified on the PHP dev server (needs the Apache/production host).

## 7. Robots and indexing

- `/robots.txt` served (200) with `User-agent: * / Disallow: /` (staging).
- Every page has a single `<meta name="robots" content="noindex, nofollow">`; no conflicts.
- `X-Robots-Tag` is configured in `.htaccess`; unverified locally.
- Note: canonical URLs and `sitemap.xml` point to production `https://www.enchantiveasia.com/…` while the site is staging with `Disallow: /`. A sitemap on a blocked staging site is inconsistent but harmless. `Disallow` plus `noindex` means crawlers cannot read the `noindex`; for a private deployment use authentication/IP restriction. Swap robots/sitemap/headers at launch per `docs/robots.production.txt`.

## 8. Responsive and visual

0 horizontal overflow at 12 viewports × 29 pages. No visual changes from the text-class refactor (pixel-identical at 3 widths). The §I-2 automated overlap detector was not run.

## 9. Remaining issues and limitations

QA-04, QA-05, QA-06 above. Not tested: Firefox/Safari/Edge, manual keyboard + screen reader pass, production headers/gzip/cache, backend form submission (`contact-submit.php`, out of scope).

## 10. Final verdict

**PASS WITH WARNINGS.** Build, link check, console, indexing, security, accessibility (Lighthouse a11y 100 on all four pages) and responsive checks pass with evidence. Warnings: index/mice Lighthouse Performance below 85 under mobile throttling, and cross-browser testing not performed.
