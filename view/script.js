let btn = document.querySelector('.btn');
let form = document.querySelector('#formAddTodoList');
btn.addEventListener('click',e=>{
	e.target.classList.add('hide');
	form.classList.add('open');
});
let wrap = document.querySelector('body');
let observer = new MutationObserver(mutations => {
	funcIf();
});
observer.observe(wrap,{childList: true,subtree: true});
funcIf();
function funcIf(){
	if(formAddTodoList){
		let wrap = document.querySelector('.wrap');
	  formAddTodoList.onsubmit = async e => {
	     e.preventDefault();
	     ajaxInquiry(formAddTodoList,wrap);
	     e.target.classList.remove('open');
	     btn.classList.remove('hide');
	  };
	}
	if(document.querySelectorAll('.formTask')){
		let formTask = document.querySelectorAll('.formTask');
		let wrapTask = document.querySelectorAll('.wrapTask');
		for(let i = 0; i < formTask.length; i++){
			formTask[i].onsubmit = async e => {
				e.preventDefault();
				ajaxformTask(formTask[i],wrapTask[i]);
			};
		}	
	}
	if(document.querySelectorAll('input[type=checkbox]')){
		let checkbox = document.querySelectorAll('input[type=checkbox]');
		for(let i =0; i < checkbox.length; i++){
			checkbox[i].onchange = async e =>{
				e.preventDefault();
				let task_id = checkbox[i].parentElement.elements.task_id.value;
				ajaxCheckbox(checkbox[i].value,task_id);
			}; 
		}
	}
	if(document.querySelectorAll('input[name=deletTask]')){
		let deletTask = document.querySelectorAll('input[name=deletTask]');
		// let wrap = document.querySelectorAll('.wrapTask');
		for(let i =0; i < deletTask.length; i++){
			deletTask[i].onclick = async e =>{
				e.preventDefault();
				let task_id = deletTask[i].parentElement.elements.task_id;
				ajaxDeletTask(deletTask[i],task_id.value,deletTask[i].parentElement.parentElement);
			}; 
		}
	}
	if(document.querySelectorAll('input[name=correctTask]')){
		let correctTask = document.querySelectorAll('input[name=correctTask]');
		for(let i =0; i < correctTask.length; i++){
			correctTask[i].onclick = async e =>{
				e.preventDefault();
				let task_id = correctTask[i].parentElement.elements.task_id;
				ajaxCorrectTask(correctTask[i],task_id.value,correctTask[i].parentElement.parentElement);
			}; 
		}
	}
	if(document.querySelectorAll('input[name=newValueTask]')){
		let newValueTask = document.querySelectorAll('input[name=newValueTask]');
		for(let i =0; i < newValueTask.length; i++){
			newValueTask[i].parentElement.elements.submitNewValueTask.onclick = e =>{
				e.preventDefault();
			};
			newValueTask[i].onchange = async e =>{
				e.preventDefault();
				let task_id = newValueTask[i].parentElement.elements.task_id.value;
				ajaxNewValueTask(newValueTask[i].value,task_id,newValueTask[i].parentElement.parentElement);
			}; 
		}
	}
	if(document.querySelectorAll('input[name=deletProject]')){
		let deletProject = document.querySelectorAll('input[name=deletProject]');
		for(let i =0; i < deletProject.length; i++){
			deletProject[i].onclick = async e =>{
				e.preventDefault();
				let project_id = deletProject[i].parentElement.elements.project_id;
				ajaxDeletPject(deletProject[i],project_id.value);
				deletProject[i].parentElement.parentElement.remove();
			}; 
		}
	}
	if(document.querySelectorAll('input[name=correctProject]')){
		let correctProject = document.querySelectorAll('input[name=correctProject]');
		for(let i = 0; i < correctProject.length; i++){
			correctProject[i].onclick = async e =>{
				e.preventDefault();
				let project_id = correctProject[i].parentElement.elements.project_id;
				ajaxCorrectProject(correctProject[i],project_id.value,correctProject[i].parentElement);
			};
		}
	}
	if(document.querySelectorAll('input[name=newValueProject]')){
		let newValueProject = document.querySelectorAll('input[name=newValueProject]');
		for(let i =0; i < newValueProject.length; i++){
			newValueProject[i].parentElement.elements.submitNewValueProject.onclick = e =>{
				e.preventDefault();
			};
			newValueProject[i].onchange = async e =>{
				e.preventDefault();
				let project_id = newValueProject[i].parentElement.elements.project_id;
				ajaxNewValueProject(newValueProject[i].value,project_id.value,newValueProject[i].parentElement);
			}; 
		}
	}
	if(document.querySelectorAll('input[name=next]')){
		let next = document.querySelectorAll('input[name=next]');
		for(let i =0; i < next.length; i++){
			next[i].onclick = async e =>{
				e.preventDefault();
				let task_id = next[i].parentElement.elements.task_id;
				ajaxNext(next[i],task_id.value,next[i].parentElement.parentElement);
			}; 
		}
	}
	if(document.querySelectorAll('input[name=prev]')){
		let prev = document.querySelectorAll('input[name=prev]');
		for(let i =0; i < prev.length; i++){
			prev[i].onclick = async e =>{
				e.preventDefault();
				let task_id = prev[i].parentElement.elements.task_id;
				ajaxPrev(prev[i],task_id.value,prev[i].parentElement.parentElement);
			}; 
		}
	}
}
function ajaxPrev(prev,task_id,wrap){
	let xhr = new XMLHttpRequest();
	xhr.open('POST','index.php');
	xhr.setRequestHeader('Content-Type',
		'application/x-www-form-urlencoded');
	xhr.send(`prev=${prev}&task_id=${task_id}`);
	xhr.addEventListener('load', () => {
		if(xhr.readyState === 4 && xhr.status === 200){
			let server = xhr.response;
			wrap.innerHTML = server;
			console.log(server);
		}
	});
}
function ajaxNext(next,task_id,wrap){
	let xhr = new XMLHttpRequest();
	xhr.open('POST','index.php');
	xhr.setRequestHeader('Content-Type',
		'application/x-www-form-urlencoded');
	xhr.send(`next=${next}&task_id=${task_id}`);
	xhr.addEventListener('load', () => {
		if(xhr.readyState === 4 && xhr.status === 200){
			let server = xhr.response;
			wrap.innerHTML = server;
		}
	});
}
function ajaxNewValueProject(newValueProject,project_id,wrap){
	let xhr = new XMLHttpRequest();
	xhr.open('POST','index.php');
	xhr.setRequestHeader('Content-Type',
		'application/x-www-form-urlencoded');
	xhr.send(`newValueProject=${newValueProject}&project_id=${project_id}`);
	xhr.addEventListener('load', () => {
		if(xhr.readyState === 4 && xhr.status === 200){
			let server = xhr.response;
			wrap.innerHTML = server;
		}
	});
}
function ajaxCorrectProject(correctProject,project_id,wrap){
	let xhr = new XMLHttpRequest();
	xhr.open('POST','index.php');
	xhr.setRequestHeader('Content-Type',
		'application/x-www-form-urlencoded');
	xhr.send(`correctProject=${correctProject}&project_id=${project_id}`);
	xhr.addEventListener('load', () => {
		if(xhr.readyState === 4 && xhr.status === 200){
			let server = xhr.response;
			wrap.innerHTML = server;
		}
	});
}
function ajaxDeletPject(deletProject,project_id,wrap){
	let xhr = new XMLHttpRequest();
	xhr.open('POST','index.php');
	xhr.setRequestHeader('Content-Type',
		'application/x-www-form-urlencoded');
	xhr.send(`deletProject=${deletProject}&project_id=${project_id}`);
	xhr.addEventListener('load', () => {
		if(xhr.readyState === 4 && xhr.status === 200){
			let server = xhr.response;
		}
	});
}
function ajaxNewValueTask(newValueTask,task_id,wrap){
	let xhr = new XMLHttpRequest();
	xhr.open('POST','index.php');
	xhr.setRequestHeader('Content-Type',
		'application/x-www-form-urlencoded');
	xhr.send(`newValueTask=${newValueTask}&task_id=${task_id}`);
	xhr.addEventListener('load', () => {
		if(xhr.readyState === 4 && xhr.status === 200){
			let server = xhr.response;
			wrap.innerHTML = server;
		}
	});
}

