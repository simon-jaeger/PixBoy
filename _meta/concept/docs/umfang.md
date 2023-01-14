# Umfang

Auf Basis der Strategie wird nun konkret definiert, was gemacht wird – und was nicht. Der Umfang teilt sich auf in inhaltliche und funktionale Anforderungen. 

Für die Erstentwicklung wird ein MVP (Minimum Viable Product) angestrebt. Der Fokus liegt auf den essenziellsten Anforderungen. Alles, was eher "nice-to-have" ist, wird vorerst weggelassen und für eine etwaige nächste Version wieder aufgegriffen.

## Inhalt

- Beschreibung von PixBoy: Plattform und Editor für Pixel-Art im Game-Boy-Style
- Verwendung von Keywords für SEO: "pixel art game boy platform editor"
- Pixel-Bilder (16x16, 4 Shades) inkl. Titel, Beschreibung und Ersteller (Übersicht und Detailansicht)
- User-Daten (Name, E-Mail, Passwort-Hash, Berechtigungen)
- Hilfe zur Plattform und dem Editor
- Über PixBoy (Infos Entwickler etc.)
- Private Entwicklerdokumentation (Code und Datenbank) in Markdown

## Funktionalität

- Registrierung, Login, Logout, Passwort-Reset
- Erstellen, bearbeiten und löschen von Pixel-Bildern
- User verwalten
- Einige Seiteninhalte verwalten (Hilfe etc.)
- Suche für Pixel-Bilder (sucht in Titel und Erstellername)
- Validierung aller Formulardaten
- Bestätigungsprompt für Löschen von Pixel-Bildern und Usern
- Warnung, wenn versucht wird, ohne zu speichern eine Bearbeitungsseite zu verlassen
- Security (Verschlüsselung, XSS, SQL-Injection, Passwörter hashen)
- URL-Rewriting
- Editor: Zeichnen mit 4 vordefinierten Shades auf einem 16x16-Raster
- Editor: History (Vorwärts und zurück. Speichere mindestens die letzten 8 States)
- Responsivität: Fokus auf Smartphone (~360px), Tablet (~768px) und Desktop (~1280px). Weitere Breiten fluide.

## Out-of-scope

Folgende Inhalte und Funktionen wurden als nicht essenziell für die erste MVP-Version eingestuft und werden nicht eingebaut. Gegebenenfalls werden sie für eine folgende Version wieder aufgegriffen.

- Öffentliche Benutzerprofile inkl. Avatar
- Profil anpassen (ändern von Benutzername, Passwort etc.)
- Favoritensystem
- Follow-System
- Kommentarsystem
- Private, unveröffentlichte Bilder
- Bestehende Bilder (eigene oder von anderen) kopieren/forken
- Bilder exportieren und importieren
- Automatisches Speichern
- Erweiterte Filter- und Sortierfunktionen
- Erweiterte CMS-Funktionen (Navigation anpassen, Seiten hinzufügen, weitere Inhalte bearbeiten, ...)
- Fallback für IE11

## Struktur

Grob formt PixBoy folgende Struktur:

![Struktur](/structure.jpg)
