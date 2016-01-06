<!DOCTYPE html>
<html>
    <head>
        {% block head %}
        <link rel="stylesheet" href="/css/style.css" />
        <title>
            {% block title %}Flickr Image Library{% endblock %}
        </title>
        {% endblock %}
    </head>
    <body>
        {% include 'partials/header.php' %}

        {% include 'partials/filters.php' %}
        <content id="content">
            {% block content %}{% endblock %}
        </content>
        <footer id="footer">
            {% block footer %}
            <a href="https://github.com/TomWright">Tom Wright</a> - Flickr Image Library
            {% endblock %}
        </footer>
    </body>
</html>