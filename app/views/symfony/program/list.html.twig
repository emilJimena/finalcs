{% extends "base.html.twig" %}

{% block title %}Programs - School Encoding Module{% endblock %}

{% block content %}
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title mb-0">Programs</h1>
    {% if app.session.get('account_type') in ['admin', 'staff'] %}
    <a href="{{ path('app_program_new') }}" class="btn btn-success">+ New Program</a>
    {% endif %}
</div>

{% if programs|length > 0 %}
<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Code</th>
                <th>Title</th>
                <th>Years</th>
                {% if app.session.get('account_type') in ['admin', 'staff'] %}
                <th>Actions</th>
                {% endif %}
            </tr>
        </thead>
        <tbody>
            {% for program in programs %}
            <tr>
                <td>{{ program.code }}</td>
                <td>{{ program.title }}</td>
                <td>{{ program.years }}</td>
                {% if app.session.get('account_type') in ['admin', 'staff'] %}
                <td class="action-buttons">
                    <a href="{{ path('app_program_edit', {programId: program.programId}) }}" 
                       class="btn btn-sm btn-info">Edit</a>
                    <form method="POST" action="{{ path('app_program_delete', {programId: program.programId}) }}" 
                          style="display:inline;" onsubmit="return confirm('Are you sure?');">
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
                {% endif %}
            </tr>
            {% endfor %}
        </tbody>
    </table>
</div>
{% else %}
<div class="alert alert-info">
    No programs found. {% if app.session.get('account_type') in ['admin', 'staff'] %}
    <a href="{{ path('app_program_new') }}">Create a new program</a>.
    {% endif %}
</div>
{% endif %}
{% endblock %}
