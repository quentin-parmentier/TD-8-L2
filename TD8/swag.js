//On ajoute un listener quand le DOM est chargé (avant le css et les images !)
document.addEventListener("DOMContentLoaded", function () {
	document
		.querySelector(".ajaxform") //Selecteur comme en css
		.addEventListener("submit", async function (event) {
			//listener sur l'évenement d'envoi de formulaire
			//Enlève le comportement par défaut
			event.preventDefault()
			//On choisi comment on veut envoyer
			let formData = new FormData(event.target)
			console.log(formData)
			let entries = Object.fromEntries(formData) //On récupère toutes les entrées
			console.log(entries) //[{id:123, productDisplayName:"Mon vetement cool", ...}]
			data = {}
			//On a vue que ça servait pas
			//Mais ça parcours toutes les clées d'un objet
			//in = clé / of = valeurs
			for (entry in entries) {
				console.log(entry)
				data[entry] = entries[entry]
			}

			result = await createVetement(data)
			updateData(result)
		})
})

async function filterByGender(id, gender) {
	//GET => /mon/url/api.php?key=value&gender=male
	console.log(id)
	console.log(gender)
	let url = buildUrl("gender", gender)
	console.log(url)
	let data = await getVetement(url) //data est un tableau de vetements
	updateData(data)
}

async function filterByYear(year) {
	console.log(year)
	let url = buildUrl("year", year)
	console.log(url)
	let data = await getVetement(url) //data est un tableau de vetements
	updateData(data)
}

async function getVetement(url) {
	const req = await fetch(url, {
		method: "GET",
	})

	const data = await req.json()
	console.log(data)
	return data
}

//data est un tableau de vetements
//Ici un tableau de vetements d'homme, mais il peut etre un tableau de vetements de femme, vert, grand...
function updateData(data) {
	///On dégage tout => On a un écran blanc
	console.log(data)
	console.log(document.querySelector("#container>.row"))
	removeAllChildNodes(document.querySelector("#container>.row"))
	///On bouche sur data
	for (vetement of data) {
		console.log(vetement)
		///Pour chaque data on créer une etiquette
		let etiquette = buildEtiquette(vetement)
		///On la pousse sur l'écran
		document.querySelector("#container>.row").innerHTML += etiquette
	}
}

//Custom function to remove all children of a HTMLElement
function removeAllChildNodes(parent) {
	while (parent.firstChild) {
		console.log(parent.firstChild)
		parent.removeChild(parent.firstChild)
	}
}

///Prend en parametre un vetement
///Retourne une etiquette (donc du html)
function buildEtiquette(vetement) {
	//Si - sinon => ternaire : condition ? true : false
	let sexIcon =
		vetement["gender"] == "Men" ? "bi-gender-male" : "bi-gender-female"
	//En JS on peut faire une string sur plusieurs lignes grace à `` et mettre des variables dedans avec ${maVariable}
	return `
    <div class="card text-bg-light" id="${vetement["id"]}">
        <img src="img/vetements/${vetement["id"]}.jpg" alt="Card img cap" class="card-img-top">
        <div class="card-body">
            <h4 class="card-title">${vetement["productDisplayName"]}</h4>
            <p class="card-text">
                <span class="badge bg-secondary">
                    ${vetement["articleType"]}
                </span>
                <span class="badge bg-secondary">
                    ${vetement["baseColour"]}
                </span>
                <span class="badge bg-dark">
                    ${vetement["year"]}
                </span>
                <span class="badge bg-secondary">
                    <button
                        onclick="filterByGender(${vetement["id"]}, '${vetement["gender"]}')"
                        class="btn btn-secondary btn-sm bi ${sexIcon}"></button>
                </span>
                <span>
                    <button class="btn btn-sm btn-danger" onclick="remove(${vetement["id"]})">
                        <i class="bi bi-trash3-fill"></i>
                    </button>
                </span>
            </p>
        </div>
    </div>
    `
}

function buildUrl(filterBy, filterValue) {
	let baseUrl = buildBaseUrl()
	return `${baseUrl}?column=${filterBy}&value=${filterValue}`
}

function buildBaseUrl() {
	//A changer en fonction de votre dossier !
	return `http://localhost/L2/TD8/api.php`
}

async function remove(id) {
	let data = await deleteVetement(id)
	updateData(data)
}

async function deleteVetement(id) {
	let headers = new Headers()
	headers.append("Content-Type", "application/x-www-form-urlencoded")
	headers.append("charset", "UTF-8")

	const config = {
		method: "POST",
		headers: headers,
		body: JSON.stringify({ action: "delete", id: id }),
	}

	const req = await fetch(buildBaseUrl(), config)

	const data = await req.json() // [vetements] ou {result: false}
	console.log(data)
	return data
}

async function createVetement(data = {}) {
	//On voit que dans les deux cas, on a exactement le même code !
	//@todo: On pourrait créer une fonction post global et passer une action dans la fonction ;)
	let headers = new Headers()
	headers.append("Content-Type", "application/x-www-form-urlencoded") //Ce que le server attend (@todo application/json est possible, mais faut modifier le server)
	headers.append("Accept", "application/json") //Ce que moi j'attends (le client)
	headers.append("charset", "UTF-8") //Comment j'encode le texte que j'envoie

	data["action"] = "add"

	const config = {
		method: "POST",
		headers: headers,
		body: JSON.stringify(data),
	}

	const req = await fetch(buildBaseUrl(), config)

	//Si on a une 200
	if (req.ok) {
		const result = await req.json() // [vetements] ou {result: false}
		console.log(result)
		if (result["result"] == false) {
			alert("Une erreur gérée s'est produite")
		} else {
			return result
		}
	} else {
		//Si on a pas une 200
		alert("Une erreur non gérée s'est produite :(")

		//Dans la vraie vie, on doit gérer les erreurs et renvoyer une 4xx/5xx quand même ! Avec un message d'erreur dans le retour
	}
}
