#!/bin/sh
 export PATH=/sbin:/bin:/usr/sbin:/usr/bin:/usr/local/sbin:/usr/local/bin
 docker run -it --rm  -v $(pwd):/app -w /app php-cli php $@