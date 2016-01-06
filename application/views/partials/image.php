<article>
    <heading></heading>
    <content>
        <img src="{{ image.url }}" alt="{{ image.title }}" />
        {% if image.tags %}
        <ul class="tags">
            {% for tag in image.tags %}
                <li class="tag">{{ tag }}</li>
            {% endfor %}
        </ul>
        {% endif %}
    </content>
</article>