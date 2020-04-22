����������� ���������� SQL �������:
1) �������� ��� �������, �� ��������, � ���������� �������
"SELECT DISTINCT status FROM tasks ORDER BY status ASC";

2) �������� ������� ���� ����� � ������ �������, ����������� �� ���������� �����
�� ��������
"SELECT projects.NAME, COUNT(tasks.id) as count_task
	FROM projects JOIN tasks ON projects.id = tasks.project_id
	GROUP BY projects.name ORDER BY COUNT(tasks.id) DESC";

3) �������� ���� ���� ������� � ������ �������, ����������� �� ��������
�����
"SELECT projects.NAME, COUNT(tasks.id) as count_task
	FROM projects JOIN tasks ON projects.id = tasks.project_id
	GROUP BY projects.name ORDER BY projects.name ASC";

4) �������� ������� ��� ���� ��������, �������� ������� ���������� �
����� "N"
"SELECT tasks.NAME, projects.NAME 
	FROM tasks JOIN projects ON tasks.project_id = projects.id
	WHERE projects.name LIKE 'N%'";

5) �������� ������ ���� ��������, ���������� ����� �� � ��������
��� � �������� ���������� ����� ����� � ������ ��������. ����������
��� ����� ������������ ������� ��� ����� � ����� �
project_id = NULL
"SELECT projects.NAME, COUNT(tasks.id) as count_task
	FROM projects JOIN tasks ON projects.id = tasks.project_id
	GROUP BY projects.name
	HAVING projects.name LIKE '%a%'";


6) �������� ������ ����� � �������������� �������. ����� �� ��������
"SELECT COUNT(name),NAME 
	FROM tasks GROUP BY name HAVING COUNT(*) > 1 ORDER BY name ASC";

7) �������� ������ �����, ������� ��������� ������ ���������� ��� �� ��������, ��� � ��
������, �� ������� ������. ����������� �� ���������� ������
"SELECT NAME 
	FROM tasks 
	WHERE NAME LIKE '%test1%' AND STATUS LIKE 'checked'";


8) �������� ������ ���� ��������, ������� ����� 10 ����� � �������
����������. ����������� �� project_id}
"SELECT projects.NAME
	FROM projects JOIN tasks ON projects.id = tasks.project_id
	GROUP BY projects.id
	HAVING COUNT(tasks.status) >10
	ORDER BY projects.id ASC";