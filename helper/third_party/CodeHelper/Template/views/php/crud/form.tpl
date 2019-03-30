<?php $this->load->view('base/header');?>

<script src="<?php echo base_url('assets/lib/validate/jquery.validate.min.js');?>"></script>
<script src="<?php echo base_url('assets/lib/validate/messages_zh.js');?>"></script>
{% if form_rules %}
<script type="text/javascript">
$().ready(function(){
    $("#form").validate({
        rules:{
{% for key, val in form_rules %}
            'data[{{ key }}]' : {'required' : true}{% if not loop.last %},{% endif %}

{% endfor %}
        }
    });
});
</script>
{% endif %}
<div class="content">
    <div class="header"><h1 class="page-title">{{ entity.comment }}</h1></div>
    <ul class="breadcrumb">
        <li><a href="<?php echo site_url('');?>">首页</a> <span class="divider">/</span></li>
        <li class="active">{{ entity.comment }}</li>
        <li class="pull-right"><a href="javascript:history.go(-1);">返回</a></li>
    </ul>
    <div class="container-fluid">
        <div class="well">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#home" data-toggle="tab">请填写资料</a></li>
            </ul>    
            <div class="tab-content">
                <div class="tab-pane active in" id="home">
                <form id="form" method="post" action="<?php echo site_url('{{ controller_name }}/verify');?>">
{% for val in entity.field %}
    {% if val != entity.primaryKey %}
        <div class="control-group">
                    <label class="control-label" for="{{ val }}"><?php echo $column['{{ val }}'];?></label>
                    <div class="controls">
                        <input type="text" name="data[{{ val }}]" id="{{ val }}" class="input-xlarge" value="<?php echo isset($data['{{ val }}']) ? $data['{{ val }}'] : NULL;?>">
                    </div>
                </div>
    {% endif %}
{% endfor %}            <div class="control-group">
                        <label class="control-label"></label>
                        <input type="hidden" name="_captcha" value="<?php echo isset($captcha) ? $captcha : NULL;?>">
                        <input type="hidden" name="_action" value="<?php echo $action;?>">
                        <input type="hidden" name="{{ entity.primaryKey }}" value="<?php echo isset($data['{{ entity.primaryKey }}']) ? $data['{{ entity.primaryKey }}'] : NULL;?>">
                        <div class="controls"><button type="submit" class="btn btn-primary"><strong>提交</strong></button></div>
                </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('base/footer');?>