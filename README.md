🌿 TLE2 Natuurtocht - Natuur Dex
Een interactieve webapplicatie waarmee gebruikers planten, bomen en schimmels kunnen ontdekken, verzamelen en hun digitale Natuur Dex vullen.
🚀 Kernfunctionaliteiten
Feature	Beschrijving
Natuur Dex	Overzicht van alle te verzamelen items, gegroepeerd per categorie (Bomen, Planten, Schimmels).
Seizoensfilters	Filtert items automatisch of handmatig op basis van het seizoen.
Camera Integratie	Direct foto's maken en uploaden in de browser.
Progressie	Toont de voortgang in percentages per gebied/seizoen.
Wizard of Oz	Gesimuleerde AI-validatie voor het testen van foto-uploads.
Rijke Data	Feitjes, locatie-info en quizvragen per item.
🛠️ Tech Stack
Framework: Laravel (PHP)
Frontend: Blade Templates
Styling: Tailwind CSS
Interactiviteit: Alpine.js (Camera, accordions, modals)
Database: MySQL / SQLite
⚙️ Installatie (Lokale Setup)
Voer de volgende stappen uit in de terminal:
git clone <jouw-repo-url>
composer install & npm install
cp .env.example .env & php artisan key:generate
Cruciaal: Database migraties en seeding:
php artisan migrate:fresh --seed
Start de servers:
npm run dev
(Nieuwe terminal) php artisan serve
📸 Wizard of Oz Validatie (Simulatie)
Dit simuleert de AI-herkenning (User Story 19).
Scenario	Actie	Resultaat
Foutief	Klik op de knop "Gebruik foto".	❌ Foutmelding: Foto niet herkend.
Correct	Druk op de ENTER toets op je toetsenbord (terwijl de preview zichtbaar is).	✅ Foto goedgekeurd en kaart verzameld.
