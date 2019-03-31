{# ./application/views/base/main.tpl #}

{% extends "base/base.tpl" %}

{% block title %}{{ title }} - 代码神器{% endblock %}

{% block stylesheet %}
<link rel="stylesheet" href="{{ base_url('assets/lib/bootstrap/css/bootstrap.css') }}">
<link rel="stylesheet" href="{{ base_url('assets/stylesheets_schoolpainting/theme.css') }}">
<link rel="stylesheet" href="{{ base_url('assets/lib/font-awesome/css/font-awesome.css') }}">
<link rel="stylesheet" href="{{ base_url('assets/css/other.css') }}">
{% endblock %}

{% block script %}
<script src="{{ base_url('assets/lib/jquery/jquery-1.8.1.min.js') }}"></script>
<script src="{{ base_url('assets/lib/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ base_url('assets/lib/bootstrap/js/bootbox.min.js') }}"></script>
{% endblock %}

{% block container %}

{% block navbar %}
<div class="navbar">
    <div class="navbar-inner">
        <a class="brand" href="{{ create_url() }}"><span class="second">代码神器</span></a>
        <ul class="nav pull-right">
            <li id="fat-menu"><a href="{{ create_url('code/helper') }}"> <i class="icon-question-sign"></i> 帮助</a></li>
        </ul>
    </div>
</div>
{% endblock %}

{% block sidebar %}
<div class="sidebar-nav">
    {% block menu %}
    {% include "base/menu.tpl" %}
    {% endblock %}
</div>
{% endblock %}

{% block main %}
<div class="content">
    <div class="header"><h1 class="page-title">{% block page_title %}{{title}}{% endblock %}</h1></div>
    <ul class="breadcrumb">
        <li><a href="{{ create_url() }}">首页</a> <span class="divider">/</span></li>
        {% block breadcrumb %}{% endblock %}
        <li class="active">{{ title }}</li>
        <li class="pull-right"><a href="javascript:history.go(-1);">返回</a></li>
    </ul>
    <div class="container-fluid">
        {% block content %}{% endblock %}
    </div>
</div>
{% endblock %}

{% endblock %}