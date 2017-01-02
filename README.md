# onkelrudi

[![Build Status](https://travis-ci.org/invalidargument/onkelrudi.svg?branch=master)](https://travis-ci.org/invalidargument/onkelrudi)

### Tests
```
ant phpunit
ant behat

for behat run local Selenium.
java -jar -Dwebdriver.chrome.driver=/Users/rudibieller/Sites/VagrantBoxes/onkelrudi/bin/chromedriver bin/selenium-server-standalone-3.0.1.jar
```

### Build
```
ant
ant build-local
```

### Database
```
./vendor/alcaeus/liquibase/liquibase --defaultsFile=deployment/liquibase.properties update
```

### API
api.feature.
```
curl -H "Content-Type: application/json" -X POST -d '{"name":"Max POWER", "description": "Blue Pants", "start":"2015-01-01 00:00:00", "end":"2015-12-12 00:00:00", "dates":"[]", "zipCode":"50667"}' http://localhost/public/api/v1/fleamarkets
```

```
curl -H "Content-Type: application/json" -X PUT -d '{"name":"Max Power", "description": "Ziel dieser Veranstaltung ist es, dass Kinder ihr nicht mehr
                                                                                           benötigtes Spielzeug tauschen oder verkaufen können. Dabei
                                                                                           können sie von ihren Eltern unterstützt werden. Junge Eltern
                                                                                           erhalten die Möglichkeit ihre nicht mehr benötigten Babyausstattungen
                                                                                           zu tauschen oder zu verkaufen.
                                                                                           Zugelassen sind: gebrauchte Sachen wie Kinderspiele, Bücher,
                                                                                           Steckspiele, Bauklötze, Kinder - CDs, Computerspiele, Kinderkleidung,
                                                                                           Kinderwagen und Kinderfahrzeuge.
                                                                                           Nicht zugelassen sind: Neuwaren und Trödel.", "start":"2016-01-03 00:00:00", "end":"2016-01-03 21:00:00", "zipCode":"50667", "city":"Köln", "street":"Hospeltstr.", "streetNo":"53"}' http://localhost/public/api/v1/fleamarkets/2
```

```
curl http://localhost/public/api/v1/fleamarkets/1  -XGET
```

```
curl http://localhost/public/api/v1/fleamarkets/1  -XDELETE
```

### Misc
```
/etc/mysql/my.conf
/var/log/apache2/error.log
/var/log/mysql/mysql.log
```