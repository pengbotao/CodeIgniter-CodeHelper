{# ./application/views/welcome/setting.tpl #}

{% extends "base/main.tpl" %}

{% set title = '模块选择' %}

{% block content %}
    <div class="block">
        <a href="#controller-setting" class="block-heading" data-toggle="collapse">{{ title }}</a>
        <div id="controller-setting" class="block-body collapse in">
        <form id="form"  method="post" action="" style="margin-top:20px;">
            <div class="control-group" style="clear:both;">
                <label class="control-label"></label>
                <div class="controls">
{% for key, val in module %}
                <label class="checkbox inline" {% if loop.first %}style="margin-left:10px;"{% endif %}>
                    <input type="checkbox" value="{{ key }}" name="module[]" {% if key in project.project_module %}checked="checked"{% endif %}> {{ val }}
                </label>
{% else %}
                <div class="controls">
                    <label>无可选模块</label>
                </div>
{% endfor %}
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="generator"></label>
                <div class="controls">
                    <button class="btn btn-primary" id="generator"><i class="icon-plus"></i> 生成</button>
                </div>
            </div>
        </form>
        </div>
    </div>
    <div id="result"></div>
{% endblock %}

{% block js %}
<script type="text/javascript">
$().ready(function(){
    $("#generator").click(function(){
        var module = new Array();
        $("input[name='module[]']:checked").each(function(){
            module.push($(this).val());
        });
        if(! module.length) {
            alert('请选择模块');
            return false;
        }
        $("#generator").attr("disabled", true);
        
        $.post('{{ create_url('code/module_helper') }}', {
            "project_module" : module.join('|')
        }, function(msg){
            $("#result").html('');
            $("#result").prepend(msg);
        });
        $("#generator").attr("disabled", false);
        return false;
    });
});
</script>
{% endblock %}