{% raw %}{# ./application/views/{% endraw %}{{ view_file_name }}{% raw %} #}

{% extends "base/main.tpl" %}

{% set title = '登录' %}

{% block container %}
<div class="navbar">
    <div class="navbar-inner">
        <a class="brand" onclick="javascript:void(0);"><span class="second">{% endraw %}{{ project_name }}{% raw %}</span></a>
    </div>
</div>
<div class="container-fluid">
    <div class="row-fluid">
    <div class="dialog">
    {% if message %}
    <div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>{{ message }}</div>
    {% endif %}
        <div class="block">
            <p class="block-heading">登入</p>
            <div class="block-body">
                <form name="login" method="post" action="">
                    <label>账号</label>
                    <input type="text" class="span12" name="username" value="{{ post.username }}" required="true" autofocus="true" autocomplete="off">
                    <label>密码</label>
                    <input type="password" class="span12" name="password" value="" required="true">
                    <label>验证码</label>
                    <input type="text" name="verify_code" class="span4" placeholder="输入验证码" autocomplete="off" required="required">
                    <img title="验证码" id="verify_code" src="{{ site_url('verify_code') }}" style="vertical-align:top">
                    <input type="submit" class="btn btn-primary pull-right" name="loginSubmit" value="登入"></div>
                </form>
            </div>
        </div>
    </div>
    <footer><hr><p>&copy; {{ "now"|date("Y") }}</p></footer>
</div>
{% endblock %}

{% block js %}
<script type="text/javascript">
$().ready(function(){
    $('body').removeClass().addClass('simple_body');
});
</script>
{% endblock %}{% endraw %}