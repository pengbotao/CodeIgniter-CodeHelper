{% raw %}{# ./application/views/{% endraw %}{{ view_file_name }}{% raw %} #}{% endraw %}

{% raw %}{% extends "base/main.tpl" %}{% endraw %}

{{ '{%' }} set title = '{{ entity.comment }}' {{ '%}' }}

{% raw %}{% block content %}{% endraw %}
    <form id="form_search" name="form_search" action="" method="GET" style="margin-bottom:0px">
        <div style="float:left;margin-right:5px">
            <label>{{ entity.fieldDefine[entity.primaryKey]['alias'] }}</label>
            <input type="text" name="{{ entity.primaryKey }}" value="{% raw %}{{ search.{% endraw %}{{ entity.primaryKey }}{% raw %} }}{% endraw %}" placeholder="{{ entity.fieldDefine[entity.primaryKey]['alias'] }}"> 
        </div>
        <div class="btn-toolbar">
            <input type="hidden" name="sortby" id="sortby" value="{% raw %}{{ search.sortby }}{% endraw %}" />
            <input type="hidden" name="asc" id="asc" value="{% raw %}{{ search.asc|default(0) }}{% endraw %}" />
            <button id="btn_search" type="submit" class="btn btn-primary" style="margin-top:25px;"><strong>检索</strong></button>
        </div>
    </form>
    <div class="btn-toolbar">
        <a href="{{ '{{' }} site_url('{{ controller_name }}/create') {{ '}}' }}"><button class="btn btn-primary"><i class="icon-plus"></i> 新增</button></a>
    </div>
    <div class="block" style="clear:both;">
        <a href="#list" class="block-heading" data-toggle="collapse">{% raw %}{{ title }}{% endraw %}列表</a>
        <div id="list" class="block-body collapse in">
            <table class="table table-striped table-hover">
                <thead>
{% for val in entity.field %}
                    <th><span class="tbsort" id="s_{{ val }}">{{ '{{ column.' }}{{ val }} {{ '}}' }}</span></th>
{% endfor %}
                    <th>操作</th>
                </thead>
                <tbody>
                {% raw %}{% for row in data %}{% endraw %}
                <tr>
{% for val in entity.field %}{% if entity.primaryKey == val %}
                    <td><a href="{{ '{{' }} site_url('{{ controller_name }}/detail?{{ entity.primaryKey }}=' ~ row.{{ entity.primaryKey }}) {{ '}}' }}">{{ '{{ row.' }}{{ val }} {{ '}}' }}</a></td>
{% else %}
                    <td>{{ '{{ row.' }}{{ val }} {{ '}}' }}</td>
{% endif %}
{% endfor %}                    <td>
                        <a href="{{ '{{' }} site_url('{{ controller_name }}/edit?{{ entity.primaryKey }}=' ~ row.{{ entity.primaryKey }}) {{ '}}' }}" title="编辑"><i class="icon-pencil"></i></a>&nbsp;&nbsp;
                        <a data-toggle="modal" href="#myModal" title="删除"><i class="icon-remove" href="{{ '{{' }} site_url('{{ controller_name }}/del?{{ entity.primaryKey }}=' ~ row.{{ entity.primaryKey }}) {{ '}}' }}#myModal" data-toggle="modal"></i></a>
                    </td>
                </tr>
                {% raw %}{% endfor %}{% endraw %}
                </tbody>
            </table> 
            {% raw %}{{ pagination|raw }}{% endraw %}
        </div>
    </div>
{% raw %}{% endblock %}{% endraw %}

{% raw %}{% block js %}
<script type="text/javascript">
$().ready(function(){
    $('.icon-remove').click(function(){
        var href=$(this).attr('href');
        bootbox.confirm('删除后将无法恢复，是否继续？', function(result) {
            if(result){
                location.replace(href);
           }
        });
    });
    $('.tbsort').click(function(){
        if($('#sortby').val() == $(this).attr('id').substring(2)) {
            $('#asc').val(1 ^ $('#asc').val());
        } else {
            $('#asc').val(0);
        }
        $('#sortby').val($(this).attr('id').substring(2));
        document.form_search.submit();
    });
    if($('#sortby').val()) {
        if(parseInt($('#asc').val())) {
            $('#s_' + $('#sortby').val()).append(' <i class="icon-caret-up"></i>');
        } else {
            $('#s_' + $('#sortby').val()).append(' <i class="icon-caret-down"></i>');
        }
    }
});
</script>
{% endblock %}{% endraw %}