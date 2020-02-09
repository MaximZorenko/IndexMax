
let servResponse = document.querySelector('#response');
document.forms.ourForm.addEventListener('submit', e => {
	e.preventDefault();
	let newMessage = {
		value: message.value,
		checked: false,
		bold: false
	};
	array.push(newMessage);
	ajaxInquiry();
});

function ajaxInquiry(){
	let a = JSON.stringify(array);
	let xhr = new XMLHttpRequest();
	xhr.open('POST','functions.php');//2)инициализация
	xhr.setRequestHeader('Content-Type',
		'application/x-www-form-urlencoded');
	xhr.send('message=' + a);
	xhr.addEventListener('load', () => {
		if(xhr.readyState === 4 && xhr.status === 200){
			servResponse.innerHTML = xhr.response;
			let server = xhr.response;
			array = JSON.parse(server);//ответ сервера
			show();
		}
	});
}