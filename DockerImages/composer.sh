#!/bin/sh
 export PATH=/sbin:/bin:/usr/sbin:/usr/bin:/usr/local/sbin:/usr/local/bin
 docker run --rm -v $(pwd):/app -v ~/.ssh:/root/.ssh composer/composer $@