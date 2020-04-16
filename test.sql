Технические требования SQL запросы:
- получить все статусы, не повторяя, в алфавитном порядке
SELECT DISTINCT status FROM tasks;

- получить счетчик всех задач в каждом проекте, упорядочить по количеству задач
по убыванию
SELECT COUNT(id) AS c,project_id FROM tasks GROUP BY project_id ORDER BY c DESC;

- получить счет всех заданий в каждом проекте, упорядочить по проектам
имена
SELECT COUNT(tasks.id), tasks.project_id, projects.name FROM projects JOIN tasks ON projects.id = tasks.project_id GROUP BY tasks.project_id; 

- получить задания для всех проектов, название которых начинается с
Буква "N"
SELECT name FROM tasks WHERE name LIKE 'N%'; 

- получить список всех проектов, содержащих букву «а» в середине
имя и показать количество задач рядом с каждым проектом. Упоминание
что могут существовать проекты без задач и задач с
project_id = NULL
COUNT(tasks.id), tasks.project_id, projects.NAME 
FROM projects JOIN tasks ON projects.id = tasks.project_id GROUP BY tasks.project_id 
HAVING projects.NAME LIKE '%A%'; 


- получить список задач с повторяющимися именами. Заказ по алфавиту
SELECT COUNT(name),NAME FROM tasks GROUP BY name HAVING COUNT(*) > 1;

- получить список задач, имеющих несколько точных совпадений как по названию, так и по
статус, из проекта «Гараж». Сортировать по количеству матчей
SELECT NAME FROM tasks GROUP BY name HAVING COUNT(STATUS) > 1 AND COUNT(NAME) > 1;


- получить список имен проектов, имеющих более 10 задач в статусе
«Завершено». Сортировать по project_id}
SELECT 
COUNT(tasks.id), tasks.status, tasks.project_id, projects.NAME 
FROM projects JOIN tasks ON projects.id = tasks.project_id GROUP BY tasks.project_id 
HAVING COUNT(tasks.id) > 10 AND  tasks.STATUS IS NOT NULL;