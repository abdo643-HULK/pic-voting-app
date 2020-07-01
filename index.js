'use strict';
const nav = Array.from(document.getElementsByClassName('nav'));
const main = document.querySelector('main');
const neu = document.getElementById('neu');
const flex_section = document.querySelector('.flex');
const block_section = document.querySelector('.block');
block_section.appendChild(neu.content.cloneNode(true));

const voten = document.getElementById('voten');
const sieger = document.getElementById('sieger');

nav.forEach((element) => {
	return element.addEventListener('click', (e) => {
		nav.forEach((element) => {
			element.classList.remove('is-active');
		});
		e.currentTarget.className += ' is-active';
		switch (e.srcElement.innerText) {
			case 'Neu':
				block_section.innerHTML != ''
					? (block_section.innerHTML = '')
					: (flex_section.innerHTML = '');
				block_section.appendChild(neu.content.cloneNode(true));
				break;
			case 'Voten':
				block_section.innerHTML != ''
					? (block_section.innerHTML = '')
					: (flex_section.innerHTML = '');
				loadCards();
				break;
			case 'Sieger':
				block_section.innerHTML != ''
					? (block_section.innerHTML = '')
					: (flex_section.innerHTML = '');
				loadRanking();
				break;
		}
	});
});

function showFileName(e) {
	const infoArea = document.getElementById('file-upload-filename');
	const input = e.srcElement;
	const fileName = input.files[0].name;
	infoArea.textContent = `${fileName}`;
}

function isFileImage(file) {
	return file && file['type'].split('/')[0] === 'image';
}

function validateAndUpload(file) {
	console.log('in');
	if (file.name.match(/.(jpg|jpeg|png|gif|svg)$/i)) {
		return true;
	} else {
		alert('Bitte ein Bild wählen');
		return false;
	}
}

function changeButton() {
	event.preventDefault();
	const submitBtn = document.getElementById('submitBtn');
	if (
		event.target.value != '' &&
		validateAndUpload(event.srcElement.files[0])
	) {
		showFileName(event);
		submitBtn.disabled = false;
	} else {
		submitBtn.disabled = true;
	}
}

document.getElementById('form').addEventListener('submit', (e) => {
	e.preventDefault();
	const API_PATH = './api/upload.php';

	const form = new FormData(event.target);

	const options = {
		method: 'POST',
		body: form,
	};

	async function request() {
		const response = await fetch(API_PATH, options);
		const data = await response.text();
		return data;
	}

	request().then((res) => console.log(res));
});

function upVote() {
	const id = event.currentTarget.value;
	const API_PATH = './api/updateVotes.php';
	const data = {
		id: id,
		event: 'inc',
	};

	const options = {
		method: 'POST',
		body: JSON.stringify(data),
	};

	async function request() {
		const response = await fetch(API_PATH, options);
		const data = await response.text();
		return data;
	}

	request().then((res) => console.log(res));
}

function downVote() {
	const id = event.currentTarget.value;
	const API_PATH = './api/updateVotes.php';
	const data = {
		id: id,
		event: 'dec',
	};

	const options = {
		method: 'POST',
		body: JSON.stringify(data),
	};

	async function request() {
		const response = await fetch(API_PATH, options);
		const data = await response.text();
		return data;
	}

	request().then((res) => console.log(res));
}

function loadCards() {
	const API_PATH = './api/getData.php';

	async function request() {
		const response = await fetch(API_PATH);
		const data = await response.json();
		return data;
	}

	request().then((res) => {
		console.log(res);
		res.forEach((card) => {
			const clone = voten.content.cloneNode(true);
			const cardImage = clone.querySelector('img');
			cardImage.src = `localhost/${card.img}`;
			const content = clone.querySelector('.content');
			const buttons = Array.from(clone.querySelectorAll('button'));
			buttons.forEach((button) => {
				button.value = card.id;
			});
			content.innerText = card.text;
			console.log(clone);
			flex_section.appendChild(clone);
		});
	});
}

function loadRanking() {
	orderWinner();
	loadWinner();
}

function orderWinner() {
	const API_PATH = './api/orderTable.php';

	async function request() {
		const response = await fetch(API_PATH);
		const data = await response.text();
		return data;
	}
	request().then((res) => console.log(res));
}

function loadWinner() {
	const API_PATH = './api/getData.php';

	async function request() {
		const response = await fetch(API_PATH);
		const data = await response.json();
		return data;
	}

	request().then((res) => {
		console.log(res);
		res.sort(function (a, b) {
			return b.votes - a.votes;
		});
		const five = res.filter((res, i) => i < 5);
		console.log(five);
		let i = 1;
		five.forEach((card) => {
			const clone = sieger.content.cloneNode(true);
			const title = clone.querySelector('.card-header-title');
			title.innerText = `${i}.Platz`;
			const cardImage = clone.querySelector('img');
			cardImage.src = `localhost/${card.img}`;
			const content = clone.querySelector('.content');
			content.innerHTML = `<h2>Votes:${card.votes}</h2></br>${card.text}`;
			block_section.appendChild(clone);
			i++;
		});
	});
}
