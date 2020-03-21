# README
PHP Captcha
# Demo
![captcha](demo.png)

# 安装
#### composer
````composer require tanchengjin/captcha````
#### github
````git clone git@github.com:tanchengjin/captcha.git````


# 使用 use
#### 直接使用
````
echo new Captcha($w,$h,$num)
````

#### 链式方法
###### 自定义要生成的字符串，如生成纯数字
````
$captcha=new Captcha();
echo $captcha->setText('0123456789')->display();
````

#### 校验

````
$captcha->verify();
````

