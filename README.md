# PHP-forum-site


Redditin inspiroima keskustelupalsta. Verkkosivusto toteutettu PHP:n olio-ohjelmoinnin periaatteita seuraten, sekä toimivat CRUD-operaatiot Ajax methodia käyttäen.
Tietokantana käytetty MySQL-tietokantaa.

## [MySQL](https://raw.githubusercontent.com/vilbedawg/PHP-forum-site/master/Database.sql)


## Default login
Tunnukset: admin/admin


## Ominaisuudet ([Näyttökuvat](https://imgur.com/a/hHnJAFD))

* Muut kirjastot 

  * Carbon API extension ajankäsittelyä varten
  * TinyMCE texteditor kirjasto



* Kirjautuneet käyttäjät

  * Luoda uusi keskusteluaihe
  * Katsella muiden julkaisuja
  * Tykätä/ei tykätä julkaisuista ja kommenteista
  * muokata omia julkaisuja
  * poistaa omia kommentteja tai julkaisuja
  * Muokata omaa profiilia, profiilikuva, nimi, salasana, sähköposti
  * Poistaa oma tili
  
 

* Admin

  * Poistaa käyttäjiä
  * Poistaa kommentteja ja postauksia
  
  
  
* Julkaisu

  * Julkaisu voi sisältää melkein mitä vain.
  * Julkaisua voidaan kommentoida
  * Julkaisusta voidaan tykätä/ei tykätä

* Kommentit

  * Vastata muiden kommentteihin
  * Tykätä/ei tykätä muiden kommenteista
  * Poistaa kommentti jos oma tai admin

* Anonyymit käyttäjät

  * Voivat vain katsella julkaisuja ja kommentteja


## Mahdolliset lisäykset tulevaisuudessa
Admin käyttäjälle enemmän moderointi ominaisuuksia, esimerkiksi julkaisujen tai kommenttien merkitseminen sopimattomaksi ja niiden tarkkailu, sekä poistettujen julkaisujen katseleminen.
