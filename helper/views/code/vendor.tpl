{# ./application/views/welcome/setting.tpl #}

{% extends "base/main.tpl" %}

{% set title = '类库选择' %}

{% block content %}
    <div class="block">
        <a href="#controller-setting" class="block-heading" data-toggle="collapse">{{ title }}</a>
        <div id="controller-setting" class="block-body collapse in">
        <form id="form"  method="post" action="" style="margin-top:20px;">
            <div class="control-group" style="clear:both;">
                <label class="control-label"></label>
                <div class="controls">
{% for key, val in vendor %}
                <label class="checkbox inline" {% if loop.first %}style="margin-left:10px;"{% endif %}>
                    <input type="checkbox" value="{{ key }}" name="vendor[]" {% if key in project.project_vendor %}checked="checked"{% endif %}> {{ val }}
                </label>
{% else %}
                <div class="controls">
                    <label>无可选类库</label>
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
        var vendor = new Array();
        $("input[name='vendor[]']:checked").each(function(){
            vendor.push($(this).val());
        });
        if(! vendor.length) {
            alert('请选择类库');
            return false;
        }
        $("#generator").attr("disabled", true);
        
        $.post('{{ create_url('code/vendor_helper') }}', {
            "project_vendor" : vendor.join('|')
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