<?php $this->load->view('base/header');?>

<div class="content">
    <div class="header"><h1 class="page-title">{{ entity.comment }}</h1></div>
    <ul class="breadcrumb">
        <li><a href="<?php echo site_url('');?>">首页</a> <span class="divider">/</span></li>
        <li class="active">{{ entity.comment }}</li>
        <li class="pull-right"><a href="javascript:history.go(-1);">返回</a></li>
    </ul>
    <div class="container-fluid" style="overflow:hidden;">
    <form id="form_search" name="form_search" action="" method="GET" style="margin-bottom:0px">
        <div style="float:left;margin-right:5px">
            <label>{{ entity.fieldDefine[entity.primaryKey]['alias'] }}</label>
            <input type="text" name="{{ entity.primaryKey }}" value="<?php echo isset($search['{{ entity.primaryKey }}']) ? $search['{{ entity.primaryKey }}'] : NULL;?>" placeholder="{{ entity.fieldDefine[entity.primaryKey]['alias'] }}"> 
        </div>
        <div class="btn-toolbar">
            <input type="hidden" name="sortby" id="sortby" value="<?php echo isset($search['sortby']) ? $search['sortby'] : '';?>" />
            <input type="hidden" name="asc" id="asc" value="<?php echo isset($search['asc']) ? $search['asc'] : 0;?>" />
            <button id="btn_search" type="submit" class="btn btn-primary" style="margin-top:25px;"><strong>检索</strong></button>
        </div>
    </form>
    <div class="btn-toolbar">
        <a href="<?php echo site_url('{{ controller_name }}/create');?>"><button class="btn btn-primary"><i class="icon-plus"></i> 新增</button></a>
    </div>
    <div class="block" style="clear:both;">
        <a href="#list" class="block-heading" data-toggle="collapse">列表</a>
        <div id="list" class="block-body collapse in">
            <table class="table table-striped table-hover">
                <thead>
{% for val in entity.field %}
                    <th><span class="tbsort" id="s_{{ val }}"><?php echo $column['{{ val }}'];?></span></th>
{% endfor %}
                    <th>操作</th>
                </thead>
                <tbody>
                <?php foreach($data as $row) :?>
                <tr>
{% for val in entity.field %}
                    {% if entity.primaryKey == val %}<td><a href="<?php echo site_url('{{controller_name}}/detail?{{ entity.primaryKey }}='.$row['{{ entity.primaryKey }}']);?>"><?php echo $row['{{ val }}'];?></a></td>
{% else %}<td><?php echo $row['{{ val }}'];?></td>
{% endif %}
{% endfor %}
                    <td>
                        <a href="<?php echo site_url('{{ controller_name }}/edit?{{ entity.primaryKey }}='.$row['{{ entity.primaryKey }}']);?>" title="编辑"><i class="icon-pencil"></i></a>&nbsp;&nbsp;
                        <a data-toggle="modal" href="#myModal" title="删除"><i class="icon-remove" href="<?php echo site_url('{{ controller_name }}/del?{{ entity.primaryKey }}='.$row['{{ entity.primaryKey }}']);?>#myModal" data-toggle="modal"></i></a>
                    </td>
                </tr>
                <?php endforeach;?>
                </tbody>
            </table> 
            <?php echo $pagination;?>
        </div>
    </div>
    </div>
</div>

<script type="text/javascript">
$().ready(function(){
    $('.icon-remove').click(function(){
        var href=$(this).attr('href');
        bootbox.confirm('是否继续？', function(result) {
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

<?php $this->load->view('base/footer');?>