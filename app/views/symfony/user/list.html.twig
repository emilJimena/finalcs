{% extends "base.html.twig" %}

{% block title %}Users - School Encoding Module{% endblock %}

{% block content %}
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title mb-0">Users</h1>
    <a href="{{ path('app_user_new') }}" class="btn btn-success">+ New User</a>
</div>

{% if users|length > 0 %}
<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Username</th>
                <th>Account Type</th>
                <th>Created On</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            {% for user in users %}
            <tr>
                <td>{{ user.username }}</td>
                <td>
                    <span class="badge bg-{% if user.accountType == 'admin' %}danger{% elseif user.accountType == 'staff' %}warning{% elseif user.accountType == 'teacher' %}info{% else %}secondary{% endif %}">
                        {{ user.accountType|capitalize }}
                    </span>
                </td>
                <td>{{ user.createdOn|date('Y-m-d H:i:s') }}</td>
                <td class="action-buttons">
                    <a href="{{ path('app_user_edit', {userId: user.id}) }}" 
                       class="btn btn-sm btn-info">Edit</a>
                    {% if user.id != app.session.get('user_id') %}
                    <form method="POST" action="{{ path('app_user_delete', {userId: user.id}) }}" 
                          style="display:inline;" onsubmit="return confirm('Are you sure?');">
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                    {% endif %}
                </td>
            </tr>
            {% endfor %}
        </tbody>
    </table>
</div>
{% else %}
<div class="alert alert-info">
    No users found. <a href="{{ path('app_user_new') }}">Create a new user</a>.
</div>
{% endif %}
{% endblock %}
