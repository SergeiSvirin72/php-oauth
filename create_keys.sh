mkdir ./auth_server/key
openssl genrsa -out "./auth_server/key/private.key" 2048
openssl rsa -in "./auth_server/key/private.key" -pubout -out "./auth_server/key/public.key"
