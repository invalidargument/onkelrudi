# onkelrudi

[![Build Status](https://travis-ci.org/invalidargument/onkelrudi.svg?branch=master)](https://travis-ci.org/invalidargument/onkelrudi)

```
./vendor/alcaeus/liquibase/liquibase --defaultsFile=deployment/liquibase.properties update
composer update
bower install
```

```
/etc/mysql/my.conf
/var/log/apache2/error.log
/var/log/mysql/mysql.log
```


curl http://localhost/public/api/v1/fleamarkets/%7B%22data%22%3A%7B%22name%22%3A%22Max+Power%22%2C+%22description%22%3A+%22Blue+Pants%22%2C+%22start%22%3A%222015-01-01+00%3A00%3A00%22%2C+%22end%22%3A%222015-12-12+00%3A00%3A00%22%2C+%22zipCode%22%3A%2250667%22%7D%7D -XPOST

curl http://localhost/public/api/v1/fleamarkets/%7B%22data%22%3A%7B%22name%22%3A%22Max+UPDATED%22%2C+%22description%22%3A+%22Blue+Pants%22%2C+%22start%22%3A%222015-01-01+00%3A00%3A00%22%2C+%22end%22%3A%222015-12-12+00%3A00%3A00%22%2C+%22zipCode%22%3A%2250667%22%2C+%22id%22%3A+%221%22%7D%7D -XPUT

