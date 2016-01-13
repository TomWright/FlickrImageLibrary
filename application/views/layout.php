<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="UTF-8">

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

        <div class="main container">

            {% include 'partials/header.php' %}

            <div class="row">
                <div class="col-md-12">
                    <section class="content main">
                        {% block content %}{% endblock %}
                    </section>
                </div>
            </div>

        </div>

        {% block bodyStyles %}
            <link rel="stylesheet" href="/css/style.css" />
        {% endblock %}
        {% block bodyScripts %}
            <script src="/js/jquery.ba-throttle-debounce.min.js"></script>
            <script src="/js/main.js"></script>
        {% endblock %}

    </body>
</html>