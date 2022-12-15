let total = 0;

for (const line of data) {
	const first = line.slice(0, line.length / 2);
	const last = line.slice(line.length / 2);
	console.log(findSharedLetter(first, last));
}

function findSharedLetter(str1, str2) {
	// Convert both strings to lowercase
	str1Var = str1.toLowerCase();
	str2Var = str2.toLowerCase();

	// Create an empty object to store the counts of each letter in each string
	let letterCounts = {};

	// Loop through each letter in the first string and add it to the letterCounts object
	for (let i = 0; i < str1Var.length; i++) {
		let letter = str1Var[i];
		if (!letterCounts[letter]) {
			letterCounts[letter] = 1;
		} else {
			letterCounts[letter]++;
		}
	}

	// Loop through each letter in the second string and add it to the letterCounts object
	for (let i = 0; i < str2Var.length; i++) {
		let letter = str2Var[i];
		if (!letterCounts[letter]) {
			letterCounts[letter] = 1;
		} else {
			letterCounts[letter]++;
		}
	}

	// Loop through each letter in the letterCounts object and return the first
	// letter that appears in both strings (i.e. has a count of 2)
	for (let letter in letterCounts) {
		if (letterCounts[letter] === 2) {
			// Check the case of the letter in the original input string
			if (str1.includes(letter.toUpperCase())) {
				return letter.toUpperCase();
			} else if (str1.includes(letter.toLowerCase())) {
				return letter.toLowerCase();
			}
		}
	}

	// If no shared letter was found, return null
	return null;
}
