<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>注册确认链接</title></head>
<body>
<h1>感谢您在<a href="http://www.blog.com">星期八博客</a>网站进行注册！</h1>
    <p>
        请点击下面的链接完成注册：
        <a href="{{route('confirmUserCreate', $user->activation_token)}}">
            {{route('confirmUserCreate', $user->activation_token)}}
        </a>
    </p>
    <p>
        如果这不是您本人的操作，请忽略此邮件。
    </p>
</body>
</html>