function ajaxCorrectTask(correctTask,task_id,wrap){
	let xhr = new XMLHttpRequest();
	xhr.open('POST','index.php');
	xhr.setRequestHeader('Content-Type',
		'application/x-www-form-urlencoded');
	xhr.send(`correctTask=${correctTask}&task_id=${task_id}`);
	xhr.addEventListener('load', () => {
		if(xhr.readyState === 4 && xhr.status === 200){
			let server = xhr.response;
			wrap.innerHTML = server;
		}
	});
}

function ajaxformTask(idForm,wrap){
	let a = new FormData(idForm);
	let xhr = new XMLHttpRequest();
	xhr.open('POST','index.php');
	xhr.send(a);
	xhr.addEventListener('load', () => {
		if(xhr.readyState === 4 && xhr.status === 200){
			let server = xhr.response;
			wrap.innerHTML = server;
		}
	});
}
function ajaxInquiry(idForm,wrap){
	let a = new FormData(idForm);
	let xhr = new XMLHttpRequest();
	xhr.open('POST','index.php');
	xhr.send(a);
	xhr.addEventListener('load', () => {
		if(xhr.readyState === 4 && xhr.status === 200){
			let server = xhr.response;
			wrap.insertAdjacentHTML('afterbegin',server);
		}
	});
}

function ajaxCheckbox(checkbox,task_id){
	let xhr = new XMLHttpRequest();
	xhr.open('POST','index.php');
	xhr.setRequestHeader('Content-Type',
		'application/x-www-form-urlencoded');
	xhr.send(`checkbox=${checkbox}&task_id=${task_id}`);
	xhr.addEventListener('load', () => {
		if(xhr.readyState === 4 && xhr.status === 200){
			let server = xhr.response;
		}
	});
}
function ajaxDeletTask(deletTask,task_id,wrap){
	let xhr = new XMLHttpRequest();
	xhr.open('POST','index.php');
	xhr.setRequestHeader('Content-Type',
		'application/x-www-form-urlencoded');
	xhr.send(`deletTask=${deletTask}&task_id=${task_id}`);
	xhr.addEventListener('load', () => {
		if(xhr.readyState === 4 && xhr.status === 200){
			let server = xhr.response;
			wrap.innerHTML = server;
		}
	});
}