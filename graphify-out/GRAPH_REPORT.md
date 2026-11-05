# Graph Report - enchantivephp  (2026-11-05)

## Corpus Check
- Large corpus: 182 files · ~914,612 words. Semantic extraction will be expensive (many Claude tokens). Consider running on a subfolder.

## Summary
- 141 nodes · 114 edges · 54 communities (8 shown, 46 thin omitted)
- Extraction: 78% EXTRACTED · 22% INFERRED · 0% AMBIGUOUS · INFERRED: 25 edges (avg confidence: 0.8)
- Token cost: 0 input · 0 output

## Community Hubs (Navigation)
- Community 0
- Community 1
- Community 2
- Community 3
- Community 4
- Community 5
- Community 6
- Community 7
- Community 8

## God Nodes (most connected - your core abstractions)
1. `scripts` - 7 edges
2. `Temporary Unsplash images in assets/images/temp` - 7 edges
3. `destinations.txt (five destinations)` - 7 edges
4. `Site sections (Services, MICE, Leisure, Luxe, Celebrations, Destinations)` - 6 edges
5. `initAnimation()` - 5 edges
6. `Project structure (pages, includes, scss, js, assets)` - 4 edges
7. `Supplied copy used verbatim` - 4 edges
8. `Enchantive Asia (Thailand DMC)` - 3 edges
9. `Brand commitments (blue #0658a7, single font, fixed copy)` - 3 edges
10. `Contact form handler (contact-submit.php, MAIL_MODE)` - 3 edges

## Surprising Connections (you probably didn't know these)
- `Site sections (Services, MICE, Leisure, Luxe, Celebrations, Destinations)` --references--> `leisure.txt (Discover Thailand. Your Way.)`  [INFERRED]
  PRODUCT.md → scripts/content/leisure.txt
- `Site sections (Services, MICE, Leisure, Luxe, Celebrations, Destinations)` --references--> `destinations.txt (five destinations)`  [INFERRED]
  PRODUCT.md → scripts/content/destinations.txt
- `Temporary Unsplash images in assets/images/temp` --semantically_similar_to--> `Unsplash photography (MICE, homepage slideshow, collage)`  [INFERRED] [semantically similar]
  docs/image-manifest.md → docs/asset-sources.md
- `Temporary Unsplash images in assets/images/temp` --references--> `Ayutthaya`  [INFERRED]
  docs/image-manifest.md → scripts/content/destinations.txt
- `Temporary Unsplash images in assets/images/temp` --references--> `Bangkok`  [INFERRED]
  docs/image-manifest.md → scripts/content/destinations.txt

## Import Cycles
- None detected.

## Hyperedges (group relationships)
- **Pre-launch open items** — readme_before_production, docs_qa_report_not_run, docs_content_notes_open_items, docs_content_notes_unverified_stats [INFERRED 0.75]
- **Brand and design token system** — product_brand_commitments, docs_design_system_colors, docs_design_system_typography, docs_asset_sources_fonts [INFERRED 0.80]
- **Page copy source files feeding site sections** — scripts_content_mice, scripts_content_leisure, scripts_content_luxe, scripts_content_celebrations, scripts_content_destinations [INFERRED 0.85]

## Communities (54 total, 46 thin omitted)

