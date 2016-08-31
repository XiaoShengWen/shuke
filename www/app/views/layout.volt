<!DOCTYPE html>
<html lang="en">
<head> 
    <meta charset="UTF-8">
    {% block title %}<title>记录平台</title>{% endblock %}
    <link href="/css/bootstrap/bootstrap-theme.css" rel="stylesheet">
    <link href="/css/bootstrap/bootstrap-theme.min.css" rel="stylesheet">
    <link href="/css/bootstrap/bootstrap.css" rel="stylesheet">
    <link href="/css/bootstrap/bootstrap.min.css" rel="stylesheet">
    {% block head_script %}{% endblock %}
</head>
<body> 
    {% block content %}{% endblock %}
    <script type="text/javascript" src="/js/jquery/jquery-3.1.0.min.js" ></script>
    <script type="text/javascript" src="/js/bootstrap/bootstrap.js" ></script>
    <script type="text/javascript" src="/js/bootstrap/bootstrap.min.js" ></script>
    {% block foot_script %}{% endblock %}
</body>
</html>
