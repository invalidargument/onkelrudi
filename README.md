# onkelrudi

[![Build Status](https://travis-ci.org/invalidargument/onkelrudi.svg?branch=master)](https://travis-ci.org/invalidargument/onkelrudi)

### Run Unit Tests
```
ant phpunit
```

### Run Acceptance Tests
```
ant behat

requires Selenium locally, e.g.:
java -jar bin/selenium-server-standalone-2.49.0.jar -Dwebdriver.chrome.driver=/Users/rudibieller/Sites/VagrantBoxes/onkelrudi/bin/chromedriver
```

### CI and Full build
```
ant
ant build-local
```

### Liquibase
```
./vendor/alcaeus/liquibase/liquibase --defaultsFile=deployment/liquibase.properties update
```

### API Documentation
Yet to be done. :) See api.feature. For playing there is curl:
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

### Misc for the Vagrant box
```
/etc/mysql/my.conf
/var/log/apache2/error.log
/var/log/mysql/mysql.log
```