# 博客一键部署版
## 使用说明
  - git clone 
  - 修改.env中的相关环境变量
  - 执行install.bash
## nginx
  - 目录结构
    - ./nginx/nginx.conf:/etc/nginx/nginx.conf
    - ./nginx/sites:/etc/nginx/sites-enable
    - conf.d在nginx.conf中被关闭
  - 配置过程中如果要添加php-fpm可参照./nginx/sites/test
## mysql
  - 目录结构
    - ./my.cnf
    - ./mysql/
  - version: 8.0
  - 为了适配php，默认的用户密码加密方式被修改mysql_native_password
## php-fpm
  - version: 7.2
  - 自带composer
