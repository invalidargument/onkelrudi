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



curl -H "Content-Type: application/json" -X POST -d '{"name":"Max POWER", "description": "Blue Pants", "start":"2015-01-01 00:00:00", "end":"2015-12-12 00:00:00", "zipCode":"50667"}' http://localhost/public/api/v1/fleamarkets

curl -H "Content-Type: application/json" -X PUT -d '{"name":"Max UPDATED", "description": "Blue Pants", "start":"2015-01-01 00:00:00", "end":"2015-12-12 00:00:00", "zipCode":"50667"}' http://localhost/public/api/v1/fleamarkets/1

curl http://localhost/public/api/v1/fleamarkets/1  -XGET

curl http://localhost/public/api/v1/fleamarkets/1  -XDELETE
