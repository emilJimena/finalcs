{% extends "base.html.twig" %}

{% block title %}Subjects - School Encoding Module{% endblock %}

{% block content %}
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title mb-0">Subjects</h1>
    {% if app.session.get('account_type') in ['admin', 'staff'] %}
    <a href="{{ path('app_subject_new') }}" class="btn btn-success">+ New Subject</a>
    {% endif %}
</div>

{% if subjects|length > 0 %}
<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Code</th>
                <th>Title</th>
                <th>Unit</th>
                {% if app.session.get('account_type') in ['admin', 'staff'] %}
                <th>Actions</th>
                {% endif %}
            </tr>
        </thead>
        <tbody>
            {% for subject in subjects %}
            <tr>
                <td>{{ subject.code }}</td>
                <td>{{ subject.title }}</td>
                <td>{{ subject.unit }}</td>
                {% if app.session.get('account_type') in ['admin', 'staff'] %}
                <td class="action-buttons">
                    <a href="{{ path('app_subject_edit', {subjectId: subject.subjectId}) }}" 
                       class="btn btn-sm btn-info">Edit</a>
                    <form method="POST" action="{{ path('app_subject_delete', {subjectId: subject.subjectId}) }}" 
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
    No subjects found. {% if app.session.get('account_type') in ['admin', 'staff'] %}
    <a href="{{ path('app_subject_new') }}">Create a new subject</a>.
    {% endif %}
</div>
{% endif %}
{% endblock %}
