Av Oliver T Andersson
Akronym olto20

Förklara din applikation projekt i en README.md, dels vad applikationen handlar om, som en liten manual. Dels hur man kan installera den utifrån dess GitHub/GitLab repo. Gör din README snygg och lägg till en representativ bild.

Applikationen är det klassiska spelet Yatzy. Det är slutprojektet för kursen MVC som läses på Blekinge Tekniska Högskola.
Applikationen är skrivit i Php och symfony som ramverk. SQLlite används som databas. Programmet kan installeras genom att.........

I detta yatsyspel kan du spela 1-4 personer. Välj först antal spelare genom att skriva in namn på de som ska vara med. 
Därefter är det bara att spela spelet! 

Första spelaren börjar genom att kasta tärningen. Spelaren kan sedan välja att kasta igen eller spara sitt resultat. Om du inte vill kasta om alla tärningar så väljer du att spara de tärningar genom att kryssa i rutorna för respektive tärning. Efter 3 kast måste du spara ett resultat. Du sparar resultatet genom att kryssa i var du vill spara det. Det finns kryssrutor för varje alternativ exemepelvis ettor, par eller yatzy. Programmet räknar ut dina poäng som visas nästa gång en spelare kastar. Om du inte uppfyller kraven så får du 0. Dvs om du sparar ettor men inte har några ettor får du 0 poäng.  Om du samlar ihop 50 poäng på första delen så får du 50 i bonuspoäng. Alltså precis som det klassiska tärningsspelet. Efter avslutat spel kommer highscore att sparas i databasen. 


![Dice](proj\dice.jpg "Dice")


[![Build Status](https://www.travis-ci.com/othorde/mvc-proj.svg?branch=main)](https://www.travis-ci.com/othorde/mvc-proj)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/othorde/mvc-proj/badges/quality-score.png?b=main)](https://scrutinizer-ci.com/g/othorde/mvc-proj/?branch=main)
[![Build Status](https://scrutinizer-ci.com/g/othorde/mvc-proj/badges/build.png?b=main)](https://scrutinizer-ci.com/g/othorde/mvc-proj/build-status/main)
