{% raw %}{# ./application/views/{% endraw %}{{ view_file_name }}{% raw %} #}{% endraw %}

{% raw %}{% extends "base/main.tpl" %}{% endraw %}

{{ '{%' }} set title = '{{ entity.comment }}' {{ '%}' }}

{% raw %}{% block content %}{% endraw %}
    <div class="btn-toolbar">
        <a href="{{ '{{' }} site_url('{{ controller_name }}/create') {{ '}}' }}"><button class="btn btn-primary"><i class="icon-plus"></i> 新增</button></a>
        <a href="{{ '{{' }} site_url('{{ controller_name }}/edit?{{ entity.primaryKey }}=' ~ data.{{ entity.primaryKey }}) {{ '}}' }}" style="margin-left:5px"><button class="btn btn-primary"><i class="icon-edit"></i> 编辑</button></a>
    </div>
    <div class="block">
        <a href="#detail" class="block-heading" data-toggle="collapse">{{ '{{' }} title {{ '}}' }}列表</a>
        <div id="detail" class="block-body collapse in">
            <table class="table table-striped">
            {% for val in entity.field %}    <tr>
                    <td>{{ '{{ column.' }}{{ val }} {{ '}}' }}</td>
                    <td>{{ '{{ data.'}}{{ val }} {{ '}}' }}</td>
                </tr>
            {% endfor %}</table>
        </div>
    </div>
{% raw %}{% endblock %}{% endraw %}