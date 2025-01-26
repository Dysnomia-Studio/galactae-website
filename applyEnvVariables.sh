cp config/config.php config.php

sed -i "s/getenv('GALACTAE_SQL_SERVER')/\"$GALACTAE_SQL_SERVER\"/" config.php
sed -i "s/getenv('GALACTAE_SQL_DATABASE')/\"$GALACTAE_SQL_DATABASE\"/" config.php
sed -i "s/getenv('GALACTAE_SQL_USERNAME')/\"$GALACTAE_SQL_USERNAME\"/" config.php
sed -i "s/getenv('GALACTAE_SQL_PASSWORD')/\"$GALACTAE_SQL_PASSWORD\"/" config.php
sed -i "s/getenv('MAIL_SERVER')/\'$MAIL_SERVER\'/" config.php
sed -i "s/getenv('MAIL_USERNAME')/\'$MAIL_USERNAME\'/" config.php
sed -i "s/getenv('MAIL_PASSWORD')/\'$MAIL_PASSWORD\'/" config.php

chown www-data:www-data config.php
