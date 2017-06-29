#mysqldump -u root -p --compatible=ansi --skip-opt emails > dumpfile

./mysql2sqlite3.sh -uroot -posboxes.org emails | sqlite3 emails.sqlite3
