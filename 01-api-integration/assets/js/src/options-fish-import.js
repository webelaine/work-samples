// Global reference to grouped TRs.
let tableRows = {};

/**
 * (On load) Group TRs whose contents relate to either Locations or Regions.
 *
 * @param {Object[]} tableChildren The current TRs.
 */
function groupRows(tableChildren) {
	const groupedRows = [];
	for (let a = 0; a < tableChildren.length; a++) {
		const currentInput = tableChildren[a].querySelector('input');
		const currentNamedId = currentInput.id.substring(
			currentInput.id.indexOf('[') + 1,
			currentInput.id.indexOf(']')
		);
		if (!groupedRows[currentNamedId]) {
			groupedRows[currentNamedId] = [];
		}
		groupedRows[currentNamedId].push(tableChildren[a]);
	}
	return groupedRows;
}

/**
 * Isolate numeric digits from an element's innerHTML.
 *
 * @param {Object[]} haystack The HTML element to search.
 * @return {number} The numeric digits.
 */
function findNumber(haystack) {
	const r = /\d+/;
	return haystack.match(r);
}

/**
 * (On Remove button press) Keep Locations and Regions in sequential order.
 *
 * @param {Object[]} tableRowsToRenumber Groups of TRs.
 * @param {string}   typeToRemove        locations or regions.
 */
function renumberRows(tableRowsToRenumber, typeToRemove) {
	// Loop through the groups of rows for either Locations or Regions.
	for (let a = 0; a < tableRowsToRenumber[typeToRemove].length; a++) {
		const rowGroup = tableRowsToRenumber[typeToRemove][a];
		// Loop through the individual rows.
		for (let b = 0; b < rowGroup.length; b++) {
			const oneRow = rowGroup[b];
			// Update TH (user-facing number).
			const tableTh = oneRow.querySelector('th');
			const thNumber = findNumber(tableTh.innerHTML);
			tableTh.innerHTML = tableTh.innerHTML.replace(thNumber[0], a + 1);
			// Update input ID and input name (array number).
			const tableInput = oneRow.querySelector('input');
			const inputNumber = findNumber(tableInput.id);
			tableInput.id = tableInput.id.replace(inputNumber[0], a);
			const inputNameNumber = findNumber(tableInput.name);
			tableInput.name = tableInput.name.replace(inputNameNumber[0], a);
			// Update button data-field (array number) and text (user-facing number).
			const tableButton = oneRow.querySelector('button');
			// Only name rows have buttons, so make sure there is one.
			if (tableButton) {
				tableButton.dataset.field = tableButton.dataset.field.replace(
					inputNameNumber[0],
					a
				);
				const buttonTextNumber = findNumber(tableButton.innerHTML);
				tableButton.innerHTML = tableButton.innerHTML.replace(
					buttonTextNumber[0],
					a + 1
				);
			}
		}
	}
}

/**
 * (On Remove button press) Remove the table rows that constitute a Location or a Region.
 */
function removeRows() {
	const dataField = this.dataset.field;
	let typeToRemove = 'locations';
	if (dataField.includes('regions')) {
		typeToRemove = 'regions';
	}
	const rowToRemove = dataField.substring(
		dataField.indexOf('[') + 1,
		dataField.indexOf(']')
	);
	const deleteRows = tableRows[typeToRemove][rowToRemove];
	for (let a = 0; a < deleteRows.length; a++) {
		deleteRows[a].remove();
	}
	tableRows[typeToRemove].splice(rowToRemove, 1);
	renumberRows(tableRows, typeToRemove);
}

/**
 * (On load) Add event listeners to the Remove buttons.
 *
 * @param {Object[]} tableRows The current TRs in the table.
 */
function addRemoveButtonListeners(tableRows) {
	for (let a = 0; a < tableRows.length; a++) {
		const removeButton =
			tableRows[a][0].getElementsByClassName('remove')[0];
		removeButton.addEventListener('click', removeRows);
	}
}

/**
 * (On load) Parse the current tables and inputs, and add any missing tables.
 */
function init() {
	const tables = document.getElementsByClassName('form-table');
	const currentRows = {};
	// Skip the first table (i=0) which is for credentials.
	for (let i = 2; i < tables.length; i++) {
		const newTable = tables[i];
		const tableChildren = newTable.querySelectorAll('tr');
		if (i === 2) {
			const locationRows = groupRows(tableChildren);
			currentRows.locations = locationRows;
			if (currentRows.locations.length) {
				addRemoveButtonListeners(currentRows.locations);
			}
		} else {
			const regionRows = groupRows(tableChildren);
			currentRows.regions = regionRows;
			if (currentRows.regions.length) {
				addRemoveButtonListeners(currentRows.regions);
			}
		}
	}
	const addButtons = document.getElementsByClassName('add');
	for (let j = 0; j < addButtons.length; j++) {
		const addButton = addButtons[j];
		addButton.addEventListener('click', addRows);
		if (addButton.dataset.field === 'locations') {
			currentRows.locationButton = addButton;
			currentRows.locationTable = addButton.nextElementSibling;
		} else {
			currentRows.regionButton = addButton;
			currentRows.regionTable = addButton.nextElementSibling;
		}
	}
	// If either Locations or Regions were empty and there was no table, add a blank.
	if (!currentRows.locations) {
		addEmptyTable('locations', currentRows);
		currentRows.locationTable = currentRows.locationButton.nextElementSibling;
	}
	if (!currentRows.regions) {
		addEmptyTable('regions', currentRows);
		currentRows.regionTable = currentRows.regionButton.nextElementSibling;
	}
	return currentRows;
}

