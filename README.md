# 系统简介

代码生成器(CH)，是一个基于Codeigniter框架而研发的自动代码生成系统，可生成以下功能：

- 快速生成模版，一键生成控制器、模型、视图
- 快速构建登录、CRUD、搜索、排序、表单校验等功能
- 支持PHP原生模版和Twig模版

# 系统安装

- 根目录有三个文件夹，system为Codeigniter框架，版本为2.1x，public为外部可访问目录，helper为代码生成器应用
- 将项目放入web目录，并配置需要生成的数据库帐号，开发环境下建议配置方式：拷贝./helper/config/database.php 到 ./helper/config/development/database.php，并修改其中的数据库配置信息；生成环境可直接修改./helper/config/database.php
- 导入helper/sql/helper.sql文件，该文件会创建admin表，用来验证用户登录，执行成功后会自动添加一条记录，帐号为admin 密码为 123456
- 确认服务器已开启rewrite，访问public下的index.php 即可看到登录界面，帐号/密码：admin/123456

# 系统使用

- 项目初始化设置，点击设置按钮系统会自动创建application文件夹，该文件夹与helper同级
- 切换到模型界面，在无任何输入的情况下点击生成可生成数据库中所有表的模型，如需生成指定模型，可根据提示填写，admin模型需要生成，否则无法登录。
- 切换到控制器界面，操作与模型相同
- 操作完毕后修改public下的index.php中76行的应用目录，将目录修改为application
<pre><code class="php">$application_folder = '../helper';</code></pre>
- 重新访问public下的index.php，即可看到已生成的项目。

_备注：所有功能均根据数据库表结构生成，字段名、模块名根据注释生成，注释太长可用 | 分隔_

# 说明

- 项目基于Codeigniter运行，CI框架未做任何更改，生成的application即为Codeigniter框架中的应用目录
- 界面使用bootstrap，界面模版来源于osadmin
- 数据库账户需有读取information_schema的权限