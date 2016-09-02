<div class="pagination pagination-centered">
    <ul>
        <li><a href="{{ href['page'] }}{{ page.first }}">首页</a></li>
        <li><a href="{{ href['page'] }}{{ page.before }}"> &lt </a></li>
        {% if page.current == page.first %}
        <li class="active"><a href="{{ href['page'] }}{{ page.current }}">{{ page.current }}</a></li>
        <li><a href="{{ href['page'] }}{{ page.current + 1 }}">{{ page.current + 1 }}</a></li>
            {%if page.last > 2%}
        <li><a href="{{ href['page'] }}{{ page.current + 2 }}">{{ page.current + 2 }}</a></li>
            {%endif%}
        {% elseif page.current == page.last %}
            {%if page.last > 2%}
        <li><a href="{{ href['page'] }}{{ page.current - 2}}">{{ page.current - 2}}</a></li>
            {%endif%}
        <li><a href="{{ href['page'] }}{{ page.current - 1 }}">{{ page.current - 1 }}</a></li>
        <li class="active"><a href="{{ href['page'] }}{{ page.current }}">{{ page.current }}</a></li>
        {% else %}
        <li><a href="{{ href['page'] }}{{ page.current - 1 }}">{{ page.current - 1 }}</a></li>
        <li class="active"><a href="{{ href['page'] }}{{ page.current }}">{{ page.current }}</a></li>
        <li><a href="{{ href['page'] }}{{ page.current + 1 }}">{{ page.current + 1 }}</a></li>
        {% endif %}

        <li><a href="{{ href['page'] }}{{ page.next }}"> &gt </a></li>
        <li><a href="{{ href['page'] }}{{ page.last }}">末页</a></li>
    </ul>
</div>     
