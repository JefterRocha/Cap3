fetch('settings/topics.php')
	.then(res => res.json())
	.then(topics => {
		console.log(topics)
		/* if (topics.length > 0) { */
		for (const topic of topics) {
			if (topic.selected) {
				document.querySelector(`input#c${topic.topic_number}`).disabled = true
				document.querySelector(`input#c${topic.topic_number}`).labels[0].classList.add('alert-secondary')
				document.querySelector(`input#c${topic.topic_number}`).labels[0].firstElementChild.textContent =
					`-${topic.owner}`
			}
		}
		/* } */
	})
	.catch(err => console.error('Não foi possivel obter as informações', err))

for (const label of document.querySelectorAll('label')) {
	label.addEventListener('click', (event) => {
		if (document.querySelector('#user-name').value != 0) {
			document.querySelector('.alert').textContent = ''
			document.querySelector('.alert').classList.remove('alert-warning')
			if (label.control.checked) {
				label.classList.remove('alert-secondary')
				label.querySelector('.owner-name').textContent = ''
			} else {
				if (!label.control.disabled) {
					label.classList.add('alert-secondary')
					label.querySelector('.owner-name').textContent = `-${document.querySelector('#user-name').value}`
					label.control.value
				}

			}
		} else {
			document.querySelector('.alert').textContent = "Digite seu nome!"
			document.querySelector('.alert').classList.add('alert-warning')
		}
	})
}
const userDatas = {
	'name': '',
	'topics': []
}
document.querySelector('#form-data').addEventListener('submit', (event) => {
	event.preventDefault()
	for (const [key, value] of new FormData(event.target).entries()) {

		if (key != 'name') {
			userDatas.topics.push(value)
		} else if (key == 'name') {
			userDatas.name = value
		}
	}

	console.log(userDatas)

	fetch('settings/register.php', {
			method: 'POST',
			body: JSON.stringify(userDatas)
		})
		.then(response => response.json())
		.then(response => {
			document.querySelector('.alert').textContent = 'Salvo com sucesso!'
			document.querySelector('.alert').classList.add('alert-success')
		})
		.catch(err => {
			console.error('Não foi possivel obter as informações', err)
			document.querySelector('.alert').textContent = 'Algo de errado aconteceu'
			ocument.querySelector('.alert').classList.add('alert-danger')
		})
})