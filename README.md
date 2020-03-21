#README
PHP Captcha
#Demo
![captcha](demo.png)


#使用 use
####直接使用
````
echo new Captcha($w,$h,$num)
````

####链式方法
######自定义要生成的字符串
````
$captcha=new Captcha();
echo $captcha->setText()->display();
````

####校验

````
$captcha->verify();
````

