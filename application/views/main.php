{% extends activeLayout %}

{% block title %}
    {{ parent() }}
{% endblock %}

{% block content %}
    <h1>Index</h1>
    <p class="important">
        Welcome on my awesome homepage.
    </p>
    <div id="imagesContainer" class="grid"></div>
    <div id="loadingBar">
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
{% endblock %}
