#!/bin/sh
set -e

USER=${USER:-www}
USER_ID=${USER_ID:-1000}

if [ -z $(id -u $USER 2>/dev/null) ]; then
    adduser --disabled-password --gecos '' --uid ${USER_ID} ${USER}

    mkdir -p /home/${USER}/.composer

    chown ${USER}:${USER} -R /home/${USER}
    chown ${USER}:${USER} /mnt
fi

# allow user to write to stdout and stderr
chown --dereference ${USER} /proc/self/fd/1
chown --dereference ${USER} /proc/self/fd/2

exec gosu ${USER} "$@"