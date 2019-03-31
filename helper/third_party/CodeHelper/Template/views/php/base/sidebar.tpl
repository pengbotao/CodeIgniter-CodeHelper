<div class="sidebar-nav">
{% for db, menu in menus %}
{% if menu %}
<a href="#sidebar_menu_{{ loop.index }}" class="nav-header collapsed" data-toggle="collapse"><i class="icon-th"></i>{{ db }}<i class="icon-chevron-up"></i></a>
<ul id="sidebar_menu_{{ loop.index }}" class="nav nav-list collapse in">
    {% for k, v in menu %}
    <li><a href="<?php echo site_url('{{ k ~ '/lists' }}');?>">{{ v }}</a></li>
    {% endfor %}
</ul>
{% endif %}
{% endfor %}

{% if module_menus %}
<a href="#sidebar_menu_setting" class="nav-header collapsed" data-toggle="collapse"><i class="icon-th"></i>系统设置<i class="icon-chevron-up"></i></a>
<ul id="sidebar_menu_setting" class="nav nav-list collapse in">
{% for m in module_menus %}
    <li><a href="<?php echo site_url('{{ m.route }}');?>">{{ m.title }}</a></li>
{% endfor %}
</ul>
{% endif %}

    <footer><hr><p>&copy; {{ "now"|date("Y") }}</p></footer>
</div>