����������� ���������� SQL �������:
- �������� ��� �������, �� ��������, � ���������� �������
SELECT DISTINCT status FROM tasks;

- �������� ������� ���� ����� � ������ �������, ����������� �� ���������� �����
�� ��������
SELECT COUNT(id) AS c,project_id FROM tasks GROUP BY project_id ORDER BY c DESC;

- �������� ���� ���� ������� � ������ �������, ����������� �� ��������
�����
SELECT COUNT(tasks.id), tasks.project_id, projects.name FROM projects JOIN tasks ON projects.id = tasks.project_id GROUP BY tasks.project_id; 

- �������� ������� ��� ���� ��������, �������� ������� ���������� �
����� "N"
SELECT name FROM tasks WHERE name LIKE 'N%'; 

- �������� ������ ���� ��������, ���������� ����� �� � ��������
��� � �������� ���������� ����� ����� � ������ ��������. ����������
��� ����� ������������ ������� ��� ����� � ����� �
project_id = NULL
COUNT(tasks.id), tasks.project_id, projects.NAME 
FROM projects JOIN tasks ON projects.id = tasks.project_id GROUP BY tasks.project_id 
HAVING projects.NAME LIKE '%A%'; 


- �������� ������ ����� � �������������� �������. ����� �� ��������
SELECT COUNT(name),NAME FROM tasks GROUP BY name HAVING COUNT(*) > 1;

- �������� ������ �����, ������� ��������� ������ ���������� ��� �� ��������, ��� � ��
������, �� ������� ������. ����������� �� ���������� ������
SELECT NAME FROM tasks GROUP BY name HAVING COUNT(STATUS) > 1 AND COUNT(NAME) > 1;


- �������� ������ ���� ��������, ������� ����� 10 ����� � �������
����������. ����������� �� project_id}
SELECT 
COUNT(tasks.id), tasks.status, tasks.project_id, projects.NAME 
FROM projects JOIN tasks ON projects.id = tasks.project_id GROUP BY tasks.project_id 
HAVING COUNT(tasks.id) > 10 AND  tasks.STATUS IS NOT NULL;