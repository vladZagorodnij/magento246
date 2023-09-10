## Local development - domains ##

Add the following domains to the `/etc/hosts` file:

```shell
127.0.0.1 magento246.local www.magento246.local mh-prod-magento246.local pma-prod-magento246.local
```

Urls list:
- [https://magento246.local](https://magento246.local) 
- [https://www.magento246.local](https://www.magento246.local) 
- [http://mh-prod-magento246.local](http://mh-prod-magento246.local) 
- [http://pma-prod-magento246.local](http://pma-prod-magento246.local)


## Local development - self-signed certificates ##

Generate self-signed certificates before running this composition in the `$DOCKERIZER_SSL_CERTIFICATES_DIR`:

```shell
mkcert -cert-file=magento246.local-prod.pem -key-file=magento246.local-prod-key.pem magento246.local www.magento246.local
```

Add these keys to the Traefik configuration file if needed.


## Local development without Traefik reverse-proxy ##

If you do not have an `$DOCKERIZER_SSL_CERTIFICATES_DIR` environment variable (try `echo $DOCKERIZER_SSL_CERTIFICATES_DIR` in the terminal) then replace `${DOCKERIZER_SSL_CERTIFICATES_DIR}` with the path to the directory containing self-signed SSL certificates.
Generate certificates with the `mkcert` command as described in this Readme.
Here `SSL termination web server` - probably the first Apache or Nginx container in the composition, the one that handles SSL.

### Approach 1: Access container by IP ###

1. Find the SSL termination web server IP address from, for example, `docker container inspect --format '{{json .NetworkSettings.Networks}}' <container_name> | jq`.
2. Add domains and this IP (instead of `127.0.0.1`) to your `/etc/hosts` file.

Remember that the IP address may change after the container restart or OS restart.

### Approach 2: Publish ports ###

1. Ensure that ports 80 and 443 are not used by other applications
2. Add ports mapping to the SSL termination web server:
```
ports:
  - "80:80"
  - "443:443"
```