/**
 * (On load) Add an empty table to the DOM if there are no Locations or no Regions.
 *
 * @param {string}   kind        Locations or Regions.
 * @param {Object[]} currentRows A collection of the Add button and associated table of the current {kind}.
 */
function addEmptyTable(kind, currentRows) {
	const newTable = document.createElement('table');
	newTable.className = 'form-table';
	newTable.dataset.field = kind;
	if ( 'regions' === kind ) {
		currentRows.regionButton.after(newTable);
	} else {
		currentRows.locationButton.after(newTable);
	}
	const newTbody = document.createElement('tbody');
	newTable.appendChild(newTbody);
}

/**
 * (On Add button press) Add a set of TRs and input fields for a new Location or Region.
 *
 * @param {number} newIndex  The array key that tracks Location or Region ID.
 * @param {string} typeLabel Location or Region.
 */
function appendRows(newIndex, typeLabel) {
	const rowArray = [];
	const sectionTable = typeLabel.toLowerCase() + 'Table';
	// Row 1: Name
	// Row
	const rowOne = document.createElement('tr');
	// TH
	const nameTh = document.createElement('th');
	nameTh.innerHTML = typeLabel + ' ' + (newIndex + 1) + ' Name';
	nameTh.scope = 'row';
	rowOne.appendChild(nameTh);
	// TD
	const nameTd = document.createElement('td');
	// TD input
	const nameInput = document.createElement('input');
	nameInput.type = 'text';
	nameInput.id =
		'fishrules_' + typeLabel.toLowerCase() + 's[' + newIndex + '][name]';
	nameInput.name = nameInput.id;
	nameTd.appendChild(nameInput);
	// TD button
	const removeButton = document.createElement('button');
	removeButton.type = 'button';
	removeButton.class = 'remove';
	removeButton.dataset.field =
		'fishrules_' + typeLabel.toLowerCase() + 's[' + newIndex + ']';
	removeButton.textContent = 'Remove ' + typeLabel + ' ' + (newIndex + 1);
	removeButton.addEventListener('click', removeRows);
	nameTd.appendChild(removeButton);
	// Add TD to TR
	rowOne.appendChild(nameTd);
	rowArray.push(rowOne);
	// Add to the DOM.
	tableRows[sectionTable].querySelector('tbody').appendChild(rowOne);
	// Row 2: Coords
	// Row
	const rowTwo = document.createElement('tr');
	// TH
	const coordsTh = document.createElement('th');
	coordsTh.innerHTML = typeLabel + ' ' + (newIndex + 1) + ' Coordinates';
	coordsTh.scope = 'row';
	rowTwo.appendChild(coordsTh);
	// TD
	const coordsTd = document.createElement('td');
	// TD input
	const coordsInput = document.createElement('input');
	coordsInput.type = 'text';
	coordsInput.id =
		'fishrules_' + typeLabel.toLowerCase() + 's[' + newIndex + '][coords]';
	coordsInput.name = coordsInput.id;
	coordsTd.appendChild(coordsInput);
	// Add TD to TR
	rowTwo.appendChild(coordsTd);
	rowArray.push(rowTwo);
	// Add to the DOM.
	tableRows[sectionTable].querySelector('tbody').appendChild(rowTwo);
	// Row 3: Species ID
	if (typeLabel === 'Region') {
		// Row
		const rowThree = document.createElement('tr');
		// TH
		const speciesTh = document.createElement('th');
		speciesTh.innerHTML = typeLabel + ' ' + (newIndex + 1) + ' Species ID';
		speciesTh.scope = 'row';
		rowThree.appendChild(speciesTh);
		// TD
		const speciesTd = document.createElement('td');
		// TD input
		const speciesInput = document.createElement('input');
		speciesInput.type = 'text';
		speciesInput.id =
			'fishrules_' +
			typeLabel.toLowerCase() +
			's[' +
			newIndex +
			'][species_id]';
		speciesInput.name = speciesInput.id;
		speciesTd.appendChild(speciesInput);
		// Add TD to TR
		rowThree.appendChild(speciesTd);
		rowArray.push(rowThree);
		// Add to the DOM.
		tableRows[sectionTable].querySelector('tbody').appendChild(rowThree);
	}
	// Finally: push to global reference
	if (typeLabel === 'Location') {
		if (Array.isArray(tableRows.locations)) {
			tableRows.locations.push(rowArray);
		} else {
			tableRows.locations = [rowArray];
		}
	} else if (Array.isArray(tableRows.regions)) {
		tableRows.regions.push(rowArray);
	} else {
		tableRows.regions = [rowArray];
	}
}

/**
 * (On Add button press) Calculate where to add rows.
 */
function addRows() {
	let newIndex = 0;
	if (this.dataset.field === 'locations') {
		if (tableRows.locations && tableRows.locations.length) {
			newIndex = tableRows.locations.length;
		}
		appendRows(newIndex, 'Location');
	} else {
		if (tableRows.regions && tableRows.regions.length) {
			newIndex = tableRows.regions.length;
		}
		appendRows(newIndex, 'Region');
	}
}

tableRows = init();
