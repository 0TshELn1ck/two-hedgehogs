#!/bin/bash

echo;
echo "Project Two hedgehogs "
echo "what you wanna do?"
echo "1 - install package"
echo "2 - create base, schema and load fixtures"
echo "3 - run tests"
echo "4 - clear cache"
echo "5 - drop database"
echo "0 - exit"
echo;

read key

case "$key" in
   "1" ) 
      composer install
      npm install
      ./node_modules/.bin/bower install
      ./node_modules/.bin/gulp
   ;;
   "2" ) 
      ./app/console doctrine:database:create
      ./app/console doctrine:schema:update --force   
#      ./app/console h:d:f:l -n
   ;;
   "3" ) 
#     ./phpunit -c app
   ;;
   "4" ) 
     ./app/console cache:clear  
   ;;
   "5" ) 
     ./app/console doctrine:database:drop --force 
   ;;
   "0" ) ;;
esac
