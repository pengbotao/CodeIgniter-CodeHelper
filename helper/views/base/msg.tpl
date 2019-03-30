{# ./application/views/base/msg.tpl #}

{% extends "base/main.tpl" %}

{% set title = '系统提醒' %}

{% block main %}
<div class="content">
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="http-error">
                <h1>O~!</h1>
                <p class="info">{{ message }}</p>
                {% if url %}
                <h2>返回 <a href="{{ create_url(url) }}">{% if not url_title %}{{ create_url(url) }}{% else %}{{ url_title }}{% endif %}</a></h2>
                {% else %}
                <h2><a href="javascript:history.go(-1);">返回</a></h2>
                {% endif %}
            </div>
        <div>
    </div>
</div>
{% endblock %}