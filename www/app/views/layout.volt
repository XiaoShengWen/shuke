<!DOCTYPE html>
<html lang="en">
<head> 
    <meta charset="UTF-8">
    {% block title %}<title>记录平台</title>{% endblock %}

    <link href="/metro/css/bootstrap.min.css" rel="stylesheet">
	<link href="/metro/css/bootstrap-responsive.min.css" rel="stylesheet">
	<link href="/metro/css/style.css" id="base-style" rel="stylesheet">
	<link href="/metro/css/style-responsive.css" id="base-style-responsive" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&subset=latin,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>
    <script type="text/javascript">
    var $Info = {}; 
    </script>

    {% block head_script %}{% endblock %}
</head>
<body> 
    <!--顶部导航-->
    {% include "common/nav.volt" %}

    <div class="container-fluid-full">
        <div class="row-fluid">
        <!--左侧导航-->
        {% include "common/sidebar-left.volt" %}

        <!--主要内容-->
            <div id="content" class="span10">
                {% block content %}
                {% endblock %}
            </div><!--/#content.span10-->
        </div><!--/row-->
    </div><!--/.fluid-container-->

    <!-- 最新版jquery
    <script src="/js/jquery/jquery-3.1.0.min.js" ></script>
    -->
    
    <script src="/metro/js/jquery-1.9.1.min.js"></script>
    <script src="/metro/js/jquery.ui.touch-punch.js"></script>
	<script src="/metro/js/jquery-migrate-1.0.0.min.js"></script>
    <script src="/metro/js/jquery-ui-1.10.0.custom.min.js"></script>
	<script src="/metro/js/jquery.flot.js"></script>
	<script src="/metro/js/jquery.flot.pie.js"></script>
	<script src="/metro/js/jquery.flot.stack.js"></script>
	<script src="/metro/js/jquery.flot.resize.min.js"></script>
    <script src="/metro/js/jquery.chosen.min.js"></script>
    <script src="/metro/js/jquery.uniform.min.js"></script>
    <script src="/metro/js/jquery.cleditor.min.js"></script>
    <script src="/metro/js/jquery.noty.js"></script>
    <script src="/metro/js/jquery.elfinder.min.js"></script>
    <script src="/metro/js/jquery.raty.min.js"></script>
    <script src="/metro/js/jquery.iphone.toggle.js"></script>
    <script src="/metro/js/jquery.uploadify-3.1.min.js"></script>
    <script src="/metro/js/jquery.gritter.min.js"></script>
    <script src="/metro/js/jquery.imagesloaded.js"></script>
    <script src="/metro/js/jquery.masonry.min.js"></script>
    <script src="/metro/js/jquery.knob.modified.js"></script>
    <script src="/metro/js/jquery.sparkline.min.js"></script>
    <script src="/metro/js/counter.js"></script>
    <script src="/metro/js/retina.js"></script>
    <script src="/metro/js/custom.js"></script>
    <script src="/metro/js/modernizr.js"></script>
    <script src="/metro/js/bootstrap.min.js"></script>
    <script src="/metro/js/jquery.cookie.js"></script>
    <script src='/metro/js/fullcalendar.min.js'></script>
    <script src='/metro/js/jquery.dataTables.min.js'></script>
    <script src="/metro/js/excanvas.js"></script>

    <script src="/js/jquery/jquery.namespace.js"></script>
    {% block foot_script %}{% endblock %}
</body>
</html>
