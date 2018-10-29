# dnmp
## 使用说明
  - 修改.env中的相关环境变量
  - 在docker-compose.yml所在目录执行`docker-compose up -d`
## nginx
  - 目录结构
    - ./nginx/nginx.conf:/etc/nginx/nginx.conf
    - ./nginx/sites:/etc/nginx/sites-enable
    - conf.d在nginx.conf中被关闭
  - 配置过程中如果要添加php-fpm可参照./nginx/sites/test
## mysql
  - version: 8.0
  - 为了适配php，默认的用户密码加密方式被修改mysql_native_password
## php-fpm
  - version: 7.2
  - 自带composer
