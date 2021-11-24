# instructions from here
# https://gist.github.com/pgilad/63ddb94e0691eebd502deee207ff62bd

# Generate private key
openssl genrsa -out private.key 4096

# Generate a Certificate Signing Request
openssl req -new -sha256 \
    -out private.csr \
    -key private.key \
    -config ../ssl.conf 

# Generate the certificate
openssl x509 -req \
    -days 3650 \
    -in private.csr \
    -signkey private.key \
    -out private.crt \
    -extensions req_ext \
    -extfile ../ssl.conf


# Create a pem file from crt
openssl x509 -in private.crt -out private.pem -outform PEM

# Allow insecure cert in chrome
# chrome://flags/#allow-insecure-localhost