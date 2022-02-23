# Installation

In development:

Required :
- php 8 https://linuxize.com/post/how-to-install-php-8-on-ubuntu-20-04/
- composer https://getcomposer.org/download/
```bash
php composer-setup.php --filename=composer --install-dir=/bin
```

To build the application, launch:

```bash
make install
```

In order to make JWT generation work in backend, copy `private.pem` and `public.pem` files from `backend/tests/jwt` folder to `backend/config/jwt` folder.

Help/Documentation for private :
```
https://github.com/lexik/LexikJWTAuthenticationBundle/blob/master/Resources/doc/index.md#installation
```

## Start the app

What you need to do to (re)start the project:

- start backend:
  ```bash
  make backend_start
  ```

The backend should now be running at [http://localhost/api](http://localhost/api).
