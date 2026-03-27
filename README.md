# Smart System Base Repository


## Installation :

**Clone  repository**

    git clone git@gitlab.com:imacca.tech.solution/ssb-project.git

**CD into ssb-project & Run Composer Update**

    cd ssb-project
    composer update

**Copy and rename .env.example into .env**

    cp .env.example .env

**Generate app key**

    php artisan key:generate

**Edi your .env file to match your local environment ( eg: database config & domain name)** 

**Configure your webserver to support subdomain** 
example configuration on **NGINX** :

    server {
        listen 80;
        server_name .ssb.pro;
        root /home/zulkifli-r/code/ssb/public;
    
        add_header X-Frame-Options "SAMEORIGIN";
        add_header X-XSS-Protection "1; mode=block";
        add_header X-Content-Type-Options "nosniff";
    
        index index.html index.htm index.php;
    
        charset utf-8;
    
        location / {
            try_files $uri $uri/ /index.php?$query_string;
        }
    
        location = /favicon.ico { access_log off; log_not_found off; }
        location = /robots.txt  { access_log off; log_not_found off; }
    
        error_page 404 /index.php;
    
        location ~ \.php$ {
            fastcgi_pass unix:/var/run/php/php7.2-fpm.sock;
            fastcgi_index index.php;
            fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
            include fastcgi_params;
        }
    
        location ~ /\.(?!well-known).* {
            deny all;
        }
    }

## Develop dengan Docker di Windows (optional) ##

**Persyaratan**

***Instal Docker desktop*** 

***Install makefile (windows)***

`choco install make`

**setup certificate (local https)**
* Buka `https://github.com/FiloSottile/mkcert` & ikuti petunjuk instalasi
* untuk **ssb-pro.test**, generate key : `mkcert -key-file key.pem -cert-file cert.pem ssb-pro.test "*.ssb-pro.test" localhost 127.0.0.1 ::1` & buat/taruh file di folder `src/storage/certs/ssb-pro.test`

**Ubah hosts file**
* gunakan perintah `ipconfig` dan temukan **IPv4 Address** pertama 
* masuk ke folder `C:\Windows:\System32\drivers\etc\hosts` dan tambahkan nilai berikut:  
**_yourIPv4Address_** ssb-pro.test  
**_yourIPv4Address_** tender.ssb-pro.test  
**_yourIPv4Address_** hse.ssb-pro.test  
**_yourIPv4Address_** workshop.ssb-pro.test  
**_yourIPv4Address_** warehouse.ssb-pro.test    
**_yourIPv4Address_** host.docker.internal  
**_yourIPv4Address_** gateway.docker.internal  
**_127.0.0.1_** kubernetes.docker.internal

**Support Sessions untuk subdomain**
tambahkan SESSION_DOMAIN=".${APP_DOMAIN}" ke file .env


### install aplikasi ###
optional jika belum menginstall aplikasi

`make install`
### jalankan container
`make dup`
### stop container
`make down`

### jalankan perintah artisan 
`make php & php artisan app:install, dll` 