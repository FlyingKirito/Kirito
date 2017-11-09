# Kirito
个人实验
本人初学phalcon,使用Micro 自己尝试着搭着玩，也是第一个个人项目。
## Nginx 配置
其中fastcgi 根据自己需求配置
```
server {
    listen      80;
    server_name kirito.dev.com;
    root        /var/www/kirito/web;
    index       app_dev.php;
    charset     utf-8;
    error_log /var/log/nginx/kirito_error.log;
    access_log /var/log/nginx/kirito_access.log;
    
    location / {
        try_files $uri $uri/ /app_dev.php?_url=$uri&$args;
    }

    location ~ \.php {
        fastcgi_pass  127.0.0.1:9000;
        fastcgi_index /app_dev.php;
        include fastcgi_params;
        fastcgi_split_path_info       ^(.+\.php)(/.+)$;
        fastcgi_param PATH_INFO       $fastcgi_path_info;
        fastcgi_param PATH_TRANSLATED $document_root$fastcgi_path_info;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }

    location ~ /\.ht {
        deny all;
    }
}
```
