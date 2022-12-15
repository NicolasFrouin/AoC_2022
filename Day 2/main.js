const op = {
	A: "Rock",
	B: "Paper",
	C: "Scissors",
};

const me = {
	X: "Rock",
	Y: "Paper",
	Z: "Scissors",
};

const res = {
	X: "Loose",
	Y: "Draw",
	Z: "Win",
};

const points = {
	Rock: 1,
	Paper: 2,
	Scissors: 3,
	Win: 6,
	Draw: 3,
	Loose: 0,
};

const beats = {
	Rock: "Scissors",
	Paper: "Rock",
	Scissors: "Paper",
};

const mode = 2;

if (mode === 1) {
	let total = 0;
	for (const p of data) {
		let score = 0;
		const [o, m] = p.split(" ");
		score += points[me[m]];
		if (beats[me[m]] === op[o]) {
			console.log("Win");
			score += points["Win"];
		} else if (beats[op[o]] === me[m]) {
			console.log("Loose");
			score += points["Loose"];
		} else {
			console.log("Draw");
			score += points["Draw"];
		}
		total += score;
		console.log(score);
	}
	console.log(total);
} else if (mode === 2) {
	let total = 0;
	const beatsValues = Object.values(beats);
	for (const p of data) {
		let score = 0;
		const [o, r] = p.split(" ");
		score += points[res[r]];
		console.log(op[o], res[r]);
		if (res[r] === "Win") {
			// console.log(beats[beatsValues.find((v) => v === beats[op[o]])]);
			score += points[beats[beatsValues.find((v) => v === beats[op[o]])]];
		} else if (res[r] === "Loose") {
			score += points[beats[op[o]]];
		} else {
			score += points[op[o]];
		}
		total += score;
	}
	console.log(total);
	// 15905 too high
}
