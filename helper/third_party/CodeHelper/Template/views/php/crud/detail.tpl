<?php $this->load->view('base/header');?>

<div class="content">
    <div class="header"><h1 class="page-title">{{ entity.comment }}</h1></div>
    <ul class="breadcrumb">
        <li><a href="<?php echo site_url('');?>">首页</a> <span class="divider">/</span></li>
        <li class="active">{{ entity.comment }}</li>
        <li class="pull-right"><a href="javascript:history.go(-1);">返回</a></li>
    </ul>
    <div class="container-fluid">
        <div class="btn-toolbar">
            <a href="<?php echo site_url('{{ controller_name }}/create');?>"><button class="btn btn-primary"><i class="icon-plus"></i> 新增</button></a>
            <a href="<?php echo site_url('{{ controller_name }}/edit?{{ entity.primaryKey }}='.$data['{{ entity.primaryKey }}']);?>" style="margin-left:5px"><button class="btn btn-primary"><i class="icon-edit"></i> 编辑</button></a>
        </div>
        <div class="block">
            <a href="#detail" class="block-heading" data-toggle="collapse">{{ entity.comment }}列表</a>
            <div id="detail" class="block-body collapse in">
            <table class="table table-striped">
            {% for val in entity.field %}    <tr>
                    <td><?php echo $column['{{ val }}'];?></td>
                    <td><?php echo $data['{{ val }}'];?></td>
                </tr>
            {% endfor %}</table>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('base/footer');?>