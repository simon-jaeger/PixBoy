# Strategie

Die Strategie untersucht und beschreibt die Ziele und Motivationen für das Projekt, intern und extern. Auch wird die bestehende Marktumgebung analysiert. Dieser Prozess soll eine klare Richtung für die weitere Planung vorgeben.

## Vorgaben SAE

In erster Linie muss das Projekt die Vorgaben der SAE erfüllen.

- PHP und MySQL verwenden
- Responsive Design
- Backend/CMS zur Datenverwaltung (CRUD)
- Datenbankstruktur (sinnvoll und normalisiert)
- Registrierung (4+ validierte Felder, Passwort-Reset)
- Login (Auth, Ban nach 3 falschen Passwörtern), Logout
- Datenverschlüsselung und -sicherheit, Security (XSS, SQL-Injection, ...), Passwörter hashen
- URL-Rewriting einsetzen
- Libraries/Frameworks professionell einsetzen
- Dateistruktur sinnvoll und nachvollziehbar
- Kommentare im Code (ausführlich)
- README.md (und PDF) mit Dokumentation Datenbank und PHP

(vgl. SAE, 2016)

## Persönliche Ziele

Die Motivationen des Entwicklers für das Projekt.

- Die Kunstform Game-Boy-Pixel-Art fördern
- Ein professionelles, portfoliogerechtes Projekt umsetzen
- Bestehendes Wissen festigen und neue Dinge lernen

## Marktanalyse

Pixel-Art ist eine kleine aber beliebte Nische. Es bestehen bereits einige wenige Plattformen, die sich dieser Kunstform widmen. Keine fokussiert sich jedoch explizit auf den Game-Boy-Style.

### Pixilart

![Logo Pixilart](/logo-pixilart.png)<br>
Logo Pixilart (Ware, 2019a)

Pixilart ist die führende Plattform für Pixel-Art. Auf ihr werden monatlich über 220'000 neue Illustrationen veröffentlicht (vgl. Ware, 2019b). Die Site erlaubt jegliche Form von Pixel-Art. Viele der Illustrationen weisen eine sehr hohe Auflösung auf und nutzen eine Vielzahl von Farben.

Game-Boy-Pixel-Art ist auf Pixilart eher eine Seltenheit. Der Editor ist relativ komplex und erscheint gerade auf Mobilgeräten daher etwas überladen. Auch weist die Site sehr penetrante Werbung für ihren Produkteshop auf.

### Pixel Joint

![Logo Pixel Joint](/logo-pixel-joint.gif)<br>
Logo Pixel Joint (Sedgeman, 2019a)

Pixel Joint ist eine 2004 gegründete Community für Pixel-Art. Aus ihr gingen Projekte wie *The Joint* und *Lil Dudes* hervor (vgl. Sedgeman, 2019b). Wie bei Pixilart sind verschiedenste Formen von Pixel-Art erlaubt. Die maximale Auflösung fällt jedoch geringer aus. Trotzdem vermisst man den Game-Boy-Style.
 
Das Erscheinungsbild der Site hat sich seit 2004 nicht gross verändert. Es fehlt ein responsives Design und ein moderner Look. Die grösste Stärke der Site ist ihre treue Userbase. Anders als bei Pixilart ist ein kein Editor inbegriffen.
 
### Marktziel PixBoy

Pixel-Art ist eine Nische, der Game-Boy-Style eine Nische in einer Nische. Aber diese Subkategorie hat noch kein wirkliches Zuhause – PixBoy will dieses schaffen. Ziel ist die Gewinnung einer kleinen aber treuen Community von vorerst höchstens hundert Benutzern.

Wichtig ist ein modernes Design, welches auch Nutzer auf Mobilgeräten überzeugt. Die Site und der Editor sollen, wie Mikro-Pixel-Art auch, simpel und auf das wesentliche fokussiert sein.

