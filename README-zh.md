# 学生成绩发布管理系统

## 运行前需求(Windows)

请在运行之前确认您已安装 nodejs, apache2, php^7, composer, MongoDB,并进行以下步骤。

> 将'api'文件夹映射到 apache 服务器根目录中。
>
> 依照数据规范在 Mongo 中添加实例用户。
>
> 安装 [php_mongo](https://docs.mongodb.com/php-library/master/tutorial/install-php-library/) 扩展。

## 运行

```
cd api
composer install //安装mongodb扩展
cd ..
npm install
npm run dev
```

## License

[MIT](https://github.com/PanJiaChen/vue-admin-template/blob/master/LICENSE) license.
