{# ./application/views/base/base.tpl #}
<!DOCTYPE html>
<html lang="en">
<head>
<title>{% block title %}{% endblock %}</title>
{% block meta %}
<meta charset="utf-8">
<meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
{% endblock %}
{% block stylesheet %}{% endblock %}
{% block script %}{% endblock %}
<!--[if lt IE 9]>
      <script src="{{ base_url('assets/js/html5.js') }}"></script>
<![endif]-->
</head>

<!--[if lt IE 7 ]> <body class="ie ie6"> <![endif]-->
<!--[if IE 7 ]> <body class="ie ie7 "> <![endif]-->
<!--[if IE 8 ]> <body class="ie ie8 "> <![endif]-->
<!--[if IE 9 ]> <body class="ie ie9 "> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<body class=""><!--<![endif]-->
{% block body %}
    {% block container %}{% endblock %}
    {% block js %}{% endblock %}
{% endblock %}
</body>
</html>