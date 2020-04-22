Технические требования SQL запросы:
1) получить все статусы, не повторяя, в алфавитном порядке
"SELECT DISTINCT status FROM tasks ORDER BY status ASC";

2) получить счетчик всех задач в каждом проекте, упорядочить по количеству задач
по убыванию
"SELECT projects.NAME, COUNT(tasks.id) as count_task
	FROM projects JOIN tasks ON projects.id = tasks.project_id
	GROUP BY projects.name ORDER BY COUNT(tasks.id) DESC";

3) получить счет всех заданий в каждом проекте, упорядочить по проектам
имена
"SELECT projects.NAME, COUNT(tasks.id) as count_task
	FROM projects JOIN tasks ON projects.id = tasks.project_id
	GROUP BY projects.name ORDER BY projects.name ASC";

4) получить задания для всех проектов, название которых начинается с
Буква "N"
"SELECT tasks.NAME, projects.NAME 
	FROM tasks JOIN projects ON tasks.project_id = projects.id
	WHERE projects.name LIKE 'N%'";

5) получить список всех проектов, содержащих букву «а» в середине
имя и показать количество задач рядом с каждым проектом. Упоминание
что могут существовать проекты без задач и задач с
project_id = NULL
"SELECT projects.NAME, COUNT(tasks.id) as count_task
	FROM projects JOIN tasks ON projects.id = tasks.project_id
	GROUP BY projects.name
	HAVING projects.name LIKE '%a%'";


6) получить список задач с повторяющимися именами. Заказ по алфавиту
"SELECT COUNT(name),NAME 
	FROM tasks GROUP BY name HAVING COUNT(*) > 1 ORDER BY name ASC";

7) получить список задач, имеющих несколько точных совпадений как по названию, так и по
статус, из проекта «Гараж». Сортировать по количеству матчей
"SELECT NAME 
	FROM tasks 
	WHERE NAME LIKE '%test1%' AND STATUS LIKE 'checked'";


8) получить список имен проектов, имеющих более 10 задач в статусе
«Завершено». Сортировать по project_id}
"SELECT projects.NAME
	FROM projects JOIN tasks ON projects.id = tasks.project_id
	GROUP BY projects.id
	HAVING COUNT(tasks.status) >10
	ORDER BY projects.id ASC";