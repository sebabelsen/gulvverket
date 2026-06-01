# Hjemmeside – seksjoner med redigerbare felter

## Pakk ut

```bash
unzip -o gulvverket-hjem.zip
ddev exec php artisan statamic:stache:clear
ddev exec php artisan cache:clear
ddev exec php artisan view:clear
```

## Innhold

**Blueprint**
- `resources/blueprints/collections/pages/home.yaml` — dedikert hjemmeside-blueprint med 4 tabs:
  - **Hero:** tittel, intro, hovedbilde, CTA-knappetekst og -lenke
  - **Verdier:** seksjon-overskrift + replicator med 1-4 verdi-punkter (tittel + beskrivelse hver)
  - **HGS-fortelling:** overskrift, Bard-brødtekst, bilde
  - **SEO:** tittel og meta-beskrivelse

**Innhold**
- `content/collections/pages/home.md` — oppdatert med seed-tekst som Tom kan finpusse i CP.

**Template**
- `resources/views/home.antlers.html` — 6 seksjoner:
  1. Hero (split layout, tittel + intro + CTA + bilde)
  2. Verdier (3 kolonner)
  3. Utvalgte produkter (3 fra `products`-collection)
  4. HGS-fortelling (split layout med bilde)
  5. Siste fra bloggen (3 nyeste artikler)
  6. CTA mot kontakt-siden

## Viktig før Tom logger inn

Hjemmeside-entry-en bruker nå et eget blueprint (`home`), ikke det generelle `page`-blueprintet. Det betyr at *kun* `home.md`-fila har de nye feltene. Hvis du skulle endre hvilken side som er hjemmeside, må den siden også få `blueprint: home`.

## Hva Tom kan endre selv i CP

- Hero-overskrift, intro, bilde, CTA-tekst og hvor knappen lenker
- Antall verdi-punkter (1-4)
- Tekst og bilde i HGS-fortellingen
- SEO-tittel og meta-beskrivelse

## Hva som er hardkodet

- Layouten av hver seksjon (split, 3 kolonner, etc.)
- Antall utvalgte produkter (3) og artikler (3) – styrt av `limit` i template
- CTA-seksjonen nederst (hardkodet tekst og lenke til /kontakt)
- "Bak Gulvverket"-etiketten over HGS-fortellingen

Hvis Tom vil endre noe av det hardkodede senere, åpner vi feltene i blueprintet og leser dem inn i templaten.

## Test

1. `/` viser ny hjemmeside med alle 6 seksjoner
2. Åpne hjemmesiden i CP – nye tabs (Hero, Verdier, HGS-fortelling, SEO) skal vises
3. Last opp et hero-bilde og et story-bilde via CP, refresh hjemmesiden
4. Endre antall verdi-punkter til 2 i CP, verifiser at layouten ser fin ut

## Designvalg

- **Hero som split-layout:** mer interessant enn full-bredde, og gir bildet plass til å fortelle noe.
- **Replicator for verdi-punkter:** Tom kan ha 1, 2, 3 eller 4 uten å redigere kode. Layouten håndterer 3 kolonner – med 2 eller 4 vil grid-en oppføre seg fint takket være Tailwinds responsive grid.
- **Fra bloggen vises på hjemmesiden:** Bevisst – Toms visjon er en fagportal som *også* selger, ikke omvendt. Bloggen må derfor være synlig fra start.
- **CTA mot kontakt, ikke kjøp:** "Send en henvendelse" passer Toms posisjon om personlig oppfølging og faglig veiledning bedre enn "Handle nå".
- **Bytter `prose-stone` for `<p>`-tags i story-seksjon:** Bard kan returnere HTML, så `prose` håndterer formatering. Andre seksjoner bruker rene felt og trenger ikke prose.

## Ikke gjort

- Logo. Header har fortsatt teksten "Gulvverket". Bytt til SVG-fil senere når Tom har logo.
- Faktiske bilder. Placeholder vises hvis ingen er lastet opp i CP.
- Hero-knapp-stil-variant (sekundær knapp). Si fra hvis du vil ha to knapper i hero.
- Animasjoner / scroll-reveal effekter. Bevisst utelatt – clean static design.
