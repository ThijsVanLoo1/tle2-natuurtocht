# 🌿 TLE2 Natuurtocht - Natuur Dex

Welkom bij de Natuurtocht Applicatie. Dit project is een interactieve webapplicatie waarmee gebruikers de natuur in kunnen trekken om specifieke planten, bomen en schimmels te ontdekken. Door foto's te maken van gevonden items, vullen gebruikers hun digitale "Natuur Dex".

## 🚀 Kernfunctionaliteiten

* **Natuur Dex:** Een overzicht van alle te verzamelen natuuritems, gegroepeerd per categorie (Bomen, Planten, Bloemen, Schimmels).
* **Seizoensfilters:** De Dex past zich automatisch aan het huidige seizoen aan, of kan handmatig gefilterd worden (Lente, Zomer, Herfst, Winter).
* **Camera Integratie:** In-browser camera functionaliteit om direct foto's te maken en te uploaden.
* **Progressie Systeem:** Gebruikers zien direct hoeveel procent van de items ze hebben gevonden in het huidige gebied/seizoen.
* **Wizard of Oz Validatie:** Een gesimuleerd AI-validatiesysteem om foto-uploads te testen (zie sectie **Validatie Simulatie**).
* **Rijke Data:** Elk item bevat feitjes, locatie-informatie en quizvragen.

## 🛠️ Tech Stack

Dit project is gebouwd met de volgende technologieën:

| Categorie | Technologie | Opmerkingen |
| :--- | :--- | :--- |
| **Framework** | Laravel (PHP) | Backend logica en routing. |
| **Frontend** | Blade Templates | View rendering. |
| **Styling** | Tailwind CSS | Utility-first CSS framework. |
| **Interactiviteit** | Alpine.js | Lichtgewicht JS voor camera, accordions en modals. |
| **Database** | MySQL / SQLite | Dataopslag. |

## ⚙️ Installatie & Lokaal Draaien

Volg deze stappen om het project lokaal te draaien.

### 1. Repository Klone & Navigeer

```bash
git clone <jouw-repo-url>
cd tle2-natuurtocht


2. Dependencies Installeren

Bash


composer install
npm install


3. Environment Setup
Kopieer het .env.example bestand en genereer de applicatie sleutel. Zorg dat je database gegevens in de .env correct staan ingesteld.

Bash


cp .env.example .env
php artisan key:generate


4. Database Migraties & Seeding (Cruciaal)
Dit is een cruciale stap. De ManualCardSeeder vult de database met alle natuurkaarten (Brandnetel, Eik, etc.) inclusief rijke JSON-data.

Bash


php artisan migrate:fresh --seed


5. Start de Server
Start de frontend asset watcher en de Laravel development server.

Bash


# Terminal 1: Frontend assets compiler
npm run dev

# Terminal 2: Laravel server
php artisan serve


📸 Validatie Simulatie (Wizard of Oz)
Voor User Story 19 ("Als gebruiker wil ik weten of de foto correct is") is een Wizard of Oz methode geïmplementeerd. Omdat er nog geen echte AI-beeldherkenning is, simuleren we dit proces.
Scenario
Actie
Effectieve Input
Resultaat
❌ Foutieve Foto
Klik met de muis op de knop "Gebruik foto".
wizard_correct = 0
Foutmelding: "Helaas, de foto wordt niet herkend als een [Kaartnaam]..."
✅ Correcte Foto
Druk op de ENTER toets op het toetsenbord (terwijl de preview zichtbaar is).
wizard_correct = 1
Goedgekeurd, geüpload, kaart toegevoegd aan collectie.

De PhotoController checkt de wizard_correct waarde en geeft een 422 error terug als deze 0 is (Foutief).
📂 Project Structuur (Key Files)
Enkele belangrijke bestanden in de codebase:
app/Models/Card.php: Het hoofdmodel. Maakt gebruik van een JSON-kolom (properties) om flexibele data (feitjes, quizvragen, kenmerken) op te slaan.
app/Http/Controllers/NatuurDexController.php: Regelt de logica voor het dashboard, inclusief het filteren op seizoenen en het berekenen van de voortgangspercentages.
app/Http/Controllers/PhotoController.php: Verwerkt de upload, voert de "Wizard of Oz" validatie uit en koppelt de kaart aan de gebruiker.
resources/views/cards/show.blade.php: De detailpagina. Bevat de Alpine.js logica (x-data="camera(...)") voor het aansturen van de webcam en het afvangen van de Enter-toets.
🧪 Database Seeding Voorbeeld
De ManualCardSeeder vult de cards tabel met rijke data. De structuur van de data in de properties JSON kolom ziet er ongeveer zo uit:

JSON


{
    "rijk": "Plant",
    "seizoen": "Lente, Zomer",
    "feitje": "Wist je dat...",
    "kenmerken": "Groene bladeren...",
    "locatie_text": "Bosranden"
}




