<!DOCTYPE html>
<html>
    <head>
        <title>
            {% block title %}Flickr Image Library{% endblock %}
        </title>
        {% block headStyles %}
            <link rel="stylesheet" href="/css/bootstrap.min.css" />
            <link rel="stylesheet" href="/css/style.css" />
        {% endblock %}
        {% block headScripts %}
            <script src="/js/jquery-1.12.0.min.js"></script>
            <script src="/js/bootstrap.min.js"></script>
        {% endblock %}
    </head>
    <body>
        <section id="sidebar" class="col-md-3 fixed-position">
            {% include 'partials/header.php' %}

            {% include 'partials/filters.php' %}

            <footer id="footer">
                <a href="https://github.com/TomWright">Tom Wright</a> - Flickr Image Library
            </footer>
        </section>

        <section id="mainContentSection" class="col-md-9 normal-scrollable">
            {% block content %}{% endblock %}
        </section>

        {% block bodyStyles %}
            <link rel="stylesheet" href="/css/style.css" />
        {% endblock %}
        {% block bodyScripts %}
            <script src="/js/imagesloaded.pkgd.min.js"></script>
            <script src="/js/masonry.pkgd.min.js"></script>
            <script src="/js/jquery.waypoints.min.js"></script>
            <script src="/js/inview.js"></script>
            <script src="/js/main.js"></script>
        {% endblock %}
    </body>
</html>