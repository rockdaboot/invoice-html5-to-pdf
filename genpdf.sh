#!/bin/bash

# quit on error
set -e

DBHOST=oms-4
custid=2
DATE1=$(date --date='1 month ago' +'01%m%y')
DATE2=$(date --date="$(date +'%d') days ago" +'%d%m%y')
XDATE1="20"${DATE1:4:2}${DATE1:2:2}${DATE1:0:2}
XDATE2="20"${DATE2:4:2}${DATE2:2:2}${DATE2:0:2}
echo $DATE1-$DATE2 $XDATE1-$XDATE2

# for testing
DATE1=010416
DATE2=300416

(
  echo '<?php'
  echo
  echo '$orderId='\"RE/test/1\"\;
  echo '$orderDate='\"$DATE1-$DATE2\"\;
  echo

  # generate receiver data (e.g. via mysql from a database)
  echo '$receiver_company='\"Empfänger GmbH\"\;
  echo '$receiver_name='\"- Buchhaltung -\"\;
  echo '$receiver_street='\"Foo Straße 55b\"\;
  echo '$receiver_postal='\"12345 Bar Stadt\"\;
  echo '$receiver_country='\"\"\;
  echo '$receiver_custid='777\;

  echo

  # generate invoice records here, as PHP array (Name, Description, Units, Price/Unit)
  echo '$items = array('
  echo '  new item(array("Admin", "DB Einrichtung, Aufwand in h", 6.5, 63.00)),'
  echo '  new item(array("Beratung", "telefonische Beratung in h", 3.0, 50.00)),'
  echo ');'
 
  echo
  echo '?>'
) >receiver.php

php5 -f invoice_a4.php >out.html
wkhtmltopdf -s A4 out.html out.pdf
