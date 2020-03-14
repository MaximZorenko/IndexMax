// 'use strict';
let servResponse = document.querySelector('#response');
let addNewTodoList = document.querySelector('.addNewTodoList'),
		wrapTodoList = document.querySelector('.wrapTodoList'),
		arrayNewTodo = [];

addNewTodoList.addEventListener('click',()=>{
	let elem = document.createElement('form');
			elem.setAttribute('name','formNameTodo');
	let label = document.createElement('label');
			label.innerHTML = 'Name Todo List';		
	let input = document.createElement('input');
			input.setAttribute('type','text');
			input.setAttribute('name','nameTodo');

	let button = document.createElement('input');
			button.setAttribute('type', 'submit');
			button.setAttribute('value','addNewTodoList');
	label.appendChild(input);
	elem.appendChild(label);
	elem.appendChild(button);
	wrapTodoList.insertAdjacentElement('beforeEnd',elem);
	document.forms.formNameTodo.addEventListener('submit',e=>{
		e.preventDefault();
		if(document.querySelector('input[name=nameTodo]').value){
			let newForm = {
			id: arrayNewTodo.length,
			nameTodo: document.querySelector('input[name=nameTodo]').value,
			arr: [], 
			};
			arrayNewTodo.push(newForm);
			arrayNewTodo.forEach((item,i)=>{
				item.id = i;
			});
			showTodoList(arrayNewTodo);
			ajaxInquiry(arrayNewTodo);	
		}		
	});
});

function showTodoList(arrayNewTodo){
	let elem = document.createElement('div');
	arrayNewTodo.forEach((item,i)=>{
		let wrapTodoList__new = document.createElement('div');
		wrapTodoList__new.setAttribute('class','wrapTodoList__new');
		let divH2 = document.createElement('div');
				divH2.setAttribute('class', 'wrapTodoList__newH');
		let h2 = document.createElement('h2');
		h2.innerHTML = item.nameTodo;
		let buttonDivH2 = document.createElement('button');
				buttonDivH2.setAttribute('type','button');
				buttonDivH2.setAttribute('data-button-Deldiv',`${item.nameTodo}`);
				buttonDivH2.setAttribute('value','deletNewTodo');
				buttonDivH2.setAttribute('class','btnDeletH');
		let ourForm = document.createElement('form');
		ourForm.setAttribute('name','ourForm');
		ourForm.setAttribute('class','ourForm');

		let inputText = document.createElement('input');
		inputText.setAttribute('type','text');
		inputText.setAttribute('name',`message${item.id}`);
		inputText.setAttribute('class','message');

		let inputSubmit = document.createElement('input');
		inputSubmit.setAttribute('type', 'submit');
		inputSubmit.setAttribute('name', 'add');
		inputSubmit.setAttribute('class', 'add');
		inputSubmit.setAttribute('value', 'Add Task');

		let ulTodo = document.createElement('ul');
		ulTodo.setAttribute('class','todo');
		let elemUlTodo = document.createElement('ul');
		item.arr.forEach((item,i)=>{
			let li = document.createElement('li');
			
			let inputWrap = document.createElement('div');
			inputWrap.setAttribute('class','inputWrap');
			let input = document.createElement('input');
			input.setAttribute('type','checkbox');
			input.setAttribute('id',`input1_${i}`);
			if(item.checked === true){
			input.setAttribute('checked','checked');
			inputWrap.classList.add('chec');
			}else{input.checked = false; inputWrap.classList.remove('chec');}
			inputWrap.appendChild(input);
			let label = document.createElement('label');
			label.innerHTML = item.value;
			label.setAttribute('for',`input1_${i}`)
			let buttonDelet = document.createElement('button');
			buttonDelet.setAttribute('type','button');
			buttonDelet.setAttribute('data-button-Delet',`${item.value}`);
			buttonDelet.setAttribute('value','delet');
			let buttonHigherPriority = document.createElement('button');
			buttonHigherPriority.setAttribute('type','button');
			buttonHigherPriority.innerHTML = '&#9650;';
			buttonHigherPriority.setAttribute('value','higherPriority');
			buttonHigherPriority.setAttribute('data-button-Priority',`${item.value}`);
			let buttonLowerPriority = document.createElement('button');
			buttonLowerPriority.setAttribute('type','button');
			buttonLowerPriority.innerHTML = '&#9660;';
			buttonLowerPriority.setAttribute('value','lowerPriority');
			buttonLowerPriority.setAttribute('data-button-Lower',`${item.value}`);
			let buttonPriorWrap = document.createElement('div');
			buttonPriorWrap.setAttribute('class','buttonPriorWrap');
			buttonPriorWrap.appendChild(buttonHigherPriority);
			buttonPriorWrap.appendChild(buttonLowerPriority);
			li.appendChild(inputWrap);
			li.appendChild(label);
			li.appendChild(buttonPriorWrap);
			li.appendChild(buttonDelet);
			elemUlTodo.appendChild(li);							
		});
		ulTodo.innerHTML = elemUlTodo.innerHTML;

		ourForm.appendChild(inputText);
		ourForm.appendChild(inputSubmit);
		divH2.appendChild(h2);
		divH2.appendChild(buttonDivH2);
		wrapTodoList__new.appendChild(divH2);
		wrapTodoList__new.appendChild(ourForm);
		wrapTodoList__new.appendChild(ulTodo);
		elem.appendChild(wrapTodoList__new);
	});


	wrapTodoList.innerHTML = elem.innerHTML;
	
	arrayNewTodo.forEach((item,i)=>{
		wrapTodoList.addEventListener('click',e=>{
			if(e.target.value==='deletNewTodo'){
				for(let i = 0; i < arrayNewTodo.length; i++){
						if(arrayNewTodo[i].nameTodo===e.target.dataset.buttonDeldiv){
							arrayNewTodo.splice(i,1);
						}
				}
			ajaxInquiry(arrayNewTodo);
			}
		});
		let message = document.querySelector(`input[name=message${item.id}]`),
				todo = Array.prototype.slice.call(document.querySelectorAll('.todo'))[i];
		
		document.querySelectorAll('[name=ourForm]')[i].addEventListener('submit', e => {
			e.preventDefault();
			if(message.value){
			let newMessage = {
				value: message.value,
				checked: false
			};
			item.arr.push(newMessage);
			ajaxInquiry(arrayNewTodo);
			}
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