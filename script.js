let message = document.querySelector('.message'),
		button = document.querySelector('.add'),
		todo = document.querySelector('.todo'),
		array = [];

		if(localStorage.getItem('todo')){
			array = JSON.parse(localStorage.getItem('todo'));
			show();
		}//--2)получаем JSON из localStorage и присвоил его в array

button.addEventListener('click', function(){
	let newMessage = {
		value: message.value,
		checked: false,
		bold: false
	};
	array.push(newMessage); 
	show();

	localStorage.setItem('todo', JSON.stringify(array));//--1)создаем JSON в localStorage

	console.log(array);
});

function show(){
	let elem = document.createElement('ul');
	array.forEach(function(item,i){
		let input = document.createElement('input');
		input.setAttribute('type','checkbox');
		input.setAttribute('id',`sapsap${i}`);

		if(item.checked === true){
		input.setAttribute('checked','checked');
		}else{input.checked = false}

		let label = document.createElement('label');
		label.innerHTML = item.value;
		label.setAttribute('for',`sapsap${i}`)
		
		if(item.bold === true){
			label.classList.add('bold');
		}else{label.classList.remove('bold');}
		
		elem.appendChild(input);
		elem.appendChild(label);
	});
	todo.innerHTML = elem.innerHTML;
}

todo.addEventListener('change', function(e){
	let input = e.target.getAttribute('id');
	let label = todo.querySelector(`[for=${input}]`);

	array.forEach(function(item,i){
		if(item.value===label.innerHTML){
			item.checked = !item.checked;
			localStorage.setItem('todo', JSON.stringify(array));
		}
	});
});

todo.addEventListener('contextmenu', function(e){
	e.preventDefault();
	array.forEach(function(item,i){
		if(item.value === e.target.innerHTML){
			if(e.ctrlKey){
				array.splice(i,1);
			}else{
				item.bold = !item.bold;
			}

			localStorage.setItem('todo', JSON.stringify(array));
			show();
		}
	});
});


