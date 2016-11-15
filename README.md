# api-skeleton

##部署方案

	ngnix 
	    server {
        listen       80;
        server_name  api.localhost.com;
        root  root;
	index api.php index.html;

        location / {
            try_files $uri $uri/ /api.php?$args;
	}
        # proxy the PHP scripts to Apache listening on 127.0.0.1:80
        #
        #location ~ \.php$ {
        #    proxy_pass   http://127.0.0.1;
        #}
        # pass the PHP scripts to FastCGI server listening on 127.0.0.1:9000
        location ~ \.php$ {
            fastcgi_pass   127.0.0.1:9000;
            fastcgi_index  api.php;
            fastcgi_param  SCRIPT_FILENAME  $document_root/$fastcgi_script_name;
            include        fastcgi_params;
        }
    }


##执行composer 
   composer install
	如果下载不了可以直接加我qq 945558163

##预览方式
###接口地址
[http://api.localhost.com](http://api.localhost.com)
###文档地址
[api.localhost.com/doc  
](http://api.localhost.com/doc )  这个是自动化文档

###restler3

[http://restler3.luracast.com/](http://restler3.luracast.com/)

###laraval 文档
[http://www.golaravel.com/laravel/docs/5.1/](http://www.golaravel.com/laravel/docs/5.1/)

###效果演示地址
 [点击查看](http://121.40.203.96:81/doc/#!/grade/lists_get)