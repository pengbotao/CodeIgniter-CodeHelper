{# ./application/views/base/menu.tpl #}

<a href="#sidebar_menu_1" class="nav-header collapsed" data-toggle="collapse"><i class="icon-home"></i>控制面板 <i class="icon-chevron-up"></i></a>
<ul id="sidebar_menu_1" class="nav nav-list collapse in">
    <li><a href="{{ create_url('code/setting') }}"><i class="icon-wrench"></i> 初始化</a></li>
    <li><a href="{{ create_url('code/module') }}"><i class="icon-book"></i> 模块</a></li>
    <li><a href="{{ create_url('code/model') }}"><i class="icon-map-marker"></i> 模型</a></li>
    <li><a href="{{ create_url('code/controller') }}"><i class="icon-globe"></i> 控制器</a></li>
    <li><a href="{{ create_url('code/vendor') }}"><i class="icon-shopping-cart"></i> 类库</a></li>
</ul>