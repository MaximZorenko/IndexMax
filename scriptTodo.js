let message = document.querySelector('.message'),
		// button = document.querySelector('.add'),
		todo = document.querySelector('.todo');
		array = [];


		// if(localStorage.getItem('todo')){
		// 	array = JSON.parse(localStorage.getItem('todo'));
		// 	show();
		// }//--2)получаем JSON из localStorage и присвоил его в array

// button.addEventListener('click', function(){
// 	// let newMessage = {
// 	// 	value: message.value,
// 	// 	checked: false,
// 	// 	bold: false
// 	// };
// 	// array.push(newMessage); 
// 	// show();
 
// 	//localStorage.setItem('todo', JSON.stringify(array));//--1)создаем JSON в localStorage

// 	console.log(array)
// 	// console.log('Hellow');
// });

function show(){
	let elem = document.createElement('ul');
	array.forEach(function(item,i){
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


		li.appendChild(input);
		li.appendChild(label);
		li.appendChild(buttonDelet);
		elem.appendChild(li);
	});
	todo.innerHTML = elem.innerHTML;
}

todo.addEventListener('change', function(e){
	let input = e.target.getAttribute('id');
	let label = todo.querySelector(`[for=${input}]`);

	array.forEach(function(item,i){
		if(item.value===label.innerHTML){
			item.checked = !item.checked;
		}
	});
	ajaxInquiry();
});//отметить выполненную задачу

todo.addEventListener('click', function(e){	
	if(e.target.value === 'delet'){
		array.forEach(function(item,i){
			if(item.value === e.target.dataset.buttonDelet){
				array.splice(i,1);
			}
		});
	}
	ajaxInquiry();
});//удалить задачу


	// if(e.ctrlKey){
	// 		array.splice(i,1);
	// 	}else{
	// 		item.bold = !item.bold;
	// 	}
