#!/usr/bin/env bash

start=false;
stop=false;

while [[ $# -ge 1 ]]
do
key="$1";

case $key in
    -s|--start)
    start=true;
    shift # past argument
    ;;
    -d|--disable)
    stop=true;
    shift # past argument
    ;;
    *)
    start=true;
    ;;
esac
shift # past argument or value
done

if [[ -v start ]] && [[ $start = true ]]
then
    # php-xdebug is not installed
    dpkg -s php-xdebug;
    if (( $? != 0 ))
    then
        apt-get update;
        apt-get install -y --no-install-recommends php-xdebug;
    fi

    echo -e "zend_extension = xdebug.so\nxdebug.remote_enable = 1\nxdebug.idekey = PHPSTORM\nxdebug.remote_autostart = 1\nxdebug.remote_host = 172.19.0.1\nxdebug.remote_port = 9000\nxdebug.max_nesting_level = 512\n" > /etc/php/7.0/mods-available/xdebug.ini;

    ln -s --force /etc/php/7.0/mods-available/xdebug.ini /etc/php/7.0/cli/conf.d/20-xdebug.ini;
    ln -s --force /etc/php/7.0/mods-available/xdebug.ini /etc/php/7.0/fpm/conf.d/20-xdebug.ini;

    service php7.0-fpm reload

elif [[ -v stop && $stop = true ]]
then
    unlink /etc/php/7.0/cli/conf.d/20-xdebug.ini;
    unlink /etc/php/7.0/fpm/conf.d/20-xdebug.ini;

    service php7.0-fpm reload
fi
