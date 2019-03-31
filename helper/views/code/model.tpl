{# ./application/views/welcome/model.tpl #}

{% extends "base/main.tpl" %}

{% set title = '模型生成器' %}

{% block content %}
    <div class="block">
        <a href="#model-list" class="block-heading" data-toggle="collapse">{{ title }}</a>
        <div id="model-list" class="block-body collapse in">
        <form id="form-table" method="post" action="" style="margin-top:10px;">
            <div class="control-group">
                <label class="control-label" for="table">表名</label>
                <div class="controls">
                    <input type="text" name="table" id="table" class="input-xlarge" value="" placeholder="表名">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="model">模型名</label>
                <div class="controls">
                    <input type="text" name="model" id="model" class="input-xlarge" value="" placeholder="模型名">
                </div>
            </div>
            <div class="btn-toolbar">
                <button class="btn btn-primary" id="generator"><i class="icon-plus"></i> 生成</button>
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
        $("#generator").attr("disabled", true);
        $.post('{{ create_url('code/model_helper') }}', {"table": $("#table").val(), "model" : $("#model").val()}, function(msg){
            $("#result").html('');
            $("#result").prepend(msg);
        });
        $("#generator").attr("disabled", false);
        return false;
    });
});
</script>
{% endblock %}