#!/bin/bash
openssl genrsa -out ./private/private.key 4096
openssl req -new -sha256 \
    -out ./private/private.csr \
    -key ./private/private.key \
    -config ./ssl.conf 
openssl x509 -req \
    -days 3650 \
    -in ./private/private.csr \
    -signkey ./private/private.key \
    -out ./private/private.crt \
    -extensions req_ext \
    -extfile ./ssl.conf
openssl x509 -in ./private/private.crt -out ./private/private.pem -outform PEM