Auf Werbung oder andere Profitmassnahmen wird verzichtet. PixBoy stellt sich in den Dienst der Kultur und Kunst – Profit ist kein Ziel. Marketing geschieht primär über SEO, Mundpropaganda und Werbung auf den sozialen Medien.

## Personas

Die Nutzer-Bedürfnisse sind zentraler Bestandteil der Zielsetzung. Die Zielgruppe wird mit Hilfe von Personas abgebildet. Beantwortet wird die Frage, für wen PixBoy erstellt wird, was diese Personen wollen und wie sich ihre Journey mit dem Produkt gestaltet.

Der Nintendo Game Boy wurde erstmals 1989 veröffentlicht. Im Jahr 1996 folgte die verbesserte Pocket-Version (vgl. GameTrog, 2019). Die Kindheit potenzieller User fällt also grösstenteils in diesen Bereich. Heute sind sie ca. 25-35 Jahre alt.

Pixel-Art wird fast ausschliesslich am Computer erstellt. Künstler mit Erfahrung bringen also Technik-Affinität mit. Auch User, die bisher nicht selbst Pixel-Art erstellt haben, sind zumindest Gamer, was eine gewisse Technik-Affinität mit sich bringt. Die User werden also grundlegende PC-Kenntnisse mitbringen und moderne Browser nutzen.

### Peter

![Peter](/persona-peter.png)<br>
Foto Peter (Malinowska, 2016)

- Alter: 30
- Beruf: Graphic Designer
- Fähigkeiten: Power-User, erfahrener Pixelkünstler
- Browser: Chrome

Pixel-Art ist seit Jahren Peters Hobby. Er nutzt zurzeit Pixilart und ist relativ zufrieden mit der Site. Ihn stört jedoch die zunehmende Anzahl an hochauflösenden Pixel-Illustrationen – er selbst bevorzugt Mikro-Pixel-Art, wie die des Game Boy.

**Journey:**

- 😠 Frustriert mit der mangelnden Präsenz von Mikro-Pixel-Art auf Pixilart
- 🤔 Googelt nach "micro pixel art" und findet PixBoy
- 😀 Startseite beschreibt PixBoy als ausschliesslich für den Game-Boy-Style gemacht
- 😀 Galerie mit nur tiefauflösender Pixelkunst, genau was Peter mag
- 😀 Scheint zu sein, was er sucht, registriert sich
- 😀 Probiert den Editor, hat keine Probleme
- 😀 Feature-Set sehr minimalistisch aber absolut ausreichend
- 😀 Verwendet beim zweiten Besuch sein Smartphone – der Editor ist auch hier gut verwendbar
- 😀 Nutz PixBoy von nun an und empfiehlt die Site weiter

### Nina

![Nina](/persona-nina.png)<br>
Foto Nina (Malinowska, 2017)

- Alter: 25
- Beruf: Kauffrau
- Fähigkeiten: Grundlegende PC-Kenntnisse, keine Erfahrung mit Pixel-Art oder sonstiger digitaler Kunst
- Browser: Firefox

Nina liebt klassische Game-Boy-Spiele. Gerade die niedlichen, minimalistischen Grafiken wie bei *Kirby's Dream Land* gefallen ihr sehr. Sie spielt das Spiel heute noch. Durch eine Freundin hört sie von PixBoy und entscheidet sich, sich erstmals selbst in Pixel-Art zu versuchen.

**Journey:**

- 🤔 Besucht auf Empfehlung PixBoy da Interesse an Pixel-Art
- 🤔 Wie funktioniert das Ganze? Sucht und findet eine Hilfe
- 😀 Scheint nicht so schwer zu sein, registriert sich
- 😀 Probiert den Editor, schlägt wenn nötig in der Hilfe nach
- 😀 Der simple Editor sagt ihr zu, Fehler können einfach rückgängig gemacht werden
- 😨 Kann sich beim nächsten Besuch nicht an Passwort erinnern...
- 😀 ... aber kann es einfach per E-Mail zurücksetzen
- 😀 Nutz PixBoy von nun an und sendet ihrer Freundin Links zu ihren Illustrationen
