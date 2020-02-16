// 'use strict';
let servResponse = document.querySelector('#response');
let addNewTodoList = document.querySelector('.addNewTodoList'),
		wrapTodoList = document.querySelector('.wrapTodoList'),
		arrayNewTodo = [];
		
addNewTodoList.addEventListener('click',()=>{
	let newForm = {
		id: arrayNewTodo.length,
		arr: [], 
	};
	arrayNewTodo.push(newForm);
	showTodoList(arrayNewTodo);
});


function showTodoList(arrayNewTodo){
	let elem = document.createElement('div');
	arrayNewTodo.forEach((item,i)=>{
		let wrapTodoList__new = document.createElement('div');
		wrapTodoList__new.setAttribute('class','wrapTodoList__new');

		let ourForm = document.createElement('form');
		ourForm.setAttribute('name',`ourForm${item.id}`);

		let inputText = document.createElement('input');
		inputText.setAttribute('type','text');
		inputText.setAttribute('name',`message${item.id}`);
		inputText.setAttribute('class','message');

		let inputSubmit = document.createElement('input');
		inputSubmit.setAttribute('type', 'submit');
		inputSubmit.setAttribute('name', 'add');
		inputSubmit.setAttribute('class', 'add');
		inputSubmit.setAttribute('value', 'Отправить');

		let ulTodo = document.createElement('ul');
		ulTodo.setAttribute('class','todo');
		let elemUlTodo = document.createElement('ul');
		item.arr.forEach((item,i)=>{
			let li = document.createElement('li');
			let input = document.createElement('input');
			input.setAttribute('type','checkbox');
			input.setAttribute('id',`input1_${i}`);
			if(item.checked === true){
			input.setAttribute('checked','checked');
			}else{input.checked = false}
			let label = document.createElement('label');
			label.innerHTML = item.value;
			label.setAttribute('for',`input1_${i}`)
			if(item.bold === true){
				label.classList.add('bold');
			}else{label.classList.remove('bold');}
			let buttonDelet = document.createElement('button');
			buttonDelet.setAttribute('type','button');
			buttonDelet.setAttribute('data-button-Delet',`${item.value}`);
			buttonDelet.setAttribute('value','delet');
			buttonDelet.innerHTML = 'Удалить';//убрать - заменить на картинку
			let buttonHigherPriority = document.createElement('button');
			buttonHigherPriority.setAttribute('type','button');
			buttonHigherPriority.innerHTML = '+';
			buttonHigherPriority.setAttribute('value','higherPriority');
			buttonHigherPriority.setAttribute('data-button-Priority',`${item.value}`);
			let buttonLowerPriority = document.createElement('button');
			buttonLowerPriority.setAttribute('type','button');
			buttonLowerPriority.innerHTML = '-';
			buttonLowerPriority.setAttribute('value','lowerPriority');
			buttonLowerPriority.setAttribute('data-button-Lower',`${item.value}`);
			li.appendChild(input);
			li.appendChild(label);
			li.appendChild(buttonDelet);
			li.appendChild(buttonHigherPriority);
			li.appendChild(buttonLowerPriority);
			elemUlTodo.appendChild(li);							
		});
		ulTodo.innerHTML = elemUlTodo.innerHTML;

		ourForm.appendChild(inputText);
		ourForm.appendChild(inputSubmit);
		wrapTodoList__new.appendChild(ourForm);
		wrapTodoList__new.appendChild(ulTodo);
		elem.appendChild(wrapTodoList__new);
	});


	wrapTodoList.innerHTML = elem.innerHTML;
	
	arrayNewTodo.forEach((item,i)=>{
		let message = document.querySelector(`input[name=message${item.id}]`),
				todo = Array.prototype.slice.call(document.querySelectorAll('.todo'))[i];
		
		document.forms[i].addEventListener('submit', e => {
			e.preventDefault();
			let newMessage = {
				value: message.value,
				checked: false,
				bold: false
			};
			item.arr.push(newMessage);
			ajaxInquiry(arrayNewTodo);
		});

		todo.addEventListener('change', function(e){
			let input = e.target.getAttribute('id');
			let label = todo.querySelector(`[for=${input}]`);
			item.arr.forEach(function(item,i){
				if(item.value===label.innerHTML){
					item.checked = !item.checked;
				}
			});
			ajaxInquiry(arrayNewTodo);
		});//отметить выполненную задачу

		todo.addEventListener('click', function(e){	
			if(e.target.value === 'delet'){
				for(let i = 0; i < item.arr.length; i++){
					if(item.arr[i].value === e.target.dataset.buttonDelet){
						item.arr.splice(i,1);
					}
				}
				ajaxInquiry(arrayNewTodo);
			}
			if(e.target.value === 'higherPriority'){
				for(let i = 0; i < item.arr.length; i++){
					if(item.arr[i].value === e.target.dataset.buttonPriority){
						let arrSplice = item.arr.splice(i,1);
						let index;
						if(i === 0){index = 0;
						}else{
							index = --i;
						}
						item.arr.splice(index,0,arrSplice[0]);
						break;
					}
				}
				ajaxInquiry(arrayNewTodo);
			}
			if(e.target.value === 'lowerPriority'){
				for(let i = 0; i < item.arr.length; i++){
					if(item.arr[i].value === e.target.dataset.buttonLower){
						let arrSplice = item.arr.splice(i,1);
						let index = ++i;
						item.arr.splice(index,0,arrSplice[0]);
						break;
					} 
				}
				ajaxInquiry(arrayNewTodo);
			}
			
		});

	});

}
 	
function ajaxInquiry(array){
	let a = JSON.stringify(array);
	let xhr = new XMLHttpRequest();
	xhr.open('POST','functions.php');//2)инициализация
	xhr.setRequestHeader('Content-Type',
		'application/x-www-form-urlencoded');
	xhr.send('message=' + a);
	xhr.addEventListener('load', () => {
		if(xhr.readyState === 4 && xhr.status === 200){
			// servResponse.innerHTML = xhr.response;
			let server = xhr.response;
			arrayNewTodo = JSON.parse(server);//ответ сервера
			showTodoList(arrayNewTodo);
		}
	});
}