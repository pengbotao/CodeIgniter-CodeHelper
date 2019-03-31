{% raw %}{# ./application/views/{% endraw %}{{ view_file_name }}{% raw %} #}{% endraw %}

{% raw %}{% extends "base/main.tpl" %}{% endraw %}

{{ '{%' }} set title = '{{ entity.comment }}' {{ '%}' }}

{% raw %}{% block content %}{% endraw %}
<div class="well">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#home" data-toggle="tab">请填写资料</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active in" id="home">
            <form id="form" method="post" action="{{ '{{' }} site_url('{{ controller_name }}/verify') {{ '}}' }}">
{% for val in entity.field %}{% if val != entity.primaryKey %}
            <div class="control-group">
                <label class="control-label" for="{{ val }}">{{ '{{ column.' }}{{ val }} {{ '}}' }}</label>
                <div class="controls">
                    <input type="text" name="data[{{ val }}]" id="{{ val }}" class="input-xlarge" value="{{ '{{ data.'}}{{ val }} {{ '}}' }}">
                </div>
            </div>
{% endif %}{% endfor %}
            <div class="control-group">
                <label class="control-label"></label>
                <input type="hidden" name="_captcha" value="{% raw %}{{ captcha }}{% endraw %}">
                <input type="hidden" name="_action" value="{% raw %}{{ action }}{% endraw %}">
                <input type="hidden" name="{{ entity.primaryKey }}" value="{{ '{{' }} data.{{ entity.primaryKey }} {{ '}}' }}">
                <div class="controls"><button type="submit" class="btn btn-primary"><strong>提交</strong></button></div>
            </div>
            </form>
        </div>
    </div>
</div>
{% raw %}{% endblock %}{% endraw %}

{% raw %}{% block js %}{% endraw %}{% if form_rules %}
<script type="text/javascript">
$().ready(function(){
    $("#form").validate({
        rules:{
{% for key, val in entity.fieldDefine %}
{% if key != entity.primaryKey and val.required %}
            'data[{{ key }}]' : {'required' : true}{% if not loop.last %},{% endif %}

{% endif %}
{% endfor %}
        }
    });
});
</script>
{% endif %}{% raw %}{% endblock%}{% endraw %}

{% raw %}{% block script %}
{{ parent() }}
<script src="{{ base_url('assets/lib/validate/jquery.validate.min.js') }}"></script>
<script src="{{ base_url('assets/lib/validate/messages_zh.js') }}"></script>
{% endblock %}{% endraw %}