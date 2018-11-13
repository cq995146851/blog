<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>密码找回链接</title></head>
<body>
<p>
    请点击下面的链接完成密码重置,两小时内有效:
    <a href="{{route('confirmResetPassword', [$token, $email])}}">
        {{route('confirmResetPassword', [$token, $email])}}
    </a>
</p>
<p>
    如果这不是您本人的操作，请忽略此邮件。
</p>
</body>
</html>