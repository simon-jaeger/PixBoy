# Mockup

Das Mockup wurde in Webflow erstellt. Einsicht in den Webflow-Prototypen kann bei Simon Jäger angefordert werden. Es folgen Screenshots inklusive Erläuterungen.

Im Design verwendet werden abgeänderte Versionen der Pixel-Illustrationen *Cyberpunk Street Environment* von ansimuz (2017), *Dino Characters* von Arks (2017) und *Dungeon Tileset II* von 0x72 (2019).

## Standard-Layout

![](/mockup/layout.png)

Alle simplen Seiten wie *Help*, *About* und *Legal notice* verwenden dieses Standardlayout.

Der Screenshot zeigt den Header für noch nicht registrierte sowie eingeloggte User. Die Navigation wird auf engen Viewports in ein Burgermenü eingeklappt. Der Header klebt oben, der Footer am unteren Ende.

Header und Footer werden so auf jeder Seite eingeblendet, der Einfachheit halber in den folgenden Screenshots jedoch ausgelassen.

## Home

![](/mockup/home.png)

Die Landingpage informiert kurz und knapp über PixBoy und fordert zur Registrierung auf. Ein Klick auf *CREATE* oder *SHARE* scrollt zur zugehörigen Sektion. Alternativ scrollt ein Klick auf *Continue* bis nach der Hero-Sektion.

## Gallery

![](/mockup/gallery.png)

In der Galerie werden standardmässig alle veröffentlichten Bilder aufgelistet. Die Anzahl Spalten richtet sich nach dem Viewport. Bei Hover wird der Titel des Bildes eingeblendet, ein Klick führt zur Detailansicht.

Über das Suchfeld oben kann nach Titel des Bildes oder Benutzer gefiltert werden.

## Gallery: Detailansicht

![](/mockup/gallery-detail.png)

Hier wird das Bild gross und mit allen Infos angezeigt. Ein Klick auf den Benutzernamen führt zurück zur Galerie und filtert nach den Bildern dieses Benutzers.

Handelt es sich um ein Bild des eingeloggten Benutzers, wird ein Link *Edit* angezeigt, der das Bild gleich im Editor öffnet.

Am Ende werden maximal vier zufällige weitere Bilder dieses Benutzers aufgelistet.

## Account-Formulare

![](/mockup/account.png)

Neue Accounts werden über das Sign-Up-Formular erstellt, über das Log-In-Formular melden sich bestehende Benutzer an. In beiden Fällen wird bei Erfolg zum Dashboard weitergeleitet. Validierungsfehler werden jeweils oberhalb des Formulars zusammengefasst.

Über ein Password-Reset-Formular kann ein Link zum Setzen eines neuen Passwortes (Formular *Change password*) angefordert werden.

## Dashboard: Drawings

![](/mockup/dash-drawings.png)

Das Dashboard weist drei Unterseiten auf. Die erste, *Drawings*, listet die Bilder des eingeloggten Benutzers auf. Sie können in der Detailansicht angesehen, im Editor geöffnet oder gelöscht werden. Ein Löschvorgang muss zusätzlich bestätigt werden (siehe auch Dashboard: Users). Auf engen Viewports werden die Aktionen eingeklappt und Namen, wenn nötig, abgekürzt.

Hat der Benutzer noch keine Bilder erstellt wird eine Aufforderung zum Erstellen des ersten Bildes angezeigt. Eine ähnliche Meldung erscheint, wenn die Suche keine Ergebnisse liefert.

Administratoren erhalten auf diese Seite Zugriff auf sämtliche Bilder. Normalen Nutzern wird die Navigation zu den anderen Unterseiten nicht angezeigt.

## Dashboard: Users

![](/mockup/dash-users.png)

Nur Administratoren haben auf diese Seite Zugriff. Hier können Benutzer und ihre Bilder gelöscht werden, um etwa Spammer von der Site zu entfernen. Ein Löschvorgang muss zusätzlich bestätigt werden.

## Dashboard: Pages

![](/mockup/dash-pages.png)

Nur Administratoren haben auf diese Seite Zugriff. Hier können einige Seiteninhalte angepasst werden. Markdown ist erlaubt.

## Editor

![](/mockup/editor-lg.png)
![](/mockup/editor-sm.png)


Über die vier farbigen Vierecke wird die aktuelle Farbe gewechselt. Auf dem Bild oben kann direkt gezeichnet werden. Der Pixel unter der Maus wird heller dargestellt, um ihn hervorzuheben.

 Die Pfeil-Icons gehen in der History zurück oder wieder vorwärts. Auf engen Viewports kann das Formular mit den Infos und dem Speichern-Button mit dem Save-Icon eingeblendet werden. Auf breiten Viewports speichert das Icon direkt. 

