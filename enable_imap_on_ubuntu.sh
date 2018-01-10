#!/bin/bash

sudo apt-get install php-imap
sudo phpenmod imap
sudo service apache2 restart
