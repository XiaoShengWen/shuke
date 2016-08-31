<!DOCTYPE html>
<html lang="en">
<head> 
    <meta charset="UTF-8">
    {% block title %}<title>记录平台</title>{% endblock %}

    <link href="css/metro/bootstrap.min.css" rel="stylesheet">
	<link href="css/metro/bootstrap-responsive.min.css" rel="stylesheet">
	<link href="css/metro/style.css" id="base-style" rel="stylesheet">
    <!--
	<link href="css/metro/style-responsive.css" id="base-style-responsive" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&subset=latin,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>
    -->
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
        {% block content %}
        {% endblock %}
        </div><!--/row-->
    </div><!--/.fluid-container-->

    <!-- 最新版jquery
    <script src="js/metro/jquery-1.9.1.min.js"></script>
    -->
    
    <script src="js/jquery/jquery-3.1.0.min.js" ></script>
    <script src="js/metro/jquery.ui.touch-punch.js"></script>
	<script src="js/metro/jquery-migrate-1.0.0.min.js"></script>
    <script src="js/metro/jquery-ui-1.10.0.custom.min.js"></script>
    <!--
	<script src="js/metro/jquery.flot.js"></script>
	<script src="js/metro/jquery.flot.pie.js"></script>
	<script src="js/metro/jquery.flot.stack.js"></script>
	<script src="js/metro/jquery.flot.resize.min.js"></script>
    <script src="js/metro/jquery.chosen.min.js"></script>
    <script src="js/metro/jquery.uniform.min.js"></script>
    <script src="js/metro/jquery.cleditor.min.js"></script>
    <script src="js/metro/jquery.noty.js"></script>
    <script src="js/metro/jquery.elfinder.min.js"></script>
    <script src="js/metro/jquery.raty.min.js"></script>
    <script src="js/metro/jquery.iphone.toggle.js"></script>
    <script src="js/metro/jquery.uploadify-3.1.min.js"></script>
    <script src="js/metro/jquery.gritter.min.js"></script>
    <script src="js/metro/jquery.imagesloaded.js"></script>
    <script src="js/metro/jquery.masonry.min.js"></script>
    <script src="js/metro/jquery.knob.modified.js"></script>
    <script src="js/metro/jquery.sparkline.min.js"></script>
    <script src="js/metro/counter.js"></script>
    <script src="js/metro/retina.js"></script>
    <script src="js/metro/custom.js"></script>
    <script src="js/metro/modernizr.js"></script>
    <script src="js/metro/bootstrap.min.js"></script>
    <script src="js/metro/jquery.cookie.js"></script>
    <script src='js/metro/fullcalendar.min.js'></script>
    <script src='js/metro/jquery.dataTables.min.js'></script>
    <script src="js/metro/excanvas.js"></script>
    -->

    {% block foot_script %}{% endblock %}
</body>
</html>
