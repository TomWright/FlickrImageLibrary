{% extends activeLayout %}

{% block title %}
    {{ parent() }}
{% endblock %}

{% block content %}
    <div id="imagesContainer" class="grid">
        <div class="grid-sizer"></div>
        <div class="gutter-sizer"></div>
    </div>
    <div id="flickrLoadingBar">
        <img src="/img/loading_spinner_circle.gif" alt="Loading">
    </div>
{% endblock %}

{% block headStyles %}
    {{ parent() }}
{% endblock %}

{% block headScripts %}
    {{ parent() }}
{% endblock %}

{% block bodyStyles %}
    {{ parent() }}
{% endblock %}

{% block bodyScripts %}
    {{ parent() }}
    <script src="/js/imagesloaded.pkgd.min.js"></script>
    <script src="/js/masonry.pkgd.min.js"></script>
    <script src="/js/jquery.waypoints.min.js"></script>
    <script src="/js/inview.js"></script>
    <script src="/js/masonry_scripts.js"></script>
{% endblock %}
