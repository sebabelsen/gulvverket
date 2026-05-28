# Gulvverket – ren startpakke

Dette er den autoritative versjonen. Hvis det er noen forskjell mellom denne pakken og hva som ligger i prosjektet ditt, er denne pakken fasit.

## Slett først

```bash
rm -f resources/blueprints/taxonomies/categories/category
rm -f content/collections/products/gulvolje-natur.md
rm -f content/collections/products/yooka-laylee.md
rm -f content/collections/products/parkett-rens.md
rm -f content/collections/products/mopp-pad-mikrofiber.md
```

(De siste to er for å fjerne eventuelle gamle seed-produkter med feil tax_class.)

## Pakk ut

```bash
unzip -o gulvverket-clean.zip
```

## Hva pakken inneholder (komplett liste)

**Blueprints**
- `resources/blueprints/collections/products/product.yaml`
- `resources/blueprints/taxonomies/categories/category.yaml`

**Innhold**
- `content/cargo/tax-classes.yaml` (kun `general`, satser kommer på tax zones)
- `content/collections/products.yaml`
- `content/collections/products/parkett-rens.md` (ett seed-produkt)
- `content/collections/pages/home.md`
- `content/collections/pages/produkter.md`
- `content/collections/pages/handlekurv.md`
- `content/taxonomies/categories.yaml`
- `content/taxonomies/categories/{7 kategorier}.yaml`
- `content/trees/collections/pages.yaml`

**Templates**
- `resources/views/layout.antlers.html`
- `resources/views/home.antlers.html`
- `resources/views/products/index.antlers.html`
- `resources/views/products/show.antlers.html`
- `resources/views/cart/index.antlers.html`
- `resources/views/partials/_product-card.antlers.html`

## Cache-rens

```bash
ddev exec php artisan cache:clear
ddev exec php artisan view:clear
```

## Sjekk i denne rekkefølgen

1. `/cp/collections` lastes uten 500-feil
2. `/cp/collections/products` viser produkter
3. Åpne `parkett-rens` i CP – verifiser at Cargo har injisert Price + Tax Class felter automatisk
4. `/` viser hjemmesiden med produktet
5. `/produkter` viser produktlisten og kategori-pills
6. `/produkter/parkett-rens` viser produktdetalj med "Legg i handlekurv"
7. Legg i kurven – kurv-teller i nav skal vise `1`
8. `/handlekurv` viser produktet med pris og totalsum

## Hva som mangler bevisst

- Tax zone for Norge (CP → Store → Tax Zones, 25 % for General-klassen)
- Faktura-gateway
- Faste fraktsatser
- Designsystem (Tailwind-default brukes som plassholder)
- Blogg, FAQ, guider
- SEO/JSON-LD utover blueprint-feltene

## Hvis noe brekker

Send feilmeldingen. Jeg har lest Cargos docs på `builtwithcargo.dev` denne gangen, så `cart:add`, `cart:remove`, `line_items`, `format_money` osv. er verifiserte mot kildedokumentasjonen. Blueprint-feltene er Statamic-native (`text`, `textarea`, `bard`, `assets`, `toggle`, `integer`, `terms`, `entries`).
