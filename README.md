# 博客一键部署版
博客原地址：https://github.com/Yipartner/pub2.0

## docker版本要求
  - docker version：17.0+
    - 按官网的docker-ce安装步骤来
  - docker-compose:1.17.1+
    - apt-get install docker-compose
    
## 使用说明
  - git clone 
  - 修改.env中的相关环境变量
  - 执行install.bash（建议在root用户下执行，因为包含文件创建操作）
  
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