### Community 0 - "Community 0"
Cohesion: 0.16
Nodes (10): Self-hosted fonts via @fontsource (OFL), Assets extracted from Design.pdf (logo, photos, partner logos), Unsplash photography (MICE, homepage slideshow, collage), Breakpoints 576/768/992/1200/1600, Colour tokens (brand blue #0658A7, red #E8372A, footer #1A1717, tint #F4F8FE), Design.pdf (1920px artboard source), Homepage section order (hero, intro, ticker, why us, MICE, tiles, locations, testimonials, CTA, footer), Animations (cross-fade, ticker, reveal, reduced-motion safe) (+2 more)

### Community 1 - "Community 1"
Cohesion: 0.14
Nodes (13): description, devDependencies, @fontsource/outfit, @fontsource/playfair-display, @fontsource-variable/fraunces, sass, name, private (+5 more)

### Community 2 - "Community 2"
Cohesion: 0.27
Nodes (10): Supplied copy used verbatim, Enchantive Asia (Thailand DMC), Site sections (Services, MICE, Leisure, Luxe, Celebrations, Destinations), Target users: B2B trade and luxury travellers, celebrations.txt (11 celebration offerings), Destination Weddings, luxe.txt (Luxe Experiences), Eight signature luxe experiences (Andaman Afterglow ... River Retreat) (+2 more)

### Community 3 - "Community 3"
Cohesion: 0.25
Nodes (8): Open items (social URLs, founder, testimonials, form backend), QA gaps: W3C, zoom, DevTools console, PageSpeed, security headers, contrast audit not run, Stack: PHP includes + SCSS + vanilla JS, Before production checklist (noindex, mail, security headers), Install/build/run (npm build, sass, php router), Contact form handler (contact-submit.php, MAIL_MODE), Project structure (pages, includes, scss, js, assets), Clean URL rewriting (.htaccess / router.php)

### Community 4 - "Community 4"
Cohesion: 0.33
Nodes (8): Temporary Unsplash images in assets/images/temp, destinations.txt (five destinations), Ayutthaya, Bangkok, Chiang Mai, Hua Hin, Pattaya, Let's Plan Your Thailand CTA

### Community 5 - "Community 5"
Cohesion: 0.29
Nodes (7): scripts, build, check, sass, sass:min, sass:watch, serve

### Community 6 - "Community 6"
Cohesion: 0.33
Nodes (5): Draft copy pages (leisure, celebration sub-pages, luxe blurbs, MICE cards), Unverified stats and testimonials (5000+ customers etc.), Deviations from PDF (nav, testimonials, capitalisation), leisure.txt (Discover Thailand. Your Way.), Leisure categories (FIT, Fixed Departures, Social Events, Family, Private Travel)

### Community 7 - "Community 7"
Cohesion: 0.60
Nodes (5): initAnimation(), initBanners(), initBgFade(), initCoverflow(), initTitles()

## Knowledge Gaps
- **25 isolated node(s):** `name`, `version`, `private`, `description`, `sass` (+20 more)
  These have ≤1 connection - possible missing edges or undocumented components. (Counts symbols only; 84 node(s) total have ≤1 connection when file, concept and rationale nodes are included.)
- **46 thin communities (<3 nodes) omitted from report** — run `graphify query` to explore isolated nodes.

## Suggested Questions
_Questions this graph is uniquely positioned to answer:_

- **Why does `Site sections (Services, MICE, Leisure, Luxe, Celebrations, Destinations)` connect `Community 2` to `Community 4`, `Community 6`?**
  _High betweenness centrality (0.034) - this node is a cross-community bridge._
- **Are the 6 inferred relationships involving `Temporary Unsplash images in assets/images/temp` (e.g. with `Unsplash photography (MICE, homepage slideshow, collage)` and `Ayutthaya`) actually correct?**
  _`Temporary Unsplash images in assets/images/temp` has 6 INFERRED edges - model-reasoned connections that need verification._
- **What connects `name`, `version`, `private` to the rest of the system?**
  _25 weakly-connected nodes found - possible documentation gaps or missing edges._
- **Should `Community 1` be split into smaller, more focused modules?**
  _Cohesion score 0.14285714285714285 - nodes in this community are weakly interconnected._
- **Why does `destinations.txt (five destinations)` connect `Community 4` to `Community 2`?**
  _High betweenness centrality (0.026) - this node is a cross-community bridge._
- **Are the 5 inferred relationships involving `Site sections (Services, MICE, Leisure, Luxe, Celebrations, Destinations)` (e.g. with `celebrations.txt (11 celebration offerings)` and `destinations.txt (five destinations)`) actually correct?**
  _`Site sections (Services, MICE, Leisure, Luxe, Celebrations, Destinations)` has 5 INFERRED edges - model-reasoned connections that need verification._
- **Why does `Temporary Unsplash images in assets/images/temp` connect `Community 4` to `Community 0`?**
  _High betweenness centrality (0.021) - this node is a cross-community bridge._